<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getProducerItem($item_id, $lpx);
	$industries = $zh->getProducerIndustries($lpx);
	$tags = $zh->getFaqItemTags();

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'LPX'							=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ), 
		'Publication'					=>	array( 'type'=>'block', 	'field'=>'Block', 		'params'=>array( 'reverse'=>true ) ),
		'Show on home page'				=>	array( 'type'=>'block', 	'field'=>'show_home', 	'params'=>array( 'reverse'=>true ) ),
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
		'Description'=>	array( 'type'=>'redactor', 	'field'=>'description', 	'params'=>array( 'size'=>100, 'hold'=>'current position' ) ),
		'Images' 			=> 	array('type'=>'header'),
	 	'Logo'				=>	array( 'type'=>'image_mono','field'=>'Logo', 			'params'=>array( 'path'=>FILESROOT."/img/icons-general/car-logos/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
	 	'Cover'				=>	array( 'type'=>'image_mono','field'=>'cover', 			'params'=>array( 'path'=>FILESROOT."/img/content/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
		'SEO settings' 	=> array('type' =>  'header'),
		'Page title'		=>	array( 'type'=>'input', 'field'=>'meta_title', 	'params'=>array( 'size'=>100,  ) ),
		'clear-seo1'				=>	array( 'type'=>'clear' ),
		'Page desctription'	=>	array( 'type'=>'area', 	'field'=>'meta_desc', 	'params'=>array(  ) ),
		'clear-seo2'				=>	array( 'type'=>'clear' ),
		'Page keywords'		=>	array( 'type'=>'area', 	'field'=>'meta_keys', 	'params'=>array(  ) )
	 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createProducerItem", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>NEW PRODUCER</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>