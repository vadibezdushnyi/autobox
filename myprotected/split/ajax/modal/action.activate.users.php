<?php  
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Action ACTIVATE USERS</title>
</head>

<?php
	$users = $_POST['users'];
?>

<body>
<button class="close-modal" onclick="close_modal();">Закрыть окно</button>
    <div class="modalW" id="modalW-1">
<?php 
	if(sizeof($users) == 0){ echo "Ни один пользователь не найден."; }
	
	foreach($users as $user_id)
	{
		$query = "SELECT * FROM [pre]users WHERE `id`='".$user_id."' LIMIT 1";

		$data_stmt = $dbh->prepare($query);
		$data_arr = $data_stmt->execute();
		$data = $data_arr->fetchallAssoc();
		
		$update_query = "UPDATE [pre]users SET `block`=0 WHERE `id`='".$user_id."' LIMIT 1";

		$update_stmt = $dbh->prepare($update_query);
		$update_arr = $update_stmt->execute();
		
		?>
		<p>Пользователь <b><?php echo $data[0]['name']." ".$data[0]['fname'] ?></b> снят с блокировки.</p>
		<?php
	}
?>
	</div>
</body>

<script type="text/javascript" language="javascript">
</script>

</html>