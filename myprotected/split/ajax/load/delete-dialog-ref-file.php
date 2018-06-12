<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
	
	//require_once "../../../../split/library/wp_lib.php";
	//$wp = new wp_Lib($db_pref);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Action LOAD DELETE DIALOG REF FILE</title>
</head>

<body>
<?php 
	$query = "SELECT  * FROM [pre]dialog_files_ref WHERE `id`='".$_GET['id']."' ORDER BY id LIMIT 1";

	$result_stmt = $dbh->prepare($query);
		$result_arr = $result_stmt->execute();
		$result = $result_arr->fetchallAssoc();
		
	$rf = $result[0];
	
	unlink("../../../../".WP_FOLDER.$rf['path']."".$rf['file']);
	unlink("../../../../".WP_FOLDER.$rf['path']."crop/".$rf['crop']);

	$query = "DELETE FROM [pre]dialog_files_ref WHERE `id`='".$_GET['id']."' LIMIT 1";

		$result_stmt = $dbh->prepare($query);
		$result_stmt->execute();
	
	echo 'Файл удален.';
?>
</body>
</html>