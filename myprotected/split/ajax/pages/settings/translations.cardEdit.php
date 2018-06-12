<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'translate_edit' );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getTranslationsItem($item_id, $lpx);

	$langs = $zh->getAvailableLangs();
	$lpx_name = ($lpx ? $lpx : 'en');

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 'LPX'		=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ),
					 'Страница'			=>	array( 'type'=>'input', 	'field'=>'page', 			'params'=>array( 'size'=>100, 'hold'=>'Translate', 'disabled'=>true ) ),
					 'clear-1'				=>	array( 'type'=>'clear' ),

					 'Перевод '.strtoupper($lpx_name)			=>	array( 'type'=>'input', 	'field'=>'text', 			'params'=>array( 'size'=>100, 'hold'=>'Translate '.$lpx_name ) )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editTranslate", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования перевода #$item_id</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>