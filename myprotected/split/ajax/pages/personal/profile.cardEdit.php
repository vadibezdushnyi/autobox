<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'profile' );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getUserInfo($item_id);
	
	$usersTypes = $zh->getUsersTypes();
	
	$efGroups = $zh->getExtraFieldsGroups();

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'First name'					=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>25, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
					 'Last name'					=>	array( 'type'=>'input', 	'field'=>'fname', 			'params'=>array( 'size'=>25, 'hold'=>'Alias' ) ),
					 'Account'						=>	array( 'type'=>'input', 	'field'=>'login', 			'params'=>array( 'size'=>25, 'hold'=>'Alias' ) ),
					 'Phone number'					=>	array( 'type'=>'input', 	'field'=>'phone', 			'params'=>array( 'size'=>25, 'hold'=>'Alias' ) ),
					 'Birth date'					=>	array( 'type'=>'date', 		'field'=>'birthday', 		'params'=>array( ) ),
					 'clear-1'						=>	array( 'type'=>'clear' ),
					 'Users group'					=>	array( 'type'=>'hidden', 	'field'=>'type' ),
					 
					 /*
					 'Група пользователей'	=>	array( 'type'=>'select', 	'field'=>'type', 			'params'=>array( 'list'=>$usersTypes, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['type'], 
																														 'onChange'=>"reload_users_extra_fields($(this).val(),$item_id);" 
																														 ) ),
					 */

					 'Block'				=>	array( 'type'=>'hidden', 	'field'=>'block' ), // 'params'=>array( 'reverse'=>true )
					 'Activity'				=>	array( 'type'=>'hidden', 	'field'=>'active' ), // 'params'=>array( 'reverse'=>false )
					 'Gender'				=>	array( 'type'=>'block', 	'field'=>'male', 			'params'=>array( 'reverse'=>true, 'yes'=>"Ma", 'no'=>"Fe", 'replace'=>array('0'=>'M', '1'=>'F') ) ),
					 'Extra`s'				=>	array( 'type'=>'usersExtraFields',	'field'=>'ef_groups'),
					 'Images'				=>	array( 'type'=>'header'),
					 'Avatar'				=>	array( 'type'=>'image_mono','field'=>'avatar', 	'params'=>array( 'path'=>"/split/files/users/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 'Password reset'		=>	array( 'type'=>'header'),
					 'Current passsword'	=>	array( 'type'=>'input', 	'field'=>'old-pass', 			'params'=>array( 'size'=>25, 'hold'=>'Current password', 'type'=>'password' ) ),
					 'New password'			=>	array( 'type'=>'input', 	'field'=>'new-pass', 			'params'=>array( 'size'=>25, 'hold'=>'New password', 'type'=>'password' ) ),
					 'New password confirmation'=>	array( 'type'=>'input', 	'field'=>'new-pass-r', 		'params'=>array( 'size'=>25, 'hold'=>'Repeat new password', 'type'=>'password' ) ),
					 'clear-2'				=>	array( 'type'=>'clear' )
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editUserCard", 'ajaxFolder'=>'edit', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>PROFILE SETTINGS</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>