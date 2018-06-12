<?php // ajax json action
	require_once "../../../require.base.php";
	
	require_once "../../library/AjaxHelp.php";
	
	$ah = new ajaxHelp($dbh);
	
	$result = "";
	
	$appTable	= "shop_products";

	$catId		= $_POST['catId'];
	
	$prodId		= $_POST['prodId'];
	
	if($catId > 0)
	{
	
		$query = "SELECT M.* FROM 
					[pre]$appTable as M
					LEFT JOIN [pre]shop_cat_prod_ref as R ON M.id=R.prod_id  
					WHERE R.cat_id=$catId 
					ORDER BY id 
					LIMIT 10000";
	
		$productsMassive = $ah->rs($query);
		
		if($productsMassive)
		{
			//$result = "Products: ".count($productsMassive);
			$result = $ah->print_adding_products_for_accessuares($productsMassive,$prodId);
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
