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
					 'Имя'					=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>25, 'hold'=>'Имя', 'onchange'=>"change_alias();" ) ),
					 
					 'Фамилия'				=>	array( 'type'=>'input', 	'field'=>'fname', 			'params'=>array( 'size'=>25, 'hold'=>'Фамилия' ) ),
					 
					 'E-mail'				=>	array( 'type'=>'input', 	'field'=>'login', 			'params'=>array( 'size'=>25, 'hold'=>'E-mail' ) ),
					 
					 'Телефон'				=>	array( 'type'=>'input', 	'field'=>'phone', 			'params'=>array( 'size'=>25, 'hold'=>'Телефон' ) ),
					 
					 'День Рождения'		=>	array( 'type'=>'date', 		'field'=>'birthday', 		'params'=>array( ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Пароль'				=>	array( 'type'=>'input', 	'field'=>'new-password', 		'params'=>array( 'size'=>25, 'hold'=>'Новый пароль', 'type'=>'password' ) ),
					 
					 'Группа пользователей'	=>	array( 'type'=>'select', 	'field'=>'type', 			'params'=>array( 'list'=>$usersTypes, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>9, 
																														 'onChange'=>"" 
																														 ) ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'Активность'			=>	array( 'type'=>'block', 	'field'=>'active', 			'params'=>array( 'reverse'=>false ) ),
					 
					 'Пол'					=>	array( 'type'=>'block', 	'field'=>'male', 			'params'=>array( 'reverse'=>true, 'yes'=>"М", 'no'=>"Ж", 'replace'=>array('0'=>'М', '1'=>'Ж') ) ),
					 
					 
					 'Экстра поля'			=>	array( 'type'=>'usersExtraFields',	'field'=>'ef_groups'),
					 
					 
					 'Изображения'			=>	array( 'type'=>'header'),
					 
					 'Аватар пользователя'	=>	array( 'type'=>'image_mono','field'=>'avatar', 	'params'=>array( 'path'=>"/split/files/users/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createUserCard", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания карточки пользователя ".((isset($params['copyItem']) && $params['copyItem'] > 0) ? "(Дубликат карточки #".$params['copyItem'].")" : "")."</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>