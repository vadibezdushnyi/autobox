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
<title>Answer DELETE STOCKS</title>
</head>

<?php
	$list = $_POST['list'];
?>

<body>
<?php 
	if(sizeof($list) == 0){ echo "Ни одна заявка не найдена."; }
	
	foreach($list as $item_id)
	{
		$query = "SELECT * FROM [pre]stock_orders WHERE `id`='".$item_id."' LIMIT 1";

			$data_stmt = $dbh->prepare($query);
			$data_arr = $data_stmt->execute();
			$data = $data_arr->fetchallAssoc();
		
			$data = $data[0];
		
		$delete_query = "DELETE FROM [pre]stock_orders WHERE `id`='".$item_id."' LIMIT 1";

			$delete_stmt = $dbh->prepare($delete_query);
			$delete_stmt->execute();
			
		$delete_products_query = "DELETE FROM [pre]stock_order_products WHERE `order_id`='".$data['id']."' LIMIT 1000";

			$delete_products_stmt = $dbh->prepare($delete_products_query);
			$delete_products_stmt->execute();
			
		$delete_refs_query = "DELETE FROM [pre]shop_products_shelf_ref WHERE `order_id`='".$data['id']."' LIMIT 100000";

			$delete_refs_stmt = $dbh->prepare($delete_refs_query);
			$delete_refs_stmt->execute();
			
		?>
		<p>Заявка <b><?php echo $data['id'] ?></b> успешно удалена из системы.</p>
		<?php
	}
?>
</body>

<script type="text/javascript" language="javascript">
</script>

</html>