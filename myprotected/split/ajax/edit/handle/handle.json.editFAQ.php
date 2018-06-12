<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	$item_id = $_POST['item_id'];
	$lpx = $_POST['lpx'];
	$lang_prefix = ($lpx ? $lpx."_" : ""); 
	$tags = $_POST['tags'];
	
	$cardUpd = array(
		$lang_prefix.'question'		=> $_POST['question'],
		$lang_prefix.'answer'		=> $_POST['answer'],
		'block'						=> $_POST['block'][0],
		'order_id'					=> $_POST['order_id'],
		'dateModify'				=> date("Y-m-d H:i:s", time()),
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
			
	$ah->rs($query);

	if($tags) {
		$ah->rs("DELETE FROM osc_faq_tags_ref WHERE `faq_id` = $item_id");
		foreach($tags as $tag_id) {
			$ah->rs("INSERT INTO osc_faq_tags_ref (faq_id, tag_id) VALUES ($item_id, $tag_id)");
		}		
	}
	
	$data['message'] = "FAQ #$item_id saved.";
	