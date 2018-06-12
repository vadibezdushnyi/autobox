<?php // ajax json action
	require_once "../../../require.base.php";
	
	require_once "../../library/AjaxHelp.php";
	
	$ah = new ajaxHelp($dbh);
	
	$str = "";
	
	$appTable	= "shop_products";

	$products = unserialize($_POST['productsItems']);
	
			$orderSum = 0;
			
			$productsQuant = 0;
			
			$icnt = 0;
			foreach($products as $pi => $product)
			{
				$icnt++;
				$iid = $product['prod_id'];
				$iclass = ($icnt%2==1 ? "trcolor" : "");
		
				if(isset($product['prod_id']) && $product['prod_id'])
				{
		
					$prodMassive = $ah->rs("SELECT id,name,sku,code,price FROM [pre]shop_products WHERE id=".$product['prod_id']." LIMIT 1");
				}else
				{
					continue;
				}
				
					$prod = ($prodMassive ? $prodMassive[0] : array('id'=>0,'name'=>'','sku'=>'','code'=>'','price'=>0));
						
					$curr_price = ($product['price_dif'] ? $product['price_dif'] : $prod['price']);
					$curr_name	= ($product['price_dif'] ? $prod['name']." (".$product['char_value'].")" : $prod['name']);
						
					$curr_sum = $curr_price*$product['quant'];
				
				$str .= "
						<tr class='$iclass' id='$iid'>
						";
						
						$str .= "<td>".$curr_name."</td>";
						$str .= "<td>".$prod['sku']."</td>";
						$str .= "<td>".$product['quant']."</td>";
						$str .= "<td>".$curr_price."</td>";
						$str .= "<td>".$curr_sum."</td>";
						$str .= "<td>
									<button class='close-option r-z-h-s-close' type='button' title='Удалить из заказа' onclick=\"delete_create_cart_product_admin($pi);\"></button>
								</td>";
						
				$str .= "</tr>";
				
				$productsQuant += $product['quant'];
				
				$orderSum += $curr_sum;
			}
		
	$data['rows'] = $str;
	
	$data['orderSum'] = $orderSum;
	
	$data['productsQuant'] = $productsQuant;
	
	$data['status'] = "success";
	
	
echo json_encode($data);
