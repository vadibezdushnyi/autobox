<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$item_id = 0;
	
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
					 'Phone number'			=>	array( 'type'=>'input', 	'field'=>'phone', 			'params'=>array( 'size'=>25, 'hold'=>'' ) ),
					 'Birth date'			=>	array( 'type'=>'date', 		'field'=>'birthday', 		'params'=>array( ) ),
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 'Password'				=>	array( 'type'=>'input', 	'field'=>'new-password', 		'params'=>array( 'size'=>25, 'hold'=>'', 'type'=>'password' ) ),
					 'Users group'			=>	array( 'type'=>'select', 	'field'=>'type', 			'params'=>array( 'list'=>$usersTypes, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>9, 
																														 'onChange'=>"" 
																														 ) ),
					 
					 'Publish'		=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 'Activity'		=>	array( 'type'=>'block', 	'field'=>'active', 			'params'=>array( 'reverse'=>false ) ),
					 'Gender'				=>	array( 'type'=>'block', 	'field'=>'male', 			'params'=>array( 'reverse'=>true, 'yes'=>"Ma", 'no'=>"Fe", 'replace'=>array('0'=>'M', '1'=>'F') ) ),
					 'Extra`s'			=>	array( 'type'=>'usersExtraFields',	'field'=>'ef_groups'),
					 'Images'			=>	array( 'type'=>'header'),
					 'Avatar'	=>	array( 'type'=>'image_mono','field'=>'avatar', 	'params'=>array( 'path'=>"/split/files/users/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createUserCard", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>NEW USER ".((isset($params['copyItem']) && $params['copyItem'] > 0) ? "(USER COPY #".$params['copyItem'].")" : "")."</h3>";
	$data['bodyContent'] .= $cardEditFormStr;
	$data['bodyContent'] .=	"
		</div>
	";

?>