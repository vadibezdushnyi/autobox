<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	// Файл обновляет информацию о характеристиках товара

	echo '<p>Файл обновляет информацию о характеристиках товара</p>';

	if(isset($_POST['char']))
	{

		$chars = $_POST['char'];
		
		foreach($chars as $i => $val)
		{
				$query = "INSERT INTO [pre]shop_chars_prod_ref (`char_id`,`prod_id`,`value`) VALUES ('".$i."','".$eh->id."','".$val."')";
			
				$_stmt = $dbh->prepare($query);
				$_stmt->execute();
		}
	}