<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	$item_id = $_POST['item_id'];
	$lpx = $_POST['lpx'];
	$lang_prefix = ($lpx ? $lpx."_" : ""); 
	$posts = $_POST['posts'];
	
	$cardUpd = array(
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
		
	if(isset($_POST['alias'])) {
		$cardUpd['alias'] = $_POST['alias'];
	}				
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

	$data['posts'] = $posts; 

	if($posts) {
		$ah->rs("DELETE FROM osc_article_tags_ref WHERE `tag_id` = $item_id");
		foreach($posts as $art_id) {
			$ah->rs("INSERT INTO osc_article_tags_ref (art_id, tag_id) VALUES ($art_id, $item_id)");
		}		
	}
	
	$data['message'] = "FAQ #$item_id saved.";
	