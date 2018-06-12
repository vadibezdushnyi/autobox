<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = "shop_orders";
	
	$orderId	= $_POST['orderId'];
	
	$pid 		= $_POST['pid'];
	
	$quant 		= $_POST['quant'];
	
	$char_ref_id = (isset($_POST['char_ref_id']) ? (int)$_POST['char_ref_id'] : 0);
	
	$type 		= $_POST['type'];
	
	$productsJs = $_POST['productsJs']; 
	
	$data['type']		= $type;
	
	$data['productsJsStr'] = serialize(array());
	
	$root_path = "../../../..";
	
	if($type == 'create')
	{
		$orderMass = array(
							array(
								'products'			=>$productsJs,
								'sum'				=>0,
								'products_quant'	=>0
								)
						);
	}else
	{
		$query = "SELECT products,sum,products_quant FROM [pre]$appTable WHERE `id`=$orderId LIMIT 1";
		$orderMass = $ah->rs($query);
	}
	
	$query = "SELECT M.* ,
					(SELECT cat_id FROM [pre]shop_cat_prod_ref WHERE prod_id=M.id ORDER BY id DESC LIMIT 1) as cat_id 
					FROM [pre]shop_products as M 
					WHERE `id`=$pid 
					LIMIT 1";
	$productMass = $ah->rs($query);
	
	$price_dif = 0;
	$char_value = 0;
	$price_char_id = 0;
	
	if($char_ref_id)
	{
		$query = "SELECT * FROM [pre]shop_chars_prod_ref WHERE `id`=$char_ref_id LIMIT 1";
		$charRef = $ah->rs($query);
		
		if($charRef)
		{
			$charRef = $charRef[0];
			
			$price_dif 		= $charRef['price_dif'];
			$char_value 	= $charRef['value'];
			$price_char_id 	= $charRef['char_id'];
		}
		
	}
	
	if($orderMass && $productMass)
	{
		$product = $productMass[0];
		
		$cartItem = array(
						  'id' 				=> 0,
						  'uid' 			=> $_COOKIE['user_id'],
						  'session_id' 		=> 0,
						  'prod_id' 		=> $pid,
						  'quant' 	   		=> $quant,
						  'char_id'			=> $char_ref_id,
						  'dateCreate' 		=> date("Y-m-d H:i:s",time()),
						  'dateModify' 		=> date("Y-m-d H:i:s",time()),
						  'price'			=> $productMass[0]['price'],
						  'name'			=> $product['name'],
						  'alias'			=> $product['alias'],
						  'price_dif'		=> $price_dif,
						  'char_value'		=> $char_value,
						  'price_char_id' 	=> $price_char_id,
						  'cat_id'			=> $product['cat_id']
						  );
		
		if($orderMass[0]['products'] != "")
		{
			$orderProducts = unserialize($orderMass[0]['products']);
			
			$sovpalo = false;
			
			foreach($orderProducts as $opi => $orderProduct)
			{
				if($orderProduct['prod_id']==$pid)
				{
					if($char_ref_id && $orderProduct['char_id']!=$char_ref_id) continue;
					
					$sovpalo = true;
					$orderProducts[$opi]['quant'] += $quant;
					break;
				}
			}
			
			if(!$sovpalo)
			{
				$data['sovp'] = 0;
				$data['price'] = $product['price'];
				array_push($orderProducts,$cartItem);
			}else
			{
				$data['sovp'] = 1;
			}
			
					// Обновляем сумму заказа
					
					$cart_product_price = ($char_ref_id ? $price_dif : $product['price']);
					
					$resultSum = $orderMass[0]['sum'] + ($quant*$cart_product_price);
					
					// Обновляем список товаров в корзине
					
					$resultProducts = serialize($orderProducts);
					
					// Обновляем количество товаров в заказе
					
					$resultProductsQuant = $orderMass[0]['products_quant']+$quant;
					
					// Обновляем заказ
				   
				    if($type=='create')
					{
						$data['productsJsStr'] = $resultProducts;
					}else
					{
						$query = "UPDATE [pre]$appTable set `products`='$resultProducts', `sum`='$resultSum', `products_quant`='$resultProductsQuant' WHERE `id`='$orderId' LIMIT 1";
						$ah->rs($query);
					}
				
					$data['message'] = "Success add product to order";
			
		}
	}
	