<?php // ajax json action
	require_once "../../../require.base.php";
	
	require_once "../../library/AjaxHelp.php";
	
	$ah = new ajaxHelp($dbh);
	
	$result = "";
	
	$appTable = "shop_catalog";

	$parentId	= $_POST['parentId'];
	
	$orderId	= $_POST['orderId'];
	
	$type		= $_POST['type'];
	
	if($parentId > 0)
	{
	
		$query = "SELECT id,name FROM [pre]$appTable WHERE `parent`=$parentId ORDER BY id LIMIT 10000";
	
		$categoriesMassive = $ah->rs($query);
		
		if($categoriesMassive)
		{
			$result = $ah->print_select("Категория",
															0,
															$categoriesMassive,
															'id',
															'name',
															'challange_cats',
															"reload_adding_products_admin($(this).val(),$orderId, '$type');",
															$first=array('name'=>'Выбрать...','id'=>0),
															false 
															);
		}
	
	}
	
	$data['message'] = $result;
	
	$data['status'] = "success";
	
	
echo json_encode($data);
