<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'afterSubmit'=>2 );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$lang_fields = array(
		'question',
		'answer',
	);

	$cardItem 	= $zh->getFaqTagItem($item_id, $lpx);
	$faqs 		= $zh->getTagFaqs($lpx);
	$rootPath 	= ROOT_PATH;

	$langs = $zh->getAvailableLangs();
	$lpx_name = strtoupper($lpx ? $lpx : DEF_LANG);

	$cardTmp = array(
		'LPX'							=>	array( 'type'=>'hidden',		'field'=>'lpx', 'value'=>$lpx ), 
		'Alias'							=> 	array('type'=>'input', 			'field'=>'alias', 'params'=>array('disabled'=> ($cardItem['alias']=='*' ? true : false) )),
		'[EN] Name'						=>	array('type'=>'input',			'field'=>'name'),
		'[DE] Name'						=>	array('type'=>'input',			'field'=>'de_name'),
		'[RU] Name'						=>	array('type'=>'input',			'field'=>'ru_name'),
		'[SK] Name'						=>	array('type'=>'input',			'field'=>'sk_name'),
		'[CZ] Name'						=>	array('type'=>'input',			'field'=>'cz_name'),
		'[TR] Name'						=>	array('type'=>'input',			'field'=>'tr_name'),
		'[ES] Name'						=>	array('type'=>'input',			'field'=>'es_name'),
		'[AR] Name'						=>	array('type'=>'input',			'field'=>'ar_name'),
		'Publication'					=>	array( 'type'=>'block', 		'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
		'clear-2'				=>	array( 'type'=>'clear' ),
		'Related faq\'s'					=>	array( 'type'=>'select_multiple', 	'field'=>'faqs', 		'params'=>array( 
																											'selected'=>$cardItem['faqs'], 
																											'elements'=>$faqs, 
																											'name_key'=>'name', 
					 																						'value_key'=>'id', 
					 																						'selected_key'=>'id', 
																										) ),
	 );

	$cardEditFormParams = array( 
		'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editFAQTags", 'ajaxFolder'=>'edit', 
		'appTable'=>$appTable, 
	);
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Tag #$item_id edit page</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>