<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'afterSubmit'=>2 );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$lang_fields = array(
		'question',
		'answer',
	);

	$cardItem = $zh->getSitemapCategoriesItem($item_id, $lpx);
	$menus = $zh->getAcceptedMenus($lpx);
	$rootPath = ROOT_PATH;

	$cardTmp = array(
		'Publication'		=>	array( 'type'=>'block', 	'field'=>'block', 		'params'=>array( 'reverse'=>true ) ),
		'Attach posts'		=>	array( 'type'=>'block', 	'field'=>'news_list', 		'params'=>array( 'reverse'=>false ) ),
		'Attach producers'	=>	array( 'type'=>'block', 	'field'=>'producers_list', 		'params'=>array( 'reverse'=>false ) ),
		'Attach industries'	=>	array( 'type'=>'block', 	'field'=>'directions_list', 		'params'=>array( 'reverse'=>false ) ),
		'Display number'	=>	array( 'type'=>'number', 	'field'=>'order_id' ),
		'clear-5'			=>	array( 'type'=>'clear' ),
		'[EN] Name'			=>	array( 'type'=>'input',		'field'=>'name', 			'params'=>array( 'size'=>100, 'hold'=>'name' ) ),
		'[DE] Name'			=>	array( 'type'=>'input',		'field'=>'de_name', 		'params'=>array( 'size'=>100, 'hold'=>'name' ) ),
		'[RU] Name'			=>	array( 'type'=>'input',		'field'=>'ru_name', 		'params'=>array( 'size'=>100, 'hold'=>'name' ) ),
		'[CZ] Name'			=>	array( 'type'=>'input',		'field'=>'cz_name', 		'params'=>array( 'size'=>100, 'hold'=>'name' ) ),
		'[SK] Name'			=>	array( 'type'=>'input',		'field'=>'sk_name', 		'params'=>array( 'size'=>100, 'hold'=>'name' ) ),
		'[TR] Name'			=>	array( 'type'=>'input',		'field'=>'tr_name', 		'params'=>array( 'size'=>100, 'hold'=>'name' ) ),
		'[ES] Name'			=>	array( 'type'=>'input',		'field'=>'es_name', 		'params'=>array( 'size'=>100, 'hold'=>'name' ) ),
		'[AR] Name'			=>	array( 'type'=>'input',		'field'=>'ar_name', 		'params'=>array( 'size'=>100, 'hold'=>'name' ) ),
		'Related menu`s'	=>	array( 'type'=>'select_multiple', 	'field'=>'menus', 	'params'=>array( 
																									'selected'=>$cardItem['menus'],
																									'elements'=>$menus, 
																									'name_key'=>'name', 
			 																						'value_key'=>'id', 
			 																						'selected_key'=>'id', 
			 																						'height'=>'200px', 
																								) ),
	 );

	$cardEditFormParams = array( 
		'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editSitemapCategory", 'ajaxFolder'=>'edit', 'appTable'=>$appTable 
	);
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	$data['bodyContent'] .= "<div class='ipad-20' id='order_conteinter'><h3 class='new-line'>SITEMAP CATEGORY #$item_id EDIT</h3>";
	$data['bodyContent'] .= $cardEditFormStr;
	$data['bodyContent'] .=	"</div>";

?>