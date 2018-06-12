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
<title>RELOAD STOCK SONEZ - LOAD IN HTML</title>
</head>

<?php
	$stock_id = (int)$_POST['stock_id'];
	$zone_id = $_POST['zone_id'];
	$rack_id = (int)$_POST['rack_id'];
	
	$stocks_query = "SELECT section FROM [pre]stock_fields WHERE `stock_id`= :1 AND `zona`= :2 AND `rack`= :3 AND `section` != :4 ORDER BY id LIMIT 1000";
			
		$stocks_stmt = $dbh->prepare($stocks_query);
		$stocks_arr = $stocks_stmt->execute($stock_id,$zone_id,$rack_id,-1);
		$stocks = $stocks_stmt->fetchallAssoc();
?>

<body>          	
					<select class="sampling_changed" id="create-section" name="section">
						<option value="0" selected="selected" data-skip="1">Укажите секцию</option>
                    <?php
                    foreach($stocks as $stock)
					{
						?><option value="<?php echo $stock['section'] ?>"><?php echo $stock['section'] ?></option><?php
					}
					?>
					</select>
</body>
</html>