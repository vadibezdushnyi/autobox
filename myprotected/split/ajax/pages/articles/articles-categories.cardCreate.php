<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'afterSubmit'=>1 );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getArtCategoriesItem($item_id);

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 'Alias'				=>	array( 'type'=>'input', 	'field'=>'alias', 			'params'=>array( 'size'=>25, 'hold'=>'Alias' ) ),
					 
					 'Publication'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'clear'				=>  array( 'type'=>'clear' ),

					 'Name'					=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>25, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
					 
					 'Description'			=>	array( 'type'=>'redactor', 		'field'=>'details', 		'params'=>array(  ) )
					 
					 /*'Изображения'			=>	array( 'type'=>'header'),
					 
					 'Изображение категории'=>	array( 'type'=>'image_mono','field'=>'filename', 		'params'=>array( 'path'=>RSF."/split/files/banners/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 
					 'Имя изображения'		=>	array( 'type'=>'hidden',	'field'=>'curr_filename', 	'params'=>array( 'field'=>"filename" ) )*/
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createArtsCategory", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>CREATE NEW ARTICLES CATEGORY</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>