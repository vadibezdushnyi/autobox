<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					'name'			=> $_POST['name'],
					'alias'			=> $_POST['alias'],
					'block'			=> $_POST['block'][0],
					'admin_enter'	=> $_POST['admin_enter'][0],
					'change_login'	=> $_POST['change_login'][0],
					
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
					
	
	// Update main table
	
	$query = "UPDATE [pre]$appTable SET ";
	
	$cntUpd = 0;
	foreach($cardUpd as $field => $itemUpd)
	{
		$cntUpd++;
		$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
	}
	
	$query .= " WHERE `id`=$item_id LIMIT 1";
		
	$data['block'] = $cardUpd['block'];
	
	$data['query'] = $query;
		
	$ah->rs($query);
	
	// Update sccess values to menu items
	
	$ac = $_POST['ac'];
	
	foreach($ac as $menu_id => $access)
	{
		$query = "SELECT id FROM [pre]user_type_access WHERE `type_id`='$item_id' AND `menu_id`='$menu_id' ORDER BY id DESC LIMIT 1";
		$refData = $ah->rs($query);
		
		if($refData)
		{
			$refId = $refData[0]['id'];
			$query = "UPDATE [pre]user_type_access SET `access`='$access' WHERE `id`='$refId' LIMIT 1";
			$ah->rs($query);
		}else
		{
			$query = "INSERT INTO [pre]user_type_access (`type_id`,`menu_id`,`access`) VALUES ('$item_id','$menu_id','$access')";
			$ah->rs($query);
		}
	}
	
	$data['status'] = 'success';
	$data['message'] = 'Success save';