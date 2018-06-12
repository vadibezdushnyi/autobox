<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = "shop_catalog";
	
	$catId	= $_POST['id'];
	
	$catPos	= $_POST['pos'];
	
	
	$query = "UPDATE [pre]$appTable SET `pos`=$catPos WHERE `id`=$catId LIMIT 1";
	
	$ah->rs($query);
	
	$data['status'] = "success";
	
	$data['message'] = "Category #$catId position has been updated.";