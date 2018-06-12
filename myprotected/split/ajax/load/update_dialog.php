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
<title>Action LOAD BUFFER LAST FILE</title>
</head>

<body>
<?php 
	$id = $_GET['id'];
	$item_id = $_GET['item_id'];
	
	$query = "SELECT * FROM [pre]users_dialogs WHERE `from_id`='".$id."' AND `to_id`='".ADMIN_ID."' AND `status`=0 LIMIT 1";
	
	$_stmt = $dbh->prepare($query);
	$_arr = $_stmt->execute();
	
	$_res = $_arr->fetchallAssoc();
	
	if(sizeof($_res) > 0)
	{
		?>
		<script type="text/javascript" language="javascript">
			$(function(){
					load_app_card(card_path, <?php echo $item_id ?>, card_data);
				});
		</script>
		<?php
	}else
	{
		// echo '<pre>'; print_r($_GET); echo '</pre>';
	}
?>
</body>
</html>