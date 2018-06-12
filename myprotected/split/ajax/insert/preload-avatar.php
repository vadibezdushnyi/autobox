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
<title>Preload USER AVATAR</title>
</head>

<?php
	$admin_id = (int)$_POST['admin_id'];
	
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
				'path'			=>"../../../../split/files/users/",
				'name'			=>"5",
				'pre'			=>"user_",
				'size'			=>5,
				'rule'			=>1,
				'max_w'			=>2500,
				'max_h'			=>2500,
				'files'			=>"file",
				'resize_path'	=>"../../../../split/files/users/crop/", // cropname = $resize_w.x.$resize_h._.$filename
				'resize_w'		=>150,
				'resize_h'		=>150,
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
			
			unlink("../../../../".WP_FOLDER."files/users/".$tmp);
			unlink("../../../../".WP_FOLDER."files/users/crop/150x150_".$tmp);
			?>
				<img alt="Photo Not Found" src="<?php echo "../../../../".WP_FOLDER."files/users/crop/150x150_".$filename ?>" title="Аватар пользователя">
			<?php
		}
	}
?>
</body>
</html>