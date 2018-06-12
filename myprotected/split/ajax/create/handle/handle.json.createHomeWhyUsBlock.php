<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	$lang_fields = json_decode(stripcslashes($_POST['av_langs']));
		
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
	);
					
	$filename = "cover";
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = '../../../../public/img/content/';
		$file_update = $ah->mtvc_add_files_file(array(
			'path'			=>$file_path,
			'name'			=>5,
			'pre'			=>"wu_",
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

	$data['query'] = $query;
	
	if($item_id) {
		$data['item_id'] = $item_id;
		$data['message'] = "Created.";
	} else {
		$data['item_id'] = 0;
		$data['message'] = "Error occured.";
	}
	
	