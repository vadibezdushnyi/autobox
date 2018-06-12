<?php 
	// require_once "../../library/mailer.class.php";
	$appTable = $_POST['appTable'];
	$item_id = $_POST['item_id'];
	$cardUpd = array(
		'viewed'	=> 1,
		'answered'	=> 1,
		'reply'	=> $_POST['reply'],
		'name'	=> $_POST['name'],
		'dateReply'	=> date("Y-m-d H:i:s"),
	);
	
	$query = "UPDATE [pre]$appTable SET ";
	
	$cntUpd = 0;
	foreach($cardUpd as $field => $itemUpd)
	{
		$cntUpd++;
		$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
	}
	
	$query .= " WHERE `id`=$item_id LIMIT 1";
	$sendTo 	= $_POST['email'];
	$from 		= "team@autobox24.com";
	$message 	= "<p>".$cardUpd['reply']."</p>";

 //    $mailer = new Mailer();
 //    $headers  = "MIME-Version: 1.0\r\n";
 //    $headers .= "Content-type: text/html; charset=utf-8\r\n";
 //    $headers .= "From: delight.travel <info@delight.travel>\r\n";
 //    $headers .= "Bcc: info@delight.travel\r\n";
 //    $send = $mailer->send($sendTo,"Ответ на Ваше сообщение",$message,$headers);

	$data['query'] = $ah->rs($query);

	if(true) {
		$m = $ah->wp_send_letter($sendTo, $from, "Autobox24 reply", $message, 'Autobox24');
		$data['letter'] = $m;
		$data['message'] = "Reply sent";
	} else {
		$data['message'] = 'Error occured while sending';	
	} 
	