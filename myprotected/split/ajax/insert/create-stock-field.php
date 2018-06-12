<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
	
	//require_once "../../../../split/library/wp_lib.php";
	//$wp = new wp_Lib($db_pref);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Action CREATE ITEM STOCK</title>
</head>

<body>
<?php 
	//echo '<pre>'; print_r($_POST); echo '</pre>';
	
	$mysql_date = date("Y-m-d H:i:s",time());
	$ip_add = $_SERVER['REMOTE_ADDR'];
		
	$object_id		= trim(strip_tags($_POST['object_id']));
	$stock_id		= trim(strip_tags($_POST['stock_id']));
	$zona			= trim(strip_tags($_POST['zona']));
	$block			= trim(strip_tags($_POST['block'][0]));
	
	$zona_valid = false;
	
	$min_pos = 0;
	$max_pos = 9;
	
	$pattern = '/[a-zA-Z]+/'; // шаблон
    preg_match($pattern, $zona, $matches);
    if ( sizeof($matches) >0 && strlen($zona) == 1 )
	{
		$zona_valid = true;
		$zona = mb_strtoupper($zona);
		
		$message = 1; // По умолчанию ошибок нет и форма может быть принята и данные запишутся в таблицу stock_fields
	}else
	{
		$message = "Указан неверный формат зоны, должен быть символ от << A >> до << Z >>.";
	}
	
	if($zona_valid)
	{
	
	$form_valid = false;
	
	switch($object_id)
	{
		case 0:
		{
			echo '<p>Добавляем обьект ЗОНА.</p>';
			if($zona_valid)
			{
				if($stock_id != "0")
				{	
					$zones_query = "SELECT rack FROM [pre]stock_fields WHERE `stock_id` = :1 AND `zona` = :2 ORDER BY id LIMIT 1";
			
							$zones_stmt	= $dbh->prepare($zones_query);
							$zones_arr	= $zones_stmt->execute($stock_id,$zona);
							$zones		= $zones_stmt->fetchallAssoc();
					
					if(sizeof($zones) == 0)
					{
						$form_valid = true;
						$rack		= -1;
						$section	= -1;
						$shelf		= -1;	
						
						$insert_query = "INSERT INTO  [pre]stock_fields 
										(`id` ,`stock_id`,`zona` ,`rack` ,`section`,`shelf` ,`block` ,`fullness` ,`dateCreate` ,`adminMod` ,`ip_add`)
										VALUES 
										(NULL , '".$stock_id."', '".$zona."', '".$rack."', '".$section."', '".$shelf."', '".$block."', '0', '".$mysql_date."', '".ADMIN_ID."', '".$ip_add."')
										;";
	
							$insert_stmt = $dbh->prepare($insert_query);
							$insert_stmt->execute();
										
						$item_id = mysql_insert_id();
					
					}else $message = "ЗОНА под символом ".$zona." уже существует.";
				}else $message = "Пожалуйста, укажите склад.";
			}
			break;
		} // end 0
		case 1:
		{
			echo '<p>Добавляем обьект Стеллаж.</p>';
			$rack		= (int)trim(strip_tags($_POST['rack']));
			$section	= (int)trim(strip_tags($_POST['section']));
			$shelf		= (int)trim(strip_tags($_POST['shelf']));
			
			if($zona_valid)
			{
				if($stock_id != "0")
				{
					if($rack >= $min_pos && $rack <= $max_pos)
					{
						$racks_query = "SELECT rack FROM [pre]stock_fields WHERE `stock_id` = :1 AND `zona` = :2 AND `rack` = :3 ORDER BY id LIMIT 1";
			
							$racks_stmt	= $dbh->prepare($racks_query);
							$racks_arr	= $racks_stmt->execute($stock_id,$zona,$rack);
							$racks		= $racks_stmt->fetchallAssoc();
							
						if(sizeof($racks) == 0)
						{
							if($section >= $min_pos && $section <= $max_pos+1)
							{
								if($shelf >= $min_pos && $shelf <= $max_pos+1)
								{
									if($section == 0)
									{
										$section	= -1;
										$shelf		= -1;	
										
										$insert_query = "INSERT INTO  [pre]stock_fields 
										(`id` ,`stock_id`,`zona` ,`rack` ,`section`,`shelf` ,
										`block` ,`fullness` ,`dateCreate` ,`adminMod`, `ip_add`)
										VALUES 
										(NULL , '".$stock_id."', '".$zona."', '".$rack."', '".$section."', '".$shelf."', 
										'".$block."', '0', '".$mysql_date."', '".ADMIN_ID."', '".$ip_add."')
										;";

											$insert_stmt = $dbh->prepare($insert_query);
											$insert_stmt->execute();
										
										$item_id = mysql_insert_id();
									}else
									{
										if($shelf == 0)
										{
											$shelf = -1;
											
											for($i = 0; $i < $section; $i++)
											{
												$insert_query = "INSERT INTO  [pre]stock_fields 
												(`id` ,`stock_id`,`zona` ,`rack` ,`section`,`shelf` ,
												`block` ,`fullness` ,`dateCreate` ,`adminMod`,`ip_add`)
												VALUES 
												(NULL , '".$stock_id."', '".$zona."', '".$rack."', '".$i."', '".$shelf."', 
												'".$block."', '0', '".$mysql_date."', '".ADMIN_ID."', '".$ip_add."')
												;";

													$insert_stmt = $dbh->prepare($insert_query);
													$insert_stmt->execute();
										
												$item_id = mysql_insert_id();
											}
										}else
										{
											for($i = 0; $i < $section; $i++)
											{
												for($j = 0; $j < $shelf; $j++)
												{
													$insert_query = "INSERT INTO  [pre]stock_fields 
													(`id` ,`stock_id`,`zona` ,`rack` ,`section`,`shelf` ,
													`block` ,`fullness` ,`dateCreate` ,`adminMod`,`ip_add`)
													VALUES 
													(NULL , '".$stock_id."', '".$zona."', '".$rack."', '".$i."', '".$j."', 
													'".$block."', '0', '".$mysql_date."', '".ADMIN_ID."', '".$ip_add."')
													;";

														$insert_stmt = $dbh->prepare($insert_query);
														$insert_stmt->execute();
										
													$item_id = mysql_insert_id();
												}
											}
										}
									}
									
									$form_valid = true;	
									
								}else $message = "Количество полок не может превышать число ".$max_pos+1;
							}else $message = "Количество секций не может превышать число ".$max_pos+1;
						}else $message = "Стеллаж под номером <b>".$rack."</b> уже существует.";
					}else $message = "Номер стеллажа не может превышать число ".$max_pos;
				}else $message = "Пожалуйста, укажите склад.";
			}
			break;
		
		} // end 1
		case 2:
		{
			echo '<p>Добавляем обьект Секция.</p>';
			$rack		= trim(strip_tags($_POST['rack']));
			$section	= trim(strip_tags($_POST['section']));
			$shelf		= trim(strip_tags($_POST['shelf']));
			
			if($zona_valid)
			{
				if($stock_id != "0")
				{
					if($rack >= $min_pos && $rack <= $max_pos)
					{
						if($section >= $min_pos && $section <= $max_pos)
						{
							$sections_query = "SELECT section FROM [pre]stock_fields WHERE `stock_id` = :1 AND `zona` = :2 AND `rack` = :3 AND `section` = :4 ORDER BY id LIMIT 1";
			
								$sections_stmt	= $dbh->prepare($sections_query);
								$sections_arr	= $sections_stmt->execute($stock_id,$zona,$rack,$section);
								$sections		= $sections_stmt->fetchallAssoc();
						
							if(sizeof($sections) == 0)
							{
								if($shelf >= $min_pos && $shelf <= $max_pos+1)
								{
									if($shelf == 0)
										{
											$shelf = -1;
											
												$insert_query = "INSERT INTO  [pre]stock_fields 
												(`id` ,`stock_id`,`zona` ,`rack` ,`section`,`shelf` ,
												`block` ,`fullness` ,`dateCreate` ,`adminMod`,`ip_add`)
												VALUES 
												(NULL , '".$stock_id."', '".$zona."', '".$rack."', '".$section."', '".$shelf."', 
												'".$block."', '0', '".$mysql_date."', '".ADMIN_ID."', '".$ip_add."')
												;";

													$insert_stmt = $dbh->prepare($insert_query);
													$insert_stmt->execute();
										
												$item_id = mysql_insert_id();
											
										}else
										{
												for($j = 0; $j < $shelf; $j++)
												{
													$insert_query = "INSERT INTO  [pre]stock_fields 
													(`id` ,`stock_id`,`zona` ,`rack` ,`section`,`shelf` ,
													`block` ,`fullness` ,`dateCreate` ,`adminMod`,`ip_add`)
													VALUES 
													(NULL , '".$stock_id."', '".$zona."', '".$rack."', '".$section."', '".$j."', 
													'".$block."', '0', '".$mysql_date."', '".ADMIN_ID."', '".$ip_add."')
													;";

														$insert_stmt = $dbh->prepare($insert_query);
														$insert_stmt->execute();
										
													$item_id = mysql_insert_id();
												}
										}
									
									$form_valid = true;
								}else $message = "Количество полок не может превышать число ".$max_pos+1;
							}else $message = "Секция под номером ".$section." уже существует."; 
						}else $message = "Номер секции не может превышать число ".$max_pos;
					}else $message = "Номер стеллажа не может превышать число ".$max_pos;
				}else $message = "Пожалуйста, укажите склад.";
			}
			break;
		
		} // end 2
		case 3:
		{
			echo '<p>Добавляем обьект ПОЛКА.</p>';
			$rack		= trim(strip_tags($_POST['rack']));
			$section	= trim(strip_tags($_POST['section']));
			$shelf		= trim(strip_tags($_POST['shelf']));
			if($zona_valid)
			{
				if($stock_id != "0")
				{
					if($rack >= $min_pos && $rack <= $max_pos)
					{
						if($section >= $min_pos && $section <= $max_pos)
						{
							if($shelf >= $min_pos && $shelf <= $max_pos)
							{
								$shelfs_query = "SELECT shelf FROM [pre]stock_fields WHERE `stock_id` = :1 AND `zona` = :2 AND `rack` = :3 AND `section` = :4 AND `shelf` = :5 ORDER BY id LIMIT 1";
			
									$shelfs_stmt	= $dbh->prepare($shelfs_query);
									$shelfs_arr		= $shelfs_stmt->execute($stock_id,$zona,$rack,$section,$shelf);
									$shelfs			= $shelfs_stmt->fetchallAssoc();
								
								if(sizeof($shelfs) == 0)
								{
									$insert_query = "INSERT INTO  [pre]stock_fields 
													(`id` ,`stock_id`,`zona` ,`rack` ,`section`,`shelf` ,
													`block` ,`fullness` ,`dateCreate` ,`adminMod`,`ip_add`)
													VALUES 
													(NULL , '".$stock_id."', '".$zona."', '".$rack."', '".$section."', '".$shelf."', 
													'".$block."', '0', '".$mysql_date."', '".ADMIN_ID."', '".$ip_add."')
													;";
														
														$insert_stmt = $dbh->prepare($insert_query);
														$insert_stmt->execute();
										
													$item_id = mysql_insert_id();
													
									$form_valid = true;
								}else $message = "Полка под номером ".$shelf." уже существует."; 
							}else $message = "Номер полки не может превышать число ".$max_pos;
						}else $message = "Номер секции не может превышать число ".$max_pos;
					}else $message = "Номер стеллажа не может превышать число ".$max_pos;
				}else $message = "Пожалуйста, укажите склад.";
			}
			break;
			
		} // end 3
		
		default: $message = "Указан неизвестный обьект для создания."; break;
	}
	
	
	} // END IF zona valid

	
	echo "<p>Message: ".$message."</p>";
	
	$status_query = "INSERT INTO [pre]admin_tmp (`admin_id`,`tmp`) VALUES ('".ADMIN_ID."','".$message."')";

		$status_stmt = $dbh->prepare($status_query);
		$status_stmt->execute();
?>
</body>
</html>