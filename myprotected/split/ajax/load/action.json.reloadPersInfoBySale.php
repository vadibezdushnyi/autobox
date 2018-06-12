<?php // ajax json action
	require_once "../../../require.base.php";
	
	require_once "../../library/AjaxHelp.php";

	$data = array('status'=>'failed','message'=>'session error');
	
	$appTable = "users";

	$ah = new ajaxHelp($dbh);
	
	$sale = (int)$_POST['sale'];
	
	$uid = (int)$_POST['uid'];
	
	$email = "info@strateg.com.ua";

	
	
	
	$query = "SELECT * FROM [pre]$appTable WHERE `id`=$uid LIMIT 1";
	$user = $ah->rs($query);
	
	$sendTo =  $user['0']['login'];;
	
	$client_name = $user['0']['name'];

	//echo "<pre>"; print_r($user); echo "</pre>"; exit();
	
	if($user)
	{
		$query = "UPDATE [pre]$appTable SET `sale_percent`=$sale WHERE `id`=$uid LIMIT 1";
		$up_sale = $ah->rs($query);

		$sendMessage = "<p>Уважаемый $client_name</p>";
		$sendMessage .= "<p>Мы обновили Вашу скидку на сайте <a href='strateg.com.ua'><strong>STRATEG.com.ua</strong></a></p>";
		$sendMessage .= "<p>Теперь она составляет <strong>$sale %</strong></p>";
		$sendMessage .= "<p>Приятных покупок</p><hr>";
		$sendMessage .= "<p>Чтобы скидка учитывалась при оформлении заказа, авторизируйтесь под своим логином: <a href='http://strateg.com.ua/login/'>http://strateg.com.ua/login/</a></p>";
				
		$sendStatus = $ah->wp_send_letter($sendTo,$email,"$client_name, Ваша скидка обновлена",$sendMessage,"STRATEG COMPANI");

		$data['status'] = "success";	
		$data['message'] = "Скидка изменена. Пользователю отправлено уведомление.";	

					
		
	}
	else
	{$data['message'] = "Пользователь с таким ID не найден !";}
	
	
	
	$data['status'] = "success";
	
	
echo json_encode($data);
