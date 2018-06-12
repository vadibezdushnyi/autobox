<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post

	$lang_fields = $ah->getAvailableLangs();
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	
	$tags = $_POST['tags'];
	
	$cardUpd = array(
		'name'			=> str_replace("'","\'",trim(stripslashes($_POST['name']))),
		'de_name'		=> str_replace("'","\'",trim(stripslashes($_POST['name']))),
		'ru_name'		=> str_replace("'","\'",trim(stripslashes($_POST['name']))),
		'cz_name'		=> str_replace("'","\'",trim(stripslashes($_POST['name']))),
		'sk_name'		=> str_replace("'","\'",trim(stripslashes($_POST['name']))),
		'tr_name'		=> str_replace("'","\'",trim(stripslashes($_POST['name']))),
		'es_name'		=> str_replace("'","\'",trim(stripslashes($_POST['name']))),
		'ar_name'		=> str_replace("'","\'",trim(stripslashes($_POST['name']))),
		'content'		=> str_replace("'","\'",trim(stripslashes($_POST['content']))),
		'de_content'	=> str_replace("'","\'",trim(stripslashes($_POST['content']))),
		'ru_content'	=> str_replace("'","\'",trim(stripslashes($_POST['content']))),
		'cz_content'	=> str_replace("'","\'",trim(stripslashes($_POST['content']))),
		'sk_content'	=> str_replace("'","\'",trim(stripslashes($_POST['content']))),
		'tr_content'	=> str_replace("'","\'",trim(stripslashes($_POST['content']))),
		'es_content'	=> str_replace("'","\'",trim(stripslashes($_POST['content']))),
		'ar_content'	=> str_replace("'","\'",trim(stripslashes($_POST['content']))),
		'order_id'		=> (int)$order_id,
		'block'			=> $_POST['block'][0],
		'modified'		=> date("Y-m-d H:i:s", time()),
		'created'		=> date("Y-m-d H:i:s", time()),
	);


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
	$item_id = $ah->rs($query,0,1,1);
	
	if ($item_id) {
		$filename = 'images';
		if(isset($_FILES[$filename]) && count($_FILES[$filename]) > 0) {
			$file_path = '../../../../public/img/gallery/';
			$uploaded = $ah->mtvc_add_files_file_miltiple(array(
				'path'			=>$file_path,
				'name'			=>5,
				'pre'			=>"cert_",
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2000,
				'files'			=>$filename,
			));
			if($uploaded) {
				foreach($uploaded as $file) {
					$query = "INSERT INTO [pre]files_ref (`ref_table`, `ref_id`, `file`, `crop`, `path`) VALUES ('certificates', '$item_id', '$file', '0', '/public/img/gallery/')";
					$ah->rs($query);
				}
			}
		}
	}

		$data['status'] = "success";
		$data['message'] = "Certificate created";
	

