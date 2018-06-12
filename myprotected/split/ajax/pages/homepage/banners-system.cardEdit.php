<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getBannerItem($item_id, $lpx);

	$langs = $zh->getAvailableLangs();
	$lpx_name = ($lpx ? $lpx : 'en');
	
	// Get positions List
	
	$sitePositions = $zh->getPositions();
	
	// Get categories List
	
	$catsList = $zh->getCatsList();

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(

					'LPX'		=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ),

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
					 'Title '.strtoupper($lpx_name)				=>	array( 'type'=>'input', 	'field'=>'title', 			'params'=>array( 'size'=>50, 'hold'=>'Title' ) ),
					 'Alt '.strtoupper($lpx_name)				=>	array( 'type'=>'input', 	'field'=>'alt', 			'params'=>array( 'size'=>50, 'hold'=>'Alt' ) )
					 
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editBanner", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования баннера #$item_id</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>