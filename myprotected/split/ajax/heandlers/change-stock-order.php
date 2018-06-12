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
<title>CHANGET STOCK ORDER STATUS</title>
</head>

<body>
<?php 
	// echo '<pre>'; print_r($_POST); echo '</pre>'; 
	$mysql_date = date("Y-m-d H:i:s",time());
	
	$order_id = strip_tags($_POST['order_id']);
	
	$comment = $_POST['comment'];
	$task_id = $_POST['task_id'];
	
	$query = "UPDATE [pre]stock_orders SET `status`= :1 WHERE `id`= :2 LIMIT 1";
	
		$order_stmt = $dbh->prepare($query);
		$order_arr = $order_stmt->execute(2,$order_id);
	
	$query = "SELECT * FROM [pre]stock_order_products WHERE `order_id`= :1 LIMIT 10000";
	
		$products_stmt = $dbh->prepare($query);
		$products_arr = $products_stmt->execute($order_id);
		
		$products = $products_arr->fetchallAssoc();
		
	foreach($products as $pr)
	{
		$query = "UPDATE [pre]shop_products SET quant = quant + ".$pr['quant']." WHERE `code`='".$pr['code']."' LIMIT 1";
		
		$_stmt = $dbh->prepare($query);
		$_stmt->execute();
	}
	
	$query = "UPDATE [pre]tasks SET `status`='1', `comment`='".$comment."', `dateModify`='".$mysql_date."', `adminMod`='".ADMIN_ID."' WHERE `id`='".$task_id."' LIMIT 1";
	
		$_stmt = $dbh->prepare($query);
		$_stmt->execute();
		
	echo 'Заявка успешно приянята на склад.';
?>
</body>
<script type="text/javascript" language="javascript">
	$(function(){
			$('#get_order_button').hide(200);
		});
</script>
</html>