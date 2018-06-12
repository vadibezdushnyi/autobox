<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams, $lpx);
	$pref = ($lpx ? $lpx.'_' : '');
	$lpx_name = strtoupper($lpx ? $lpx : 'en');
	
	// Start body content
	
	$cardItem = $zh->getArticleItem($item_id, $lpx);
	$langs = $zh->getAvailableLangs();

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'ID'							=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
		'Alias'							=>	array( 'type'=>'text', 		'field'=>'alias', 			'params'=>array() ),
		'Category'						=>	array( 'type'=>'text', 		'field'=>'cat_name', 		'params'=>array() ),
		'['.$lpx_name.'] '.'Title'		=>	array( 'type'=>'text', 		'field'=>'name', 			'params'=>array() ),
		'['.$lpx_name.'] '.'Content'	=>	array( 'type'=>'text', 		'field'=>'content', 		'params'=>array() ),
		'Publication'					=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Yes', '1'=>'No') ) ),
		'Created at'					=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array() ),
		'Edited at'						=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array() ),
		'Images'						=>	array( 'type'=>'covers',	'field'=>'images',			'params'=>array( 'path'=>FILESROOT."/img/content/", 'field'=>'file' ) ),
	);

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'headParams'=>$headParams, 'lpx'=>$lpx, 'langs'=>$langs );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>ARTICLE #$item_id VIEW</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>