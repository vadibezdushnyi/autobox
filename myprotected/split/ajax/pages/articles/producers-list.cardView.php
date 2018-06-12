<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams, $lpx);
	$lpx_name = ($lpx ? $lpx.'_' : '');
	
	// Start body content
	
	$cardItem = $zh->getProducerItem($item_id, $lpx);

	$langs = $zh->getAvailableLangs();
	$lpx_name = strtoupper($lpx ? $lpx : DEF_LANG);
	$_loc = '['.$lpx_name.'] ';
	$rootPath = ROOT_PATH;
	

	$cardTmp = array(
		'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
		'Background'			=>	array( 'type'=>'image',		'field'=>'cover',			'params'=>array( 'path'=>FILESROOT.'/img/content/' ) ),
		'Logo'					=>	array( 'type'=>'image',		'field'=>'Logo',			'params'=>array( 'path'=>FILESROOT.'/img/icons-general/car-logos/' ) ),
		'Name'					=>	array( 'type'=>'text', 		'field'=>'Name', 			'params'=>array() ),
		$_loc.'Description'		=>	array( 'type'=>'text', 		'field'=>'description', 	'params'=>array() ),
		$_loc.'SEO Title'		=>	array( 'type'=>'text', 		'field'=>'meta_title', 		'params'=>array() ),
		$_loc.'SEO Keys'		=>	array( 'type'=>'text', 		'field'=>'meta_keys', 		'params'=>array() ),
		$_loc.'Seo desc'		=>	array( 'type'=>'text', 		'field'=>'meta_desc', 		'params'=>array() ),
		'Publication'			=>	array( 'type'=>'text', 		'field'=>'Block', 			'params'=>array( 'replace'=>array('0'=>'Yes', '1'=>'No') ) ),
		'Show on home page'		=>	array( 'type'=>'text', 		'field'=>'show_home', 		'params'=>array( 'replace'=>array('0'=>'No', '1'=>'Yes') ) ),
		'Created at'			=>	array( 'type'=>'date', 		'field'=>'Created', 		'params'=>array() ),
		'Edited at'				=>	array( 'type'=>'date', 		'field'=>'Modified', 		'params'=>array() ),
	);

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'lpx'=>$lpx, 'langs'=>$langs, 'headParams'=>$headParams );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>PRODUCER #$item_id VIEW</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>