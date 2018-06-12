<?php 
	// Start header content
	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable ,'type'=>'art_land' );
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	$cardItem = $zh->getCertificateItem($item_id, $lpx);

	$langs = $zh->getAvailableLangs();
	$lpx_name = strtoupper($lpx ? $lpx : 'en');
	
	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 
		'LPX'		=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ),
					 
		'clear-123'		=>	array( 'type'=>'clear' ),
	 	'Publication'	=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
		'Display order'	=>	array( 'type'=>'input', 	'field'=>'order_id', 		'params'=>array( 'size'=>25, 'hold'=>'Позиция' ) ),
	    'clear-124'		=>	array( 'type'=>'clear' ),
	 	'['.$lpx_name.'] '.'Certificate name' =>	array( 'type'=>'input', 'field'=>'name', 'params'=>array( 'size'=>150, 'hold'=>'title', 'onchange'=>"change_alias();" ) ),
	   	'clear-0'				=>	array( 'type'=>'clear' ),
		/*'Видеоматериал?'		=>	array( 'type'=>'block', 	'field'=>'is_video', 		'params'=>array( 'reverse'=>false ) ),*/
		'clear-2'				=>	array( 'type'=>'clear' ),
		'['.$lpx_name.'] '.'Certificate description'				=>	array( 'type'=>'redactor', 		'field'=>'content', 	'params'=>array(  ) ),
	 	'clear-33532'			=>	array( 'type'=>'clear' ),
		'clear-2'						=>	array( 'type'=>'clear' ),
					 
		'Images'		=>	array( 'type'=>'header'),
		'Last uploaded image gonna be used as cover' 	=>	array( 'type'=>'image_mult', 'field'=>'images', 		'params'=>array( 'path'=>FILESROOT."/img/gallery/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'file' ) ),
		
	 );


	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editCertificate", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs  );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>CERTIFICATE #$item_id edit.</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>