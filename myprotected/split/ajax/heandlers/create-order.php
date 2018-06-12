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

<?php
	
	$author_id = 2;
	$user_id = $_POST['user_id'];
	$sum = $_POST['sum'];
	
	//$products = serialize($_POST['products']);
	
	$quants = $_POST['quant'];
	
	$products = array();
	
	$total_quant = 0;
	
	foreach($quants as $p_id => $p_quant)
	{
		$res = mysql_query("SELECT `code` FROM `next_shop_products` WHERE `id`='".$p_id."' LIMIT 1");
		$row = mysql_fetch_assoc($res);
		
		array_push($products,array('id'=>$p_id,'code'=>$row['code'],'quant'=>$p_quant,'shipped'=>0));
		$total_quant += $p_quant;
	}
	
	$products = serialize($products);
	
	$query = "INSERT INTO  `zencosmet`.`next_shop_orders` (
`id` ,
`author_id` ,
`user_id` ,
`status` ,
`pay_method` ,
`products_quant` ,
`sum` ,
`products` ,
`details` ,
`dateCreate` ,
`dateModify`
)
VALUES (
NULL ,  '".$author_id."',  '".$user_id."',  'Не оформлен',  'Не оплачен',  '".$total_quant."',  '".$sum."',  '".$products."',  'Заказ сформирован презентантом.',  '".date("Y-m-d H:i:s",time())."',  '".date("Y-m-d H:i:s",time())."'
);";
	mysql_query($query);
?>

<body>
<?php echo '<pre>'; print_r($_POST); echo '</pre>'; ?>
</body>

<script type="text/javascript" language="javascript">
</script>

</html>