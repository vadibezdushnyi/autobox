<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// Delete shop order
	
	$appTable = "shop_orders";
	
	$id = $_POST['orderId'];
	
	$root_path = "../../../..";
	
	// Start to change products quant
	
		$query = "SELECT products,status FROM [pre]shop_orders WHERE `id`=$id LIMIT 1";
	
		$orderData = $ah->rs($query);
		
		$data['test'] = 0;
		
		if($orderData)
		{
			$orderProducts = $orderData[0]['products'];
			
			$old_order_status = $orderData[0]['status'];
			
			$new_order_status = 5;
			
			if($orderProducts != "")
			{
				$op = unserialize($orderProducts);
				
				foreach($op as $prod)
				{	
					$query = "SELECT price,quant,in_stock FROM [pre]shop_products WHERE `id`='".$prod['prod_id']."' LIMIT 1";
					$prodCurr = $ah->rs($query);
					
					if($prodCurr)
					{
						$pr = $prodCurr[0];
						
						if($old_order_status!=5 && $new_order_status==5)
						{
							
							$data['test'] = 2;
							
							$new_quant = $pr['quant']+$prod['quant'];
							$new_in_stock = $pr['in_stock']+$prod['quant'];
							
							if($new_quant < 0) $new_quant = 0;
							if($new_in_stock < 0) $new_in_stock = 0;
							
							$query = "UPDATE [pre]shop_products SET `quant`='$new_quant', `in_stock`='$new_in_stock' WHERE `id`='".$prod['prod_id']."' LIMIT 1";
							$ah->rs($query);
						}
						
						if($old_order_status==5 && $new_order_status!=5)
						{
							
							$new_quant = $pr['quant']-$prod['quant'];
							$new_in_stock = $pr['in_stock']-$prod['quant'];
							
							if($new_quant < 0) $new_quant = 0;
							if($new_in_stock < 0) $new_in_stock = 0;
							
							$query = "UPDATE [pre]shop_products SET `quant`='$new_quant', `in_stock`='$new_in_stock' WHERE `id`='".$prod['prod_id']."' LIMIT 1";
							$ah->rs($query);
						}
						
					}
				}
			}
		}
		
	// End of change products quant
	
	$query = "DELETE FROM [pre]$appTable WHERE `id`=$id LIMIT 1";
	$ah->rs($query);
	
	$data['status'] = 'success';
	$data['message'] = 'Заказ №'.(5000+$id)." успешно удален.";
	