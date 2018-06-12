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
<title>Action CREATE STOCK FIELD STATUS LOAD</title>
</head>

<body>
<?php 
	$query = "SELECT  * FROM [pre]admin_tmp WHERE `admin_id`='".ADMIN_ID."' ORDER BY id DESC";

		$result_stmt = $dbh->prepare($query);
		$result_stmt->execute();
		$result = $result_stmt->fetchallAssoc();
		
	$tmp = $result[0]['tmp'];
	
	if($tmp == 1)
	{
		echo "Новый улумент склада успешно создан.";
	}else
	{
		echo $tmp;
	}
	
	$clear_query = "DELETE FROM [pre]admin_tmp WHERE `admin_id`='".ADMIN_ID."'";

		$clear_stmt = $dbh->prepare($clear_query);
		$clear_stmt->execute();
?>
</body>
</html>