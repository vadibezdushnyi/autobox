<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					'user_id'		=> (int)$_POST['user_id'],
					'art_id'		=> (int)$_POST['art_id'],
					
					'name'			=> str_replace("'","\'",$_POST['name']),
					'caption'		=> str_replace("'","\'",$_POST['caption']),
					'comment'		=> str_replace("'","\'",$_POST['comment']),
					
					'rating'		=> (int)$_POST['rating'],
					
					'block'			=> $_POST['block'][0],
					
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
					
	if($cardUpd['rating'] < 1) $cardUpd['rating']  = 1;
	if($cardUpd['rating'] > 5) $cardUpd['rating']  = 5;
					
	// Update main table
	
	$query = "UPDATE [pre]$appTable SET ";
	
	$cntUpd = 0;
	foreach($cardUpd as $field => $itemUpd)
	{
		$cntUpd++;
		$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
	}
	
	$query .= " WHERE `id`=$item_id LIMIT 1";
		
	$data['query'] = $query;
		
	$ah->rs($query);
	
	
	
	$data['message'] = "Отзыв успешно сохранен";
	