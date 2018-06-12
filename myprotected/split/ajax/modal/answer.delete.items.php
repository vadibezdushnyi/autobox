<?php  
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
	
	require_once "../../library/AjaxHelp.php";
	
	$r = array("status"=>"fail", "message"=>"error", "html"=>"");
	
	$ah = new ajaxHelp($dbh);

	$items = $_POST['items'];
	$table = $_POST['table'];

	
	if(count($items) != 0){
	
		foreach($items as $item_id)
		{
			// Get info by item
			
			$query = "SELECT * FROM [pre]".$table." WHERE `id`='".$item_id."' LIMIT 1";
			
			$data = $ah->rs($query,1);
			$info = $data;
			
			$is_continue = true;
			
			switch($table)
			{	
				case 'users_types':
				{
					$mQuery = "SELECT id FROM [pre]users WHERE `type`=$item_id LIMIT 1";
					$m_data = $ah->rs($mQuery,1);
					
					if($m_data)
					{
						$is_continue = false;
						$r['html'] .= "<p>Группа <b>".$info['name']."</b> не может быть удалена, поскольку она не пустая.</p>";
						
					}
					break;
				}
				case 'o_orders':
				{
					$mQuery = "UPDATE [pre]o_boxes SET `order_id`=0 WHERE `order_id`=$item_id";
					$ah->rs($mQuery,0,1);
					
					$mQuery = "DELETE FROM [pre]o_orders_boxes WHERE `order_id`=$item_id";
					$ah->rs($mQuery,0,1);
					
					$mQuery = "DELETE FROM [pre]o_orders_extras WHERE `order_id`=$item_id";
					$ah->rs($mQuery,0,1);
					
					break;
				}

				default:
				{
					break;
				}
			}
			
			if(!$is_continue)
			{
				echo json_encode($r);
				exit();
			}
			
			if($table == "users_dialogs")
			{
				$delete_query = "DELETE FROM [pre]".$table." WHERE (`from_id`='".$info['from_id']."' AND `to_id`='".$info['to_id']."') OR 
								(`to_id`='".$info['from_id']."' AND `from_id`='".$info['to_id']."') LIMIT 10000";
			}else
			{
				$delete_query = "DELETE FROM [pre]".$table." WHERE `id`='".$item_id."' LIMIT 1";
			}

					$res = $ah->rs($delete_query,0,1);
					
			$item_name = "[".$info['id']."]";
			
			if(isset($info['name'])) $item_name .= " ".$info['name'];
			
			$r['html'] .= "<p>Запись <b>".$item_name."</b> успешно удалена из системы.</p>";
		}
	}else{
		$r['html'] = "Ни одна запись для удаления не найдена."; 
		}


echo json_encode($r);
exit();