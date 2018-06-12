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
		'name'			=> str_replace("'","\'",trim($_POST['name'])),
		'de_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'ru_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'cz_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'sk_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'tr_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'es_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'ar_name'		=> str_replace("'","\'",trim($_POST['name'])),
		'content'		=> str_replace("'","\'",trim($_POST['content'])),
		'de_content'	=> str_replace("'","\'",trim($_POST['content'])),
		'ru_content'	=> str_replace("'","\'",trim($_POST['content'])),
		'cz_content'	=> str_replace("'","\'",trim($_POST['content'])),
		'sk_content'	=> str_replace("'","\'",trim($_POST['content'])),
		'tr_content'	=> str_replace("'","\'",trim($_POST['content'])),
		'es_content'	=> str_replace("'","\'",trim($_POST['content'])),
		'ar_content'	=> str_replace("'","\'",trim($_POST['content'])),
		'meta_title'	=> str_replace("'","\'",trim($_POST['meta_title'])),
		'meta_desc'		=> str_replace("'","\'",trim($_POST['meta_desc'])),
		'meta_keys'		=> str_replace("'","\'",trim($_POST['meta_keys'])),
		'cat_id'		=> $_POST['cat_id'],
		'alias'			=> $_POST['alias'],
		'order_id'		=> (int)$order_id,
		'block'			=> $_POST['block'][0],
		'dateCreate'	=> date("Y-m-d H:i:s", time()),
		'dateModify'	=> date("Y-m-d H:i:s", time()),
	);

	// Main query INSERT START

	
	$query = "SELECT id FROM [pre]articles WHERE `alias`='".$cardUpd['alias']."' LIMIT 1";
	$test_alias = $ah->rs($query);
	
	if(strlen($cardUpd['name'])>1) {
		if(!$test_alias) {
	
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

				if($tags) {
					$ah->rs("DELETE FROM [pre]article_tags_ref WHERE `art_id` = $item_id");
					foreach($tags as $tag_id) {
						$ah->rs("INSERT INTO [pre]article_tags_ref (art_id, tag_id) VALUES ($item_id, $tag_id)");
					}		
				}

				$data['status'] = "success";
				$data['message'] = "Article created";
			}	
		}else{
			$data['status'] = "failed";
			$data['message'] = "Such an alias already exists";
		}
	}else{
		$data['status'] = "failed";
		$data['message'] = "Specify article name";
	}
	

