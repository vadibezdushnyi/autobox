<?php  
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
	
	require_once "../../library/AjaxHelp.php";
	
	$r = array("status"=>"fail", "message"=>"error");
	
	$ah = new ajaxHelp($dbh);

	$items = $_POST['items'];
	$table = $_POST['table'];

	if(sizeof($items) == 0){ $r["message"] = "Ни одна запись не найдена."; }
	
	if($items) $r["message"] = "";
	
	foreach($items as $item_id)
	{
		$query = "SELECT * FROM [pre]".$table." WHERE `id`='".$item_id."' LIMIT 1";

		$data = $ah->dbh->q($query,1);
		
		$update_query = "UPDATE [pre]".$table." SET `block`=1 WHERE `id`='".$item_id."' LIMIT 1";

		$update = $ah->dbh->q($update_query,0,1);
		
		$item_name = "[".$data[0]['id']."]";
		
		$item_name .= " ".(isset($data['name']) ? $data['name'] : (isset($data['title']) ? $data['title'] : "Unknown"));
		
		$r["message"] .= "ROW $item_name is blocked";
	}
	
	$r["status"] = "success";
	
	echo json_encode($r); exit();
