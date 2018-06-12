<?php 
	
	$appTable = $_POST['appTable'];
	
	$cardUpd = array(
		'name'			=> str_replace("'","\'",trim($_POST['name'])),
		'de_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'ru_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'cz_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'sk_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'tr_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'es_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'ar_name'		=> str_replace("'","\'",trim($_POST['name'])),
		
		'title'			=> str_replace("'","\'",trim($_POST['title'])),
		'de_title'		=> str_replace("'","\'",trim($_POST['title'])),
		'ru_title'		=> str_replace("'","\'",trim($_POST['title'])),
		'cz_title'		=> str_replace("'","\'",trim($_POST['title'])),
		'sk_title'		=> str_replace("'","\'",trim($_POST['title'])),
		'tr_title'		=> str_replace("'","\'",trim($_POST['title'])),
		'es_title'		=> str_replace("'","\'",trim($_POST['title'])),
		'ar_title'		=> str_replace("'","\'",trim($_POST['title'])),
		
		'block'			=> $_POST['block'][0],
		'dateCreate'	=> date("Y-m-d H:i:s", time()),
		'dateModify'	=> date("Y-m-d H:i:s", time())
	);
	
	
	$item_id = 0;
	
	if(strlen($cardUpd[$lang_prefix.'name'])>1) {
		$query = "INSERT INTO [pre]$appTable ";
		$fieldsStr = " ( ";
		$valuesStr = " ( ";
		$cntUpd = 0;
		foreach($cardUpd as $field => $itemUpd) {
			$cntUpd++;
			$fieldsStr .= ($cntUpd==1 ? "`$field`" : ", `$field`");
			$valuesStr .= ($cntUpd==1 ? "'$itemUpd'" : ", '$itemUpd'");
		}
		$fieldsStr .= " ) ";
		$valuesStr .= " ) ";
		$query .= $fieldsStr." VALUES ".$valuesStr;
		$data['block'] = $cardUpd['block'];
		$data['query'] = $query;
		$item_id = $ah->rs($query, 0, 1, 1);
		$data['item_id'] = $item_id;
		
		if($item_id) {
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
			$data['message'] = "Done";
		} else {
			$data['status'] = "failed";
			$data['message'] = "Error occured";
		}
	} else {
		$data['status'] = "failed";
		$data['message'] = "Specify gallery name";
	}
	
	