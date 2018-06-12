<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'us_data' );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getUserData($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 			'params'=>array() ),
					 'Email'					=>	array( 'type'=>'text', 		'field'=>'email', 			'params'=>array() ),
					 'IP'					=>	array( 'type'=>'text', 		'field'=>'ip', 			'params'=>array() ),
					 'User Agent'					=>	array( 'type'=>'text', 		'field'=>'agent', 			'params'=>array() ),
					 
					 
					 'Дата регистрации'		=>	array( 'type'=>'date', 		'field'=>'date_created', 		'params'=>array( ) )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр карточки пользователя</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>