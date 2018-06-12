<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = 1;
	$lpx = $_POST['lpx'];
	$lang_prefix = ($lpx ? $lpx."_" : ""); 
	
	$cardUpd = [];

	if(isset($_POST['indexing'])) $cardUpd['indexing'] = (int)$_POST['indexing'][0];
	if(isset($_POST['alt'])) $cardUpd['alt'] = $_POST['alt'];
	if(isset($_POST['title'])) $cardUpd['title'] = $_POST['title'];
	
	if(isset($_POST['meta_title'])) $cardUpd[$lang_prefix.'meta_title'] = $_POST['meta_title'];
	if(isset($_POST['meta_keys'])) $cardUpd[$lang_prefix.'meta_keys'] = $_POST['meta_keys'];
	if(isset($_POST['meta_desc'])) $cardUpd[$lang_prefix.'meta_desc'] = $_POST['meta_desc'];
	
	if(isset($_POST['text_1'])) $cardUpd[$lang_prefix.'text_1'] = $_POST['text_1'];
	if(isset($_POST['text_2'])) $cardUpd[$lang_prefix.'text_2'] = $_POST['text_2'];
	if(isset($_POST['text_3'])) $cardUpd[$lang_prefix.'text_3'] = $_POST['text_3'];
	if(isset($_POST['text_4'])) $cardUpd[$lang_prefix.'text_4'] = $_POST['text_4'];
	if(isset($_POST['text_5'])) $cardUpd[$lang_prefix.'text_5'] = $_POST['text_5'];
	if(isset($_POST['text_6'])) $cardUpd[$lang_prefix.'text_6'] = $_POST['text_6'];
	if(isset($_POST['text_7'])) $cardUpd[$lang_prefix.'text_7'] = $_POST['text_7'];
	if(isset($_POST['text_8'])) $cardUpd[$lang_prefix.'text_8'] = $_POST['text_8'];
	if(isset($_POST['text_9'])) $cardUpd[$lang_prefix.'text_9'] = $_POST['text_9'];
	if(isset($_POST['text_10'])) $cardUpd[$lang_prefix.'text_10']= $_POST['text_10'];
	if(isset($_POST['text_11'])) $cardUpd[$lang_prefix.'text_11']= $_POST['text_11'];
	if(isset($_POST['text_12'])) $cardUpd[$lang_prefix.'text_12']= $_POST['text_12'];
	if(isset($_POST['text_13'])) $cardUpd[$lang_prefix.'text_13']= $_POST['text_13'];
	if(isset($_POST['text_14'])) $cardUpd[$lang_prefix.'text_14']= $_POST['text_14'];
	if(isset($_POST['text_15'])) $cardUpd[$lang_prefix.'text_15']= $_POST['text_15'];
	if(isset($_POST['text_16'])) $cardUpd[$lang_prefix.'text_16']= $_POST['text_16'];
	if(isset($_POST['text_17'])) $cardUpd[$lang_prefix.'text_17']= $_POST['text_17'];
	if(isset($_POST['text_18'])) $cardUpd[$lang_prefix.'text_18']= $_POST['text_18'];
	if(isset($_POST['text_19'])) $cardUpd[$lang_prefix.'text_19']= $_POST['text_19'];
	if(isset($_POST['text_20'])) $cardUpd[$lang_prefix.'text_20']= $_POST['text_20'];
	if(isset($_POST['text_21'])) $cardUpd[$lang_prefix.'text_21']= $_POST['text_21'];
	if(isset($_POST['text_22'])) $cardUpd[$lang_prefix.'text_22']= $_POST['text_22'];
	if(isset($_POST['text_23'])) $cardUpd[$lang_prefix.'text_23']= $_POST['text_23'];
	if(isset($_POST['text_24'])) $cardUpd[$lang_prefix.'text_24']= $_POST['text_24'];
	if(isset($_POST['text_25'])) $cardUpd[$lang_prefix.'text_25']= $_POST['text_25'];
	if(isset($_POST['text_26'])) $cardUpd[$lang_prefix.'text_26']= $_POST['text_26'];
	if(isset($_POST['text_27'])) $cardUpd[$lang_prefix.'text_27']= $_POST['text_27'];
	if(isset($_POST['text_28'])) $cardUpd[$lang_prefix.'text_28']= $_POST['text_28'];
	if(isset($_POST['text_29'])) $cardUpd[$lang_prefix.'text_29']= $_POST['text_29'];
	if(isset($_POST['text_30'])) $cardUpd[$lang_prefix.'text_30']= $_POST['text_30'];
	if(isset($_POST['text_31'])) $cardUpd[$lang_prefix.'text_31']= $_POST['text_31'];
	if(isset($_POST['text_32'])) $cardUpd[$lang_prefix.'text_32']= $_POST['text_32'];
	if(isset($_POST['text_33'])) $cardUpd[$lang_prefix.'text_33']= $_POST['text_33'];
	if(isset($_POST['text_34'])) $cardUpd[$lang_prefix.'text_34']= $_POST['text_34'];
	if(isset($_POST['text_35'])) $cardUpd[$lang_prefix.'text_35']= $_POST['text_35'];
	if(isset($_POST['text_36'])) $cardUpd[$lang_prefix.'text_36']= $_POST['text_36'];
	if(isset($_POST['text_37'])) $cardUpd[$lang_prefix.'text_37']= $_POST['text_37'];
	if(isset($_POST['text_38'])) $cardUpd[$lang_prefix.'text_38']= $_POST['text_38'];
	if(isset($_POST['text_39'])) $cardUpd[$lang_prefix.'text_39']= $_POST['text_39'];
	if(isset($_POST['text_40'])) $cardUpd[$lang_prefix.'text_40']= $_POST['text_40'];
	if(isset($_POST['text_41'])) $cardUpd[$lang_prefix.'text_41']= $_POST['text_41'];
	if(isset($_POST['text_42'])) $cardUpd[$lang_prefix.'text_42']= $_POST['text_42'];
	if(isset($_POST['text_43'])) $cardUpd[$lang_prefix.'text_43']= $_POST['text_43'];
	if(isset($_POST['text_44'])) $cardUpd[$lang_prefix.'text_44']= $_POST['text_44'];
	if(isset($_POST['text_45'])) $cardUpd[$lang_prefix.'text_45']= $_POST['text_45'];
	if(isset($_POST['text_46'])) $cardUpd[$lang_prefix.'text_46']= $_POST['text_46'];
	if(isset($_POST['text_47'])) $cardUpd[$lang_prefix.'text_47']= $_POST['text_47'];
	if(isset($_POST['text_48'])) $cardUpd[$lang_prefix.'text_48']= $_POST['text_48'];
	if(isset($_POST['text_49'])) $cardUpd[$lang_prefix.'text_49']= $_POST['text_49'];
	if(isset($_POST['text_50'])) $cardUpd[$lang_prefix.'text_50']= $_POST['text_50'];
	if(isset($_POST['text_51'])) $cardUpd[$lang_prefix.'text_51']= $_POST['text_51'];
	if(isset($_POST['text_52'])) $cardUpd[$lang_prefix.'text_52']= $_POST['text_52'];
	if(isset($_POST['text_53'])) $cardUpd[$lang_prefix.'text_53']= $_POST['text_53'];
	if(isset($_POST['text_54'])) $cardUpd[$lang_prefix.'text_54']= $_POST['text_54'];
	if(isset($_POST['text_55'])) $cardUpd[$lang_prefix.'text_55']= $_POST['text_55'];
	if(isset($_POST['text_56'])) $cardUpd[$lang_prefix.'text_56']= $_POST['text_56'];
	if(isset($_POST['text_57'])) $cardUpd[$lang_prefix.'text_57']= $_POST['text_57'];
	if(isset($_POST['text_58'])) $cardUpd[$lang_prefix.'text_58']= $_POST['text_58'];
	if(isset($_POST['text_59'])) $cardUpd[$lang_prefix.'text_59']= $_POST['text_59'];
	if(isset($_POST['text_60'])) $cardUpd[$lang_prefix.'text_60']= $_POST['text_60'];
	
	// File upload filename

	$filename = "file";
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = '../../../../public/img/content/';
		$file_update = $ah->mtvc_add_files_file(array(
			'path'			=>$file_path,
			'name'			=>5,
			'pre'			=>"pg_",
			'size'			=>10,
			'rule'			=>0,
			'max_w'			=>2500,
			'max_h'			=>2500,
			'files'			=>$filename,
			'resize_path'	=>0,
			'resize_w'		=>0,
			'resize_h'		=>0
	  	));
		if($file_update) {
			$cardUpd[$filename] = $file_update;
			if(file_exists($file_path.$old_file)) {
				unlink($file_path.$old_file);
			}			
		}
	}				
	
	// Update main table
	
	$query = "UPDATE `$appTable` SET ";
	
	$cntUpd = 0;
	foreach($cardUpd as $field => $itemUpd) {
		$cntUpd++;
		$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
	}
	
	$query .= " WHERE `id`=$item_id LIMIT 1";
			
	$ah->rs($query,0,1);
	
	$data['q'] = $query;
	$data['message'] = "Page settings saved.";
	