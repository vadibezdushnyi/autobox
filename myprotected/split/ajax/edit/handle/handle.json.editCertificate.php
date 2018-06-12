<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	$item_id = $_POST['item_id'];
	$lpx = $_POST['lpx'];
	$lang_prefix = ($lpx ? $lpx."_" : ""); // empty = en
	$query = "SELECT `alias`, `fl_name_preview`, `fl_name_banner`, `fl_name_top_img`, `fl_name_bot_img`, `fl_name_modal`  FROM [pre]articles WHERE `id`='$item_id' LIMIT 1";
	$alias = $ah->rs($query);

	if ($_POST['order_id'] == '' || preg_match('/[a-z]+/i',$_POST['order_id'])) {
		$order_id = 0;
	}else{
		$order_id = $_POST['order_id'];
	}

	$tags = $_POST['tags'];

	$cardUpd = array(
		$lang_prefix.'name'			=> str_replace("'","\'",trim(stripslashes($_POST['name']))),
		$lang_prefix.'content'		=> str_replace("'","\'",trim(stripslashes($_POST['content']))),
		'order_id'					=> (int)$order_id,
		'block'						=> $_POST['block'][0],
		'modified'				=> date("Y-m-d H:i:s", time()),
	);

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


	$query = "UPDATE [pre]$appTable SET ";
	$cntUpd = 0;
	foreach($cardUpd as $field => $itemUpd) {
		$cntUpd++;
		$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
	}

	$query .= " WHERE `id`=$item_id LIMIT 1";
	$ah->rs($query);

	$data['status'] = "success";
	$data['queyr'] = $query;
	$data['message'] = "Certificate updated";
	
	