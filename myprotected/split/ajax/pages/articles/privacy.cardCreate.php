<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'privacy_h' );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$available_languages = $zh->getAvailableLangs();
	$cardItem = $zh->getPrivacyItem($item_id);

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					  'Заголовок'				=>	array( 'type'=>'input', 		'field'=>'q', 		'params'=>array( 'size'=>100, 'hold'=>'Caption' ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Описание'				=>	array( 'type'=>'redactor', 	'field'=>'a', 			'params'=>array( 'size'=>100, 'hold'=>'Description' ) ),
					  
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 																							 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'Порядковый номер'		=>	array( 'type'=>'number', 	'field'=>'order_id' ),
					 'av_langs' 			=>	array( 'type'=>'post_array', 		'field'=>'av_langs', 	'params'=>array('arr_field' =>  json_encode($available_languages) ) )
					 
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createPrivacy", 'ajaxFolder'=>'create', 'appTable'=>$appTable , 'lang_fields'=>$lang_inputs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания элемента Privacy</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>