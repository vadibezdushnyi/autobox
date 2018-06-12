<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'global-settings' );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getShopSettings($item_id);

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 'Email заказов'			=>	array( 'type'=>'input', 	'field'=>'order_email', 		'params'=>array( 'size'=>35, 'hold'=>'OrderEmail' ) ),
					 
					 'clear-1'					=>	array( 'type'=>'clear' ),
					 
					 'Правила использования'	=>	array( 'type'=>'redactor', 	'field'=>'terms', 				'params'=>array(  ) )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editShopSettings", 'ajaxFolder'=>'edit', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Настройки магазина (режим редактирования)</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>