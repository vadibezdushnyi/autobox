<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];

	$lpx = $_POST['lpx'];
	
	$lang_prefix = ($lpx ? $lpx."_" : ""); // empty = en

	$query = "SELECT `id`, `file` FROM [pre]$appTable WHERE `id`='$item_id' LIMIT 1";
	$testRow = $ah->rs($query,1);
	$old_file = $testRow['file'];

	$related_menus = $_POST['menus'];
	$cardUpd = array(
		'name'			=> str_replace("'", "\'", $_POST['name']),
		'de_name'		=> str_replace("'", "\'", $_POST['de_name']),
		'ru_name'		=> str_replace("'", "\'", $_POST['ru_name']),
		'cz_name'		=> str_replace("'", "\'", $_POST['cz_name']),
		'sk_name'		=> str_replace("'", "\'", $_POST['sk_name']),
		'tr_name'		=> str_replace("'", "\'", $_POST['tr_name']),
		'es_name'		=> str_replace("'", "\'", $_POST['es_name']),
		'ar_name'		=> str_replace("'", "\'", $_POST['ar_name']),
		'order_id'		=> (int)$_POST['order_id'],
		'block'			=> (int)$_POST['block'][0],
		'news_list'		=> (int)$_POST['news_list'][0],
		'producers_list'	=> (int)$_POST['producers_list'][0],
		'directions_list'=> (int)$_POST['directions_list'][0],
	);


	$query = "UPDATE [pre]$appTable SET ";
	
	$cntUpd = 0;
	foreach($cardUpd as $field => $itemUpd)
	{
		$cntUpd++;
		$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
	}
	
	$query .= " WHERE `id`=$item_id LIMIT 1";
	
	$ah->rs($query);	

	$ah->rs("DELETE FROM [pre]menu_sitemap_relations WHERE category_id = $item_id");
	if($related_menus):
		foreach($related_menus as $menu_id):
			$menu_id = (int)$menu_id;
			$ah->rs("INSERT INTO [pre]menu_sitemap_relations (menu_id, category_id) VALUES ($menu_id, $item_id)");
		endforeach;
	endif;
	
	$data['message'] = "Saved.";
	