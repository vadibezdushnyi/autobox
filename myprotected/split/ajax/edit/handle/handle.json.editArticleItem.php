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
		$lang_prefix.'name'			=> str_replace("'","\'",trim($_POST['name'])),
		$lang_prefix.'content'		=> str_replace("'","\'",trim($_POST['content'])),
		$lang_prefix.'meta_title'	=> str_replace("'","\'",trim($_POST['meta_title'])),
		$lang_prefix.'meta_desc'	=> str_replace("'","\'",trim($_POST['meta_desc'])),
		$lang_prefix.'meta_keys'	=> str_replace("'","\'",trim($_POST['meta_keys'])),
		'cat_id'					=> $_POST['cat_id'],
		'order_id'					=> (int)$order_id,
		'block'						=> $_POST['block'][0],
		'dateModify'				=> date("Y-m-d H:i:s", time()),
	);

	if (isset($_POST['alias'])) {
		$cardUpd['alias'] = $_POST['alias'];
	}

	// Main query update START
	$query = "SELECT id FROM [pre]articles WHERE `alias`='".$cardUpd['alias']."' AND `id`!=$item_id LIMIT 1";
	$test_alias = $ah->rs($query);

	
	if(strlen($_POST['name'])>1) {
		if(!$test_alias) {

			$filename = 'images';
			if(isset($_FILES[$filename]) && count($_FILES[$filename]) > 0) {
				$file_path = '../../../../public/img/content/';
				$uploaded = $ah->mtvc_add_files_file_miltiple(array(
					'path'			=>$file_path,
					'name'			=>5,
					'pre'			=>"post_",
					'size'			=>10,
					'rule'			=>0,
					'max_w'			=>2500,
					'max_h'			=>2000,
					'files'			=>$filename,
				));
				if($uploaded) {
					foreach($uploaded as $file) {
						$query = "INSERT INTO [pre]files_ref (`ref_table`, `ref_id`, `file`, `crop`, `path`) VALUES ('articles', '$item_id', '$file', '0', '/public/img/content/')";
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

			if($tags) {
				$ah->rs("DELETE FROM [pre]article_tags_ref WHERE `art_id` = $item_id");
				foreach($tags as $tag_id) {
					$ah->rs("INSERT INTO [pre]article_tags_ref (art_id, tag_id) VALUES ($item_id, $tag_id)");
				}		
			}			
			
			$data['status'] = "success";
			$data['message'] = "Article updated";
		} else {
			$data['status'] = "failed";
			$data['message'] = "Such an alias already exists";
		}
	} else {
		$data['status'] = "failed";
		$data['message'] = "Specify article name";
	}
	
	