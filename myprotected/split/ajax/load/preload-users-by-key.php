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
<title>PRELOAD USERS BY KEY</title>
</head>

<?php
	$key = trim($_POST['key']);
	
	$keys = split(" ",$key);
	
	$name = trim($keys[0]);
	
	$fname = "";
	
	if($keys[sizeof($keys)-1] != null && sizeof($keys) > 1)
	{
		$fname = trim($keys[sizeof($keys)-1]);
	}
	
	$f_sql = "";
	
	if($fname != "")
	{
		$f_sql = " AND `fname` LIKE '%".$fname."%'";
	}
	
	$query = "SELECT id,name,fname FROM [pre]users WHERE `name` LIKE '%".$name."%' ".$f_sql." ORDER BY id LIMIT 100";
			
		$_stmt = $dbh->prepare($query);
		$_arr = $_stmt->execute();
	
	$_res = $_arr->fetchallAssoc();
?>

<body>          	
<?php
	//echo '<pre>'; print_r($keys); echo '</pre>';
	//echo $query;
	foreach($_res as $item)
	{
	?>
    	<div class="key_item" title="Выбрать <?php echo $item['name']." ".$item['fname'] ?>" 
        onclick="set_key_choice('<?php echo $item['name']." ".$item['fname'] ?>',<?php echo $item['id'] ?>);"><?php echo $item['name']." ".$item['fname'] ?></div>
    <?php
	}
	?>
</body>
</html>