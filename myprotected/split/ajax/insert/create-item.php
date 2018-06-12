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
<title>Action CREATE ITEM</title>
</head>

<body>
<?php 
	echo $tmp;
	
	echo '<pre>'; print_r($_POST); echo '</pre>';
	
	$item		= unserialize($_POST['item_data']);
	$card_data	= unserialize($_POST['card_data']);
	
	//echo '<pre>'; print_r($card_data); echo '</pre>'; die();
	
	$mysql_date = date("Y-m-d H:i:s",time());
	
	// filter_var($email, FILTER_VALIDATE_EMAIL)
	
	$message = 1; // По умолчанию ошибок нет и форма может быть принята и данные запишутся в таблицу stocks
	
	if($card_data['type'] != 'dialog')
	{
		
	$query = "INSERT INTO [pre]".$card_data['table']." ";
	
	$f_cnt = 0;
	
	$query_fields = "(";
	$query_values = "(";
	
	$f_filter = true;
	
	foreach($card_data['fields'] as $field)
	{
		if($field['name'] == 're-pass')
		{
			if($_POST['pass'] != $_POST['re-pass'])
			{
				$message = "Неверное подтверждение пароля.";
				$f_filter = false;
				break;
			}
			continue;
		}
		$f_cnt++;
		
		$value = $_POST[$field['name']];
		
		if(is_array($value))
		{
			$value = $_POST[$field['name']][0];
		}
		
		if(strtotime($value) > 0)
		{
			$value = date("Y-m-d H:i:s",strtotime($value));
		}
		
		if($field['name'] == 'pass') $value = md5(trim($_POST['pass']));
		
		if($f_cnt == 1)
		{
			$query_fields .= "`".$field['name']."` ";
			$query_values .= "'".$value."' ";
		}else
		{
			$query_fields .= ", `".$field['name']."` ";
			$query_values .= ", '".$value."' ";
		}
	}
	
	if($f_filter)
	{
			$query_fields .= ", `dateCreate` ";
			$query_values .= ", '".$mysql_date."' ";
			
			$query_fields .= ", `dateModify` ";
			$query_values .= ", '".$mysql_date."' ";
			
			$query_fields .= ", `adminMod` ";
			$query_values .= ", '".ADMIN_ID."' ";
			
			if($card_data['one_photo_field'] != '0' && trim($card_data['one_photo_field']) != '' && $tmp != null)
			{
				$query_fields .= ", `".$card_data['one_photo_field']."` ";
				$query_values .= ", '".$tmp."' ";
			}
			
			if($card_data['editor'] != null && sizeof($card_data['editor']) > 0)
			{
				$query_fields .= ", `".$card_data['editor']['field']."` ";
				$query_values .= ", '".$_POST[$card_data['editor']['field']]."' ";
			}
	
	$query .= $query_fields.") VALUES ".$query_values." )";
	
	$_stmt = $dbh->prepare($query);
	$_stmt->execute();
	
	$id = mysql_insert_id();
	
	echo "<p>Query: ".$query."</p>";
	
	$save_rules = $card_data['save_rules'];
	if(sizeof($save_rules) > 0)
	{
		foreach($save_rules as $rule)
		{
			foreach($_POST[$rule['post_field']] as $ef_id => $value)
			{
					$query = "INSERT INTO [pre]".$rule['table']." (`".$rule['where']['item_id']."`,`".$rule['where']['ef_id']."`,`".$rule['field']."`) 
							  VALUES ('".$id."','".$ef_id."','".$value."')";
							  
					$_stmt = $dbh->prepare($query);
					$_stmt->execute();
			}
		}
	}
	
	if($card_data['editor'] != null && sizeof($card_data['editor']) > 0)
	{
		$query = "UPDATE [pre]files_ref SET `ref_id`='".$id."' WHERE `ref_table`='".$card_data['table']."' AND `ref_id`='0' LIMIT 100";
			
			$_stmt = $dbh->prepare($query);
			$_arr = $_stmt->execute();
	}
	
	if($card_data['admin_access'] != null && $card_data['admin_access'] == 1)
	{
		echo '<pre>'; print_r($_POST['admin_access']); echo '</pre>';
		
		foreach($_POST['admin_access'] as $menu_id => $acc)
		{
			$query = "INSERT INTO [pre]user_type_access (`type_id`,`menu_id`,`access`) VALUES ('".$id."','".$menu_id."','".$acc."')";
			
			$_stmt = $dbh->prepare($query);
			$_stmt->execute();
		}
	}
	
	} // end f_filter
	
	}elseif($card_data['type'] == 'dialog')
	{
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
	}
	
	echo "<p>Message: ".$message."</p>";
	
	$status_query = "INSERT INTO [pre]admin_tmp (`admin_id`,`tmp`) VALUES ('".ADMIN_ID."','".$message."')";

		$status_stmt = $dbh->prepare($status_query);
		$status_stmt->execute();
?>
</body>
</html>