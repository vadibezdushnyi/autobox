<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
	
	//require_once "../../../../split/library/wp_lib.php";
	//$wp = new wp_Lib($db_pref);
	
	function deformat_date($val)
		{
			$result = "";
			$monthes = array('','янв.','фев.','мар.','апр.','мая','июня','июля','авг.','сен.','окт.','нбр.','дек.');
			
			if(strtotime($val) > strtotime(date("d.m.Y",time())." 00:00:00"))
								{
									$result = "Сегодня, ".date("H:i",strtotime($val));
		
								}elseif(strtotime($val) < strtotime(date("d.m.Y",time())." 00:00:00") &&
										strtotime($data[$item_num]['dateCreate']) > (strtotime(date("d.m.Y",time())." 00:00:00")-86400))
									{
										$result = "Вчера, ".date("H:i",strtotime($val));
									}
								else
									{
										$result = date("d",strtotime($val))." ".$monthes[(int)date("m",strtotime($val))]." ".
																	", ".
																	date("H:i",strtotime($val));
									}
			return $result;
		}
	
	function next_sub_str($str,$len)
	{
		return implode(array_slice(explode('<br>',wordwrap($str,$len,'<br>',false)),0,1));
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Action LOAD BUFFER LAST FILE</title>
</head>

<body>
<?php 
	//echo '<pre>'; print_r($_POST); echo '</pre>'; die();
	
	$mysql_date = date("Y-m-d H:i:s",time());
	
	$id = $_POST['id'];
	$order_id = $_POST['order_id'];
	$comment = $_POST['comment'];
	$type = $_POST['type'];
	
	$pre_summ = $_POST['pre_summ'];
	$post_summ = $_POST['post_summ'];
	
	$date_arrive	= date("Y-m-d H:i:s",strtotime($_POST['date_arrive']));;
	$car_model		= $_POST['car_model'];
	$car_num		= $_POST['car_num'];
	
	$next_name = "Новая заявка";
	
	switch($type)
	{
	////////////////////////////////////////////////////////// 1 //////////////////////////////////////////////////////////////////////////
		case 1:{
		$query = "UPDATE [pre]tasks SET `status`='1', `comment`='".$comment."', `dateModify`='".$mysql_date."', `adminMod`='".ADMIN_ID."' WHERE `id`='".$id."' LIMIT 1";
	
		$_stmt = $dbh->prepare($query);
		$_stmt->execute();
		
	$query = "INSERT INTO [pre]tasks (`type`,`stock_order_id`,`status`,`comment`,`dateCreate`,`dateModify`,`adminMod`) VALUES
		     ('2','".$order_id."','0','','".$mysql_date."','".$mysql_date."','0')";
	
		$_stmt = $dbh->prepare($query);
		$_arr = $_stmt->execute();
		
	$next_name = "Подтверждение заявки на поставку";	
	
	echo '<p>Заявка успешно оформлена.</p>';
			break;
			}
	
	////////////////////////////////////////////////////////// 2 //////////////////////////////////////////////////////////////////////////
		
		case 2:{
		$query = "UPDATE [pre]tasks SET `status`='1', `comment`='".$comment."', `dateModify`='".$mysql_date."', `adminMod`='".ADMIN_ID."' WHERE `id`='".$id."' LIMIT 1";
	
		$_stmt = $dbh->prepare($query);
		$_stmt->execute();
		
	$query = "INSERT INTO [pre]tasks (`type`,`stock_order_id`,`status`,`comment`,`dateCreate`,`dateModify`,`adminMod`) VALUES
		     ('3','".$order_id."','0','','".$mysql_date."','".$mysql_date."','0')";
	
		$_stmt = $dbh->prepare($query);
		$_arr = $_stmt->execute();
		
	$next_name = "Подтверждение заявки производителем";
		
	echo '<p>Заявка успешно отправлена.</p>';
			break;
			}
	
	////////////////////////////////////////////////////////// 3 //////////////////////////////////////////////////////////////////////////
		
		case 3:{
		$query = "UPDATE [pre]tasks SET `status`='1', `comment`='".$comment."', `dateModify`='".$mysql_date."', `adminMod`='".ADMIN_ID."' WHERE `id`='".$id."' LIMIT 1";
	
		$_stmt = $dbh->prepare($query);
		$_stmt->execute();
		
	$query = "INSERT INTO [pre]tasks (`type`,`stock_order_id`,`status`,`comment`,`dateCreate`,`dateModify`,`adminMod`) VALUES
		     ('4','".$order_id."','0','','".$mysql_date."','".$mysql_date."','0')";
	
		$_stmt = $dbh->prepare($query);
		$_arr = $_stmt->execute();
		
	$next_name = "Оплата заявки на поставку";
		
	echo '<p>Заявка успешно подтверждена производителем.</p>';
			break;
			}
	
	////////////////////////////////////////////////////////// 4 //////////////////////////////////////////////////////////////////////////
		
		case 4:{
		$query = "UPDATE [pre]tasks SET `status`='1', `comment`='".$comment."', `dateModify`='".$mysql_date."', `adminMod`='".ADMIN_ID."' WHERE `id`='".$id."' LIMIT 1";
	
		$_stmt = $dbh->prepare($query);
		$_stmt->execute();
		
		$query = "UPDATE [pre]stock_orders SET `pre_summ`='".(float)$pre_summ."', `dateModify`='".$mysql_date."', `adminMod`='".ADMIN_ID."' WHERE `id`='".$order_id."' LIMIT 1";
	
		$_stmt = $dbh->prepare($query);
		$_stmt->execute();
		
	$query = "INSERT INTO [pre]tasks (`type`,`stock_order_id`,`status`,`comment`,`dateCreate`,`dateModify`,`adminMod`) VALUES
		     ('5','".$order_id."','0','','".$mysql_date."','".$mysql_date."','0')";
	
		$_stmt = $dbh->prepare($query);
		$_arr = $_stmt->execute();
		
	$next_name = "Подтверждение заявки на поставку";
		
	echo '<p>Заявка успешно отправлена и отмечена как предоплачена.</p>';
			break;
			}
			
	////////////////////////////////////////////////////////// 5 //////////////////////////////////////////////////////////////////////////
		
		case 5:{
		$query = "UPDATE [pre]tasks SET `status`='1', `comment`='".$comment."', `dateModify`='".$mysql_date."', `adminMod`='".ADMIN_ID."' WHERE `id`='".$id."' LIMIT 1";
	
		$_stmt = $dbh->prepare($query);
		$_stmt->execute();
		
		$query = "UPDATE [pre]stock_orders SET `date_arrive`='".$date_arrive."', `car_model`='".$car_model."', `car_num`='".$car_num."', `dateModify`='".$mysql_date."', `adminMod`='".ADMIN_ID."' WHERE `id`='".$order_id."' LIMIT 1";
	
		$_stmt = $dbh->prepare($query);
		$_stmt->execute();
		
	$query = "INSERT INTO [pre]tasks (`type`,`stock_order_id`,`status`,`comment`,`dateCreate`,`dateModify`,`adminMod`) VALUES
		     ('6','".$order_id."','0','','".$mysql_date."','".$mysql_date."','0')";
	
		$_stmt = $dbh->prepare($query);
		$_arr = $_stmt->execute();
		
	echo '<p>Заявка успешно отправлена на поставку.</p>';
			break;
			}
	
	////////////////////////////////////////////////////////// 6 //////////////////////////////////////////////////////////////////////////
		
		case 6:{
		$query = "UPDATE [pre]tasks SET `status`='1', `comment`='".$comment."', `dateModify`='".$mysql_date."', `adminMod`='".ADMIN_ID."' WHERE `id`='".$id."' LIMIT 1";
	
		$_stmt = $dbh->prepare($query);
		$_stmt->execute();
		
		$query = "UPDATE [pre]stock_orders SET `post_summ`='".(float)$post_summ."', `dateModify`='".$mysql_date."', `adminMod`='".ADMIN_ID."' WHERE `id`='".$order_id."' LIMIT 1";
	
		$_stmt = $dbh->prepare($query);
		$_stmt->execute();
		
	$query = "INSERT INTO [pre]tasks (`type`,`stock_order_id`,`status`,`comment`,`dateCreate`,`dateModify`,`adminMod`) VALUES
		     ('7','".$order_id."','0','','".$mysql_date."','".$mysql_date."','0')";
	
		$_stmt = $dbh->prepare($query);
		$_arr = $_stmt->execute();
		
		$last_id = mysql_insert_id();
		
	echo '<p>Полная оплата успешно подтверждена.</p>';
			break;
			}
		
		default: {
			echo 'Не задан тип задачи.';
			break;
			}
	}
	
	
?>
</body>
<script type="text/javascript" language="javascript">
	$(function(){
			$('#form_task_button').hide(200);
			
			$('#quant-new-messages').addClass('mactive');
			
			$('#quant-new-messages').animate({'top':'3px'},200,function(){
								$('#quant-new-messages').animate({'top':'13px'},800,'easeOutBounce',function(){
										$('#quant-new-messages').removeClass('mactive');
									});
			});
			
	<?php
	if($type > 0 && false)
	{
		$last_mess = '<li onclick="change_head(2); load_card(paid_orders_card_path,'.$last_id.');">Новая заявка 
                                <span class="right">'.deformat_date($mysql_date).'</span></li>';
		?>
		$('#zen_tickets').prepend('<?php echo $last_mess ?>');
		<?php
	}
	?>
			
		});
</script>
</html>