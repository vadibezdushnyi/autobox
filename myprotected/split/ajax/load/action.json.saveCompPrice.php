<?php // ajax json action
	require_once "../../../require.base.php";
	
	require_once "../../library/AjaxHelp.php";
	
	$data = array('status'=>"error",'message'=>"Failed saving.");
	
	$ah = new ajaxHelp($dbh);
	
	$price = (float)$_POST['price'];
	
	$id = (int)$_POST['id'];
	
	
	$query = "UPDATE [pre]shop_prod_complect_ref SET `c_price`='$price' WHERE `id`=$id LIMIT 1";
	
	$ah->rs($query);
	
	$data['message'] = "Saved.";
	
echo json_encode($data);

