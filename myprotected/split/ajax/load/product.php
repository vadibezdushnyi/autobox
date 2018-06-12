<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	//require_once "../../../require.base.php";
	$db_connect = mysql_connect("localhost","zencosmusr","kTpcgY5q");
			mysql_select_db("zencosmet",$db_connect);
			mysql_set_charset("utf8",$db_connect);
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tables MENU</title>
</head>

<?php
	$code = $_GET['code'];
	
	$query = "SELECT * FROM next_shop_products WHERE `code`='".$code."' LIMIT 1";
	$res = mysql_query($query);
	$data = mysql_fetch_assoc($res);
	
			$query = "SELECT * FROM next_shop_cat_prod_ref WHERE `prod_id`='".$data['id']."' ORDER BY id LIMIT 1";
			$res1 = mysql_query($query);
			$ref = mysql_fetch_assoc($res1);
			
			$query = "SELECT * FROM next_shop_catalog WHERE `id`='".$ref['cat_id']."' ORDER BY id LIMIT 1";
			$res2 = mysql_query($query);
			$cat = mysql_fetch_assoc($res2);
	
			//$data_stmt = $dbh->prepare($query);
			//$data_arr = $data_stmt->execute();
			//$data = $data_stmt->fetchallAssoc();
	
	
	$message = "";
	if($data == null){ $message = "Искомый товар не найден."; }
?>

<body>
<?php // echo '<pre>'; print_r($data); echo '</pre>';  ?>
		<input type="hidden" id="code-name" value="<?php echo $data['name'] ?>">
        <input type="hidden" id="code-cat" value="<?php echo $cat['name'] ?>">
        <input type="hidden" id="code-dost" value="<?php echo $data['quant'] ?>">
        <input type="hidden" id="code-sum" value="<?php echo $data['price'] ?>">
        <input type="hidden" id="code-id" value="<?php echo $data['id'] ?>">
        <input type="hidden" id="code-message" value="<?php echo $message ?>">
<?php // ?>
</body>

<script type="text/javascript" language="javascript">
</script>

</html>