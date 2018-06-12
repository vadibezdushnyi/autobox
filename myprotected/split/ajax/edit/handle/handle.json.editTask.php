<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$to_id		= $_POST['user_id'];
	$from_id	= ADMIN_ID;
	
	$cardUpd = array(
					'subject'		=> $_POST['subject'],
					'comment'		=> $_POST['comment'],
					'status'		=> $_POST['status'],
					
					'date_finish'	=> date("Y-m-d H:i:s", strtotime($_POST['date_finish'])),
					
					'dateModify'	=> date("Y-m-d H:i:s", time()),
					'adminMod'		=> ADMIN_ID
					);
					
	// Update ref table
	

	$query = "SELECT task_id FROM [pre]task_admin_ref WHERE `task_id`=$item_id LIMIT 1";
	
	$ref = $ah->rs($query);


	
	if($ref)
	{
		$task_id = $ref[0]['task_id'];
		
		$query = "UPDATE [pre]task_admin_ref SET `admin_id`='$from_id', `responsible_id`='$to_id' WHERE `id`=$item_id LIMIT 1";
		$ah->rs($query);
						
		// Update main table
		
		$query = "UPDATE [pre]$appTable SET ";
		
		$cntUpd = 0;
		foreach($cardUpd as $field => $itemUpd)
		{
			$cntUpd++;
			$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
		}
		
		$query .= " WHERE `id`=$task_id LIMIT 1";
				
		$ah->rs($query);
		
		$data['message'] = "Задание #$item_id успешно обновлено.";
	
	}else
	{
		$data['message'] = "Задания по номером #$item_id не существует.";
	}