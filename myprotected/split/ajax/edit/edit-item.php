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
<title>Action EDIT ITEM</title>
</head>

<body>
<?php 
	//echo '<pre>'; print_r($_POST); echo '</pre>';
	
	$id			= trim(strip_tags($_POST['id']));
	
	$item		= unserialize(base64_decode($_POST['item_data']));
	$card_data	= unserialize(base64_decode($_POST['card_data']));
	
	echo '<pre>'; print_r($card_data); echo '</pre>';
	
	$message = 1; // По умолчанию ошибок нет и форма может быть принята и данные запишутся в таблицу stocks
	
	$query = "UPDATE [pre]".$card_data['table']." SET ";
	
	$f_cnt = 0;
	
	foreach($card_data['fields'] as $field)
	{
		if(!$field['edit']){ continue; }
		
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
		
		$value = str_replace("'","\'",$value);
		
		if($f_cnt == 1)
		{
			$query .= "`".$field['name']."`='".$value."'";
		}else
		{
			$query .= ", `".$field['name']."`='".$value."'";
		}
		
		if(isset($card_data['editor']) && isset($card_data['editor']['field']))
		{
			$value = $_POST[$card_data['editor']['field']];
			$value = str_replace("'","\'",$value);
			
			$query .= ", `".$card_data['editor']['field']."`='".$value."'";
		}
	}
	
	$query .= " WHERE `id`='".$id."' LIMIT 1";
	
	$_stmt = $dbh->prepare($query);
	$_stmt->execute();
	
	echo "<p>Query: ".$query."</p>";
	
	$save_rules = $card_data['save_rules'];
	if(sizeof($save_rules) > 0)
	{
		foreach($save_rules as $rule)
		{
			foreach($_POST[$rule['post_field']] as $ef_id => $value)
			{
				$query = "SELECT id FROM [pre]".$rule['table']."  
						  WHERE `".$rule['where']['item_id']."`='".$id."' AND `".$rule['where']['ef_id']."`='".$ef_id."' LIMIT 1";
				
					$_stmt	= $dbh->prepare($query);
					$_arr 	= $_stmt->execute();
				
				$_res = $_arr->fetchallAssoc(); 
				
				if(sizeof($_res) > 0)
				{
					$query = "UPDATE [pre]".$rule['table']." SET `".$rule['field']."`='".$value."' 
							  WHERE `".$rule['where']['item_id']."`='".$id."' AND `".$rule['where']['ef_id']."`='".$ef_id."' LIMIT 1";
							  
					$_stmt = $dbh->prepare($query);
					$_stmt->execute();
				}else
				{
					$query = "INSERT INTO [pre]".$rule['table']." (`".$rule['where']['item_id']."`,`".$rule['where']['ef_id']."`,`".$rule['field']."`) 
							  VALUES ('".$id."','".$ef_id."','".$value."')";
							  
					$_stmt = $dbh->prepare($query);
					$_stmt->execute();
				}
			}
		}
	}
	
	if($card_data['admin_access'] != null && $card_data['admin_access'] == 1)
	{
		echo '<pre>'; print_r($_POST['admin_access']); echo '</pre>';
		
		foreach($_POST['admin_access'] as $menu_id => $acc)
		{
			$query = "SELECT access FROM [pre]user_type_access WHERE `type_id`='".$id."' AND `menu_id`='".$menu_id."'";
			
			$_stmt	= $dbh->prepare($query);
			$_arr	= $_stmt->execute();
			
			$_res = $_arr->fetchallAssoc();
			
			if(sizeof($_res) > 0)
			{
				$query = "UPDATE [pre]user_type_access SET `access`='".$acc."' WHERE `type_id`='".$id."' AND `menu_id`='".$menu_id."'";
			}else
			{
				$query = "INSERT INTO [pre]user_type_access (`type_id`,`menu_id`,`access`) VALUES ('".$id."','".$menu_id."','".$acc."')";
			}
			
			$_stmt = $dbh->prepare($query);
			$_stmt->execute();
		}
	}
	
	
	echo "<p>Message: ".$message."</p>";
	
	$status_query = "INSERT INTO [pre]admin_tmp (`admin_id`,`tmp`) VALUES ('".ADMIN_ID."','".$message."')";

		$status_stmt = $dbh->prepare($status_query);
		$status_stmt->execute();

?>
</body>
</html>