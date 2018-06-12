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
	$name		= trim(strip_tags($_POST['name']));
	$alias		= trim(strip_tags($_POST['alias']));
	$adress		= trim(strip_tags($_POST['adress']));
	$gps_w		= trim(strip_tags($_POST['gps_w']));
	$gps_h		= trim(strip_tags($_POST['gps_h']));
	$block		= trim(strip_tags($_POST['block'][0]));;
	
	$extra_fields = false;
	$extra_dates = false;
	
	$message = 1; // По умолчанию ошибок нет и форма может быть принята и данные запишутся в таблицу stocks
	
	if($name != "")
	{
		if($alias != "")
		{
			if($gps_w != "")
			{
				if($gps_h != "")
				{
					if($adress != "")
					{
									$mysql_date = date("Y-m-d H:i:s",time());
							
									$insert_query = "INSERT INTO  [pre]stocks (
									`id` ,
									`order_id`,
									`name` ,
									`alias` ,
									`block`,
									`adress` ,
									`gps_w` ,
									`gps_h` ,
									`dateCreate` ,
									`dateModify` ,
									`adminMod`
									)
									VALUES (
									NULL ,  
									'0',
									'".$name."',  
									'".$alias."',    
									'".$block."',     
									'".$adress."',  
									'".$gps_w."',
									'".$gps_h."',
									'".$mysql_date."',  
									'".$mysql_date."',  
									'".ADMIN_ID."'
									);";

									$insert_stmt = $dbh->prepare($insert_query);
									$insert_stmt->execute();
									
									$item_id = mysql_insert_id();
									
					}else $message = "Пожалуйста, заполните поле Адрес.";
				}else $message = "Пожалуйста, заполните поле GPS долгота.";
			}else $message = "Пожалуйста, заполните поле GPS широта.";
		}else $message = "Пожалуйста, заполните поле Алиас.";
	}else $message = "Пожалуйста, заполните поле Название.";
	
	echo "<p>Message: ".$message."</p>";
	
	$status_query = "INSERT INTO [pre]admin_tmp (`admin_id`,`tmp`) VALUES ('".ADMIN_ID."','".$message."')";

		$status_stmt = $dbh->prepare($status_query);
		$status_stmt->execute();
?>
</body>
</html>