<?php // ajax json action 
	
	require_once "../../../require.base.php";
 
 	$data = array('status'=>"error",'message'=>"Tech error",'user_id'=>0,'user_pass'=>"");
 
	$login = strip_tags($_POST['login']);
	$pass = strip_tags($_POST['pass']);
	
	
	$user_query = "SELECT * FROM [pre]users WHERE login = '".$login."' AND pass = '".md5($pass)."' AND `block` = 0 AND `active`=1 LIMIT 1";
	$user_stmt = $dbh->prepare($user_query);
	$user_stmt->execute();
                	
	$user_result = new DB_Result($user_stmt);

		$user = $user_result->Next();
		
		if($user->id != null && $user->id != "" && $user->id != "0")
		{
			$query = "SELECT * FROM [pre]users_types WHERE id = '".$user->type."' AND 'block' = 0 LIMIT 1";
			
				$_stmt	= $dbh->prepare($query);
				$_arr	= $_stmt->execute();
			
			$_res = $_arr->fetchallAssoc();
			
			if(sizeof($_res) > 0)
			{
				$type = $_res[0];
				
				if($type['admin_enter'] == 1)
				{
					$data['status'] = "success";
					$data['message'] = "Success login";
					
					$data['user_id'] = $user->id;
					$data['user_pass'] = $user->pass;
				}
			}
		}else{
			$data['message'] = "Login or password is incorrect";
		}



echo json_encode($data);