<?php 
	// require_once "../../library/mailer.class.php";
	$appTable = $_POST['appTable'];
	$item_id = $_POST['item_id'];
	$cardUpd = array(
		'response'	=> $_POST['response'],
		'answered'	=> 1,
		'answeredAt'	=> date("Y-m-d H:i:s"),
		'modified'	=> date("Y-m-d H:i:s"),
	);
	
	$query = "UPDATE [pre]$appTable SET ";
	
	$cntUpd = 0;
	foreach($cardUpd as $field => $itemUpd)
	{
		$cntUpd++;
		$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
	}
	
	$query .= " WHERE `id`=$item_id LIMIT 1";
	$sendTo = $_POST['email'];
	$from = "info@apx-moe.com";
	$message = "<p>".$cardUpd['response']."</p>";

 //    $mailer = new Mailer();
 //    $headers  = "MIME-Version: 1.0\r\n";
 //    $headers .= "Content-type: text/html; charset=utf-8\r\n";
 //    $headers .= "From: delight.travel <info@delight.travel>\r\n";
 //    $headers .= "Bcc: info@delight.travel\r\n";
 //    $send = $mailer->send($sendTo,"Ответ на Ваше сообщение",$message,$headers);

	$m = $ah->wp_send_letter($sendTo, $from, "Ответ на Ваше сообщение", $message, 'APX-M.O.E');
	$data['24515'] = $m;
	
	if(1) {
		$ah->rs($query);
		$data['message'] = "Сообщение отправлено";
	} else {
		$data['message'] = 'Ошибка при отправке сообщения';	
	} 
	