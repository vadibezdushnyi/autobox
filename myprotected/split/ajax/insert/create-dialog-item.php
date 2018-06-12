<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
	
	//require_once "../../../../split/library/wp_lib.php";
	//$wp = new wp_Lib($db_pref);
	
	$query = "SELECT  * FROM [pre]admin_tmp WHERE `admin_id`='".ADMIN_ID."' ORDER BY id DESC";

		$result_stmt = $dbh->prepare($query);
		$result_arr = $result_stmt->execute();
		$result = $result_arr->fetchallAssoc();
		
		if($result[0] != null)
		{
			$tmp = $result[0]['tmp'];
		}else
		{
			$tmp = 0;
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Action CREATE DIALOG ITEM</title>
</head>

<body>
<?php 
		$mysql_date = date("Y-m-d H:i:s",time());
		
		echo '<pre>'; print_r($_POST); echo '</pre>';
		
		$from_id	= (int)$_POST['from_id'];
		$to_id		= (int)$_POST['to_id'];
		$mess		= trim(strip_tags($_POST['message']));
		
		$query = "UPDATE [pre]users_dialogs SET `last`=0 WHERE 
		(`from_id`='".$from_id."' OR `to_id`='".$from_id."') AND (`from_id`='".$to_id."' OR `to_id`='".$to_id."') LIMIT 10000";
		
			$_stmt = $dbh->prepare($query);
			$_stmt->execute();
		
		$query = "INSERT INTO [pre]users_dialogs (`message`,`from_id`,`to_id`,`dateCreate`) VALUES 
		('".$mess."','".$from_id."','".$to_id."','".$mysql_date."')";
		
			$_stmt = $dbh->prepare($query);
			$_stmt->execute();
			
		$id = mysql_insert_id();
		
		//echo '<pre>'; print_r($_POST); echo '</pre>'; die();
		
		$query = "UPDATE [pre]dialog_files_ref SET `ref_id`='".$id."' WHERE `ref_table`='users_dialogs' AND `ref_id`='0' AND `adminMod`='".ADMIN_ID."' LIMIT 100";
			
			$_stmt = $dbh->prepare($query);
			$_stmt->execute();
?>
</body>
</html>