<?php 
	// Start header content
	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getGalleryItem($item_id);
	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'Name'					=>	array( 'type'=>'text', 		'field'=>'name', 			'params'=>array() ),
		'Title'					=>	array( 'type'=>'text', 		'field'=>'title', 			'params'=>array() ),
		'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
		'Publication'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
		'Created at'			=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array() ),
		'Edited at'				=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array() ),
		'Images'				=>	array( 'type'=>'covers',	'field'=>'images',			'params'=>array( 'path'=>FILESROOT.'/img/gallery/', 'field'=>'file' ) ),
	 );
	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>GALLERY #$item_id VIEW</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";
?>