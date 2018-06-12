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
	
	$query = "SELECT * FROM [pre]shop_orders WHERE `id`= :1 LIMIT 1";
	
		$order_stmt = $dbh->prepare($query);
		$order_arr = $order_stmt->execute($order_id);
		
		$order = $order_arr->fetchallAssoc();
		$order = $order[0];
		
		$product_id = 0;
		$message = "Товар найден и отмечен.";
		
		if($order != null)
		{
			$products = unserialize($order['products']);
			
			$search_status = false;
			
			foreach($products as $number => $product)
			{
				if($product['code'] == $code)
				{
					$search_status = true;
					
					$product_id = $product['id'];
					
					if($product['shipped'] < $product['quant'])
					{
						$products[$number]['shipped'] = $products[$number]['shipped']+1;
						
						$update_query = "UPDATE [pre]shop_orders SET `products` = '".serialize($products)."' WHERE `id`='".$order_id."' LIMIT 1";
						
						$order_update_stmt = $dbh->prepare($update_query);
						$order_update_stmt->execute();
						
						?>
                        <script type="text/javascript" language="javascript">
							$('#shipped_quant_<?php echo $product_id ?>').html(<?php echo $products[$number]['shipped'] ?>);
							<?php
								if($products[$number]['shipped'] == $product['quant'])
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
										$('#get_order_button').attr('title','Сформировать заказ');
									
										$('#order_code').focus();
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
					break;
				}
			}
			
			if($search_status)
			{
				echo $message;
			}else
			{
				echo 'Товар не найден.';
			}
			
		}else echo 'Заказ №'.$order_id.' не существует.';
?>
</body>

</html>