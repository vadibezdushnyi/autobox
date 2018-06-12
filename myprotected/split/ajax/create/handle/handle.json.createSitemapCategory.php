<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	$lang_fields = json_decode(stripcslashes($_POST['av_langs']));
	$data['$related_menus'] = $related_menus;
		
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
					
	// Create main table item
	
	$query = "INSERT INTO [pre]$appTable ";
	
	$fieldsStr = " ( ";
	
	$valuesStr = " ( ";
	
	$cntUpd = 0;
	foreach($cardUpd as $field => $itemUpd) {
		$cntUpd++;
		$fieldsStr .= ($cntUpd==1 ? "`$field`" : ", `$field`");
		$valuesStr .= ($cntUpd==1 ? "'$itemUpd'" : ", '$itemUpd'");
	}
	$fieldsStr .= " ) ";
	$valuesStr .= " ) ";
	$query .= $fieldsStr." VALUES ".$valuesStr;
	$item_id = $ah->rs($query,0,1,1);

	$data['query'] = $query;
	
	if($item_id) {
		$data['item_id'] = $item_id;
		if($related_menus):
			foreach($related_menus as $menu_id):
				$menu_id = (int)$menu_id;
				$ah->rs("INSERT INTO [pre]menu_sitemap_relations (menu_id, category_id) VALUES ($menu_id, $item_id)");
			endforeach;
		endif;
		$data['message'] = "Created.";
	} else {
		$data['item_id'] = 0;
		$data['message'] = "Error occured.";
	}
	
	