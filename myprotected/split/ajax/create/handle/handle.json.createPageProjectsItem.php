<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	
	$cardUpd = array(
					'name'			=> $_POST['name'],
					'year'			=> $_POST['year'],
					'location'		=> $_POST['location'],
					'customer'		=> $_POST['customer'],
					'square'		=> $_POST['square'],
					'description'	=> $_POST['description'],
					'alias'			=> $_POST['alias'],
					'cat_id'		=> (int)$_POST['cat_id'],
					'block'			=> (int)$_POST['block'][0],
					'show_home'		=> (int)$_POST['show_home'][0],
					'meta_title'	=> $_POST['meta_title'],
					'meta_keys' 	=> $_POST['meta_keys'],
					'meta_desc' 	=> $_POST['meta_desc'],
					'index' 	=> (int)$_POST['index'][0],
					'modified'	=> date("Y-m-d H:i:s", time()),
					'created'	=> date("Y-m-d H:i:s", time()),
					);
	
	// File upload 
	
	$filename = "cover";
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = "../../../../public/img/content/";
		if (strlen($cardUpd['file']) > 0) {
			$file_update = $ah->mtvc_add_files_file(array(
				'path'			=>$file_path,
				'name'			=>4, //4
				'pre'			=>$cardUpd['file'], // name
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
		}else{
			$file_update = $ah->mtvc_add_files_file(array(
				'path'			=>$file_path,
				'name'			=>5, //4
				'pre'			=>"post_", // name
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
		
	}	
	
	// Create main table item
	
	$query = "INSERT INTO $appTable ";
	
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
		
	$item_id = $ah->rs($query,0,1,1);
	
	if($item_id)
	{
		$data['item_id'] = $item_id;
	}else
	{
		$data['item_id'] = 0;
	}


	$filename = "images";
	
	if(isset($_FILES[$filename]) && count($_FILES[$filename]) > 0)
	{
		$file_path = "../../../../public/img/content/project-gallery/";
		
		$files_upload = $ah->mtvc_add_files_file_miltiple(array(
				'path'			=>$file_path,
				'name'			=>5,
				'pre'			=>"gall_",
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2500,
				'files'			=>$filename,
				'resize_path'	=>"0",
				'resize_w'		=>0,
				'resize_h'		=>0,
				'resize_path_2'	=>"0",
				'resize_w_2'	=>0,
				'resize_h_2'	=>0
			  ));
		if($files_upload)
		{
			foreach($files_upload as $file_upload)
			{
				$query = "INSERT INTO [pre]projects_gallery (`project_id`, `cover`,`created`,`modified`) VALUES ('$item_id', '$file_upload', '$now', '$now')";
				$ah->rs($query);
			}
		}
	}	
	
	$data['message'] = "Проект создан.";
	