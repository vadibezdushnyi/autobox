<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	$lpx_name = ($lpx ? $lpx.'_' : '');
	// Start body content
	
	$cardItem = $zh->getArtCategoriesItem($item_id, $lpx);
	
	$langs = $zh->getAvailableLangs();

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 'Name'				=>	array( 'type'=>'text', 		'field'=>'name', 			'params'=>array() ),
					 'ID'				=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 /*'Изображение'	=>	array( 'type'=>'image',		'field'=>'filename',		'params'=>array( 'path'=>RSF.'/split/files/banners/' ) ),*/
					 'Alias'			=>	array( 'type'=>'text', 		'field'=>'alias', 			'params'=>array() ),
					 /*'Публикация'		=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),*/
					 'Description'		=>	array( 'type'=>'text', 		'field'=>'details', 		'params'=>array() ),
					 'Created at'		=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array() ),
					 'Edited at'		=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array() ),
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'lpx'=>$lpx, 'langs'=>$langs, 'headParams'=>$headParams );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>ARTICLES CATEGORY #$item_id VIEW </h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>