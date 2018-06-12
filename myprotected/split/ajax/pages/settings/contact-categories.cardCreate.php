<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	$available_languages = $zh->getAvailableLangs();
	
	// Start body content
	
	$cardItem = $zh->getContactCatsItem($item_id);

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					  'Название'				=>	array( 'type'=>'input', 		'field'=>'name', 		'params'=>array( 'size'=>100, 'hold'=>'Название' ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),

					 																							 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'Порядковый номер'		=>	array( 'type'=>'number', 	'field'=>'order_id' ),

					 'av_langs' 			=>	array( 'type'=>'post_array', 		'field'=>'av_langs', 	'params'=>array('arr_field' =>  json_encode($available_languages) ) )
					 
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createContactCat", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания категории контактной формы</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>