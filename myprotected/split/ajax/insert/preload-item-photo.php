<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
	
	require_once "../../../../split/library/wp_lib.php";
	
	$wp = new wp_Lib($db_pref);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Preload ITEM PHOTO</title>
</head>

<?php
	$id 		= (int)$_POST['id'];
	$file_data 	= $_POST['file_data'];
	$admin_id 	= (int)$_POST['admin_id'];
	
	$fd = unserialize($file_data);
	
	$query = "SELECT  * FROM [pre]admin_tmp WHERE `admin_id`='".$admin_id."' ORDER BY id DESC";

		$result_stmt = $dbh->prepare($query);
		$result_stmt->execute();
		$result = $result_stmt->fetchallAssoc();
		
		$tmp = $result[0]['tmp'];
?>

<body>
<?php 
	if(isset($_FILES['file']) && $_FILES['file']['size'] > 0 && $admin_id > 0)
	{
		$filename = $wp->wp_add_files_file(array(
				'path'			=>"../../../../".$fd['path'],
				'name'			=>"5",
				'pre'			=>"zen_",
				'size'			=>$fd['size'],
				'rule'			=>$fd['rule'],
				'max_w'			=>$fd['max_w'],
				'max_h'			=>$fd['max_h'],
				'files'			=>"file",
				'resize_path'	=>"../../../../".$fd['path'].$fd['crop'], // cropname = $resize_w.x.$resize_h._.$filename
				'resize_w'		=>$fd['crop_w'],
				'resize_h'		=>$fd['crop_h'],
				'resize_path_2'	=>"0",
				'resize_w_2'	=>0,
				'resize_h_2'	=>0
			  ));
		if($filename)
		{
			$query = "DELETE FROM [pre]admin_tmp WHERE `admin_id`='".$admin_id."'";

				$clear_stmt = $dbh->prepare($query);
				$clear_stmt->execute();
			
			$query = "INSERT INTO [pre]admin_tmp (`admin_id`,`tmp`) VALUES ('".$admin_id."','".$filename."')";

				$result_stmt = $dbh->prepare($query);
				$result_stmt->execute();
			
			//unlink("../../../../".$fd['path'].$tmp);
			//unlink("../../../../".$fd['path'].$fd['crop'].$fd['crop_w']."x".$fd['crop_h']."_".$tmp);
			
			if($_POST['action'] == 'edit')
			{
			
				$query = "UPDATE [pre]".$fd['table']." SET `".$fd['field']."` = '".$filename."' WHERE `id`='".$id."' LIMIT 1";
			
				//echo '<pre>'.$query.": "; print_r($fd); echo '</pre>';
			
				$_stmt = $dbh->prepare($query);
				$_stmt->execute();
			
			}
			?>
				<img alt="Photo Not Found" src="<?php echo "../../../../".$fd['path'].$fd['crop'].$fd['crop_w']."x".$fd['crop_h']."_".$filename ?>" 
                	 title="<?php echo $fd['title'] ?>">
			<?php
		}
	}
?>
</body>
</html>