<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getFaqItem($item_id);
	$tags = $zh->getFaqItemTags();

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'Question'				=>	array( 'type'=>'area', 		'field'=>'question', 		'params'=>array( 'size'=>100, 'hold'=>'Question' ) ),
		'clear-1'				=>	array( 'type'=>'clear' ),
		'Answer'				=>	array( 'type'=>'area', 	'field'=>'answer', 			'params'=>array( 'size'=>100, 'hold'=>'Answer' ) ),
		'clear-2'				=>	array( 'type'=>'clear' ),
		'Related tags'					=>	array( 'type'=>'select_multiple', 	'field'=>'tags', 		'params'=>array( 
																											'selected'=>[],
																											'elements'=>$tags, 
																											'name_key'=>'name', 
					 																						'value_key'=>'id', 
					 																						'selected_key'=>'id',
																										) 
		),		
		'Publication'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
		'Order number'			=>	array( 'type'=>'number', 	'field'=>'order_id' )
	);

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createFAQ", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>NEW FAQ</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>