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
	if(sizeof($list) == 0){ echo "Ни один склад не найден."; }
	
	foreach($list as $item_id)
	{
		$query = "SELECT * FROM [pre]stocks WHERE `id`='".$item_id."' LIMIT 1";

			$data_stmt = $dbh->prepare($query);
			$data_arr = $data_stmt->execute();
			$data = $data_arr->fetchallAssoc();
		
		$update_query = "UPDATE [pre]stocks SET `block`=1 WHERE `id`='".$item_id."' LIMIT 1";

			$update_stmt = $dbh->prepare($update_query);
			$update_arr = $update_stmt->execute();
		
		?>
		<p>Склад <b><?php echo $data[0]['name'] ?></b> заблокирован.</p>
		<?php
	}
?>
	</div>
</body>

<script type="text/javascript" language="javascript">
</script>

</html>