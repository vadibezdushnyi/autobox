<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'contact-message' );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getSupportMessageItem($item_id);

	$rootPath = "../../../../..";
	
	$statuses = array(
					array('id'=>0,'name'=>'Не отвечено'),
					array('id'=>1,'name'=>'Отвечено')
					);
	
	$cardTmp = array(
	 	'Email'				=>	array( 'type'=>'input', 		'field'=>'email', 					'params'=>array( 'size'=>50, 'hold'=>'email', 'disabled'=>false, 'value'=>$cardItem['email'] ) ),
	 	'Name'				=>	array( 'type'=>'input', 		'field'=>'name', 					'params'=>array( 'size'=>50, 'hold'=>'name', 'disabled' =>false, 'value'=>$cardItem['name']) ),
	 	'Created at'		=>	array( 'type'=>'input', 		'field'=>'dateCreate', 				'params'=>array( 'size'=>50, 'hold'=>'email', 'disabled'=>true, 'value'=>$cardItem['dateCreate'] ) ),
	 	'clear-1'			=>	array( 'type'=>'clear' ),
	 	'Message'			=>	array( 'type'=>'area', 			'field'=>'message', 				'params'=>array( 'size'=>50, 'disabled'=>true, 'value'=>$cardItem['message']) ), 
	 	'clear-2'			=>	array( 'type'=>'clear' ),
	 	'Reply'				=>	array( 'type'=>'area', 			'field'=>'reply', 					'params'=>array( 'size'=>50, 'hold'=>'Your reply' ) ),
	 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editContactMessage", 'ajaxFolder'=>'edit', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>MESSAGE #$item_id REPLY</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>