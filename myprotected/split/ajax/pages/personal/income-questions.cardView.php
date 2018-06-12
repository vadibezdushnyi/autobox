<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'serv_orders_view' );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getQuestionItem($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'ID'						=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Имя'					=>	array( 'type'=>'text', 		'field'=>'name', 		'params'=>array() ),
					 'Email'					=>	array( 'type'=>'text', 		'field'=>'email', 			'params'=>array() ),
					 'Категория'					=>	array( 'type'=>'text', 		'field'=>'cat_name', 			'params'=>array() ),
					 /*'Phone'			=>	array( 'type'=>'text', 		'field'=>'phone', 		'params'=>array() ),*/
					 'Сообщение'				=>	array( 'type'=>'text', 		'field'=>'message', 			'params'=>array() ),
					 'Дата создания'			=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array() )/*
					 'Дата редактирования'		=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array() )*/
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр вопроса #$item_id</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>