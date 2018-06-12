<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
	
	require_once "../../../../split/library/wp_lib.php";
	$wp = new wp_Lib($db_pref);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Action CREATE ITEM STOCK ORDER</title>
</head>

<body>
<?php 
	$supplier		= trim(strip_tags($_POST['supplier']));
	$user_id		= trim(strip_tags($_POST['user_id']));
	
	$stock_id		= trim(strip_tags($_POST['stock_id']));
	$zona			= trim(strip_tags($_POST['zona']));
	$rack			= trim(strip_tags($_POST['rack']));
	
	$filename = $wp->wp_add_files_file(array(
				'path'			=>"../../../../split/files/orders/",
				'name'			=>1,
				'pre'			=>"order_",
				'size'			=>100,
				'rule'			=>0,
				'max_w'			=>25000,
				'max_h'			=>25000,
				'files'			=>"file",
				'resize_path'	=>"0",
				'resize_w'		=>0,
				'resize_h'		=>0,
				'resize_path_2'	=>"0",
				'resize_w_2'	=>0,
				'resize_h_2'	=>0
			  ));
	
	$message = 1; // По умолчанию ошибок нет и форма может быть принята и данные запишутся в таблицу stocks
	
	if($filename)
	{	
					$mysql_date = date("Y-m-d H:i:s",time());
							
									$insert_query = "INSERT INTO  [pre]stock_orders (
									`id` ,
									`stock_id` ,
									`zona` ,
									`rack` ,
									`supplier`,
									`code` ,
									`status` ,
									`file`,
									`user_id` ,
									`dateCreate` ,
									`dateModify` ,
									`adminMod` ,
									`ip_add`
									)
									VALUES (
									NULL ,  
									'".$stock_id."',
									'".$zona."',
									'".$rack."',
									'".$supplier."',
									'0',  
									'0',    
									'".$filename."',     
									'".$user_id."',  
									'".$mysql_date."',
									'".$mysql_date."',
									'".ADMIN_ID."',  
									'".$_SERVER['REMOTE_ADDR']."'
									);";

									$insert_stmt = $dbh->prepare($insert_query);
									$insert_stmt->execute();
									
									$order_id = mysql_insert_id();
									
		error_reporting(E_ALL ^ E_NOTICE);
		require_once '../../excel_reader/excel_reader2.php';
		$data = new Spreadsheet_Excel_Reader("../../../../split/files/orders/".$filename);
		
		$sheets = $data->sheets;
		
		echo '<pre>'; print_r($sheets); echo '</pre>';
		
		$sheet_cnt = 0;
		foreach($sheets[0]['cells'] as $sheet)
	    {
			$sheet_cnt++;
			
			if( trim($sheet[1]) == "" || $sheet[1] == null ) break;
			//if($sheet_cnt > 200) break;
			//if($sheet_cnt == 1) continue;    
				$insert_query = "INSERT INTO  [pre]stock_order_products (
									`id` ,
									`order_id`,
									`name` ,
									`sku` ,
									`code`,
									`status` ,
									`category` ,
									`quant` ,
									`price`
									)
									VALUES (
									NULL ,  
									'".$order_id."',
									'".$sheet[1]."',  
									'".$sheet[2]."',    
									'".$sheet[3]."',     
									'0',  
									'".$sheet[4]."',
									'".$sheet[5]."',
									'0'
									);";

									$insert_stmt = $dbh->prepare($insert_query);
									$insert_stmt->execute();
									
									$item_id = mysql_insert_id();
		}
	}else{
		$message = "Не удалось загрузить документ.";
		}
	echo "<p>Message: ".$message."</p>";
	
	$status_query = "INSERT INTO [pre]admin_tmp (`admin_id`,`tmp`) VALUES ('".ADMIN_ID."','".$message."')";

		$status_stmt = $dbh->prepare($status_query);
		$status_stmt->execute();
?>
</body>
</html>