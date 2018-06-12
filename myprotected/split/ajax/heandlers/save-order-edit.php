<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	//require_once "../../../require.base.php";
	$db_connect = mysql_connect("localhost","zencosmusr","kTpcgY5q");
			mysql_select_db("zencosmet",$db_connect);
			mysql_set_charset("utf8",$db_connect);
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tables MENU</title>
</head>


<body>
<?php
	$total_quant = 0;
	
	$products = array();
	
	foreach($_POST['quants'] as $p_id => $p_quant)
	{
		if($p_id > 0 && $p_id != null)
		{
			$res = mysql_query("SELECT `code` FROM `next_shop_products` WHERE `id`='".$p_id."' LIMIT 1");
			$row = mysql_fetch_assoc($res);
		
			array_push($products,array('id'=>$p_id,'code'=>$row['code'],'quant'=>$p_quant,'shipped'=>0));
			$total_quant += $p_quant;
		}
	}
	
	$products = serialize($products);
	
	$sum = (int)$_POST['sum'];


	$pay_method = "Не оплачен";
	if($_POST['paid_status'] == "Оплачен")
	{
		$pay_method = "Оплачен";
	}

	$query = "UPDATE `zencosmet`.`next_shop_orders` SET `status`='".$_POST['status']."',
														`paid_status`='".$_POST['paid_status']."',
														`pay_method`='".$pay_method."',
														`products`='".$products."',`sum`='".$sum."' WHERE `id`='".$_GET['id']."'";
	if(mysql_query($query))
	{
		echo 'Изменения успешно вступили в силу.';
	}else
	{
		echo 'Ошибка конфигурации БД.';
	}
?>
</body>

<script type="text/javascript" language="javascript">
</script>

</html>