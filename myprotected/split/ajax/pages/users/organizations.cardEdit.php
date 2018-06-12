<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getOrganizationInfo($item_id);
	$specs = $zh->getOrgSpecs($item_id);
	
	$rootPath = "../../../../..";
	
	$cardTmp = array(



					 'Название организации'	=>	array( 'type'=>'input', 	'field'=>'org_name', 	 	'params'=>array( 'size'=>25, 'hold'=>'Имя', 'onchange'=>"change_alias();" ) ),
					 
					 'Контактное лицо'		=>	array( 'type'=>'input', 	'field'=>'contact_name', 	'params'=>array( 'size'=>25, 'hold'=>'Фамилия' ) ),

					 'clear-5'		=>	array( 'type'=>'clear' ),

					 'Город'				=>	array( 'type'=>'input', 	'field'=>'city', 			'params'=>array( 'size'=>25, 'hold'=>'' ) ),
					 
					 'Адресс'				=>	array( 'type'=>'input', 	'field'=>'address', 		'params'=>array( 'size'=>50, 'hold'=>'' ) ),
					 
					 'Индекс'				=>	array( 'type'=>'input', 	'field'=>'zip', 			'params'=>array( 'size'=>25, ) ),
					 
					 'Телефон'				=>	array( 'type'=>'input', 	'field'=>'phone', 			'params'=>array( 'size'=>25, ) ),

					 'clear-6'		=>	array( 'type'=>'clear' ),
					 
					 'Сайт'					=>	array( 'type'=>'input', 	'field'=>'site', 			'params'=>array( 'size'=>50, ) ),
					 
					 'Email'				=>	array( 'type'=>'input', 	'field'=>'login', 			'params'=>array( 'size'=>50, ) ),

					 'clear-2'		=>	array( 'type'=>'clear' ),

					 'FB'					=>	array( 'type'=>'input', 	'field'=>'socials_fb', 		'params'=>array( 'size'=>50, ) ),

					 'IN'					=>	array( 'type'=>'input', 	'field'=>'socials_ln', 		'params'=>array( 'size'=>50, ) ),

					 'VK'					=>	array( 'type'=>'input', 	'field'=>'socials_vk', 		'params'=>array( 'size'=>50, ) ),
					 
					 'clear-3'		=>	array( 'type'=>'clear' ),

					 'Описание деятельности'=>	array( 'type'=>'area',	'field'=>'description', 		'params'=>array( 'size'=>25, ) ),

	 				 'Специализация'			=>	['type'=>'select', 	'field'=>'spec', 		'params'=>[ 'list'=>$specs,
																									'first'=>['name'=>'Не выбран', 'id'=>0], 
																									'fieldValue'=>'id', 
																									'fieldTitle'=>'name',
																									'currValue'=>$cardItem['spec_id'],
																							  ] ],

					 'clear-1'		=>	array( 'type'=>'clear' ),
					 
					 'Блокировка'	=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>false ) ),
					 
					 'Подтверждение регистрации'=>	array( 'type'=>'block', 	'field'=>'confirmed', 			'params'=>array( 'reverse'=>false ) ),

					 'Подтверждение формы'=>	array( 'type'=>'block', 	'field'=>'agreed', 			'params'=>array( 'reverse'=>false ) ),
					 
					 'Изображения'	=>	array( 'type'=>'header'),
					 
					 'Аватар'		=>	array( 'type'=>'image_mono', 'field'=>'image', 	'params'=>array( 'path'=>"/platform/img/avatars/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 
					 // 'Смена пароля'				=>	array( 'type'=>'header'),
					 
					 // 'Старый пароль'			=>	array( 'type'=>'input', 	'field'=>'old-pass', 			'params'=>array( 'size'=>25, 'hold'=>'Старый пароль', 'type'=>'password' ) ),
					 
					 // 'Новый пароль'				=>	array( 'type'=>'input', 	'field'=>'new-pass', 			'params'=>array( 'size'=>25, 'hold'=>'Новый пароль', 'type'=>'password' ) ),
					 
					 // 'Повторить новый пароль'	=>	array( 'type'=>'input', 	'field'=>'new-pass-r', 			'params'=>array( 'size'=>25, 'hold'=>'Повторить новый пароль', 'type'=>'password' ) ),
					 
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editOrganization", 'ajaxFolder'=>'edit', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования карточки организации #$item_id</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>