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
					
					'dateCreate'	=> date("Y-m-d H:i:s", time()),
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
					
	if(strlen($cardUpd['name'])>1)
	{
		// Create main table item
		
		$query = "INSERT INTO [pre]$appTable ";
		
		$fieldsStr = " ( ";
		
		$valuesStr = " ( ";
		
		$cntUpd = 0;
		foreach($cardUpd as $field => $itemUpd)
		{
			$cntUpd++;
			
			$fieldsStr .= ($cntUpd==1 ? "`$field`" : ", `$field`");
			
			$valuesStr .= ($cntUpd==1 ? "'$itemUpd'" : ", '$itemUpd'");
		}
		
		$fieldsStr .= " ) ";
		
		$valuesStr .= " ) ";
		
		$query .= $fieldsStr." VALUES ".$valuesStr;
			
		$data['block'] = $cardUpd['block'];
		
		$data['query'] = $query;
			
		$ah->rs($query);
		
		$item_id = mysql_insert_id();
		
		$data['item_id'] = $item_id;
		
		// Update sccess values to menu items
		
		$ac = $_POST['ac'];
		
		foreach($ac as $menu_id => $access)
		{
			$query = "INSERT INTO [pre]user_type_access (`type_id`,`menu_id`,`access`) VALUES ('$item_id','$menu_id','$access')";
			$ah->rs($query);
			unset($ac[$menu_id]);
		}
		
		$data['status'] = "success";
		$data['message'] = "Success save";
	}else
	{
		$data['status']='failed';
		$data['message']='Укажите название группы пользователей';
	}
	