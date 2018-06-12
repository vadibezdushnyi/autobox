<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	$posts = $_POST['posts'];

	
	$cardUpd = array(
		'alias'		=> $_POST['alias'],
		'name'		=> $_POST['name'],
		'de_name'	=> $_POST['de_name'],
		'ru_name'	=> $_POST['ru_name'],
		'sk_name'	=> $_POST['sk_name'],
		'cz_name'	=> $_POST['cz_name'],
		'tr_name'	=> $_POST['tr_name'],
		'es_name'	=> $_POST['es_name'],
		'ar_name'	=> $_POST['ar_name'],
		'block'		=> $_POST['block'][0],
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
	
	if($item_id) {
		$data['item_id'] = $item_id;
		if($posts) {
			foreach($posts as $art_id) {
				$ah->rs("INSERT INTO osc_article_tags_ref (art_id, tag_id) VALUES ($art_id, $item_id)");
			}	
		}
		$data['status'] = "success";
		$data['message'] = "CREATED";
	} else {
		$data['item_id'] = 0;
		$data['message'] = "ERROR OCCURED";
	}
	