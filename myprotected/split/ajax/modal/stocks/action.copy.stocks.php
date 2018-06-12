<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../../require.base.php";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Action ACTIVATE STOCKS</title>
</head>

<?php
	$list = $_POST['list'];
?>

<body>
<button class="close-modal" onclick="close_modal();">Закрыть окно</button>
    <div class="modalW" id="modalW-1">
<?php 
	if(sizeof($list) == 0){ echo "Ни один Склад не найден."; }
	
	$table_name = $db_pref."stocks";
	
	foreach($list as $item_id)
	{
		$query = "SELECT * FROM [pre]stocks WHERE `id`='".$item_id."' LIMIT 1";

			$data_stmt = $dbh->prepare($query);
			$data_arr = $data_stmt->execute();
			$data = $data_arr->fetchallAssoc();
		
		$insert_query = "INSERT INTO [pre]stocks (";
		
		$fields = "`id`";
		$values = "'NULL'";
		
		$copy_name = "Копия";
		$copy_quant = 0;
		
		$his_query = "SELECT * FROM [pre]copy_history WHERE `table`='".$table_name."' AND `row_id`='".$item_id."' ORDER BY id DESC LIMIT 1";

			$his_stmt = $dbh->prepare($his_query);
			$his_arr = $his_stmt->execute();
			$his = $his_arr->fetchallAssoc();
		
		if($his[0] != null)
		{
			$copy_quant = $his[0]['copy_quant']+1;
			$copy_name .= "(".$copy_quant.")";
		}
		
		foreach($data[0] as $item_field => $item_value)
		{
			if($item_field == 'id') continue;
			$fields .= ",`".$item_field."`";
			if($item_field == 'block')
			{
				$values .= ",'1'";
			}elseif($item_field == 'name')
			{
				$values .= ",'".$copy_name." ".$item_value."'";
			}else
			{
				$values .= ",'".$item_value."'";
			}
		}
		
		$insert_query .= $fields.") VALUES (".$values.")";
		
		//echo $insert_query;

		$insert_stmt = $dbh->prepare($insert_query);
		$insert_arr = $insert_stmt->execute();
		
		$his_query = "INSERT INTO [pre]copy_history (`table`,`row_id`,`copy_quant`) VALUES ('".$table_name."','".$item_id."','".$copy_quant."')";

			$his_stmt = $dbh->prepare($his_query);
			$his_arr = $his_stmt->execute();
		
		?>
		<p>Склад <b><?php echo $data[0]['name'] ?></b> успешно скопирован.</p>
		<?php
	}
?>
	</div>
</body>

<script type="text/javascript" language="javascript">
</script>

</html>