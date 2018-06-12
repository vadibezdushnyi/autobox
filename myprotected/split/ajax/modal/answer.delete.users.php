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
<title>Answer DELETE USERS</title>
</head>

<?php
	$users = $_POST['users'];
?>

<body>
<?php 
	if(sizeof($users) == 0){ echo "Ни один пользователь не найден."; }
	
	foreach($users as $user_id)
	{
		$query = "SELECT * FROM [pre]users WHERE `id`='".$user_id."' LIMIT 1";

			$data_stmt = $dbh->prepare($query);
			$data_arr = $data_stmt->execute();
			$data = $data_arr->fetchallAssoc();
		
		$delete_query = "DELETE FROM [pre]users WHERE `id`='".$user_id."' LIMIT 1";

			$delete_stmt = $dbh->prepare($delete_query);
			$delete_arr = $delete_stmt->execute();
			
		$ef_query = "DELETE FROM [pre]user_ef_ref WHERE `user_id`='".$user_id."' LIMIT 1000";

			$ef_stmt = $dbh->prepare($ef_query);
			$ef_arr = $ef_stmt->execute();
		
		
		?>
		<p>Пользователь <b><?php echo $data[0]['name']." ".$data[0]['fname'] ?></b> успешно удален из системы.</p>
		<?php
	}
?>
</body>

<script type="text/javascript" language="javascript">
</script>

</html>