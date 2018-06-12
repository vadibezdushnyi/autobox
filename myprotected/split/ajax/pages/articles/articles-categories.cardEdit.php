<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'afterSubmit'=>1  );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$lang_fields = array(
		'details',
		'name',
	);

	$cardItem = $zh->getArtCategoriesItem($item_id, $lpx);
	$langs = $zh->getAvailableLangs();
	$rootPath = ROOT_PATH;

	$langs = $zh->getAvailableLangs();
	$lpx_name = strtoupper($lpx ? $lpx : DEF_LANG);
	
	$cardTmp = array(
		'LPX'						=>	array( 'type'=>'hidden',		'field'=>'lpx', 'value'=>$lpx ), 
		'Alias'						=>	array( 'type'=>'input', 	'field'=>'alias', 			'params'=>array( 'size'=>25, 'hold'=>'Alias' , 'readonly' => ( $lpx_name=='EN' ? false : true ) ) ),
		'Publication'				=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
		'clear'						=>  array('type'=>'clear'),
		'['.$lpx_name.'] '.'Name'			=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>25, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
		'['.$lpx_name.'] '.'Description'	=>	array( 'type'=>'redactor', 	'field'=>'details', 		'params'=>array(  ) )
		/*'Изображения'			=>	array( 'type'=>'header'),
		'Изображение категории'=>	array( 'type'=>'image_mono','field'=>'filename', 		'params'=>array( 'path'=>RSF."/split/files/banners/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
		'Имя изображения'		=>	array( 'type'=>'hidden',	'field'=>'curr_filename', 	'params'=>array( 'field'=>"filename" ) )*/
	);

	$cardEditFormParams = array( 
		'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editArtsCategory", 'ajaxFolder'=>'edit', 
		'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs   
	);
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Articles category #$item_id edit</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>