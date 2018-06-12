<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$field	= (isset($_POST['field']) ? $_POST['field'] : 'images');
	$appTable = $_POST['appTable'];

	if(strtolower(trim($appTable)) == "osc_projects") {
		$appTable = "projects_gallery";
		$fieldset = 'alt';
	} elseif(strtolower(trim($appTable)) == "articles") {
		$appTable = "files_ref";
		$fieldset = 'alt';
	} else {
		if($field == 'docs'){
			$appTable = "docs_ref";
		}else{
			$appTable = "files_ref";
		}		
		$fieldset = 'title';
	}
	
	$id	= (int)$_POST['id'];
	
	$val	= strip_tags(str_replace("'","",$_POST['val']));
	
	
	$query = "UPDATE [pre]$appTable SET $fieldset='$val' WHERE `id`=$id LIMIT 1";
	
	$ah->rs($query);
	
	$data['status'] = "success";
	
	$data['message'] = "Saved.";
