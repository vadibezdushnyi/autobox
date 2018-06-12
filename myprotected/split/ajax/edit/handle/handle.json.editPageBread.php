<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];

	$lpx = $_POST['lpx'];

	$lang_prefix = ($lpx ? $lpx."_" : ""); // (Israel - empty, ru, en, fr)
	
	$cardUpd = array(
					$lang_prefix.'caption' 	=> $_POST['caption'],
					$lang_prefix.'details' 	=> $_POST['details'],
					'text1'		=>	$_POST['text1'],
					'text2'		=>	$_POST['text2'],
					'text3'		=>	$_POST['text3'],
					'text4'		=>	$_POST['text4'],
					'text5'		=>	$_POST['text5'],
					'text6'		=>	$_POST['text6'],
					'text7'		=>	$_POST['text7'],
					'text8'		=>	$_POST['text8'],
					'text9'		=>	$_POST['text9'],
					'text10'	=>	$_POST['text10'],
					
					'caption1_home'	=>	$_POST['caption1_home'],
					'caption2_home'	=>	$_POST['caption2_home'],
					'details_home'	=>	$_POST['details_home'],

					'index' 	=> (int)$_POST['index'][0],
					'show_home' => (int)$_POST['show_home'][0],
					
					$lang_prefix.'meta_title'	=> $_POST['meta_title'],
					$lang_prefix.'meta_keys' 	=> $_POST['meta_keys'],
					$lang_prefix.'meta_desc' 	=> $_POST['meta_desc'],
					
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
					
	// File upload 
	
	$filename = "filename";
	
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = "../../../../webroot/img/content/";
		
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
	
	// Update main table
	
	$query = "UPDATE `$appTable` SET ";
	
	$cntUpd = 0;
	foreach($cardUpd as $field => $itemUpd)
	{
		$cntUpd++;
		$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
	}
	
	$query .= " WHERE `id`=$item_id LIMIT 1";
			
	$ah->rs($query,0,1);
	
	$data['q'] = $query;

	$data['message'] = "Page Bread saved successfully.";
	