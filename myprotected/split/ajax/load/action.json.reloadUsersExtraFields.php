<?php // ajax json action
	require_once "../../../require.base.php";
	
	require_once "../../library/AjaxHelp.php";
	
	$ah = new ajaxHelp($dbh);
	
	$data = array();
	
	$appTable = "users";

	$typeId	= $_POST['typeId'];
	
	$userId	= $_POST['userId'];
	
	
	if($typeId > 0)
	{
		// Get extra field groups
				
				$query = "SELECT M.ef_group_id as id,
						(SELECT name FROM [pre]users_extra_fields_groups WHERE id=M.ef_group_id) as name
						FROM [pre]users_types_extra_field_ref as M 
						WHERE `group_id`='".$typeId."' 
						LIMIT 100";
				$eData = $ah->rs($query);
		
		if($eData)
		{		
				foreach($eData as $i => $efg)
					{
						$query = "SELECT M.*,
									(SELECT name FROM [pre]user_extra_fields WHERE id=M.ef_id) as name,
									(SELECT value FROM [pre]user_ef_ref WHERE ef_id=M.ef_id AND user_id='".$userId."') as value
									FROM [pre]users_ef_group_ref as M 
									WHERE `group_id`='".$efg['id']."' 
									ORDER BY id 
									LIMIT 100 
						";
						$eData[$i]['values'] = $ah->rs($query);
						
					}
	
			$result .= "<div id='usersExtraFields'>";
						foreach($eData as $eGroup)
						{
							$result .= $ah->hr($eGroup['name']);
							foreach($eGroup['values'] as $eValue)
							{
								$result .= $ah->print_input($eValue['name'],"ef[".$eValue['ef_id']."]",$eValue['name'],$eValue['value'],25,"text");
							}
						}
			$result .= "</div>";
		}
	}
	
	$data['message'] = $result;
	
	$data['status'] = "success";
	
	
echo json_encode($data);
