<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	// Файл обновляет информацию о характеристиках товара

	echo '<p>Файл обновляет привязку товара к катеории</p>';

	$cat_id = $_POST['cat_id'];
	
	if($cat_id)
	{
		$query = "SELECT id FROM [pre]shop_cat_prod_ref WHERE `cat_id`='".$cat_id."' AND `prod_id`='".$eh->id."' LIMIT 1";
		
		$_stmt = $dbh->prepare($query);
		$_res = $_stmt->execute();
		
		$_arr = $_res->fetchallAssoc();
		if($_arr)
		{
			
			$query = "UPDATE [pre]shop_cat_prod_ref SET `cat_id`='".$cat_id."' WHERE `id`='".$_arr[0]['id']."' LIMIT 1";
		
			$_stmt = $dbh->prepare($query);
			$_stmt->execute();
		}else
		{
			$query = "INSERT INTO [pre]shop_cat_prod_ref (`cat_id`,`prod_id`) VALUES ('".$cat_id."','".$eh->id."')";
		
			$_stmt = $dbh->prepare($query);
			$_stmt->execute();
		}
	}