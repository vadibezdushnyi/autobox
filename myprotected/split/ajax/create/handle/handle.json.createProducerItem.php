<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	$lang_fields = json_decode(stripcslashes($_POST['av_langs']));
	$refs = $_POST['refs'];
		
	$cardUpd = array(
		'description'				=> str_replace("'", "\'", $_POST['description']),
		'de_description'			=> str_replace("'", "\'", $_POST['description']),
		'ru_description'			=> str_replace("'", "\'", $_POST['description']),
		'cz_description'			=> str_replace("'", "\'", $_POST['description']),
		'sk_description'			=> str_replace("'", "\'", $_POST['description']),
		'tr_description'			=> str_replace("'", "\'", $_POST['description']),
		'es_description'			=> str_replace("'", "\'", $_POST['description']),
		'ar_description'			=> str_replace("'", "\'", $_POST['description']),
		'meta_title'				=> str_replace("'", "\'", $_POST['meta_title']),
		'de_meta_title'				=> str_replace("'", "\'", $_POST['meta_title']),
		'ru_meta_title'				=> str_replace("'", "\'", $_POST['meta_title']),
		'cz_meta_title'				=> str_replace("'", "\'", $_POST['meta_title']),
		'sk_meta_title'				=> str_replace("'", "\'", $_POST['meta_title']),
		'tr_meta_title'				=> str_replace("'", "\'", $_POST['meta_title']),
		'es_meta_title'				=> str_replace("'", "\'", $_POST['meta_title']),
		'ar_meta_title'				=> str_replace("'", "\'", $_POST['meta_title']),
		'meta_keys'					=> str_replace("'", "\'", $_POST['meta_keys']),
		'de_meta_keys'				=> str_replace("'", "\'", $_POST['meta_keys']),
		'ru_meta_keys'				=> str_replace("'", "\'", $_POST['meta_keys']),
		'cz_meta_keys'				=> str_replace("'", "\'", $_POST['meta_keys']),
		'sk_meta_keys'				=> str_replace("'", "\'", $_POST['meta_keys']),
		'tr_meta_keys'				=> str_replace("'", "\'", $_POST['meta_keys']),
		'es_meta_keys'				=> str_replace("'", "\'", $_POST['meta_keys']),
		'ar_meta_keys'				=> str_replace("'", "\'", $_POST['meta_keys']),
		'meta_desc'					=> str_replace("'", "\'", $_POST['meta_desc']),
		'de_meta_desc'				=> str_replace("'", "\'", $_POST['meta_desc']),
		'ru_meta_desc'				=> str_replace("'", "\'", $_POST['meta_desc']),
		'cz_meta_desc'				=> str_replace("'", "\'", $_POST['meta_desc']),
		'sk_meta_desc'				=> str_replace("'", "\'", $_POST['meta_desc']),
		'tr_meta_desc'				=> str_replace("'", "\'", $_POST['meta_desc']),
		'es_meta_desc'				=> str_replace("'", "\'", $_POST['meta_desc']),
		'ar_meta_desc'				=> str_replace("'", "\'", $_POST['meta_desc']),
		'Block'						=> $_POST['Block'][0],
		'show_home'					=> $_POST['show_home'][0],
		'products_amount'			=> $_POST['products_amount'],
		'Name'						=> $_POST['Name'],
		'Modified'					=> date("Y-m-d H:i:s", time()),
		'Created'					=> date("Y-m-d H:i:s", time()),
	);
					
	$filename = "Logo";
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = '../../../../public/img/icons-general/car-logos/';
		$file_update = $ah->mtvc_add_files_file(array(
			'path'			=>$file_path,
			'name'			=>5,
			'pre'			=>"producer_",
			'size'			=>10,
			'rule'			=>0,
			'max_w'			=>2500,
			'max_h'			=>2500,
			'files'			=>$filename,
			'resize_path'	=>0,
			'resize_w'		=>0,
			'resize_h'		=>0
	  	));
		if($file_update) {
			$cardUpd[$filename] = $file_update;
		}
	}
	
	$filename = "cover";
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = '../../../../public/img/content/';
		$file_update = $ah->mtvc_add_files_file(array(
			'path'			=>$file_path,
			'name'			=>5,
			'pre'			=>"producer_",
			'size'			=>10,
			'rule'			=>0,
			'max_w'			=>2500,
			'max_h'			=>2500,
			'files'			=>$filename,
			'resize_path'	=>0,
			'resize_w'		=>0,
			'resize_h'		=>0
	  	));
		if($file_update) {
			$cardUpd[$filename] = $file_update;
		}
	}
	
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
	
	if($item_id) {
		$data['item_id'] = $item_id;
		if($refs) {
			$ah->rs("DELETE FROM osc_producers_categories WHERE `producer_id` = $item_id");
			foreach($refs as $ref_id) {
				$ah->rs("INSERT INTO osc_producers_categories (producer_id, category_id) VALUES ($item_id, $ref_id)");
			}		
		}
		$data['message'] = "Created.";
	} else {
		$data['item_id'] = 0;
		$data['message'] = "Error occured.";
	}
	
	