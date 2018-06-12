<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	$lpx = $_POST['lpx'];
	$lang_prefix = ($lpx ? $lpx."_" : ""); // (Israel - empty, ru, en, fr)
	
	$cardUpd = array(
					$lang_prefix.'name'			=> $_POST['name'],
					$lang_prefix.'year'			=> $_POST['year'],
					$lang_prefix.'location'		=> $_POST['location'],
					$lang_prefix.'customer'		=> $_POST['customer'],
					$lang_prefix.'square'		=> $_POST['square'],
					$lang_prefix.'description'	=> $_POST['description'],
					'alias'						=> $_POST['alias'],
					'cat_id'					=> (int)$_POST['cat_id'],
					'block'						=> (int)$_POST['block'][0],
					'show_home'					=> (int)$_POST['show_home'][0],
					$lang_prefix.'meta_title'	=> $_POST['meta_title'],
					$lang_prefix.'meta_keys' 	=> $_POST['meta_keys'],
					$lang_prefix.'meta_desc' 	=> $_POST['meta_desc'],
					'index' 	=> (int)$_POST['index'][0],
					'modified'	=> date("Y-m-d H:i:s", time()),
					);
					
	// File upload 
	
	$filename = "cover";
	
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = "../../../../public/img/content/";
		
		$file_update = $ah->mtvc_add_files_file(array(
				'path'			=>$file_path,
				'name'			=>5,
				'pre'			=>"page_",
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2500,
				'files'			=>$filename
			  ));
		if($file_update)
		{
			$cardUpd[$filename] = $file_update;
			
			$curr_filename = $_POST['curr_filename'];
			
			unlink($file_path.$curr_filename);
		}
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
	
	// Update main table
	
	$query = "UPDATE $appTable SET ";
	
	$cntUpd = 0;
	foreach($cardUpd as $field => $itemUpd)
	{
		$cntUpd++;
		$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
	}
	
	$query .= " WHERE `id`=$item_id LIMIT 1";

	$data['qq'] = $query;
			
	$ah->rs($query,0,1);
	
	$data['message'] = "Проект сохранен.";
	