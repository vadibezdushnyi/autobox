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
<title>Answer DELETE ORDERS</title>
</head>

<?php
	$orders = $_POST['orders'];
?>

<body>
<?php
	if(sizeof($orders) == 0){ echo "Ни один заказ не найден."; }
	
	foreach($orders as $order_id)
	{
		$query = "SELECT * FROM [pre]shop_orders WHERE `id`='".$order_id."' LIMIT 1";

			$data_stmt = $dbh->prepare($query);
			$data_arr = $data_stmt->execute();
			$data = $data_arr->fetchallAssoc();
		
		$delete_query = "DELETE FROM [pre]shop_orders WHERE `id`='".$order_id."' LIMIT 1";

			$delete_stmt = $dbh->prepare($delete_query);
			$delete_stmt->execute();
		
		
		?>
		<p>Заказ #<b><?php echo $order_id+5000 ?></b> успешно удален из системы.</p>
		<?php
	}
?>
</body>

<script type="text/javascript" language="javascript">
</script>

</html>