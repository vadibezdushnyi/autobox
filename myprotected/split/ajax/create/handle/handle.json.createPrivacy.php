<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);

	$lang_fields = $ah->getAvailableLangs();
	//json_decode($_POST['av_langs']);
	
	if ($_POST['order_id'] == '' || preg_match('/[a-z]+/i',$_POST['order_id'])) {
		$order_id = 0;
	}else{
		$order_id = $_POST['order_id'];
	}
	
	$cardUpd = array(
					'q'		=> $_POST['q'],
					'a'		=> $_POST['a'],
					'block'			=> $_POST['block'][0],
					'order_id'		=> $order_id,
					
					'dateCreate'	=> date("Y-m-d H:i:s", time()),
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);

	foreach ($lang_fields as $key) {

		$ind = (string)$key['alias'].'_q';
		$lang_tmp = array($ind => (string)$_POST['q']);
		$cardUpd = array_merge($cardUpd, $lang_tmp);


		$ind2 = (string)$key['alias'].'_a';
		$lang_tmp2 = array($ind2 => (string)$_POST['a']);
		$cardUpd = array_merge($cardUpd, $lang_tmp2);

	}
	
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
		$data['item_id'] = $item_id;
	}else
	{
		$data['item_id'] = 0;
	}
	
	$data['message'] = "Новый элемент Privacy успешно создан.";
	