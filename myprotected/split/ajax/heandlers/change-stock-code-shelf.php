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
<title>ENTR CODE</title>
</head>

<body>
<?php 
	 //echo '<pre>'; print_r($_POST); echo '</pre>';
	
	$order_id = $_POST['order_id'];
	
	// Вытягиваем информацию по заявке
	
	$query = "SELECT * FROM [pre]stock_orders WHERE `id`= :1 LIMIT 1";
	
		$order_stmt = $dbh->prepare($query);
		$order_arr = $order_stmt->execute($order_id);
		
		$order = $order_arr->fetchallAssoc();
		$order = $order[0];
	
	// Вытягиваем все продукты по заявке
	
	$query = "SELECT * FROM [pre]stock_order_products WHERE `order_id`= :1 LIMIT 1";
	
		$products_stmt = $dbh->prepare($query);
		$products_arr = $products_stmt->execute($order_id);
		
		$products = $products_arr->fetchallAssoc();
	
	// Ловим штрих-код товара из заявки
		
	$code = strip_tags($_POST['code']);
	
	// Вытягиваем те полочки из таблицы связей, которые уже зранаят товары с таким штрих-кодом из других заявок
	
	$query = "SELECT shelf_id FROM [pre]shop_products_shelf_ref WHERE `order_id` != :1 AND `product_code` = :2 ORDER BY id LIMIT 1000";
	
		$code_shelfs_stmt	= $dbh->prepare($query);
		$code_shelfs_arr	= $code_shelfs_stmt->execute($order_id,$code);
		
		$code_shelfs = $code_shelfs_arr->fetchallAssoc();
	
	// Вытягиваем ID ячейки в которую уже положили товар и удаляем товар с этой полки
	
	$query = "SELECT * FROM [pre]shop_products_shelf_ref WHERE `order_id` = :1 AND `product_code` = :2 ORDER BY dateCreate DESC LIMIT 1";
	
		$old_ref_stmt	= $dbh->prepare($query);
		$old_ref_arr	= $old_ref_stmt->execute($order_id,$code);
		
		$old_ref = $old_ref_stmt->fetchallAssoc();
		$old_ref = $old_ref[0];
		
	
	$query = "DELETE FROM [pre]shop_products_shelf_ref WHERE `id` = :1 LIMIT 1";
	
		$del_stmt	= $dbh->prepare($query);
		$del_stmt->execute($old_ref['id']);
	
		$message = "Товар из ячейки ".$old_ref['shelf_id']." удален и перемещен в новую.";
	
		
	$fullness = $_POST['fullness'];
		
	if($fullness == 2)
	{
		$message .= "<br>Ячейка изменила статус на Заполненная";
		
		// Обновляем статус ячейки на предмет полноты

	$query = "UPDATE [pre]stock_fields SET `fullness` = :1 WHERE `id` = :2 LIMIT 1";
	
		$update_stmt = $dbh->prepare($query);
		$update_stmt->execute(2,$old_ref['shelf_id']);
	}
						// Создаем запрос в таблицу связей товаров из заказа и полок на складе для предложения ближайшей полки
						
						$and_not_shelfs = " AND `id` != '".$old_ref['shelf_id']."'";
						
						foreach($code_shelfs as $code_shelf)
						{
							$and_not_shelfs .= " AND `id` != '".$code_ref['shelf_id']."'";
						}
						
						$query = "	SELECT * FROM [pre]stock_fields WHERE 
									`stock_id`	= :1	AND 
									`zona`		= :2	AND 
									`rack`		= :3	AND 
									`fullness`	< 2		AND
									`block`		= 0		AND 
									`shelf`		>= 0 	".$and_not_shelfs."
									ORDER BY section, shelf 
									LIMIT 1";
							
							$preposition_shelf_stmt	= $dbh->prepare($query);
							$preposition_shelf_arr	= $preposition_shelf_stmt->execute($order['stock_id'],$order['zona'],$order['rack']);
							
							$preposition_shelf = $preposition_shelf_arr->fetchallAssoc();
							$ps = $preposition_shelf[0];
							
							// echo '<pre>'; print_r($preposition_shelf); echo '<pre>';
							
							$preposition_shelf = $ps['stock_id'].$ps['zona'].$ps['rack'].$ps['section'].$ps['shelf'];
							
						// Обновляем количество отмеченных едениц по коду
						
						$product['shipped'] = $product['shipped']+1;
						
						$update_query = "UPDATE [pre]stock_order_products SET `shipped` = '".$product['shipped']."' WHERE `id`='".$product_id."' LIMIT 1";
						
						$update_stmt = $dbh->prepare($update_query);
						$update_stmt->execute();
						
						// Присваеваем что данная еденица товара по коду лежит в предложенной ячейке 
						
						$now_time = date("Y-m-d H:i:s",time());
						
						$query = "INSERT INTO [pre]shop_products_shelf_ref 
								(`id`,`order_id`,`product_code`,`shelf_id`,`quant`,`dateCreate`) VALUES
								(NULL,:1,:2,:3,:4,:5)";
								
							$ref_stmt	= $dbh->prepare($query);
							$ref_arr	= $ref_stmt->execute($order_id,$code,$ps['id'],1,$now_time);
						?>
                        <script type="text/javascript" language="javascript">
							$('#cur_shelf_id').html('<?php echo $preposition_shelf ?>');
                        </script>
						<?php
						
	echo $message;
?>
</body>

</html>