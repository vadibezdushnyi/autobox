<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	$tags = $_POST['tags'];
	
	$cardUpd = array(
					'question'		=> $_POST['question'],
					'answer'		=> $_POST['answer'],
					'block'			=> $_POST['block'][0],
					'order_id'		=> $_POST['order_id'],
					
					'dateCreate'	=> date("Y-m-d H:i:s", time()),
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
	
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
		
	$item_id = $ah->rs($query,0,1,1);
	
	if($item_id)
	{
		$data['item_id'] = $item_id;
		if($tags) {
			foreach($tags as $tag_id) {
				$ah->rs("INSERT INTO osc_faq_tags_ref (faq_id, tag_id) VALUES ($item_id, $tag_id)");
			}		
		}
		$data['message'] = "CREATED";
		$data['status'] = "success";
	}else
	{
		$data['item_id'] = 0;
	}

	
	