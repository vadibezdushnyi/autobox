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
<title>Action add products to shop</title>
</head>

<?php
	$items = $_POST['items'];
	
	$mysql_date = date("Y-m-d H:i:s",time());
?>

<body>
<?php 
	//echo '<pre>'; print_r($items); echo '</pre>'; 
	
	foreach($items as $item)
	{	
		 $query = "SELECT * FROM [pre]stock_order_products WHERE `id`='".$item."' ORDER BY id LIMIT 1";
			
			$products_stmt	= $dbh->prepare($query);
			$products_arr 	= $products_stmt->execute();
			$products 		= $products_arr->fetchallAssoc();
			
			$product = $products[0];
			
		if(!$product['in_shop'])
		{
			
		$query = "SELECT * FROM [pre]shop_products WHERE `code`='".$product['code']."' ORDER BY id LIMIT 1";
			
			$shop_products_stmt	= $dbh->prepare($query);
			$shop_products_arr 	= $shop_products_stmt->execute();
			$shop_products 		= $shop_products_arr->fetchallAssoc();
			
		if(sizeof($shop_products) > 0)
		{
			$shop_product = $shop_products[0];
			
			$query = "UPDATE [pre]shop_products SET `quant`='".($shop_product['quant']+$product['quant'])."', `dateModify`='".$mysql_date."' 
					WHERE `id`='".$shop_product['id']."' LIMIT 1";
			
				$update_stmt	= $dbh->prepare($query);
				$update_stmt->execute();
				
			$query = "UPDATE [pre]stock_order_products SET `in_shop` = 1 WHERE `id`='".$product['id']."' LIMIT 1";
			
				$update_stmt	= $dbh->prepare($query);
				$update_stmt->execute();
				
			echo '<p>Товар №<b>'.$shop_product['id'].'</b> обновлен в количестве + '.$product['quant'].' шт.</p>';
		}else
		{	
			$query = "INSERT INTO [pre]shop_products 
			(`id`, `quant`, `order_id`, `name`, `alias`, `sku`, `code`, `price`, 
			`currency`, `filename`, `block`, `dateCreate`, `dateModify`, `adminMod`) 
			VALUES 
			(NULL, '".$product['quant']."', '0', '".$product['name']."', 'product_".$product['id']."', '".$product['sku']."', '".$product['code']."', '".$product['price']."', 
			'UAH', '0', '0', '".$mysql_date."', '".$mysql_date."', '".ADMIN_ID."')";
			
			//echo $query;
			//die("4");
			
				$insert_stmt	= $dbh->prepare($query);
				$insert_stmt->execute();
				
				$cur_id = mysql_insert_id();
				
			$query = "INSERT INTO [pre]shop_cat_prod_ref 
			(`id`, `cat_id`, `prod_id`, `dateCreate`) 
			VALUES 
			(NULL, '1', '".$cur_id."', '".$mysql_date."')";
			
				$insert_stmt	= $dbh->prepare($query);
				$insert_stmt->execute();	
			
			$query = "UPDATE [pre]stock_order_products SET `in_shop` = 1 WHERE `id`='".$product['id']."' LIMIT 1";
			
				$update_stmt	= $dbh->prepare($query);
				$update_stmt->execute();
				
			echo '<p>Товар №<b>'.$cur_id.'</b> добавлен в категорию "Новые товары". Количество = '.$product['quant'].' шт.</p>';
		}
		
		}else
		{
			echo '<p>Товар <b>'.$product['code'].'</b> уже был ранее добавлен в продажу.</p>';
		}
	}
?>
</body>

<script type="text/javascript" language="javascript">
</script>

</html>