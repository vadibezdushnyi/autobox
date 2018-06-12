<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	require_once "../../../../require.base.php";
	
	require_once "../../../library/AjaxHelp.php";
	
	$path = "../../../../../split/files/dialogs/";
	
	$ah = new ajaxHelp($dbh);
	
	$message	= strip_tags($_POST['message']);
	$to_id		= (int)$_POST['to_id'];
	$from_id	= ADMIN_ID;

	$data = array(
				"status"=>"failed",
				"message"=>"Tech error"
				);
	
	
	$dateCreate = date("Y-m-d H:i:s",time());
	
	if($message!="" || (isset($_FILES['file']) && $_FILES['file']['size'] > 0) )
	{
		if(isset($_FILES['file']) && $_FILES['file']['size'] > 0)
		{
			$filename = $ah->mtvc_add_files_file(array(
				'path'			=>$path,
				'name'			=>5,
				'pre'			=>"ms_",
				'size'			=>20,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2500,
				'files'			=>"file",
				'resize_path'	=>$path."crop/",
				'resize_w'		=>320,
				'resize_h'		=>240
				));
		}
		
		$query = "UPDATE [pre]users_dialogs SET `last`=0 WHERE (`from_id`=$from_id AND `to_id`=$to_id) OR (`from_id`=$to_id AND `to_id`=$from_id) LIMIT 1000";
		$ah->rs($query);
		
		$query = "INSERT INTO [pre]users_dialogs (`message`,`from_id`,`to_id`,`dateCreate`,`last`,`status`) VALUES ('$message',$from_id,$to_id,'$dateCreate',1,0)";
		$ah->rs($query);
		
		$msId = mysql_insert_id();
		
		if($filename)
			{
				$crop_name = "320x240_".$filename;
				
				$query = "INSERT INTO [pre]dialog_files_ref (`ref_table`,`ref_id`,`file`,`crop`,`path`,`adminMod`)
								VALUES ('users_dialogs','$msId','$filename','$crop_name','files/dialogs/','".ADMIN_ID."')";
				$ah->rs($query);
			}
		
		$data['status'] = "success";
		$data['message'] = "Your message has been sent.";
	
	}else{
		$data['message'] = "Your message is empty, minimum one letter required.";
		}
	
	echo json_encode($data);	