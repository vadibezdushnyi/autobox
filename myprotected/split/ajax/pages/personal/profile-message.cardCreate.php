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
					 
					 'Пользователь'			=>	array( 'type'=>'autocomplete', 	'field'=>'user_select', 			'params'=>array( 'size'=>50, 'hold'=>'Начните вводить имя пользователя', 
					 																										'value'=>"" ) ),
					 
					 'Имя'					=>	array( 'type'=>'input', 		'field'=>'client_name', 			'params'=>array( 'size'=>25, 'hold'=>'Name', 'disabled'=>true ) ),
					 
					 'Фамилия'				=>	array( 'type'=>'input', 		'field'=>'client_fname', 			'params'=>array( 'size'=>25, 'hold'=>'Last name', 'disabled' =>true) ),
					 
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Сообщение'	=>	array( 'type'=>'area', 			'field'=>'message', 				'params'=>array( 'size'=>50, 'hold'=>'Your message' ) ),
					 
					 'Вложение'			=>	array( 'type'=>'header'),
					 
					 'Вложенный файл'=>	array( 'type'=>'image_mono','field'=>'file', 			'params'=>array( 'path'=>"/split/files/dialogs/", 'appTable'=>$appTable, 'id'=>$item_id ) )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createDialog", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Создание диалога</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>