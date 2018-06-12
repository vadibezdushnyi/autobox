<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams, $lpx);
	$lpx_name = ($lpx ? $lpx.'_' : '');
	
	// Start body content
	
	$cardItem = $zh->getHomeWhyUsItem($item_id, $lpx);

	$langs = $zh->getAvailableLangs();
	$lpx_name = strtoupper($lpx ? $lpx : DEF_LANG);
	$_loc = '['.$lpx_name.'] ';
	$rootPath = ROOT_PATH;
	

	$cardTmp = array(
		'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
		'[EN] Title'				=>	array('type'=>'text',		'field'=>'name'),
		'[DE] Title'				=>	array('type'=>'text',		'field'=>'de_name'),
		'[RU] Title'				=>	array('type'=>'text',		'field'=>'ru_name'),
		'[CZ] Title'				=>	array('type'=>'text',		'field'=>'cz_name'),
		'[SK] Title'				=>	array('type'=>'text',		'field'=>'sk_name'),
		'[TR] Title'				=>	array('type'=>'text',		'field'=>'tr_name'),
		'[ES] Title'				=>	array('type'=>'text',		'field'=>'es_name'),
		'[AR] Title'				=>	array('type'=>'text',		'field'=>'ar_name'),		
		'Display number'		=>	array( 'type'=>'text', 		'field'=>'order_id', 		'params'=>array() ),
		'Publication'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array('replace'=>array('0'=>'Yes', '1'=>'No') ) ),
		'Image'					=>	array( 'type'=>'image',		'field'=>'cover',			'params'=>array( 'path'=>FILESROOT.'/img/content/' ) ),
	);

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>WHY US #$item_id VIEW</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>