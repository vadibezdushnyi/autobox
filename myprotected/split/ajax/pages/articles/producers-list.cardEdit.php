<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$lang_fields = array(
		'question',
		'answer',
	);

	$cardItem = $zh->getProducerItem($item_id, $lpx);
	$industries = $zh->getProducerIndustries($lpx);
	$rootPath = ROOT_PATH;
	$langs = $zh->getAvailableLangs();
	$lpx_name = strtoupper($lpx ? $lpx : DEF_LANG);

	$cardTmp = array(
		'LPX'							=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ), 
		'Publication'					=>	array( 'type'=>'block', 	'field'=>'Block', 		'params'=>array( 'reverse'=>true ) ),
		'Show on home page'				=>	array( 'type'=>'block', 	'field'=>'show_home', 	'params'=>array( 'reverse'=>false ) ),
		'clear-5'						=>	array( 'type'=>'clear' ),
		'Name'							=>	array( 'type'=>'input', 	'field'=>'Name', 		'params'=>array( 'size'=>100, 'hold'=>'Producer name' ) ),
		'Products amount'				=>	array( 'type'=>'input', 	'field'=>'products_amount', 		'params'=>array( 'size'=>100, 'hold'=>'100000' ) ),
		'clear-2'						=>	array( 'type'=>'clear' ),
		'Related industries'			=>	array( 'type'=>'select_multiple', 	'field'=>'refs', 	'params'=>array( 
																											'selected'=>$cardItem['refs'],
																											'elements'=>$industries, 
																											'name_key'=>'name', 
					 																						'value_key'=>'id', 
					 																						'selected_key'=>'id', 
					 																					) ),
		'['.$lpx_name.'] '.'Description'=>	array( 'type'=>'redactor', 	'field'=>'description', 	'params'=>array( 'size'=>100, 'hold'=>'current position' ) ),
		'Images' 			=> 	array('type'=>'header'),
	 	'Logo'				=>	array( 'type'=>'image_mono','field'=>'Logo', 			'params'=>array( 'path'=>FILESROOT."/img/icons-general/car-logos/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
	 	'Image current'		=>	array( 'type'=>'hidden',	'field'=>'curr_filename', 	'params'=>array( 'field'=>"Logo" ) ),
	 	'Cover'				=>	array( 'type'=>'image_mono','field'=>'cover', 			'params'=>array( 'path'=>FILESROOT."/img/content/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
	 	'Image current2'	=>	array( 'type'=>'hidden',	'field'=>'curr_filename2', 	'params'=>array( 'field'=>"Logo" ) ),
		'SEO settings' 	=> array('type' =>  'header'),
		'['.$lpx_name.'] '.'Page title'		=>	array( 'type'=>'input', 'field'=>'meta_title', 	'params'=>array( 'size'=>100,  ) ),
		'clear-seo1'				=>	array( 'type'=>'clear' ),
		'['.$lpx_name.'] '.'Page desctription'	=>	array( 'type'=>'area', 	'field'=>'meta_desc', 	'params'=>array(  ) ),
		'clear-seo2'				=>	array( 'type'=>'clear' ),
		'['.$lpx_name.'] '.'Page keywords'		=>	array( 'type'=>'area', 	'field'=>'meta_keys', 	'params'=>array(  ) )
	 );

	$cardEditFormParams = array( 
		'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editProducerItem", 'ajaxFolder'=>'edit', 
		'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs  
	);
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>PRODUCER #$item_id EDIT</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>