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
<title>UNSET TASK ADMIN REF</title>
</head>

<body>
<?php 
	$query = "DELETE FROM [pre]task_admin_ref WHERE `admin_id`='".ADMIN_ID."' LIMIT 1000";
	
	$_stmt = $dbh->prepare($query);
	$_stmt->execute();
?>
</body>

</html>