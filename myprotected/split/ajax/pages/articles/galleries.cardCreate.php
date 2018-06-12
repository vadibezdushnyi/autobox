<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getBannerItem($item_id);
	
	// Get positions List
	
	$sitePositions = $zh->getPositions();
	
	// Get categories List
	
	$catsList = $zh->getCatsList();

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'Name'					=>	array( 'type'=>'input', 	'field'=>'name', 		'params'=>array( 'size'=>50, 'hold'=>'Name', 'onchange'=>"" ) ),
		'clear-0'				=>	array( 'type'=>'clear' ),
		'Title'					=>	array( 'type'=>'area', 		'field'=>'title', 		'params'=>array( 'size'=>50, 'hold'=>'Title' ) ),
		'clear-1'				=>	array( 'type'=>'clear' ),
		'Publication'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
		'Images'				=>	array( 'type'=>'header'),
		'Last uploaded image gonna be used as cover' 	=>	array( 'type'=>'image_mult', 'field'=>'images', 		'params'=>array( 'path'=>FILESROOT."/img/gallery/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'file' ) ),
	);

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createGallery", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>NEW GALLERY</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>