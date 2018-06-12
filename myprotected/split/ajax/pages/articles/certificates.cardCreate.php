<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'art_land' );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$available_languages = $zh->getAvailableLangs();
	$cardItem = $zh->getArticleItem($item_id);
	$tags = $zh->getArticleItemTags($lpx);
	
	// Get positions List
	
	$sitePositions = $zh->getPositions();
	
	// Get formats List
	
	$menuFormats = $zh->getMenuFormats();
	
	// Get Menu Categories
	
	$catsList = $zh->getCatsList();

	// Get Galleries List
	
	$galleriesList = $zh->getGalleriesList();

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 
		'LPX'		=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ),
					 
		'clear-123'		=>	array( 'type'=>'clear' ),
	 	'Publication'	=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
		'Display order'	=>	array( 'type'=>'input', 	'field'=>'order_id', 		'params'=>array( 'size'=>25, 'hold'=>'Позиция' ) ),
	    'clear-124'		=>	array( 'type'=>'clear' ),
	 	'Certificate name' =>	array( 'type'=>'input', 'field'=>'name', 'params'=>array( 'size'=>150, 'hold'=>'title', 'onchange'=>"change_alias();" ) ),
	   	'clear-0'				=>	array( 'type'=>'clear' ),
		/*'Видеоматериал?'		=>	array( 'type'=>'block', 	'field'=>'is_video', 		'params'=>array( 'reverse'=>false ) ),*/
		'clear-2'				=>	array( 'type'=>'clear' ),
		'Certificate description'				=>	array( 'type'=>'redactor', 		'field'=>'content', 	'params'=>array(  ) ),
	 	'clear-33532'			=>	array( 'type'=>'clear' ),
		'clear-2'						=>	array( 'type'=>'clear' ),
					 
		'Images'		=>	array( 'type'=>'header'),
		'Last uploaded image gonna be used as cover' 	=>	array( 'type'=>'image_mult', 'field'=>'images', 		'params'=>array( 'path'=>FILESROOT."/img/gallery/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'file' ) ),
		
	 );
		


	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createCertificate", 'ajaxFolder'=>'create', 'appTable'=>$appTable, 'lang_fields'=>$lang_inputs);
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>NEW CERTIFICATE</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>