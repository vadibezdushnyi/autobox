<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	// Файл обновляет информацию о характеристиках товара

	echo '<p>Файл обновляет информацию о характеристиках товара</p>';

	
	$query = "UPDATE [pre]files_ref SET `ref_id`='".$eh->id."' WHERE `ref_table`='shop_products' AND `ref_id`='0' AND `adminMod`='".ADMIN_ID."' LIMIT 20";
			
	$_stmt = $dbh->prepare($query);
	$_stmt->execute();