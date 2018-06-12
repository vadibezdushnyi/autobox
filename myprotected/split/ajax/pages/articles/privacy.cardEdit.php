<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'privacy_h' );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getPrivacyItem($item_id, $lpx);

	$langs = $zh->getAvailableLangs();
	$lpx_name = ($lpx ? $lpx : 'en');

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(

					'LPX'		=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ),

					 'Заголовок '.strtoupper($lpx_name)				=>	array( 'type'=>'input', 		'field'=>'q', 		'params'=>array( 'size'=>100, 'hold'=>'Caption' ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Описание '.strtoupper($lpx_name)				=>	array( 'type'=>'redactor', 	'field'=>'a', 			'params'=>array( 'size'=>100, 'hold'=>'Description' ) ),
					  
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 																							 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'Порядковый номер'		=>	array( 'type'=>'number', 	'field'=>'order_id' )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editPrivacy", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования Privacy #$item_id</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>