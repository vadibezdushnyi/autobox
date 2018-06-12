<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	$available_languages = $zh->getAvailableLangs();
	$cardItem = $zh->getBannerItem($item_id);
	
	// Get positions List
	
	$sitePositions = $zh->getPositions();
	
	// Get categories List
	
	$catsList = $zh->getCatsList();

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 'Название'				=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>50, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
					 
					 'Алиас'				=>	array( 'type'=>'input', 	'field'=>'alias', 			'params'=>array( 'size'=>50, 'hold'=>'Alias' ) ),
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 'Ссылка'				=>	array( 'type'=>'input', 	'field'=>'link', 			'params'=>array( 'size'=>50, 'hold'=>'Link' ) ),
					 'В новом окне?'		=>	array( 'type'=>'block', 	'field'=>'target', 			'params'=>array( 'reverse'=>false ) ),
					 
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 'Позиция'				=>	array( 'type'=>'input', 	'field'=>'order_id', 		'params'=>array('size'=>20, 'hold'=>'Позиция') 
																														  ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					


											 
					 'Изображения'			=>	array( 'type'=>'header'),


					 
					 'Изображение материала'=>	array( 'type'=>'image_mono','field'=>'file', 			'params'=>array( 'path'=>"/public/img/content/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 
					 'Имя изображения'		=>	array( 'type'=>'hidden',	'field'=>'curr_filename', 	'params'=>array( 'field'=>"file" ) ),
					 'Имя файла'				=>	array( 'type'=>'input', 	'field'=>'file_name', 			'params'=>array( 'size'=>50, 'hold'=>'Имя файла' ) ),
					 'Title'				=>	array( 'type'=>'input', 	'field'=>'title', 			'params'=>array( 'size'=>50, 'hold'=>'Title' ) ),
					 'Alt'					=>	array( 'type'=>'input', 	'field'=>'alt', 			'params'=>array( 'size'=>50, 'hold'=>'Alt' ) ),

					 'av_langs' 			=>	array( 'type'=>'post_array', 		'field'=>'av_langs', 	'params'=>array('arr_field' =>  json_encode($available_languages) ) )
					 
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createBanner", 'ajaxFolder'=>'create', 'appTable'=>$appTable, 'lang_fields'=>$lang_inputs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания баннера</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>