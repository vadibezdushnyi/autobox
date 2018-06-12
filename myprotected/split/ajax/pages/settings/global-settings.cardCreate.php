<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getCatalogItemDetails($item_id);

	$catalogParents = $zh->getCatalogParents();
	
	$charsGroups = $zh->getCharsGroups();

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 'Название'				=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>25, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
					 
					 'Алиас'				=>	array( 'type'=>'input', 	'field'=>'alias', 			'params'=>array( 'size'=>25, 'hold'=>'Alias' ) ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'Индексация'			=>	array( 'type'=>'block', 	'field'=>'index', 			'params'=>array( 'reverse'=>false ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Родитель'				=>	array( 'type'=>'select', 	'field'=>'parent', 			'params'=>array( 'list'=>$catalogParents, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['parent']['id'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'Node', 'id'=>0 ) 
																														 ) ),
					'Ггрупа характеристик'	=>	array( 'type'=>'select', 	'field'=>'charsGroup', 		'params'=>array( 'list'=>$charsGroups, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['charsGroup']['id'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'No select', 'id'=>0 ) 
																														 ) ),
					 
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'Описание категории'	=>	array( 'type'=>'redactor', 	'field'=>'details', 		'params'=>array(  ) ),
					 
					 'Параметры публикации'	=>	array( 'type'=>'header'),
					 
					 'Начало публикации'	=>	array( 'type'=>'date', 		'field'=>'startPublish', 	'params'=>array( ) ),
					 
					 'Завершение публикации'=>	array( 'type'=>'date', 		'field'=>'finishPublish', 	'params'=>array( ) ),
					 
					 'Мета теги'			=>	array( 'type'=>'header'),
					 
					 'Title'				=>	array( 'type'=>'input', 	'field'=>'meta_title', 			'params'=>array( 'size'=>50, 'hold'=>'Title', 'onchange'=>"" ) ),
					 
					 'Keywords'				=>	array( 'type'=>'input', 	'field'=>'meta_keys', 			'params'=>array( 'size'=>50, 'hold'=>'Keywords', 'onchange'=>"" ) ),
					 
					 'Description'			=>	array( 'type'=>'area', 		'field'=>'meta_desc', 			'params'=>array( 'size'=>100, 'hold'=>'Description' ) ),
					 
					 'Изображения'			=>	array( 'type'=>'header'),
					 
					 'Изображение категории'=>	array( 'type'=>'image_mono','field'=>'filename', 		'params'=>array( 'path'=>RSF."/split/files/shop/categories/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 
					 'Имя изображения'		=>	array( 'type'=>'hidden',	'field'=>'curr_filename', 	'params'=>array( 'field'=>"filename" ) )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createShopCatalogItem", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания карточки</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>