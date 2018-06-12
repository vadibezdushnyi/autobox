<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	require_once "../../../../require.base.php";
	
	require_once "../../../library/AjaxHelp.php";
	
	$ah = new ajaxHelp($dbh);
	
	$query = trim($_POST['term']);

	$data = array(
				"query"=>$query,
				"suggestions"=>array()
				);
	
	
	if($query!="")
	{ 
	
		$DBquery = "SELECT id,cat_id,name,rus_name FROM [pre]shop_mf WHERE (`name`LIKE'%$query%') OR (`rus_name`LIKE'%$query%') ORDER BY name LIMIT 100";
		
		$resultMass = $ah->rs($DBquery);
		
		if($resultMass)
		{
			foreach($resultMass as $item)
			{
				array_push($data['suggestions'],array('value'=>$item['name'],'data'=>$item['id'],
														'name'	=> $item['name'],
														'rus_name'	=> $item['rus_name'] 
														));
			}
		}
	} // end if $query != ""
	
	echo json_encode($data);	