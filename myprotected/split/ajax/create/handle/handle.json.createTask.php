<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	
	$to_id		= $_POST['user_id'];
	$from_id	= ADMIN_ID;
	
	$cardUpd = array(
					'subject'		=> str_replace("'","\'",$_POST['title']),
					'comment'		=> str_replace("'","\'",$_POST['message']),
					
					'date_finish'	=> date("Y-m-d H:i:s", strtotime($_POST['date_finish'])),
					
					'dateCreate'	=> date("Y-m-d H:i:s", time()),
					'dateModify'	=> date("Y-m-d H:i:s", time()),
					'adminMod'		=> ADMIN_ID
					);
					
	if($to_id)
	{
		if(strlen($cardUpd['subject'])>3)
		{
			if($cardUpd['date_finish']!="1970-01-01 03:00:00")
			{
				// Create main table item
	
				$query = "INSERT INTO [pre]$appTable ";
				
				$fieldsStr = " ( ";
				
				$valuesStr = " ( ";
				
				$cntUpd = 0;
				foreach($cardUpd as $field => $itemUpd)
				{
					$cntUpd++;
					
					$fieldsStr .= ($cntUpd==1 ? "`$field`" : ", `$field`");
					
					$valuesStr .= ($cntUpd==1 ? "'$itemUpd'" : ", '$itemUpd'");
				}
				
				$fieldsStr .= " ) ";
				
				$valuesStr .= " ) ";
				
				$query .= $fieldsStr." VALUES ".$valuesStr;
					
				$ah->rs($query);
				
				$item_id = mysql_insert_id();
				
				if($item_id)
				{
					$query = "INSERT INTO [pre]task_admin_ref (`task_id`,`admin_id`,`responsible_id`) VALUES ('$item_id','$from_id','$to_id')";
					$ah->rs($query);
					
					$data['item_id'] = $item_id;
					
					$query = "SELECT * FROM [pre]users WHERE `id`='$to_id' LIMIT 1";
					$RespUser = $ah->rs($query);
					
					if($RespUser)
					{
						$R = $RespUser[0];
						
						$r_mess = "<p>".$R['name']." ".$R['fname'].", Вы получили новое задание от администратора.</p>
								   <p>Дедлайн: ".$cardUpd['date_finish']."</p>
								   <p>Перейдиете в админпанель для выполнения: <a href='http://".$_SERVER['HTTP_HOST']."/myprotected'>Перейти</a></p>
								   <table style='border:4px solid #EEE'>
									<tr>
										<td style='padding:5px; border-right:1px solid #EEE; border-bottom:1px solid #EEE;'>Тема:</td>
										<td style='padding:5px;'><h4>".$cardUpd['subject']."</h4></td>
									</tr>
									<tr>
										<td style='padding:5px; border-right:1px solid #EEE;'>Задание:</td>
										<td style='padding:5px;'>".strip_tags($cardUpd['comment'])."</td>
									</tr>
								   </table>
									";
						
						$ah->wp_send_letter($R['login'],"support@".$_SERVER['HTTP_HOST'],"New PROJECT Task: ".$cardUpd['subject'],$r_mess);
					}
					
				}else
				{
					$data['item_id'] = 0;
				}
				
				$data['status'] = "success";
				$data['message'] = "Задание успешно назначено.";
			}else{
				$data['status']='failed';
				$data['message']='Укажите дедлайн.';
				}
		}else{
			$data['status']='failed';
			$data['message']='Укажите тему задания.';
			}
	}else{
		$data['status']='failed';
		$data['message']='Укажите ответственного.';
		}
	
	