<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = isset($_POST['appTable']) && strlen($_POST['appTable']) ? $_POST['appTable'] : 'files_ref';
	
	$id = $_POST['id'];
	
	$path = $_POST['path'];
	
	$root_path = "../../../..";
	
	if($path=='/split/files/documents/') $appTable = 'docs_ref';
	if($appTable=='osc_projects') $appTable = 'projects_gallery';
	if($appTable=='osc_posts') $appTable = 'posts_gallery';
	if($appTable=='certificates') $appTable = 'files_ref';
	
	$data = array();
	
	$query = "SELECT * FROM [pre]$appTable WHERE `id`=$id LIMIT 1";

	$data = $ah->rs($query);
	
	if($data)
	{
		$data = $data[0];

		if($appTable=='projects_gallery') {
			$filepath = $root_path.$path.$data['cover'];
			if(file_exists($filepath) && trim($data['cover']) != "") {
				unlink($filepath);
			}
		} else {
			$filepath = $root_path.$path.$data['file'];
			$croppath = $root_path.$path."crop/".$data['crop'];
		
			if(file_exists($filepath) && trim($data['file']) != "") {
				unlink($filepath);
			}
			if(file_exists($croppath) && trim($data['crop']) != "") {
				unlink($croppath);
			}			
		}
		
		$ah->rs("DELETE FROM [pre]$appTable WHERE `id`='$id' LIMIT 1");
		$data['message'] = "Success file delete";
	}else
	{
		$data['message'] = 'File not found';
	}
	