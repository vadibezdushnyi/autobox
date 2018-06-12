<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	$item_id = $_POST['item_id'];
	$lpx = $_POST['lpx'];
	$lang_prefix = ($lpx ? $lpx."_" : ""); 
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
		
	// File upload filename

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
			if(file_exists($file_path.$old_file)) {
				unlink($file_path.$old_file);
			}			
		}
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

	if($refs) {
		$ah->rs("DELETE FROM osc_producers_categories WHERE `category_id` = $item_id");
		foreach($refs as $ref_id) {
			$ah->rs("INSERT INTO osc_producers_categories (producer_id, category_id) VALUES ($ref_id, $item_id)");
		}		
	}
	
	$data['message'] = "Industry #$item_id saved.";
	