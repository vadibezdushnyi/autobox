<?php  
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
	
	require_once "../../library/AjaxHelp.php";
	
	$r = array("status"=>"fail", "message"=>"error");
	
	$ah = new ajaxHelp($dbh);

	$items = $_POST['items'];
	$table = $_POST['table'];

 ?>
<!DOCTYPE HTML>
<html lang="ru">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Action ACTIVATE USERS</title>
</head>
<body>
<button class="close-modal" onclick="close_modal();">Закрыть окно</button>
    <div class="modalW" id="modalW-1">
<?php 
	if(sizeof($items) == 0){ echo "Ни одна запись не найдена."; }
	
	$table_name = $db_pref.$table;
	
	foreach($items as $item_id)
	{
		$query = "SELECT * FROM [pre]".$table." WHERE `id`='".$item_id."' LIMIT 1";

		$data = $ah->dbh->q($query,1);
		
		$insert_query = "INSERT INTO [pre]".$table." (";
		
		$fields = "`id`";
		$values = "'NULL'";
		
		$copy_name = "Copy";
		$copy_quant = 0;
		
		$his_query = "SELECT * FROM [pre]copy_history WHERE `table`='".$table_name."' AND `row_id`='".$item_id."' ORDER BY id DESC LIMIT 1";

		$his = $ah->dbh->q($his_query,1);
		
		if($his)
		{
			$copy_quant = $his['copy_quant']+1;
			$copy_name .= "(".$copy_quant.")";
		}
		
		foreach($data as $user_field => $user_value)
		{
			$user_value = str_replace("'","\'",$user_value);
			
			if($user_field == 'id') continue;
			$fields .= ",`".$user_field."`";
			if($user_field == 'block')
			{
				$values .= ",'1'";
			}elseif($user_field == 'email')
			{
				$values .= ",''";
			}elseif($user_field == 'phone')
			{
				$values .= ",''";
			}elseif($user_field == 'pass')
			{
				$values .= ",''";
			}elseif($user_field == 'active')
			{
				$values .= ",'0'";
			}elseif($user_field == 'block')
			{
				$values .= ",'1'";
			}elseif($user_field == 'name')
			{
				$values .= ",'".$copy_name." ".$user_value."'";
			}elseif($user_field == 'alias')
			{
				$values .= ",'".$user_value."_".$copy_quant."'";
			}else
			{
				$values .= ",'".$user_value."'";
			}
		}
		
		if($values == "'NULL'") continue;
		
		$insert_query .= $fields.") VALUES (".$values.")";
		
		//echo $insert_query;

		$insert_stmt = $ah->dbh->q($insert_query,0,1);
		
		$his_query = "INSERT INTO [pre]copy_history (`table`,`row_id`,`copy_quant`) VALUES ('".$table_name."','".$item_id."','".$copy_quant."')";

		$his_stmt = $ah->dbh->q($his_query,0,1);
		
		$item_name = "[".$data['id']."]";
		
		if($data['name'] != null) $item_name .= " ".$data['name'];
		
		?>
		<p>Запись <b><?php echo $item_name ?></b> успешно скопирована.</p>
		<?php
		
		//echo "<pre>SQL INSERT: "; print_r($insert_query); echo "</pre>";
	}
?>
	</div>
</body>
</html>