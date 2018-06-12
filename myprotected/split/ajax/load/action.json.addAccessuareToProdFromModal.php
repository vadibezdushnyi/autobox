<?php // ajax json action
	require_once "../../../require.base.php";
	
	require_once "../../library/AjaxHelp.php";
	
	$data = array('status'=>"error",'message'=>"");
	
	$ah = new ajaxHelp($dbh);
	
	$prod_id = $_POST['prod_id'];
	
	$acc_id = $_POST['acc_id'];
	
	$id1 = ADMIN_ID;
	
	$query = "INSERT INTO [pre]shop_prod_access_ref (`prod_id`,`prod_sku`,`acc_id`) VALUES ('$prod_id','0','$acc_id')";
	$ah->rs($query);
	
	$ref_id = mysql_insert_id();
	
	$query = "SELECT M.* , 
				(SELECT file FROM [pre]files_ref WHERE `ref_table`='shop_products' AND `ref_id`='$acc_id' ORDER BY id LIMIT 1) as myphoto
				FROM [pre]shop_products as M 
				WHERE M.id='$acc_id' 
				LIMIT 1";
	$acc_data = $ah->rs($query);	
	
	if($acc_data)
	{
		$acc = $acc_data[0];
		
		$acc_id = $acc['id'];
		$acc_name = $acc['name'];
		$acc_photo = $acc['myphoto'];
		
		$data['status'] = 'success';
		$data['message'] = "
							<tr id='prod_acc_ref_$ref_id'>
								<td>ID: $acc_id</td>
								<td class='img'><a class='theater' href='/split/files/shop/products/$acc_photo' title='Аксессуар: ".str_replace("'","",$acc_name)."'><img alt='NO PHOTO' src='/split/files/shop/products/$acc_photo' /></a></td>
								<td>$acc_name</td>
								<td class='last'> <button class='close-option r-z-h-s-close' type='button' title='Удалить' onclick='delete_prod_acc_ref($ref_id);'></button> </td>
							</tr>
							";
	}else{
		$data['status'] = 'ACC ID NOT FOUND';
		}
	
	
echo json_encode($data);

