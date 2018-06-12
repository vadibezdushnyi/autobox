<?php // ajax json action
	require_once "../../../require.base.php";
	
	require_once "../../library/AjaxHelp.php";
	
	$appTable = "shop_products";

	$ah = new ajaxHelp($dbh);
	
	$sku = strip_tags(trim(str_replace("'","\'",$_POST['sku'])));
	
	$data['prod_id'] = 0;
	$data['prod_name'] = "Товар не найден по артикулу :(";
	$data['prod_price'] = 0;

	if($sku)
	{
	
		$query = "SELECT id,name,price FROM [pre]$appTable WHERE `sku`='$sku' LIMIT 1";
	
		$prod = $ah->rs($query);
		
		if($prod)
		{
			$data['prod_id'] = $prod[0]['id'];
			$data['prod_name'] = $prod[0]['name'];
			$data['prod_price'] = $prod[0]['price'];

			$data['message'] = "Товар найден.";
		}
	
	}
	
	$data['status'] = "success";
	
	
echo json_encode($data);
