<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
	
	//require_once "../../../../split/library/wp_lib.php";
	//$wp = new wp_Lib($db_pref);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Action UPDATE QUANT NEW MESSAGES</title>
</head>

<body>
<?php 
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

	$quant = 0;
	
	$query = "SELECT COUNT(*) FROM [pre]shop_orders WHERE `status`= :1 AND `paid_status` = :2 ORDER BY id LIMIT 1000";
			
		$_stmt = $dbh->prepare($query);
		$_arr = $_stmt->execute('Оформлен','Оплачен');
		
	$_res = $_arr->fetchallAssoc();
	$quant = (int)$_res[0]['COUNT(*)'];
	
	$query = "SELECT COUNT(*) FROM [pre]tasks WHERE `status`= 0 ORDER BY id LIMIT 1000";
			
		$_stmt = $dbh->prepare($query);
		$_arr = $_stmt->execute();
		
	$tasks = $_arr->fetchallAssoc();
	
	$quant += $tasks[0]['COUNT(*)'];
	
	$query = "SELECT * FROM [pre]users_dialogs WHERE `to_id`='".ADMIN_ID."' AND `status`=0 ORDER BY dateCreate DESC LIMIT 10000";
	
		$_stmt = $dbh->prepare($query);
		$_arr = $_stmt->execute();
	
	$_res = $_arr->fetchallAssoc();
	$dialogs = $_res;
	
	$last_name = "";
	$last_message = "";
	$last_date = "";
	
	
	if(sizeof($_res) > 0)
	{
		$lastM = $_res[0];
		
		$query = "SELECT name,fname FROM [pre]users WHERE `id`='".$lastM['from_id']."' LIMIT 1";
		
		$_stmt = $dbh->prepare($query);
		$_arr = $_stmt->execute();
		
		$_res = $_arr->fetchallAssoc();
		
		$last_name = next_sub_str($_res[0]['name']." ".$_res[0]['fname'],15);
		$last_message = next_sub_str($lastM['message'],50);
		$last_date = deformat_date($lastM['dateCreate']);
		
		$last_mess = '<li id="mess_loop_'.$lastM['id'].'" title="Прочитать" onclick="document.location.href = mess_path;"><span class="left">'.$last_name.'</span><span class="right">'.$last_date.'</span><br>'.$last_message.'</li>';
	}
	
	$quant += sizeof($dialogs);
?>
		<script type="text/javascript" language="javascript">
		var mess_path = 'index.php?control=personal&item=29&id=<?php echo $lastM['id'] ?>';
			$(function(){
					//alert('<?php echo $last_name ?>');
					var cur_quant = parseInt($('#quant-new-messages').html());
					if(cur_quant != <?php echo $quant ?>)
					{
						$('#quant-new-messages').addClass('mactive');
						$('#quant-new-messages').html('<?php echo $quant ?>');
						$('#quant-new-messages').animate({'top':'3px'},200,function(){
								$('#quant-new-messages').animate({'top':'13px'},800,'easeOutBounce',function(){
										$('#quant-new-messages').removeClass('mactive');
									});
								//alert('<?php echo $last_mess ?>');
								
								$('#zen_messages').prepend('<?php echo $last_mess ?>');
							});
					}
				});
		</script>
</body>
</html>