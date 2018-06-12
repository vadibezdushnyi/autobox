<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	// Файл обновляет информацию о характеристиках товара

	echo '<p>Файл обновляет информацию о характеристиках товара</p>';

	$chars = $_POST['char'];
	
	foreach($chars as $i => $val)
	{
		$query = "SELECT id FROM [pre]shop_chars_prod_ref WHERE `char_id`='".$i."' AND `prod_id`='".$eh->id."' LIMIT 1";
		
		$_stmt = $dbh->prepare($query);
		$_res = $_stmt->execute();
		
		$_arr = $_res->fetchallAssoc();
		if($_arr)
		{
			
			$query = "UPDATE [pre]shop_chars_prod_ref SET `char_id`='".$i."', `prod_id`='".$eh->id."', `value`='".$val."' WHERE `id`='".$_arr[0]['id']."' LIMIT 1";
		
			$_stmt = $dbh->prepare($query);
			$_stmt->execute();
		}else
		{
			$query = "INSERT INTO [pre]shop_chars_prod_ref (`char_id`,`prod_id`,`value`) VALUES ('".$i."','".$eh->id."','".$val."')";
		
			$_stmt = $dbh->prepare($query);
			$_stmt->execute();
		}
	}