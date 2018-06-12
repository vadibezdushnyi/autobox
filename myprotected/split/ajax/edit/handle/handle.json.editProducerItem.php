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
		$lang_prefix.'description'	=> $_POST['description'],
		$lang_prefix.'meta_title'	=> $_POST['meta_title'],
		$lang_prefix.'meta_keys'	=> $_POST['meta_keys'],
		$lang_prefix.'meta_desc'	=> $_POST['meta_desc'],
		'Block'						=> $_POST['Block'][0],
		'show_home'					=> $_POST['show_home'][0],
		'products_amount'			=> $_POST['products_amount'],
		'Name'						=> $_POST['Name'],
		'Modified'					=> date("Y-m-d H:i:s", time()),
	);


	// File upload filename

	$filename = "Logo";
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$old_file = $_POST['curr_filename'];
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
			if(file_exists($file_path.$old_file)) {
				unlink($file_path.$old_file);
			}			
		}
	}	
	
	$filename = "cover";
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$old_file = $_POST['curr_filename2'];
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
		$ah->rs("DELETE FROM osc_producers_categories WHERE `producer_id` = $item_id");
		foreach($refs as $ref_id) {
			$ah->rs("INSERT INTO osc_producers_categories (producer_id, category_id) VALUES ($item_id, $ref_id)");
		}		
	}
	
	$data['message'] = "Producer #$item_id saved.";
	