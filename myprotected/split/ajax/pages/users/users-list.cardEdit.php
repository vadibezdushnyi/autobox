<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getUserInfo($item_id);
	
	$usersTypes = $zh->getUsersTypes();
	
	$efGroups = $zh->getExtraFieldsGroups();

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Nickname'				=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>25, 'hold'=>'' ) ),
					 'First name'			=>	array( 'type'=>'input', 	'field'=>'fame', 			'params'=>array( 'size'=>25, 'hold'=>'' ) ),
					 'Last name'			=>	array( 'type'=>'input', 	'field'=>'lname', 			'params'=>array( 'size'=>25, 'hold'=>'' ) ),
					 'Email'				=>	array( 'type'=>'input', 	'field'=>'email', 			'params'=>array( 'size'=>25, 'hold'=>'' ) ),
					 'Login'				=>	array( 'type'=>'input', 	'field'=>'login', 			'params'=>array( 'size'=>25, 'hold'=>'' ) ),
					 'Phone number'				=>	array( 'type'=>'input', 	'field'=>'phone', 			'params'=>array( 'size'=>25, 'hold'=>'' ) ),
					 'Birth date'		=>	array( 'type'=>'date', 		'field'=>'birthday', 		'params'=>array( ) ),
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 'Users group'	=>	array( 'type'=>'select', 	'field'=>'type', 			'params'=>array( 'list'=>$usersTypes, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['type'], 
																														 'onChange'=>"" 
																														 ) ),
					 'Publish'						=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 'Activity'						=>	array( 'type'=>'block', 	'field'=>'active', 			'params'=>array( 'reverse'=>false ) ),
					 'Gender'						=>	array( 'type'=>'block', 	'field'=>'male', 			'params'=>array( 'reverse'=>true, 'yes'=>"Ma", 'no'=>"Fe", 'replace'=>array('0'=>'M', '1'=>'F') ) ),
					 'Номер карты'					=>	array( 'type'=>'hidden', 	'field'=>'sale_card_id', 	'params'=>array( 'size'=>25, 'hold'=>'Discount card number', 'disabled'=>true ) ),
					 'Штрихкод'						=>	array( 'type'=>'hidden', 	'field'=>'sale_barcode', 	'params'=>array( 'size'=>25, 'hold'=>'Barcode', 'disabled'=>true ) ),
					 'Размер скидки (%)'			=>	array( 'type'=>'hidden', 	'field'=>'sale_percent', 	'params'=>array( 'size'=>25, 'uid'=>$item_id, 'hold'=>'Sale' ) ),
					 'Экстра поля'					=>	array( 'type'=>'hidden',	'field'=>'ef_groups'),
					 'Images'						=>	array( 'type'=>'header'),
					 'Avatar'						=>	array( 'type'=>'image_mono','field'=>'avatar', 	'params'=>array( 'path'=>"/split/files/users/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 'Password reset'				=>	array( 'type'=>'header'),
					 'Current password'				=>	array( 'type'=>'input', 	'field'=>'old-pass', 			'params'=>array( 'size'=>25, 'hold'=>'Current password', 'type'=>'password' ) ),
					 'New password'					=>	array( 'type'=>'input', 	'field'=>'new-pass', 			'params'=>array( 'size'=>25, 'hold'=>'New password', 'type'=>'password' ) ),
					 'New password confirmation'	=>	array( 'type'=>'input', 	'field'=>'new-pass-r', 			'params'=>array( 'size'=>25, 'hold'=>'Repeat new password', 'type'=>'password' ) ),
					 'clear-2'						=>	array( 'type'=>'clear' )
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editUserCard", 'ajaxFolder'=>'edit', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>USER #$item_id EDIT</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>