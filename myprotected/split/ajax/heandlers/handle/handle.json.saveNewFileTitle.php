<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$field	= (isset($_POST['field']) ? $_POST['field'] : 'images');
	$appTable = $_POST['appTable'];
	$fieldset = 'title';
	
	$appTable = $appTable == 'articles' ? 'files_ref' : $appTable;

	$id	= (int)$_POST['id'];
	
	$val	= strip_tags(str_replace("'","",$_POST['val']));
	
	
	$query = "UPDATE [pre]$appTable SET $fieldset='$val' WHERE `id`=$id LIMIT 1";
	
	$ah->rs($query);
	
	$data['status'] = "success";
	
	$data['message'] = "Saved.";
