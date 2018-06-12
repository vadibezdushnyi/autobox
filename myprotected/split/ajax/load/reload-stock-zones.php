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
	
	$stocks_query = "SELECT DISTINCT zona FROM [pre]stock_fields WHERE `stock_id`= :1 AND `zona` != :2 ORDER BY id LIMIT 1000";
			
		$stocks_stmt = $dbh->prepare($stocks_query);
		$stocks_arr = $stocks_stmt->execute($stock_id,-1);
		$stocks = $stocks_stmt->fetchallAssoc();
?>

<body>          	
					<select class="sampling_changed" id="create-zona" name="zona" onchange="show_actual_racks($(this).val());">
						<option value="0" selected="selected" data-skip="1">Укажите зону</option>
                    <?php
                    foreach($stocks as $stock)
					{
						?><option value="<?php echo $stock['zona'] ?>"><?php echo $stock['zona'] ?></option><?php
					}
					?>
					</select>
</body>
<script type="text/javascript">
</script>
</html>