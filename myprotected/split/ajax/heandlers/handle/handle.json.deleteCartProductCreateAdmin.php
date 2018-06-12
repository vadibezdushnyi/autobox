<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = "shop_orders";
	
	$pi = $_POST['pi'];
	
	$productsJs = $_POST['productsJs']; 
	
	$root_path = "../../../..";
	
	$data['productsJsStr'] = serialize(array());
		
	$orderProducts = unserialize($productsJs);
		
	if($orderProducts)
	{
			if(isset($orderProducts[$pi]))
			{
				$query = "SELECT price FROM [pre]shop_products WHERE `id`='".$orderProducts[$pi]['prod_id']."' LIMIT 1";
				$prodMass = $ah->rs($query);
				
				$deleteQuant = $orderProducts[$pi]['quant'];
				
				$deleteSum = $orderProducts[$pi]['quant']*$orderProducts[$pi]['price'];
				
				
				$quant = $orderProducts[$pi]['quant'];
				
					// Обновляем список товаров в корзине
					
					unset($orderProducts[$pi]);
				
					$resultProducts = serialize($orderProducts);
				
					$data['productsJsStr'] = $resultProducts;
				
					$data['deleteQuant'] = $deleteQuant;
					
					$data['deleteSum'] = $deleteSum;	
				
					$data['message'] = "Success delete product from creating order";
				
			}
	}
	