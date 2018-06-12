<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	$available_languages = $zh->getAvailableLangs();
	$cardItem = $zh->getBannerItem($item_id);
	
	// Get positions List
	
	$sitePositions = $zh->getPositions();
	
	// Get categories List
	
	$catsList = $zh->getCatsList();

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		 'Name'					=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>50, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
		 'Alias'				=>	array( 'type'=>'hidden', 	'field'=>'alias', 			'params'=>array( 'size'=>50, 'hold'=>'Alias' ) ),
		 'clear-1'				=>	array( 'type'=>'clear' ),					 
		 'Text'					=>	array( 'type'=>'area', 	'field'=>'data', 			'params'=>array( 'size'=>50, 'hold'=>'Text' ) ),					 
		 'clear-2'				=>	array( 'type'=>'clear' ),					 
		 'Link'					=>	array( 'type'=>'hidden', 	'field'=>'link', 			'params'=>array( 'size'=>50, 'hold'=>'Link' ) ),
		 'New tab?'				=>	array( 'type'=>'hidden', 	'field'=>'target', 			'params'=>array( 'reverse'=>false ) ),
		 'clear-3'				=>	array( 'type'=>'clear' ),
		 'Position'				=>	array( 'type'=>'input', 	'field'=>'order_id', 		'params'=>array('size'=>20, 'hold'=>'Position') ),					 
		 'Publication'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
		 'Image'			=>	array( 'type'=>'header'),
		 'Image file'		=>	array( 'type'=>'image_mono','field'=>'file', 			'params'=>array( 'path'=>RSF."/split/files/images/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
		 'Image name curr'	=>	array( 'type'=>'hidden',	'field'=>'curr_filename', 	'params'=>array( 'field'=>"file" ) ),
		 'Image name'		=>	array( 'type'=>'input', 	'field'=>'file_name', 			'params'=>array( 'size'=>50, 'hold'=>'Image name' ) ),
		 'Title'			=>	array( 'type'=>'input', 	'field'=>'title', 			'params'=>array( 'size'=>50, 'hold'=>'Title' ) ),
		 'Alt'				=>	array( 'type'=>'input', 	'field'=>'alt', 			'params'=>array( 'size'=>50, 'hold'=>'Alt' ) ),
		 'av_langs' 		=>	array( 'type'=>'post_array', 		'field'=>'av_langs', 	'params'=>array('arr_field' =>  json_encode($available_languages) ) )
	 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createBanner", 'ajaxFolder'=>'create', 'appTable'=>$appTable, 'lang_fields'=>$lang_inputs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'> Banner creating form</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>