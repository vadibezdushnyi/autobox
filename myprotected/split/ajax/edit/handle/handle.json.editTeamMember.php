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

	foreach ($_POST['languages'] as &$value) 
		$value = json_decode($value, true); 

	$cardUpd = array(
		$lang_prefix.'name'			=> str_replace("'", "\'", $_POST['name']),
		$lang_prefix.'position'		=> str_replace("'", "\'", $_POST['position']),
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
	);
					
	
	// File upload filename

	$data['cwd'] = [is_dir('../../../../public/img/content/'), getcwd()];

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
	