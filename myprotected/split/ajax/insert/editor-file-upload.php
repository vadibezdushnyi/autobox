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
<title>Editor file upload</title>
</head>

<?php
	echo '<pre>'; print_r($_POST); echo '</pre>';
	//echo '<pre>'; print_r($_FILES); echo '</pre>';
	
	//die();

	$admin_id = (int)$_POST['admin_id'];
	
	$table 		= $_POST['table'];
	$ref_table 	= $_POST['ref_table'];
	$ref_id 	= $_POST['ref_id'];
	$file_path 	= $_POST['file_path'];
	
	$is_link 	= $_POST['is_link'][0];
	$is_target 	= $_POST['is_target'][0];
	
	$link 		= $_POST['link'];
?>

<body>
<?php 
	if(isset($_FILES['file']) && $_FILES['file']['size'] > 0 && $admin_id > 0)
	{
		$rw = 320;
		$rh = 240;
		$filename = $wp->wp_add_files_file(array(
				'path'			=>"../../../../".WP_FOLDER.$file_path,
				'name'			=>"5",
				'pre'			=>"zen_",
				'size'			=>5,
				'rule'			=>1,
				'max_w'			=>5000,
				'max_h'			=>5000,
				'files'			=>"file",
				'resize_path'	=>"../../../../".WP_FOLDER.$file_path."crop/", // cropname = $resize_w.x.$resize_h._.$filename
				'resize_w'		=>$rw,
				'resize_h'		=>$rh,
				'resize_path_2'	=>"0",
				'resize_w_2'	=>0,
				'resize_h_2'	=>0
			  ));
		if($filename)
		{
			$crop = $rw."x".$rh."_".$filename;
			
			$query = "INSERT INTO [pre]files_ref (`ref_table`,`ref_id`,`file`,`crop`,`title`,`is_link`,`href`,`target`,`path`,`adminMod`) 
					  VALUES ('".$ref_table."','".$ref_id."','".$filename."','".$crop."','','".$is_link."','".$link."','".$is_target."','".$file_path."','".$admin_id."')";

				$result_stmt = $dbh->prepare($query);
				$result_stmt->execute();
			?>
				<img alt="File Not Found" src="<?php echo "../../../../".WP_FOLDER.$file_path."crop/".$crop ?>" title="UPLOAD IMAGE">
			<?php
		}
	}
?>
</body>
</html>