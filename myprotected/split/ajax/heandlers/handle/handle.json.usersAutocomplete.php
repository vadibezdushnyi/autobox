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
	
		$mass = explode(" ",$query);
	
		$q1 = $mass[0];
		$q2 = (isset($mass[1]) ? $mass[1] : "");
	
		if($q2 != "")
		{
			$DBquery = "SELECT id,name,fname,login,phone,delivery_address FROM [pre]users WHERE (`name`LIKE'%$q1%' AND `fname`LIKE'%$q2%') OR (`name`LIKE'%$q2%' AND `fname`LIKE'%$q1%') OR `id`='$query' LIMIT 100";
		
		}else
		{
			$DBquery = "SELECT id,name,fname,login,phone,delivery_address FROM [pre]users WHERE (`name`LIKE'%$q1%') OR (`fname`LIKE'%$q1%') OR (`login`LIKE'%$q1%') OR `id`='$query' LIMIT 100";
		}
		$resultMass = $ah->rs($DBquery);
		
		if($resultMass)
		{
			foreach($resultMass as $item)
			{
				array_push($data['suggestions'],array('value'=>$item['name']." ".$item['fname'],'data'=>$item['id'],
														'name'	=> $item['name'],
														'fname'	=> $item['fname'],
														'login'	=> $item['login'],
														'phone'	=> $item['phone'],
														'delivery_address' => $item['delivery_address'] 
														));
			}
		}
	} // end if $query != ""
	
	echo json_encode($data);	