<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = "shop_orders";
	
	$id = $_POST['orderId'];
	
	$pi = $_POST['pi'];
	
	$root_path = "../../../..";
	
	$query = "SELECT products,sum,products_quant FROM [pre]$appTable WHERE `id`=$id LIMIT 1";
	$orderMass = $ah->rs($query);
	
	if($orderMass)
	{
		if($orderMass[0]['products'] != "")
		{
			$orderProducts = unserialize($orderMass[0]['products']);
			
			if(isset($orderProducts[$pi]))
			{
				$query = "SELECT price FROM [pre]shop_products WHERE `id`='".$orderProducts[$pi]['prod_id']."' LIMIT 1";
				$prodMass = $ah->rs($query);
				
				$quant = $orderProducts[$pi]['quant'];
				
				if($prodMass)
				{
					// Обновляем сумму заказа
					
					$prod_price = $prodMass[0]['price'];
					
					$resultSum = $orderMass[0]['sum'] - ($orderProducts[$pi]['quant']*$prod_price);
					
					// Обновляем список товаров в корзине
					
					unset($orderProducts[$pi]);
				
					$resultProducts = serialize($orderProducts);
					
					// Обновляем количество товаров в заказе
					
					$resultProductsQuant = $orderMass[0]['products_quant']-$quant;
					
					// Обновляем заказ
				
					$query = "UPDATE [pre]$appTable set `products`='$resultProducts', `sum`='$resultSum', `products_quant`='$resultProductsQuant' WHERE `id`='$id' LIMIT 1";
					$ah->rs($query);
				
					$data['message'] = "Success delete product from order";
				}
			}
		}
	}
	