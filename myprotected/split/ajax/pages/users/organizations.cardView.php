<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getOrganizationInfo($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Название организации'	=>	array( 'type'=>'text', 		'field'=>'org_name', 			'params'=>array() ),
					 'Специализация'		=>	array( 'type'=>'text', 		'field'=>'spec', 			'params'=>array() ),
					 'Контактное лицо'		=>	array( 'type'=>'text', 		'field'=>'contact_name', 			'params'=>array() ),
					 'Город'				=>	array( 'type'=>'text', 		'field'=>'city', 			'params'=>array() ),
					 'Адресс'				=>	array( 'type'=>'text', 		'field'=>'address', 			'params'=>array() ),
					 'Индекс'				=>	array( 'type'=>'text', 		'field'=>'zip', 			'params'=>array() ),
					 'Телефон'				=>	array( 'type'=>'text', 		'field'=>'phone', 			'params'=>array() ),
					 'Сайт'					=>	array( 'type'=>'text', 		'field'=>'site', 			'params'=>array() ),
					 'Email'				=>	array( 'type'=>'text', 		'field'=>'login', 			'params'=>array() ),
					 'FB'					=>	array( 'type'=>'text', 		'field'=>'socials_fb', 			'params'=>array() ),
					 'IN'					=>	array( 'type'=>'text', 		'field'=>'socials_ln', 			'params'=>array() ),
					 'VK'					=>	array( 'type'=>'text', 		'field'=>'socials_vk', 			'params'=>array() ),
					 'Описание деятельности'=>	array( 'type'=>'text', 		'field'=>'description', 			'params'=>array() ),
					 'Изображение'			=>	array( 'type'=>'image',		'field'=>'image',			'params'=>array( 'path'=>'/platform/img/avatars/' ) ),
					 'Блокировка'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('1'=>'Да', '0'=>'Нет') ) ),
					 'Подтверждение формы'	=>	array( 'type'=>'text', 		'field'=>'agreed', 			'params'=>array( 'replace'=>array('1'=>'Да', '0'=>'Нет') ) ),
					 
					 'Дата регистрации'		=>	array( 'type'=>'date', 		'field'=>'created', 		'params'=>array( ) ),
					 'Дата редактирования'	=>	array( 'type'=>'date', 		'field'=>'modified', 		'params'=>array( ) )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр карточки пользователя</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>