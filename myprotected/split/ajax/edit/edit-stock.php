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
<title>Action EDIT ITEM STOCK</title>
</head>

<body>
<?php 
	//echo '<pre>'; print_r($_POST); echo '</pre>';
	
	$id			= trim(strip_tags($_POST['id']));
	
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
							
									$update_query = "UPDATE [pre]stocks SET
									`name`			='".$name."' ,
									`alias`			='".$alias."' ,
									`block`			='".$block."',
									`adress`		='".$adress."' ,
									`gps_w`			='".$gps_w."' ,
									`gps_h`			='".$gps_h."' ,
									`dateModify`	='".$mysql_date."' ,
									`adminMod`		='".ADMIN_ID."'
									
									WHERE `id`='".$id."' LIMIT 1
									";

									$update_stmt = $dbh->prepare($update_query);
									$update_stmt->execute();
									
					}else $message = "Пожалуйста, не оставляйте пустым поле Адрес.";
				}else $message = "Пожалуйста, не оставляйте пустым поле GPS долгота.";
			}else $message = "Пожалуйста, не оставляйте пустым поле GPS широта.";
		}else $message = "Пожалуйста, не оставляйте пустым поле Алиас.";
	}else $message = "Пожалуйста, не оставляйте пустым поле Название.";
	
	echo "<p>Query: ".$update_query."</p>";
	
	echo "<p>Message: ".$message."</p>";
	
	$status_query = "INSERT INTO [pre]admin_tmp (`admin_id`,`tmp`) VALUES ('".ADMIN_ID."','".$message."')";

		$status_stmt = $dbh->prepare($status_query);
		$status_stmt->execute();
?>
</body>
</html>