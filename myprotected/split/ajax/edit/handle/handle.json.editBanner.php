<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];

	$lpx = $_POST['lpx'];
	
	$lang_prefix = ($lpx ? $lpx."_" : ""); // empty = en

	if ($_POST['order_id'] == '' || preg_match('/[a-z]+/i',$_POST['order_id'])) {
		$order_id = 0;
	}else{
		$order_id = $_POST['order_id'];
	}
	
	$query = "SELECT `id`, `file` FROM [pre]$appTable WHERE `id`='$item_id' LIMIT 1";
	$testRow = $ah->rs($query,1);
	$old_file = $testRow['file'];

	$cardUpd = array(
		'name'			=> $_POST['name'],
		//'alias'		=> $_POST['alias'],
		$lpx.'data'		=> $_POST[$lpx.'data'],
		'order_id'		=> $order_id,
		'alt'			=> $_POST['alt'],
		'title'			=> $_POST['title'],
		'block'			=> $_POST['block'][0],
		'link'			=> $_POST['link'],
		'target'		=> $_POST['target'][0],
		
		'dateModify'			=> date("Y-m-d H:i:s", time())
	);
					
	
	// File upload filename

	$filename = "file";
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = '../../../../public/img/content/';
		$file_update = $ah->mtvc_add_files_file(array(
			'path'			=>$file_path,
			'name'			=>5,
			'pre'			=>"bs_",
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
	
	$data['message'] = "Banner saved.";
	