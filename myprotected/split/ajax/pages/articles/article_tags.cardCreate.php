<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'afterSubmit'=>2 );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	

	$cardItem 	= $zh->getArticleTagItem($item_id, $lpx);
	$posts 		= $zh->getTagArticles($lpx);

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'Alias'							=> 	array('type'=>'hidden', 		'field'=>'alias'),
		'[EN] Name'						=>	array('type'=>'input',			'field'=>'name', 'params'=>array('onchange'=>'change_alias();')),
		'[DE] Name'						=>	array('type'=>'input',			'field'=>'de_name'),
		'[RU] Name'						=>	array('type'=>'input',			'field'=>'ru_name'),
		'[SK] Name'						=>	array('type'=>'input',			'field'=>'sk_name'),
		'[CZ] Name'						=>	array('type'=>'input',			'field'=>'cz_name'),
		'[TR] Name'						=>	array('type'=>'input',			'field'=>'tr_name'),
		'[ES] Name'						=>	array('type'=>'input',			'field'=>'es_name'),
		'[AR] Name'						=>	array('type'=>'input',			'field'=>'ar_name'),
		'Publication'					=>	array( 'type'=>'block', 		'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
		'clear-2'				=>	array( 'type'=>'clear' ),
		'Related faq\'s'					=>	array( 'type'=>'select_multiple', 	'field'=>'posts', 	'params'=>array( 
																											'selected'=>[],
																											'elements'=>$posts, 
																											'name_key'=>'name', 
					 																						'value_key'=>'id', 
					 																						'selected_key'=>'id',					
																										) ),
	);

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createArticleTags", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>NEW TAG</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>