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
<title>Action CREATE SHOP PRODUCT</title>
</head>

<body>
<?php 
	//echo '<pre>'; print_r($_POST); echo '</pre>'; die("STOP");
	
	$query = "SELECT  * FROM [pre]admin_tmp WHERE `admin_id`='".ADMIN_ID."' ORDER BY id DESC";

		$result_stmt = $dbh->prepare($query);
		$result_arr = $result_stmt->execute();
		$result = $result_arr->fetchallAssoc();
		
		if($result[0] != null)
		{
			$tmp = $result[0]['tmp'];
		}else
		{
			$tmp = 0;
		}
		
	$name		= trim(strip_tags($_POST['name']));
	$sku		= trim(strip_tags($_POST['sku']));
	$code		= trim(strip_tags($_POST['code']));
	$alias		= trim(strip_tags($_POST['alias']));
	$block		= trim(strip_tags($_POST['block'][0]));
	$index		= trim(strip_tags($_POST['index'][0]));
	$group		= trim(strip_tags($_POST['group']));
	$price 		= trim(strip_tags($_POST['price']));
	$quant 		= trim(strip_tags($_POST['quant']));
	$details	= trim(strip_tags($_POST['details']));
	$date_start	= trim(strip_tags($_POST['date_start']));
	$date_finish = trim(strip_tags($_POST['date_finish']));
	
	$title	= trim(strip_tags($_POST['title']));
	$desc	= trim(strip_tags($_POST['desc']));
	$keys	= trim(strip_tags($_POST['keys']));
	// shop_products
	
	$cat		= trim(strip_tags($_POST['cat']));
	// shop_cat_prod_ref
	
	$char	= trim(strip_tags($_POST['char'])); // array
	// shop_product_chars_ref
	
	
	$message = 1; // По умолчанию ошибок нет и форма может быть принята и данные запишутся в таблицу users
	
	if($name != "")
	{
		if($sku != "")
		{
			if($code != "")
			{
				if($alias != "")
				{
					if($cat > 0)
					{
						if(strlen($name) >= 3)
						{
								$test_user = array();
								
								$test_query = "SELECT * FROM [pre]shop_products WHERE `sku`='".$sku."' LIMIT 1";
								
									$test_stmt = $dbh->prepare($test_query);
									$test_arr = $test_stmt->execute();
									$test = $test_arr->fetchallAssoc();
								
								if(sizeof($test) == 0)
								{
									$date_start = date("Y-m-d H:i:s",strtotime($date_start));
									$date_finish = date("Y-m-d H:i:s",strtotime($date_finish));
								
									$mysql_date = date("Y-m-d H:i:s",time());
							
									$insert_query = "INSERT INTO  [pre]shop_products (
									`id` ,
									`quant` ,
									`order_id` ,
									`name` ,
									`alias` ,
									`sku` ,
									`code` ,
									`price` ,
									`currency` ,
									`filename` ,
									`block` ,
									`index`,
									`title` ,
									`keys` ,
									`desc` ,
									`date_start` ,
									`date_finish` ,
									`dateCreate` ,
									`dateModify`,
									`adminMod`
									)
									VALUES (
									NULL ,  
									'".$quant."',  
									'0',  
									'".$name."',  
									'".$alias."',   
									'".$sku."',  
									'".$code."',  
									'".$price."',  
									'UAH',  
									'',  
									'".$block."',  
									'".$index."',  
									'".$title."',  
									'".$keys."',  
									'".$desc."',  
									'".$date_start."',  
									'".$date_finish."',  
									'".$mysql_date."',
									'".$mysql_date."',
									'".ADMIN_ID."'
									);";

									$insert_stmt = $dbh->prepare($insert_query);
									$insert_stmt->execute();
									
									$product_id = mysql_insert_id();
									
									echo "<p>Товар успешно добавлен в интернет магазин, PRODUCT_ID = ".$product_id."</p>";
									
									if($product_id)
									{
										$query = "INSERT INTO [pre]shop_cat_prod_ref (`cat_id`,`prod_id`,`dateCreate`) VALUES ('".$cat."','".$product_id."','".$mysql_date."')";
										
										$_stmt = $dbh->prepare($query);
										$_stmt->execute();
										
										foreach($char as $char_id => $char_value)
										{
											$query = "INSERT INTO [pre]shop_product_chars_ref (`product_id`,`char_id`,`value`) VALUES ('".$product_id."','".$char_id."','".$char_value."')";
										
											$_stmt = $dbh->prepare($query);
											$_stmt->execute();
										}
								
								
										echo '<p>Все успешно добавлено.</p>';
									}else{
										echo '<p>Не удалось добавить товар.</p>';
										}
									
							}else $message = " Товар с таким артикулом ".$test[0]['sku']." уже существует, укажите другой.";
						}else $message = "Сликом короткое название товара, минимум - 3 символов.";
					}else $message = "Выберите категорию товаров из каталога.";
				}else $message = "Пожалуйста, заполните поле Алиас.";
			}else $message = "Пожалуйста, заполните поле Штрих-код.";
		}else $message = "Пожалуйста, заполните поле Артикул.";
	}else $message = "Пожалуйста, заполните поле Название.";
	
	echo "<p>Message: ".$message."</p>";
	
	$status_query = "INSERT INTO [pre]admin_tmp (`admin_id`,`tmp`) VALUES ('".ADMIN_ID."','".$message."')";

		$status_stmt = $dbh->prepare($status_query);
		$status_stmt->execute();
?>
</body>
</html>