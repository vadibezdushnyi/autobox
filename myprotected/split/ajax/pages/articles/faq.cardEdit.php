<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$lang_fields = array(
		'question',
		'answer',
	);

	$cardItem = $zh->getFaqItem($item_id, $lpx);
	$tags = $zh->getFaqItemTags($lpx);
	$rootPath = ROOT_PATH;

	$langs = $zh->getAvailableLangs();
	$lpx_name = strtoupper($lpx ? $lpx : DEF_LANG);

	$cardTmp = array(
		'LPX'							=>	array( 'type'=>'hidden',		'field'=>'lpx', 'value'=>$lpx ), 
		'['.$lpx_name.'] '.'Question'	=>	array( 'type'=>'area', 			'field'=>'question', 		'params'=>array( 'size'=>100, 'hold'=>'Question' ) ),
		'clear-1'						=>	array( 'type'=>'clear' ),
		'['.$lpx_name.'] '.'Answer'		=>	array( 'type'=>'area', 			'field'=>'answer', 			'params'=>array( 'size'=>100, 'hold'=>'Answer' ) ),
		'clear-2'						=>	array( 'type'=>'clear' ),
		'Related tags'					=>	array( 'type'=>'select_multiple', 	'field'=>'tags', 		'params'=>array(  
																											'selected'=>$cardItem['tags'], 
																											'elements'=>$tags, 
																											'name_key'=>'name', 
					 																						'value_key'=>'id', 
					 																						'selected_key'=>'id', 
																										) 
		),
		'Publication'					=>	array( 'type'=>'block', 		'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
		'Order number'					=>	array( 'type'=>'number', 		'field'=>'order_id' ),
	 );

	$cardEditFormParams = array( 
		'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editFAQ", 'ajaxFolder'=>'edit', 
		'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs  
	);
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Faq #$item_id edit page</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>