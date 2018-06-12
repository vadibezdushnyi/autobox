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
<title>Action CREATE SHOP PRODUCT</title>
</head>

<body>
<?php 
	echo '<pre>'; print_r($_POST); echo '</pre>'; // die("STOP");
	
	$query = "SELECT  * FROM [pre]admin_tmp WHERE `admin_id`='".ADMIN_ID."' ORDER BY id DESC";

		$result_stmt = $dbh->prepare($query);
		$result_arr = $result_stmt->execute();
		$result = $result_arr->fetchallAssoc();
		
		if($result[0] != null)
		{
			$tmp = $result[0]['tmp'];
		}else
		{
			$tmp = 0;
		}
		
	$id = (int)$_POST['id'];
		
	$name		= trim(strip_tags($_POST['name']));
	$sku		= trim(strip_tags($_POST['sku']));
	$code		= trim(strip_tags($_POST['code']));
	$alias		= trim(strip_tags($_POST['alias']));
	$block		= strip_tags($_POST['block'][0]);
	$index		= strip_tags($_POST['index'][0]);
	$price 		= trim(strip_tags($_POST['price']));
	$quant 		= trim(strip_tags($_POST['quant']));
	$details	= trim(strip_tags($_POST['details']));
	$date_start	= trim(strip_tags($_POST['date_start']));
	$date_finish = trim(strip_tags($_POST['date_finish']));
	
	$title	= trim(strip_tags($_POST['title']));
	$desc	= trim(strip_tags($_POST['desc']));
	$keys	= trim(strip_tags($_POST['keys']));
	// shop_products
	
	
	
									$date_start = date("Y-m-d H:i:s",strtotime($date_start));
									$date_finish = date("Y-m-d H:i:s",strtotime($date_finish));
								
									$mysql_date = date("Y-m-d H:i:s",time());
							
									$query = "UPDATE  [pre]shop_products SET
									`quant`		='".$quant."' ,
									`name`		='".$name."' ,
									`alias`		='".$alias."' ,
									`sku`		='".$sku."' ,
									`code`		='".$code."' ,
									`price`		='".$price."',
									`block`		='".$block."',
									`index`		='".$index."',
									`title`		='".$title."',
									`keys`		='".$keys."',
									`desc`		='".$desc."',
									`details`		='".$details."',
									`date_start`	='".$date_start."',
									`date_finish`	='".$date_finish."',
									`dateModify`	='".$mysql_date."',
									`adminMod`	='".ADMIN_ID."'
									
									WHERE `id`=".$id." LIMIT 1
									;";

									$_stmt = $dbh->prepare($query);
									$_stmt->execute();
									
									//echo $query;
									
									echo "<p>Товар успешно редактирован.</p>";
									
	
	$chars = $_POST['char'];
	
	foreach($chars as $i => $val)
	{
		$query = "SELECT id FROM [pre]shop_chars_prod_ref WHERE `char_id`='".$i."' AND `prod_id`='".$id."' LIMIT 1";
		
		$_stmt = $dbh->prepare($query);
		$_res = $_stmt->execute();
		
		$_arr = $_res->fetchallAssoc();
		if($_arr)
		{
			
			$query = "UPDATE [pre]shop_chars_prod_ref SET `char_id`='".$i."', `prod_id`='".$id."', `value`='".$val."' WHERE `id`='".$_arr[0]['id']."' LIMIT 1";
		
			$_stmt = $dbh->prepare($query);
			$_stmt->execute();
		}else
		{
			$query = "INSERT INTO [pre]shop_chars_prod_ref (`char_id`,`prod_id`,`value`) VALUES ('".$i."','".$id."','".$val."')";
		
			$_stmt = $dbh->prepare($query);
			$_stmt->execute();
		}
	}
	
	$groups = $_POST['groups'];
	
	if($groups)
	{
		$where = " WHERE `prod_id`=".$id." ";
		foreach($groups as $g)
		{
			$where .= " AND `group_id` != ".$g;
			$query = "INSERT IGNORE INTO [pre]shop_prod_group_ref (`prod_id`,`group_id`) VALUES ($id,$g)";
			
			echo $query."<br>";
			
			$_stmt = $dbh->prepare($query);
			$_stmt->execute();	
		}
		$query = "DELETE FROM [pre]shop_prod_group_ref ".$where." LIMIT 10";
		echo $query."<br>";
		$_stmt = $dbh->prepare($query);
		$_stmt->execute();
	}else
	{
		$query = "DELETE FROM [pre]shop_prod_group_ref WHERE `prod_id`='".$id."' LIMIT 100";
		
		$_stmt = $dbh->prepare($query);
		$_stmt->execute();
	}
	
	echo "<p>Message: ".$message."</p>";
	
	$status_query = "INSERT INTO [pre]admin_tmp (`admin_id`,`tmp`) VALUES ('".ADMIN_ID."','".$message."')";

		$status_stmt = $dbh->prepare($status_query);
		$status_stmt->execute();
		
		/*
		INSERT INTO `next_shop_prod_group_ref` (prod_id, group_id)
SELECT 'prod_id', 'group_id' FROM DUAL 
WHERE NOT EXISTS (SELECT * FROM `next_shop_prod_group_ref` 
      WHERE prod_id='1' AND group_id='2') 
LIMIT 1 

step 1. CREATE UNIQUE INDEX id ON `next_shop_prod_group_ref` (`prod_id`,`group_id`);

step 2. INSERT IGNORE INTO `next_shop_prod_group_ref` (`prod_id`,`group_id`) VALUES (1,3)
		*/
?>
</body>
<script>
</script>
</html>