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
	 //echo '<pre>'; print_r($_POST); echo '</pre>';
	
	// Вытягиваем все продукты по заявке
	
	$order_id = $_POST['order_id'];
	
	$query = "SELECT * FROM [pre]stock_orders WHERE `id`= :1 LIMIT 1";
	
		$order_stmt = $dbh->prepare($query);
		$order_arr = $order_stmt->execute($order_id);
		
		$order = $order_arr->fetchallAssoc();
		$order = $order[0];
	
	$query = "SELECT * FROM [pre]stock_order_products WHERE `order_id`= :1 LIMIT 10000";
	
		$products_stmt = $dbh->prepare($query);
		$products_arr = $products_stmt->execute($order_id);
		
		$products = $products_arr->fetchallAssoc();
	
	// Ловим штрих-код товара из заявки
		
	$code = strip_tags($_POST['code']);
	
	// Вытягиваем те полочки из таблицы связей, которые уже зранаят товары с таким штрих-кодом из других заявок
	
	$query = "SELECT shelf_id FROM [pre]shop_products_shelf_ref WHERE `order_id` != :1 AND `product_code` = :2 ORDER BY id LIMIT 1000";
	
		$code_shelfs_stmt	= $dbh->prepare($query);
		$code_shelfs_arr	= $code_shelfs_stmt->execute($order_id,$code);
		
		$code_shelfs = $code_shelfs_arr->fetchallAssoc();
	
	// Вытягиваем информацию о продукте по штрих-коду товара
	
	$query = "SELECT * FROM [pre]stock_order_products WHERE `code`= :1 AND `order_id` = :2 LIMIT 1";
	
		$product_stmt = $dbh->prepare($query);
		$product_arr = $product_stmt->execute($code,$order_id);
		
		$product = $product_arr->fetchallAssoc();
		$product = $product[0];
	
		$product_id = $product['id'];
		
		$message = "Товар найден и отмечен.";
		
		if($product != null)
		{
				if($product['code'] == $code)
				{
					$search_status = true;
					
					if($product['shipped'] < $product['quant'])
					{
						// Создаем запрос в таблицу связей товаров из заказа и полок на складе для предложения ближайшей полки
						
						$and_not_shelfs = "";
						
						foreach($code_shelfs as $code_shelf)
						{
							$and_not_shelfs .= " AND `id` != '".$code_shelf['shelf_id']."'";
						}
						
						$query = "	SELECT * FROM [pre]stock_fields WHERE 
									`stock_id`	= :1	AND 
									`zona`		= :2	AND 
									`rack`		= :3	AND 
									`fullness`	< 2		AND
									`block`		= 0		AND 
									`shelf`		>= 0 	".$and_not_shelfs."
									ORDER BY section, shelf 
									LIMIT 1";
							
							$preposition_shelf_stmt	= $dbh->prepare($query);
							$preposition_shelf_arr	= $preposition_shelf_stmt->execute($order['stock_id'],$order['zona'],$order['rack']);
							
							$preposition_shelf = $preposition_shelf_arr->fetchallAssoc();
							$ps = $preposition_shelf[0];
							
							// echo '<pre>'; print_r($preposition_shelf); echo '<pre>';
							
							$preposition_shelf = $ps['stock_id'].$ps['zona'].$ps['rack'].$ps['section'].$ps['shelf'];
							
						// Обновляем количество отмеченных едениц по коду
						
						$product['shipped'] = $product['shipped']+1;
						
						$update_query = "UPDATE [pre]stock_order_products SET `shipped` = '".$product['shipped']."' WHERE `id`='".$product_id."' LIMIT 1";
						
						$update_stmt = $dbh->prepare($update_query);
						$update_stmt->execute();
						
						// Присваеваем что данная еденица товара по коду лежит в предложенной ячейке 
						
						$now_time = date("Y-m-d H:i:s",time());
						
						$query = "INSERT INTO [pre]shop_products_shelf_ref 
								(`id`,`order_id`,`product_code`,`shelf_id`,`quant`,`dateCreate`) VALUES
								(NULL,:1,:2,:3,:4,:5)";
								
							$ref_stmt	= $dbh->prepare($query);
							$ref_arr	= $ref_stmt->execute($order_id,$code,$ps['id'],1,$now_time);
						?>
                        <script type="text/javascript" language="javascript">
							$('#cur_shelf_id').html('<?php echo $preposition_shelf ?>');
						
							$('#shipped_quant_<?php echo $product_id ?>').html(<?php echo $product['shipped'] ?>);
							<?php
								if($product['shipped'] == $product['quant'])
								{
									?>
									$('.maintable tr').removeClass('entered');
									$('#order-product-<?php echo $product_id ?>').addClass('shipped');
									
									var total_pos = parseInt($('#total_position').html());
									total_pos++;
									$('#total_position').html(total_pos);
									
									if(total_pos == <?php echo sizeof($products) ?>)
									{
										$('#get_order_button').removeClass('nonactive');
										$('#get_order_button').attr('title','Принять заказ');
									}
									<?php
								}else{
									?>
									$('.maintable tr').removeClass('entered');
									$('#order-product-<?php echo $product_id ?>').addClass('entered');
									<?php
									}
							?>
                        </script>
						<?php
						
					}else{
							$message = "Данный товар уже отмечен в полном количестве.";
						}
				}else
				{
					$message = "Штрих-код товара не совпадает.";
				}
			
			if($search_status)
			{
				echo $message;
			}else
			{
				echo 'Товар не найден.';
			}
			
		}else echo 'Товар с кодом <b>'.$code.'</b> не существует в заявке.';
?>
</body>

</html>