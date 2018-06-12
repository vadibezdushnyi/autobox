<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	require_once "../../../require.base.php";
	
	require_once "../../library/AjaxHelp.php";
	
	$ah = new ajaxHelp($dbh);
	
	// GET POST
	
	$choice = (int)$_POST['choice'];
	
	$actionName = $_POST['action'];
	
	// INI DATA
	
	$data = array('status'=>"error",'message'=>"Tech error",'choice'=>$choice);
	
	// INCLUDE HANDLE SCRIPT
	
	$handleName = "handle/handle.json.".$actionName.".php";
	
	$appTable = (isset($_POST['appTable']) ? $_POST['appTable'] : "");

	if(file_exists($handleName))
	{
		foreach($_POST as $indx => &$postItem)
		{
			if($appTable=='articles'){
				if(
					$indx!='meta_title' && 
					$indx!='meta_desc' && 
					$indx!='meta_keys' && 

					$indx!='alt_preview' && 
					$indx!='title_preview' && 

					$indx!='alt_banner' && 
					$indx!='title_banner' && 

					$indx!='alt_top_img' && 
					$indx!='title_top_img' && 

					$indx!='alt_bot_img' && 
					$indx!='title_bot_img' && 

					$indx!='alt_modal' && 
					$indx!='title_modal'
				){

					if(!is_array($postItem)) $postItem = addslashes($postItem);
				}
			}
			else{
				if(!is_array($postItem)) $postItem = addslashes($postItem);
			}
		}
		
		include_once($handleName);
	}
	
	echo json_encode($data);