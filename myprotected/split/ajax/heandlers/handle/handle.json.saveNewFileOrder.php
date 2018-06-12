<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$field	= (isset($_POST['field']) ? $_POST['field'] : 'images');
	
	if($field == 'docs'){
			$appTable = "docs_ref";
		}else{
			$appTable = "files_ref";
			}
	
	$id	= (int)$_POST['id'];
	
	$val	= strip_tags(str_replace("'","",$_POST['val']));
	
	
	$query = "UPDATE [pre]$appTable SET `order_pos`='$val' WHERE `id`=$id LIMIT 1";
	
	$ah->rs($query);
	
	$data['status'] = "success";
	
	$data['message'] = "Позиция файла успешно сохранена.";