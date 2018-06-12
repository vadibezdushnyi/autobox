<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getContentBlockItem($item_id);
	
	// Get positions List
	
	$sitePositions = $zh->getPositions();
	
	// Get categories List
	
	$catsList = $zh->getCatsList();

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 'Название'				=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>50, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
					 
					 'Алиас'				=>	array( 'type'=>'input', 	'field'=>'alias', 			'params'=>array( 'size'=>50, 'hold'=>'Alias' ) ),
					 
					 'Ссылка'				=>	array( 'type'=>'input', 	'field'=>'link', 			'params'=>array( 'size'=>75, 'hold'=>'Link' ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Позиция'				=>	array( 'type'=>'select', 	'field'=>'pos_id', 			'params'=>array( 'list'=>$sitePositions, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['pos_id'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'No select', 'id'=>0 ) 
																														 ) ),
																														 
					 'Начало публикации'	=>	array( 'type'=>'date', 		'field'=>'startPublish', 	'params'=>array(  ) ),
					 
					 'Завершение публикации'=>	array( 'type'=>'date', 		'field'=>'finishPublish', 	'params'=>array(  ) ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'В новом окне?'		=>	array( 'type'=>'block', 	'field'=>'target', 			'params'=>array( 'reverse'=>false ) ),
					 
					 'Содержание'			=>	array( 'type'=>'redactor', 	'field'=>'data', 			'params'=>array(  ) ),
					 
					 'Изображения'			=>	array( 'type'=>'header'),
					 
					 'Изображение материала'=>	array( 'type'=>'image_mono','field'=>'file', 			'params'=>array( 'path'=>RSF."/split/files/banners/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 
					 'Имя изображения'		=>	array( 'type'=>'hidden',	'field'=>'curr_filename', 	'params'=>array( 'field'=>"file" ) )
					 
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createContentBlock", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания контент блока</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>