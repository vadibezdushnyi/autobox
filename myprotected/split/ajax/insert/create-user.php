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
<title>Action CREATE USER</title>
</head>

<body>
<?php 
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
	$fname		= trim(strip_tags($_POST['fname']));
	$email		= trim(strip_tags($_POST['email']));
	$phone		= trim(strip_tags($_POST['phone']));
	$type		= trim(strip_tags($_POST['type']));
	$block		= trim(strip_tags($_POST['block'][0]));
	$pass		= trim(strip_tags($_POST['pass']));
	$repass 	= trim(strip_tags($_POST['repass']));
	$birthday 	= trim(strip_tags($_POST['birthday']));
	$male		= trim(strip_tags($_POST['male'][0]));
	$active		= trim(strip_tags($_POST['active'][0]));
	
	if(isset($_POST['ef'])){$extra_fields = $_POST['ef'];} else $extra_fields = false;
	if(isset($_POST['ef_date'])){$extra_dates = $_POST['ef_date'];} else $extra_dates = false;
	
	$message = 1; // По умолчанию ошибок нет и форма может быть принята и данные запишутся в таблицу users
	
	if($name != "")
	{
		if($fname != "")
		{
			if($email != "")
			{
				if($pass != "")
				{
					if($pass == $repass)
					{
						if(strlen($pass) >= 6)
						{
							if(filter_var($email, FILTER_VALIDATE_EMAIL))
							{
								$test_user = array();
								
								$test_query = "SELECT * FROM [pre]users WHERE `login`='".$email."' LIMIT 1";
								
									$test_stmt = $dbh->prepare($test_query);
									$test_arr = $test_stmt->execute();
									$test_user = $test_arr->fetchallAssoc();
								
								if($test_user[0] == null)
								{
									$login_ex = explode("@",$email);
									$login = $login_ex[0];
							
									$birthday_date = date("Y-m-d H:i:s",strtotime($birthday));
								
									$mysql_date = date("Y-m-d H:i:s",time());
							
									if($male == '0')
									{
										$male = "М";
									}else $male = "Ж";
							
									$insert_query = "INSERT INTO  [pre]users (
									`id` ,
									`type` ,
									`login` ,
									`pass` ,
									`phone` ,
									`birthday` ,
									`name` ,
									`fname` ,
									`lname` ,
									`male` ,
									`avatar` ,
									`data` ,
									`dateCreate` ,
									`dateModify` ,
									`adminMod` ,
									`block` ,
									`active` ,
									`order_id`
									)
									VALUES (
									NULL ,  
									'".$type."',  
									'".$email."',  
									'".md5($pass)."',  
									'".$phone."',   
									'".$birthday_date."',  
									'".$name."',  
									'".$fname."',  
									'',  
									'".$male."',  
									'".$tmp."',  
									'',  
									'".$mysql_date."',  
									'".$mysql_date."',  
									'".ADMIN_ID."',  
									'".$block."',  
									'".$active."',  
									'0'
									);";

									$insert_stmt = $dbh->prepare($insert_query);
									$insert_stmt->execute();
									
									$user_id = mysql_insert_id();
									
									if($extra_fields)
									{
										foreach($extra_fields as $ef_id => $ef_value)
										{
											$ef_value = trim(strip_tags($ef_value));
											
											$ef_query = "INSERT INTO [pre]user_ef_ref (`id`,`user_id`,`ef_id`,`value`) 
														VALUES (NULL,'".$user_id."','".$ef_id."','".$ef_value."')";
											
											$ef_stmt = $dbh->prepare($ef_query);
											$ef_stmt->execute();
										}
									}
									if($extra_dates)
									{
										foreach($extra_dates as $ef_id => $ef_value)
										{
											$ef_value = trim(strip_tags($ef_value));
											$ef_value = date("Y-m-d H:i:s",strtotime($ef_value));
											
											$ef_query = "INSERT INTO [pre]user_ef_ref (`id`,`user_id`,`ef_id`,`value`) 
														VALUES (NULL,'".$user_id."','".$ef_id."','".$ef_value."')";
											
											$ef_stmt = $dbh->prepare($ef_query);
											$ef_stmt->execute();
										}
									}
								
									echo "<p>Пользователь успешно добавлен, USER_ID = ".$user_id."</p>";
									
								}else $message = "Пользователь с таким Email уже существует.";
							}else $message = "Поле Email заполнено некорректно.";
						}else $message = "Сликом короткий пароль, минимум - 6 символов.";
					}else $message = "Подтверждение пароля не сопадает, попробуйте указать еще раз.";
				}else $message = "Пожалуйста, заполните поле Пароль.";
			}else $message = "Пожалуйста, заполните поле Email.";
		}else $message = "Пожалуйста, заполните поле Фамилия.";
	}else $message = "Пожалуйста, заполните поле Имя.";
	
	echo "<p>Message: ".$message."</p>";
	
	$status_query = "INSERT INTO [pre]admin_tmp (`admin_id`,`tmp`) VALUES ('".ADMIN_ID."','".$message."')";

		$status_stmt = $dbh->prepare($status_query);
		$status_stmt->execute();
?>
</body>
</html>