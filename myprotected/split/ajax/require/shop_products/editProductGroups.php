<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	// Файл обновляет информацию о группах товара
	
	echo '<p>Файл обновляет информацию о группах товара</p>';

	$groups = $_POST['groups'];
	
	if($groups)
	{
		$where = " WHERE `prod_id`=".$eh->id." ";
		foreach($groups as $g)
		{
			$where .= " AND `group_id` != ".$g;
			$query = "INSERT IGNORE INTO [pre]shop_prod_group_ref (`prod_id`,`group_id`) VALUES (".$eh->id.",$g)";
			
			echo $query."<br>";
			
			$_stmt = $dbh->prepare($query);
			$_stmt->execute();	
		}
		$query = "DELETE FROM [pre]shop_prod_group_ref ".$where." LIMIT 10";
		echo $query."<br>";
		$_stmt = $dbh->prepare($query);
		$_stmt->execute();
	}else
	{
		$query = "DELETE FROM [pre]shop_prod_group_ref WHERE `prod_id`='".$eh->id."' LIMIT 100";
		
		$_stmt = $dbh->prepare($query);
		$_stmt->execute();
	}