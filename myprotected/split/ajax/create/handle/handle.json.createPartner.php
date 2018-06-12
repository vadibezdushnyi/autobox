<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	
	$cardUpd = array(
		'name'				=> strip_tags(trim($_POST['name'])),
		'link'				=> strip_tags(trim($_POST['link'])),
		'show_home'				=> $_POST['show_home'][0],
		'created'			=> date("Y-m-d H:i:s", time())
	);
				

	$filename = "logo";
	
	if(isset($_FILES[$filename]) && count($_FILES[$filename]) > 0)
	{
		$file_path = "../../../../webroot/img/content/";
		$files_upload = $ah->mtvc_add_files_file(array(
				'path'			=>$file_path,
				'name'			=>5,
				'pre'			=>"upd_",
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2500,
				'files'			=>$filename,
				'resize_path'	=>$file_path."crop/",
				'resize_w'		=>600,
				'resize_h'		=>600,
				'resize_path_2'	=>"0",
				'resize_w_2'	=>0,
				'resize_h_2'	=>0
			  ));
		if($files_upload) {
			$cardUpd[$filename] = $files_upload;
		}
	}				
				
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
		
	$item_id = $ah->dbh->q($query,0,1,1);
	
	if($item_id)
	{
		$data['item_id'] = $item_id;
		$data['status'] = "success";
		$data['message'] = "Партнер успешно создан.";
	}
	