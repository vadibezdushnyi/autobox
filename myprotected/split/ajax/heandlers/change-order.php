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
<title>ENTR CODE</title>
</head>

<body>
<?php 
	// echo '<pre>'; print_r($_POST); echo '</pre>'; 
	$order_id = strip_tags($_POST['order_id']);
	$code = strip_tags($_POST['code']);
	$weight = strip_tags($_POST['weight']);
	
	$query = "UPDATE [pre]shop_orders SET `status`= :1, `code`= :2, `weight` = :3 WHERE `id`= :4 LIMIT 1";
	
		$order_stmt = $dbh->prepare($query);
		$order_arr = $order_stmt->execute('Отгружен',$code,$weight,$order_id);
		
	echo 'Заказ успешно отгружен.';
?>
</body>

</html>