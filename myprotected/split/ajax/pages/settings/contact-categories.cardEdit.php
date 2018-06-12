<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getContactCatsItem($item_id, $lpx);

	$langs = $zh->getAvailableLangs();
	$lpx_name = ($lpx ? $lpx : 'en');

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					'LPX'		=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ),

					 'Название '.strtoupper($lpx_name)				=>	array( 'type'=>'input', 		'field'=>'name', 		'params'=>array( 'size'=>100, 'hold'=>'Название '.strtoupper($lpx_name) ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),

					 																							 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'Порядковый номер'		=>	array( 'type'=>'number', 	'field'=>'order_id' )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editContactCat", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования категории контактной формы</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>