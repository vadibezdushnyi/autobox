<?php // ajax json action
	require_once "../../../require.base.php";
	
	require_once "../../library/AjaxHelp.php";
	
	$lastMessId = $_POST['lastMessId'];
	
	$data = array('status'=>"error",'message'=>"", 'newItems'=>"", 'last_id'=>$lastMessId);
	
	$ah = new ajaxHelp($dbh);
	

	$itemId = $_POST['itemId'];
	
	$id1 = ADMIN_ID;
	
	$query = "SELECT `from_id`,`to_id` FROM [pre]users_dialogs WHERE id=$itemId LIMIT 1";
	$uds = $ah->rs($query);
	
	$query = "UPDATE [pre]users_dialogs SET `status`=1 WHERE `to_id`='".ADMIN_ID."' AND `status`=0 LIMIT 1000";
	$ah->rs($query);	
	
	if($uds)
	{
		$uds = $uds[0];
		$id2 = ($uds['from_id']==$id1 ? $uds['to_id'] : $uds['from_id']);
		
		if($lastMessId == (-1))
		{
			$query = "SELECT id 
						FROM [pre]users_dialogs  
						WHERE (`from_id`=$id1 AND `to_id`=$id2) OR (`from_id`=$id2 AND `to_id`=$id1) 
						ORDER BY id DESC LIMIT 1";
			$idM = $ah->rs($query);
			if($idM)
			{
				$data['last_id'] = $idM[0]['id'];
			}
		}else
		{
			
			$query = "SELECT M.* ,
						(SELECT file FROM [pre]dialog_files_ref WHERE ref_id=M.id LIMIT 1) as file,
						(SELECT crop FROM [pre]dialog_files_ref WHERE ref_id=M.id LIMIT 1) as crop
						FROM [pre]users_dialogs as M 
						WHERE `id`>$lastMessId AND ( (`from_id`=$id1 AND `to_id`=$id2) OR (`from_id`=$id2 AND `to_id`=$id1) ) 
						ORDER BY id DESC LIMIT 10000";
			$result = $ah->rs($query);
			
			$rootPath = "../../../../";
			
			if($result)
			{
				$data['last_id'] = $result[0]['id'];
				
				$myInfo		= $ah->getUserInfo(ADMIN_ID);
			
				$friendInfo	= $ah->getUserInfo($id2);
				
				$ava_folder = "/split/files/users/crop/150x150_";
				
				$icnt = 0;
				foreach($result as $mess)
				{
					$icnt++;
					$curr_class = ($icnt%2 > 0 ? "zebra" : "");
					$curr_ava = ($mess['from_id']==ADMIN_ID ? $myInfo['avatar'] : $friendInfo['avatar']);
					$curr_name = ($mess['from_id']==ADMIN_ID ? $myInfo['name']." ".$myInfo['fname'] : $friendInfo['name']." ".$friendInfo['fname']);
					$curr_mess = $mess['message'];
					$curr_date = $ah->deformat_long_date($mess['dateCreate']);
					$curr_file = $mess['file'];
					$curr_crop = $mess['crop'];
					
					if(!file_exists($rootPath."split/files/users/crop/150x150_".$curr_ava))
					{
						$curr_ava = "split/img/no_image.png?i=".time();
					}else
					{
						$curr_ava = $ava_folder.$curr_ava;
					}
			
					$data['newItems'] .= "
							<div class='dialog-item $curr_class'>
            					<div class='avatar'><img alt='AVATAR' src='$curr_ava'></div>
                				<div class='dialog-content'>
                					<div class='dialog-name'>$curr_name</div>
                    				<div class='dialog-block'>
                    					<div class='dialog-message'>$curr_mess</div>";
									if($curr_file)
									{
										$data['newItems'] .= "
											<div class='dialog-files'>
                        						<div class='file'><a class='theater' rel='group' href='/split/files/dialogs/$curr_file' title='MESSAGE FILE'>
													<img alt='PHOTO' src='/split/files/dialogs/crop/$curr_crop'></a>
												</div>
												<div class='clear'></div>
											</div>
											";
									}
									$data['newItems'] .= "
									</div>
                				</div>
                				<div class='dialog-date'>$curr_date</div>
            				</div>
						";
				}
			}
			
		}
	}
	
	
echo json_encode($data);

