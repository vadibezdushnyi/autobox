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
			
	$filename = "logo";
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = '../../../../public/img/content/parts/';
		$file_update = $ah->mtvc_add_files_file(array(
			'path'			=>$file_path,
			'name'			=>5,
			'pre'			=>"industry_",
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
			$ah->rs("DELETE FROM osc_producers_categories WHERE `category_id` = $item_id");
			foreach($refs as $ref_id) {
				$ah->rs("INSERT INTO osc_producers_categories (producer_id, category_id) VALUES ($ref_id, $item_id)");
			}		
		}
		$data['message'] = "Created.";
	} else {
		$data['item_id'] = 0;
		$data['message'] = "Error occured.";
	}
	
	