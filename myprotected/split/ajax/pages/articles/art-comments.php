<?php 
	require_once "../../../../require.base.php";
	require_once "../../../library/articles.class.php";
	
	$zh = new articlesHelp($dbh);
	
	$data = array('status'=>"error",'message'=>"Tech error",'headContent'=>"",'bodyContent'=>"",'filter'=>array('f1'=>0,'f2'=>0,'f3'=>0));

	$parent		= str_replace(" ","",$_POST['parent']);
	$alias		= str_replace(" ","",$_POST['alias']);
	$id			= (int)$_POST['id'];
	$item_id	= (int)$_POST['item_id'];
	$actionType	= $_POST['action_type'];
	$params 	= $_POST['params'];
	
	if(isset($params['copyItem']))
	{
		$item_id = (int)$params['copyItem'];
	}
	
	if(isset($params['filtr']))
	{
		parse_str($params['filtr'],$prmFiltr);
	}else
	{
		$prmFiltr = array();
	}
	$params['filtr'] = $prmFiltr;
	
	$appTable = "article_comments"; // Main table
	
	$moduleFile = $alias.".".$actionType.".php";
	
	if(file_exists($moduleFile))
	{
		include_once($moduleFile);
		
		$data['status'] = "success";
		$data['message'] = "Success responce";
	}else
	{
		$data['message'] = "Incorrect type of module file";
	}
	
	echo json_encode($data);