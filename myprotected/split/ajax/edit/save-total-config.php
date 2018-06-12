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
<title>Action SAVE TOTAL CONFIG</title>
</head>

<body>
<?php 
	echo '<pre>'; print_r($_POST); echo '</pre>';

	$id		= trim(strip_tags($_POST['id']));
	
	$sitename	= trim(strip_tags($_POST['sitename']));
	$active		= trim(strip_tags($_POST['active'][0]));
	$editor		= trim(strip_tags($_POST['editor'][0]));
	$index		= trim(strip_tags($_POST['index'][0]));
	
	$title		= trim(strip_tags($_POST['title']));
	$keys		= trim(strip_tags($_POST['keys']));
	$desc		= trim(strip_tags($_POST['desc']));
	
	$data_query = "SELECT * FROM [pre]stock_orders WHERE `id` = :1 LIMIT 1";
	
		$data_stmt = $dbh->prepare($data_query);
		$data_arr = $data_stmt->execute($id);
		$data = $data_arr->fetchallAssoc();
		
	$data = $data[0];
	
	$message = 1; // По умолчанию ошибок нет и форма может быть принята и данные запишутся в таблицу stocks
	
	$mysql_date = date("Y-m-d H:i:s",time());
							
									$query = "UPDATE [pre]total_config SET
									`sitename` 		= '".$sitename."' ,
									`active` 		= '".$active."' ,
									`editor` 		= '".$editor."' ,
									`index` 		= '".$index."',
									`meta_title` 	= '".$title."' ,
									`meta_keys` 	= '".$keys."' ,
									`meta_desc` 	= '".$desc."' ,
									`dateModify` 	= '".$mysql_date."' ,
									`adminMod` 		= '".ADMIN_ID."' 
									WHERE `id` 		= '".$id."' LIMIT 1
									";

									$update_stmt = $dbh->prepare($query);
									//echo $dbh->query;
									$update_stmt->execute();
	
	if(isset($_FILES['file']) && $_FILES['file']['size'] > 0)
	{
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
		if($filename)
		{
			$query = "UPDATE [pre]stock_orders SET
									`file` 		= :1
									WHERE `id` = :5 LIMIT 1
									";

									$update_stmt = $dbh->prepare($query);
									$update_stmt->execute($supplier,$status,$user_id,$mysql_date,$id);
			
			$delete_products_query = "DELETE FROM [pre]stock_order_products WHERE `order_id`='".$id."' LIMIT 1000";

				$delete_products_stmt = $dbh->prepare($delete_products_query);
				$delete_products_stmt->execute();
				
			
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
									'".$id."',
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
		} // end foreach
			
		}else
			{
				$message = "Не удалось загрузить документ.";
			}
	}
	
		
	echo "<p>Message: ".$message."</p>";
	
	$status_query = "INSERT INTO [pre]admin_tmp (`admin_id`,`tmp`) VALUES ('".ADMIN_ID."','".$message."')";

		$status_stmt = $dbh->prepare($status_query);
		$status_stmt->execute();
?>
</body>
</html>