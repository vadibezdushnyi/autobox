<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	
	$cardUpd = array(
		'name'			=> str_replace("'","\'",trim($_POST['name'])),
		'de_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'ru_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'cz_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'sk_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'tr_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'es_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'ar_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'details'		=> str_replace("'","\'",trim($_POST['details'])),
		'de_details'	=> str_replace("'","\'",trim($_POST['details'])),
		'ru_details'	=> str_replace("'","\'",trim($_POST['details'])),
		'cz_details'	=> str_replace("'","\'",trim($_POST['details'])),
		'sk_details'	=> str_replace("'","\'",trim($_POST['details'])),
		'tr_details'	=> str_replace("'","\'",trim($_POST['details'])),
		'es_details'	=> str_replace("'","\'",trim($_POST['details'])),
		'ar_details'	=> str_replace("'","\'",trim($_POST['details'])),
		'alias'			=> $_POST['alias'],
		'block'			=> $_POST['block'][0],
		'dateCreate'	=> date("Y-m-d H:i:s", time()),
		'dateModify'	=> date("Y-m-d H:i:s", time())
	);
					
	// File upload 
	
	$filename = "filename";
	
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = "../../../../split/files/banners/";
		
		$file_update = $ah->mtvc_add_files_file(array(
				'path'			=>$file_path,
				'name'			=>5,
				'pre'			=>"artc_",
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2500,
				'files'			=>$filename
			  ));
		if($file_update)
		{
			$cardUpd[$filename] = $file_update;
		}
	}
	
	// Create main table item
	
	$query = "INSERT INTO [pre]$appTable ";
	
	$fieldsStr = " ( ";
	
	$valuesStr = " ( ";
	
	$cntUpd = 0;
	foreach($cardUpd as $field => $itemUpd)
	{
		$cntUpd++;
		
		$fieldsStr .= ($cntUpd==1 ? "`$field`" : ", `$field`");
		
		$valuesStr .= ($cntUpd==1 ? "'$itemUpd'" : ", '$itemUpd'");
	}
	
	$fieldsStr .= " ) ";
	
	$valuesStr .= " ) ";
	
	$query .= $fieldsStr." VALUES ".$valuesStr;
		
	$ah->rs($query);
	
	$item_id = mysql_insert_id();
	
	if($item_id)
	{
		$data['item_id'] = $item_id;
	}else
	{
		$data['item_id'] = 0;
	}
	
	$data['message'] = "Done.";
	