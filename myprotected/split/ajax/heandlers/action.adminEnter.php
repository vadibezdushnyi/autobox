<?php 
// ajax action: admin Enter 
	
require_once "../../../boot/boot.php";
$db = new DBManager($config);
require_once "../../../helpers/functions.php";

$response = array(
		'status'=>"error",
		'message'=>"Tech error",
		'user_id'=>0,
		'user_pass'=>""
		);

$login = _post('login');
$pass = _post('pass');

$response['pass'] = md5($pass);


$query = "
		SELECT * 
		FROM [pre]users 
		WHERE 
			login = '".$login."' AND 
			pass = '".md5($pass)."' AND 
			`block` = 0 AND 
			`active`=1 
		LIMIT 1
		";
$user = $db->q($query,1);
	
if($user){
	
	$query = "
			SELECT * 
			FROM [pre]users_types 
			WHERE 
				id = '".$user['type']."' AND 
				'block' = 0 
			LIMIT 1
			";
	
	if($type=$db->q($query,1)){
		if($type['admin_enter'] == 1){

			$response['status'] = "success";
			$response['message'] = "Success login";
			
			$response['user_id'] = $user['id'];
			$response['user_pass'] = $user['pass'];

			_log(1,"Admin login: Success login.",$user['id']);
		}else{
			$response['message'] = "Permission denied.";
			_log(1,"Admin login: Permission denied.",$user['id']);
		}
	}
	else{
		$response['message'] = "Incorrect user type, Permission denied.";
		_log(1,"Admin login: Incorrect user type, Permission denied.",$user['id']);
	}
}else{
	$response['message'] = "Login or password is incorrect";
}
echo json_encode($response);