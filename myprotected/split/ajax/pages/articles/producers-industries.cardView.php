<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams, $lpx);
	$lpx_name = ($lpx ? $lpx.'_' : '');
	
	// Start body content
	
	$cardItem = $zh->getProducerIndustryItem($item_id, $lpx);

	$langs = $zh->getAvailableLangs();

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'ID'			=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
		'Publication'	=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Yes', '1'=>'No') ) ),
		'[EN] Name'		=>	array('type'=>'text',		'field'=>'name'),
		'[DE] Name'		=>	array('type'=>'text',		'field'=>'de_name'),
		'[RU] Name'		=>	array('type'=>'text',		'field'=>'ru_name'),
		'[SK] Name'		=>	array('type'=>'text',		'field'=>'sk_name'),
		'[CZ] Name'		=>	array('type'=>'text',		'field'=>'cz_name'),
		'[TR] Name'		=>	array('type'=>'text',		'field'=>'tr_name'),
		'[ES] Name'		=>	array('type'=>'text',		'field'=>'es_name'),
		'[AR] Name'		=>	array('type'=>'text',		'field'=>'ar_name'),
		'Image'			=>	array( 'type'=>'image',		'field'=>'logo',			'params'=>array( 'path'=>FILESROOT.'/img/content/parts/' ) ),
	);

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'langs'=>$langs, 'headParams'=>$headParams );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>INDUSTRY #$item_id VIEW</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>