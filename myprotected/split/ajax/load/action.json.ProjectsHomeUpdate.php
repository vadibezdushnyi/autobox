<?php
	// Action SET BOOSTER IN ORDER

	require_once "../../../require.base.php";
	
	require_once "../../library/AjaxHelp.php";

	$ah = new ajaxHelp($dbh);

	$response = ['status'=>'fail', 'message'=>'Error'];

	$_id = (int)$_POST['id'];
	$_val = (int)$_POST['val'];

	$query = "UPDATE [pre]projects SET `show_home`='$_val' WHERE `id`=$_id LIMIT 1";

	$ah->rs($query,0,1);

	$response['status'] = 'success';

	echo json_encode($response);
