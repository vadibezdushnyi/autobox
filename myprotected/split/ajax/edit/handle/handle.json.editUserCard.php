<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					'name'			=> $_POST['name'],
					'fname'			=> $_POST['fname'],
					'login'			=> $_POST['login'],
					'email'			=> $_POST['email'],
					'phone'			=> $_POST['phone'],
					'block'			=> $_POST['block'][0],
					'active'		=> $_POST['active'][0],
					'male'			=> $_POST['male'][0],
					'type'			=> $_POST['type'],
					'birthday'		=> date("Y-m-d H:i:s", strtotime($_POST['birthday'])),
					
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
					
	// File upload 
	
	//echo "<pre>"; print_r($cardUpd); echo "</pre>"; exit();

	
	$filename = "avatar";
	
	$file_update = false;

	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = "../../../../split/files/users/";
		
		$file_update = $ah->mtvc_add_files_file(array(
				'path'			=>$file_path,
				'name'			=>5,
				'pre'			=>"zen_",
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2500,
				'files'			=>$filename,
				'resize_path'	=>"0", //$file_path."crop/",
				'resize_w'		=>0, //150,
				'resize_h'		=>0, //150,
				'resize_path_2'	=>"0", 
				'resize_w_2'	=>0,
				'resize_h_2'	=>0
			  ));

		if($file_update)
		{
			$cardUpd[$filename] = $file_update;

			//$data['message'] = "file $filename = ".$file_update;
			//echo json_encode($data); exit();
			
			//$curr_filename = $_POST['curr_filename'];
			
			//unlink($file_path.$curr_filename);
		}
	}
	
	// Update main table
	
	$query = "UPDATE [pre]$appTable SET ";
	
	$cntUpd = 0;
	foreach($cardUpd as $field => $itemUpd)
	{
		$cntUpd++;
		$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
	}
	
	$query .= " WHERE `id`=$item_id LIMIT 1";
		
	$data['block'] = $cardUpd['block'];
	
	$data['query'] = $query;
		
	$ah->rs($query);
	
	// Update user extra fields
	
	$ef = array();
	
	$data['message'] = "Success user save. ";
	
	// Change password
	
	if(isset($_POST['old-pass']))
	{
		$oldPass	= $_POST['old-pass'];
		$newPass	= $_POST['new-pass'];
		$newPassR	= $_POST['new-pass-r'];
		
		$query = "SELECT pass FROM [pre]users WHERE `id`='$item_id' LIMIT 1";
		$userData = $ah->rs($query);
		
		if($userData)
		{
			$userPass = $userData[0]['pass'];
			
			if( (md5($oldPass)==$userPass || ADMIN_TYPE==1) && trim($newPass) != "")
			{
				if($newPass===$newPassR)
				{
					$query = "UPDATE [pre]users SET `pass`='".md5($newPass)."' WHERE `id`='$item_id' LIMIT 1";
					$ah->rs($query);
					
					$letter = "<p>Здравствуйте, ".$cardUpd['name']." ".$cardUpd['fname']."!</p>";
					
					$letter .= "<p>Уведомляем Вас о том, что Ваш пароль для аккаунта <b>".$cardUpd['login']."</b> на сайте <u>http://".$_SERVER['HTTP_HOST']."</u> был изменен!</p>";
					
					$letter .= "<h4>Новые параметры для входа:</h4>";
					
					$letter .= "<table border='1'>
									<tr>
										<td style='padding:5px;'>Логин</td>
										<td style='padding:5px;'>".$cardUpd['login']."</td>
									</tr>
									<tr>
										<td style='padding:5px;'>Пароль</td>
										<td style='padding:5px;'>".$newPass."</td>
									</tr>
								</table>";
								
					$letter .= "<p>Если Вы не являетесь владельцем данного аккаунта - просто удалите это письмо.</p>";
					
					$ah->wp_send_letter($cardUpd['login'],"support@".$_SERVER['HTTP_HOST'],"Ваш пароль был изменен.",$letter);
					
					$data['message'] .= "Пароль успешно обновлен.";
				}else{
					$data['message'] .= "Пароли не совпадают!";
					}
			}else{
					if(trim($newPass) != "")
					{
						$data['message'] .= "Старый пароль введен неверно!";
					}
				}
		}
	}
	