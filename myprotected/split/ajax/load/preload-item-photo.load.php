<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Preload ITEM PHOTO - LOAD IN HTML</title>
</head>

<?php
	$admin_id = (int)$_POST['admin_id'];
	
	$file_data 	= $_POST['file_data'];
	$fd = unserialize($file_data);
?>

<body>
<?php 
	$query = "SELECT  * FROM [pre]admin_tmp WHERE `admin_id`='".$admin_id."' ORDER BY id DESC";

		$result_stmt = $dbh->prepare($query);
		$result_stmt->execute();
		$result = $result_stmt->fetchallAssoc();
		
		$tmp = $result[0]['tmp'];
?>
	<img alt="Photo Not Found" src="<?php echo "../".$fd['path'].$fd['crop'].$fd['crop_w']."x".$fd['crop_h']."_".$tmp ?>" 
    	 title="<?php echo $fd['title'] ?>">
</body>
</html>