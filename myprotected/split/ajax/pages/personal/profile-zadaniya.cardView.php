<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'TaskProfile' );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getDirectorTaskItem($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Тип задачи'			=>	array( 'type'=>'text', 		'field'=>'type', 			'params'=>array( 'replace'=>(array('1'=>'Задание администратора')) ) ),
					 'Дедлайн'				=>	array( 'type'=>'date', 		'field'=>'date_finish', 	'params'=>array( ) ),
					 'ID'					=>	array( 'type'=>'text', 		'field'=>'id' ),
					 'Постановщик'			=>	array( 'type'=>'text', 		'field'=>'author_name', 	'params'=>array( 'secondField'=>'author_fname', 'separate'=>" " ) ),
					 'Ответственный'		=>	array( 'type'=>'text', 		'field'=>'responsible_name','params'=>array( 'secondField'=>'responsible_fname', 'separate'=>" " ) ),
					 'Статус'				=>	array( 'type'=>'text',		'field'=>'status',			'params'=>array( 'replace'=>(array('0'=>'Не выполнено','1'=>'На ревизии','2'=>'Выполнено')) ) ),
					 'Заголовок'			=>	array( 'type'=>'text', 		'field'=>'subject' ),
					 'Содержание'			=>	array( 'type'=>'text', 		'field'=>'comment' ),
					 
					 'Дата назначения'		=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array( ) ),
					 'Дата редактирования'	=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array( ) )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр задания</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>