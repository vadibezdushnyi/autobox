<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getDirectorTaskItem($item_id);

	$rootPath = "../../../../..";
	
	$statuses = array(
					array('id'=>0,'name'=>'Не выполнено'),
					array('id'=>1,'name'=>'На ревизии'),
					array('id'=>2,'name'=>'Выполнено'),
					);
	
	$cardTmp = array(
					 
					 'Клиент ID'			=>	array( 'type'=>'hidden', 		'field'=>'user_id' ),
					 
					 'Ответственный'		=>	array( 'type'=>'autocomplete', 	'field'=>'user_select', 			'params'=>array( 'size'=>50, 'hold'=>'User name/email', 
					 																										'value'=>$cardItem['responsible_name']." ".$cardItem['responsible_name'] ) ),
					 
					 'Имя'					=>	array( 'type'=>'input', 		'field'=>'client_name', 			'params'=>array( 'size'=>25, 'hold'=>'Name', 'disabled'=>true, 'value'=>$cardItem['responsible_name'] ) ),
					 
					 'Фамилия'				=>	array( 'type'=>'input', 		'field'=>'client_fname', 			'params'=>array( 'size'=>25, 'hold'=>'Last name', 'disabled' =>true, 'value'=>$cardItem['responsible_fname']) ),
					 
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Тема задания'			=>	array( 'type'=>'input', 		'field'=>'subject', 				'params'=>array( 'size'=>50, 'hold'=>'Заголовок', 'disabled'=>false ) ),
					 
					 'Дедлайн'				=>	array( 'type'=>'date', 			'field'=>'date_finish', 			'params'=>array( ) ),
					 
					 'Статус'				=>	array( 'type'=>'select', 		'field'=>'status', 					'params'=>array( 'list'=>$statuses, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['status'], 
																														 'onChange'=>"" 
																														 ) ),
					 
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'Сообщение'	=>	array( 'type'=>'area', 					'field'=>'comment', 				'params'=>array( 'size'=>50, 'hold'=>'Текст задания' ) ),
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editTask", 'ajaxFolder'=>'edit', 'appTable'=>'tasks' );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования задания</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>