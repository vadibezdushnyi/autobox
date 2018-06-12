<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'afterSubmit'=>2 );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$lang_fields = array(
		'question',
		'answer',
	);

	$cardItem 	= $zh->getProducerIndustryItem($item_id, $lpx);
	$producers 	= $zh->getIndustryProducers($lpx);
	$rootPath 	= ROOT_PATH;

	$langs = $zh->getAvailableLangs();
	$lpx_name = strtoupper($lpx ? $lpx : DEF_LANG);

	$cardTmp = array(
		'LPX'							=>	array( 'type'=>'hidden',		'field'=>'lpx', 'value'=>$lpx ), 
		'Publication'					=>	array( 'type'=>'block', 		'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
		'clear-1'						=>	array( 'type'=>'clear' ),
		'[EN] Name'						=>	array('type'=>'input',			'field'=>'name'),
		'[DE] Name'						=>	array('type'=>'input',			'field'=>'de_name'),
		'[RU] Name'						=>	array('type'=>'input',			'field'=>'ru_name'),
		'[SK] Name'						=>	array('type'=>'input',			'field'=>'sk_name'),
		'[CZ] Name'						=>	array('type'=>'input',			'field'=>'cz_name'),
		'[TR] Name'						=>	array('type'=>'input',			'field'=>'tr_name'),
		'[ES] Name'						=>	array('type'=>'input',			'field'=>'es_name'),
		'[AR] Name'						=>	array('type'=>'input',			'field'=>'ar_name'),
		'clear-2'						=>	array( 'type'=>'clear' ),
		'Related producers'				=>	array( 'type'=>'select_multiple', 	'field'=>'refs', 		'params'=>array( 
																											'selected'=>$cardItem['refs'], 
																											'elements'=>$producers, 
																											'name_key'=>'name', 
					 																						'value_key'=>'id', 
					 																						'selected_key'=>'id', 
																										) ),
		'Images' 			=> 	array('type'=>'header'),
	 	'File'				=>	array( 'type'=>'image_mono','field'=>'logo', 			'params'=>array( 'path'=>FILESROOT."/img/content/parts/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
	 	'Image current'		=>	array( 'type'=>'hidden',	'field'=>'curr_filename', 	'params'=>array( 'field'=>"logo" ) ),
	 );

	$cardEditFormParams = array( 
		'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editProducerIndustry", 'ajaxFolder'=>'edit', 
		'appTable'=>$appTable, 
	);
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Industry #$item_id edit page</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>