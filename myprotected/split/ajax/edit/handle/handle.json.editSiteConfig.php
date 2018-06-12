<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];

	$lpx = $_POST['lpx'];

	$lang_prefix = ($lpx ? $lpx."_" : ""); // empty = en

	$query = "SELECT `filename` FROM [pre]total_config WHERE `id`='$item_id' LIMIT 1";
	$alias = $ah->rs($query);

	$old_filename = $alias[0]['filename'];
	
	$cardUpd = array(
		'sitename'		=> $_POST['sitename'],
		'support_email'	=> $_POST['support_email'],
		'phone_number'	=> $_POST['phone_number'],
		'address'		=> $_POST['address'],
		'index'			=> $_POST['index'][0],
		'fb_link'		=> $_POST['fb_link'],
		'tw_link'		=> $_POST['tw_link'],
		'yt_link'		=> $_POST['yt_link'],
		'in_link'		=> $_POST['in_link'],
		'ins_link'		=> $_POST['ins_link'],
		'sk_link'		=> $_POST['sk_link'],
		$lang_prefix.'meta_title'	=> $_POST['meta_title'],
		$lang_prefix.'meta_keys'	=> $_POST['meta_keys'],
		$lang_prefix.'meta_desc'	=> $_POST['meta_desc'],
		'afterHead'		=> $_POST['afterHead'],
		'afterBody'		=> $_POST['afterBody'],
		'dateModify'	=> date("Y-m-d H:i:s", time()),
	);
					

	// File upload filename

	$file_path = "../../../../split/files/images/";

	// PREVIEW ------------------
	$im_1_filename = "filename";

	$im_1 		= false;
	$im_1_name 	= 5;
	$im_1_pre 	= "cfg_";
	
	if(isset($_FILES[$im_1_filename]) && $_FILES[$im_1_filename]['size'] > 0)
	{
		if (strlen($_POST['filename']) > 0) {

			$ext = explode('.', $_FILES[$im_1_filename]['name']);
			$ext = $ext[1];
			$new_name = str_replace(' ', '_', $_POST['filename_hd']).'.'.$ext;

			if (file_exists($file_path.$new_name)) {
				$data['status'] = "failed";
				$data['message'] = "Изображение с таким именем уже существует";
				echo json_encode($data);
				exit();
			}

			$im_1 		= true;
			$im_1_name 	= 4;
			$im_1_pre 	= str_replace(' ', '_', $_POST['filename_hd']);
			
		}else{
			$im_1 = true;
		}
	}
	elseif (strlen($_POST['filename_hd']) > 0) {
		$ext = explode('.', $old_filename);
		$ext = $ext[1];
		$new_name = str_replace(' ', '_', $_POST['filename_hd']).'.'.$ext;
		$cardUpd[$im_1_filename] = $new_name;

		if(!file_exists($file_path.$new_name)){
			rename($file_path.$old_filename, $file_path.$new_name);
		}else{
			$data['status'] = "failed";
			$data['message'] = "Изображение нельзя переименовать по указанному значению";
			echo json_encode($data);
			exit();
		}
	}

	// END OF IMAGES UPLOADS

	if($im_1)
	{
		$file_update = $ah->mtvc_add_files_file(array(
				'path'			=>$file_path,
				'name'			=>$im_1_name,
				'pre'			=>$im_1_pre,
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2500,
				'files'			=>$im_1_filename
			  ));
		if($file_update)
		{
			$cardUpd[$im_1_filename] = $file_update;

			if (explode('.', $old_filename)[0] != $_POST['filename_hd']) {
				unlink($file_path.$old_filename);
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
		
	$data['query'] = $query;
		
	$ah->rs($query);
	
	
	
	$data['message'] = "Saved.";
	