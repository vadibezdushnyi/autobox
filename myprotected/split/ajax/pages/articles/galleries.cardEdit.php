<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'afterSubmit'=>1 );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	$lang_fields = array(
		'name',
	);

	$langs = $zh->getAvailableLangs();
	$lpx_name = strtoupper($lpx ? $lpx : 'en');

	$cardItem = $zh->getGalleryItem($item_id, $lpx);

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'LPX'						=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ), 
		'['.$lpx_name.'] '.'Name'	=>	array( 'type'=>'input', 	'field'=>'name', 		'params'=>array( 'size'=>50, 'hold'=>'Name', 'onchange'=>"" ) ), 
		'clear-0'				=>	array( 'type'=>'clear' ),
		'['.$lpx_name.'] '.'Title'	=>	array( 'type'=>'area', 	'field'=>'title', 		'params'=>array( 'size'=>50, 'hold'=>'Title' ) ),
		'clear-1'				=>	array( 'type'=>'clear' ),
		'Publication'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
		'Images'			=>	array( 'type'=>'header'),
		'Last uploaded image gonna be used as cover' 	=>	array( 'type'=>'image_mult', 'field'=>'images', 		'params'=>array( 'path'=>FILESROOT."/img/gallery/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'file' ) ),
	 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editGallery", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>GALLERY #$item_id EDIT</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>