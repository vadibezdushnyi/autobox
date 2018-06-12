<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	$lang_fields = json_decode(stripcslashes($_POST['av_langs']));
	
	foreach ($_POST['languages'] as &$value) 
		$value = json_decode($value, true); 
		
	$cardUpd = array(
		'name'						=> str_replace("'", "\'", $_POST['name']),
		'de_name'					=> str_replace("'", "\'", $_POST['name']),
		'ru_name'					=> str_replace("'", "\'", $_POST['name']),
		'cz_name'					=> str_replace("'", "\'", $_POST['name']),
		'sk_name'					=> str_replace("'", "\'", $_POST['name']),
		'tr_name'					=> str_replace("'", "\'", $_POST['name']),
		'es_name'					=> str_replace("'", "\'", $_POST['name']),
		'ar_name'					=> str_replace("'", "\'", $_POST['name']),
		'position'					=> str_replace("'", "\'", $_POST['position']),
		'de_position'				=> str_replace("'", "\'", $_POST['position']),
		'ru_position'				=> str_replace("'", "\'", $_POST['position']),
		'cz_position'				=> str_replace("'", "\'", $_POST['position']),
		'sk_position'				=> str_replace("'", "\'", $_POST['position']),
		'tr_position'				=> str_replace("'", "\'", $_POST['position']),
		'es_position'				=> str_replace("'", "\'", $_POST['position']),
		'ar_position'				=> str_replace("'", "\'", $_POST['position']),
		'languages'					=> json_encode($_POST['languages'], JSON_UNESCAPED_UNICODE),
		'order_id'					=> $_POST['order_id'],
		'type'						=> $_POST['type'],
		'phone_1'					=> $_POST['phone_1'],
		'phone_2'					=> $_POST['phone_2'],
		'phone_3'					=> $_POST['phone_3'],
		'fax'						=> $_POST['fax'],
		'email'						=> $_POST['email'],
		'sk_link'					=> $_POST['sk_link'],
		'fb_link'					=> $_POST['fb_link'],
		'tw_link'					=> $_POST['tw_link'],
		'ins_link'					=> $_POST['ins_link'],
		'in_link'					=> $_POST['in_link'],
		'block'						=> $_POST['block'][0],
		'support'					=> $_POST['support'][0],
		'modified'					=> date("Y-m-d H:i:s", time()),
		'created'					=> date("Y-m-d H:i:s", time()),
	);
					
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
		$data['message'] = "Created.";
	} else {
		$data['item_id'] = 0;
		$data['message'] = "Error occured.";
	}
	
	