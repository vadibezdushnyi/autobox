<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);

    $cardUpd = array(
        'name'	        => $_POST['name'],
        'body'          => str_replace("'","\'",trim($_POST['body'])),
        'de_body'       => str_replace("'","\'",trim($_POST['body'])),
        'ru_body'       => str_replace("'","\'",trim($_POST['body'])),
        'cz_body'       => str_replace("'","\'",trim($_POST['body'])),
        'sk_body'       => str_replace("'","\'",trim($_POST['body'])),
        'tr_body'       => str_replace("'","\'",trim($_POST['body'])),
        'es_body'       => str_replace("'","\'",trim($_POST['body'])),
        'ar_body'       => str_replace("'","\'",trim($_POST['body'])),
        'subject'       => str_replace("'","\'",trim($_POST['subject'])),
        'de_subject'    => str_replace("'","\'",trim($_POST['subject'])),
        'ru_subject'    => str_replace("'","\'",trim($_POST['subject'])),
        'cz_subject'    => str_replace("'","\'",trim($_POST['subject'])),
        'sk_subject'    => str_replace("'","\'",trim($_POST['subject'])),
        'tr_subject'    => str_replace("'","\'",trim($_POST['subject'])),
        'es_subject'    => str_replace("'","\'",trim($_POST['subject'])),
        'ar_subject'    => str_replace("'","\'",trim($_POST['subject'])),
        'email_from'    => $_POST['email_from']
    );
	
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
    $item_id = $ah->rs($query,0,0,1);
    
    if($item_id)
    {
        $data['item_id'] = $item_id;
    }else
    {
        $data['item_id'] = 0;
    }
    
    $data['message'] = "Created.";

	

	