<?php 
	// Start header content
	
	$cardItem = array();
	
	$headOrderParams = array('confirm'=>false,'cancel'=>false);
	
	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'messages', 'params'=>$headOrderParams );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 
					 'Клиент ID'			=>	array( 'type'=>'hidden', 		'field'=>'user_id' ),
					 
					 'Ответственный'		=>	array( 'type'=>'autocomplete', 	'field'=>'user_select', 			'params'=>array( 'size'=>50, 'hold'=>'Начните вводить Имя или E-mail', 
					 																										'value'=>"" ) ),
					 
					 'Имя'					=>	array( 'type'=>'input', 		'field'=>'client_name', 			'params'=>array( 'size'=>25, 'hold'=>'Name', 'disabled'=>true ) ),
					 
					 'Фамилия'				=>	array( 'type'=>'input', 		'field'=>'client_fname', 			'params'=>array( 'size'=>25, 'hold'=>'Last name', 'disabled' =>true) ),
					 
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Тема задания'			=>	array( 'type'=>'input', 		'field'=>'title', 					'params'=>array( 'size'=>50, 'hold'=>'Заголовок', 'disabled'=>false ) ),
					 
					 'Дедлайн'				=>	array( 'type'=>'date', 			'field'=>'date_finish', 			'params'=>array( ) ),
					 
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'Суть задания'			=>	array( 'type'=>'area', 					'field'=>'message', 				'params'=>array( 'size'=>50, 'hold'=>'Текст задания' ) ),
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createTask", 'ajaxFolder'=>'create', 'appTable'=>'tasks' );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Новое задание</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>