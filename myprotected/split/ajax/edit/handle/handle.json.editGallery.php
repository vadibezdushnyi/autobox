<?php 
	
	$appTable = $_POST['appTable'];
	$item_id = $_POST['item_id'];
	$lpx = $_POST['lpx'];
	$lang_prefix = ($lpx ? $lpx."_" : ""); // empty = en
	
	$cardUpd = array(
		$lang_prefix.'name'	=> str_replace("'","\'",$_POST['name']),
		$lang_prefix.'title'	=> str_replace("'","\'",$_POST['title']),		
		'block'				=> $_POST['block'][0],
		'dateModify'		=> date("Y-m-d H:i:s", time()),
	);
					
	$query = "SELECT id FROM [pre]galleries WHERE `name`='".$cardUpd['name']."' AND `id`!=$item_id LIMIT 1";
	$test_name = $ah->rs($query);
	
	if(strlen($cardUpd[$lang_prefix.'name'])>1) {
		$query = "UPDATE [pre]$appTable SET ";
		$cntUpd = 0;
		foreach($cardUpd as $field => $itemUpd) {
			$cntUpd++;
			$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
		}
		$query .= " WHERE `id`=$item_id LIMIT 1";
		$data['query'] = $query;
		$ah->rs($query);

		// Upload files
		$filename = "images";
		if(isset($_FILES[$filename]) && count($_FILES[$filename]) > 0) {
			$file_path = '../../../../public/img/gallery/';
			$files_upload = $ah->mtvc_add_files_file_miltiple(array(
				'path'			=>$file_path,
				'name'			=>5,
				'pre'			=>"gall_",
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2000,
				'files'			=>$filename,
			));
			if($files_upload) {
				foreach($files_upload as $file_upload) {
					$query = "INSERT INTO [pre]files_ref (`ref_table`, `ref_id`, `file`, `crop`, `path`) VALUES ('gallery', '$item_id', '$file_upload', '0', '/public/img/gallery/')";
					$ah->rs($query);
				}
			}
		}
		
		$data['status'] = "success";
		$data['message'] = "Gallery saved";
	} else {
		$data['status'] = "failed";
		$data['message'] = "Specify name of gallery";
	}
	
	