<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$lang_fields = array(
		'question',
		'answer',
	);

	$cardItem = $zh->getHomeWhyUsItem($item_id, $lpx);
	$rootPath = ROOT_PATH;

	$cardTmp = array(
		'Publication'		=>	array( 'type'=>'block', 	'field'=>'block', 		'params'=>array( 'reverse'=>true ) ),
		'Display number'	=>	array( 'type'=>'number', 	'field'=>'order_id' ),
		'clear-5'			=>	array( 'type'=>'clear' ),
		'[EN] Title'			=>	array('type'=>'input',		'field'=>'name', 			'params'=>array( 'size'=>100, 'hold'=>'name' ) ),
		'[DE] Title'			=>	array('type'=>'input',		'field'=>'de_name', 		'params'=>array( 'size'=>100, 'hold'=>'name' ) ),
		'[RU] Title'			=>	array('type'=>'input',		'field'=>'ru_name', 		'params'=>array( 'size'=>100, 'hold'=>'name' ) ),
		'[CZ] Title'			=>	array('type'=>'input',		'field'=>'cz_name', 		'params'=>array( 'size'=>100, 'hold'=>'name' ) ),
		'[SK] Title'			=>	array('type'=>'input',		'field'=>'sk_name', 		'params'=>array( 'size'=>100, 'hold'=>'name' ) ),
		'[TR] Title'			=>	array('type'=>'input',		'field'=>'tr_name', 		'params'=>array( 'size'=>100, 'hold'=>'name' ) ),
		'[ES] Title'			=>	array('type'=>'input',		'field'=>'es_name', 		'params'=>array( 'size'=>100, 'hold'=>'name' ) ),
		'[AR] Title'			=>	array('type'=>'input',		'field'=>'ar_name', 		'params'=>array( 'size'=>100, 'hold'=>'name' ) ),
		'Image'				=>	array( 'type'=>'header'),
	 	'File'				=>	array( 'type'=>'image_mono','field'=>'cover', 			'params'=>array( 'path'=>FILESROOT."/img/content/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
	 	'Image current'		=>	array( 'type'=>'hidden',	'field'=>'curr_filename', 	'params'=>array( 'field'=>"cover" ) ),
	 );

	$cardEditFormParams = array( 
		'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editHomeWhyUsBlock", 'ajaxFolder'=>'edit', 'appTable'=>$appTable 
	);
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>WHY US #$item_id EDIT</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>