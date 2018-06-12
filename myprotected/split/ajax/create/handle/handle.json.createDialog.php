<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	
	$cardUpd = array(
					'message'		=> $_POST['message'],
					'to_id'			=> $_POST['user_id'],
					'from_id'		=> ADMIN_ID,
					'last'			=> 1,
					'status'		=> 0,
					
					'dateCreate'	=> date("Y-m-d H:i:s", time())
					);
	
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
		
		// File upload 
	
		$filename = "file";
		
		$path = "../../../../split/files/dialogs/";
	
		if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
		{
			$file_path = "../../../../split/files/banners/";
			
			$filename = $ah->mtvc_add_files_file(array(
				'path'			=>$path,
				'name'			=>5,
				'pre'			=>"ms_",
				'size'			=>20,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2500,
				'files'			=>"file",
				'resize_path'	=>$path."crop/",
				'resize_w'		=>320,
				'resize_h'		=>240
				));
			if($filename)
			{
				$crop_name = "320x240_".$filename;
				
				$query = "INSERT INTO [pre]dialog_files_ref (`ref_table`,`ref_id`,`file`,`crop`,`path`,`adminMod`)
								VALUES ('users_dialogs','$item_id','$filename','$crop_name','files/dialogs/','".ADMIN_ID."')";
				$ah->rs($query);
			}
		}
	
		
	}else
	{
		$data['item_id'] = 0;
	}
	
	$data['status'] = "success";
	$data['message'] = "Новый дилог успешно создан.";
	