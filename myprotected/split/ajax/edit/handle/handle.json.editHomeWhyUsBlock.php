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

	$cardUpd = array(
		'name'			=> str_replace("'", "\'", $_POST['name']),
		'de_name'		=> str_replace("'", "\'", $_POST['de_name']),
		'ru_name'		=> str_replace("'", "\'", $_POST['ru_name']),
		'cz_name'		=> str_replace("'", "\'", $_POST['cz_name']),
		'sk_name'		=> str_replace("'", "\'", $_POST['sk_name']),
		'tr_name'		=> str_replace("'", "\'", $_POST['tr_name']),
		'es_name'		=> str_replace("'", "\'", $_POST['es_name']),
		'ar_name'		=> str_replace("'", "\'", $_POST['ar_name']),
		'order_id'		=> $_POST['order_id'],
		'block'			=> $_POST['block'][0],
	);
					
	
	// File upload filename

	$filename = "cover";
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = '../../../../public/img/content/';
		$file_update = $ah->mtvc_add_files_file(array(
			'path'			=>$file_path,
			'name'			=>5,
			'pre'			=>"team_",
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
	
	//echo '<pre>'; print_r($query); echo '</pre>'; exit();
	$ah->rs($query);	
	
	$data['message'] = "Saved.";
	