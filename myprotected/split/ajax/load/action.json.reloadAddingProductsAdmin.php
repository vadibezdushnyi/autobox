<?php // ajax json action
	require_once "../../../require.base.php";
	
	require_once "../../library/AjaxHelp.php";
	
	$ah = new ajaxHelp($dbh);
	
	$result = "";
	
	$appTable	= "shop_products";

	$catId		= $_POST['catId'];
	
	$orderId	= $_POST['orderId'];
	
	$type		= $_POST['type'];
	
	if($catId > 0)
	{
	
		$query = "SELECT M.* FROM 
					[pre]$appTable as M
					LEFT JOIN [pre]shop_cat_prod_ref as R ON M.id=R.prod_id  
					WHERE `block`=0 AND R.cat_id=$catId 
					ORDER BY id 
					LIMIT 10000";
	
		$productsMassive = $ah->rs($query);
		
		if($productsMassive)
		{
			//$result = "Products: ".count($productsMassive);
			$result = $ah->print_adding_products_list_table($productsMassive,$orderId,$type);
		}else
		{
			$result = "В категории нет ни одного доступного товара.";
		}
	
	}else
		{
			$result = "Категория еще не выбрана.";
		}
	
	$data['message'] = $result;
	
	$data['status'] = "success";
	
	
echo json_encode($data);
