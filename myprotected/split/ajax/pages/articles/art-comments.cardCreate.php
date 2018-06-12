<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getArticleCommentItem($item_id);

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 'Имя'					=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>50, 'hold'=>'Name', 'onchange'=>"" ) ),
					 
					 'Рейтинг (1-5)'				=>	array( 'type'=>'input', 	'field'=>'rating', 			'params'=>array( 'size'=>15, 'hold'=>'Name', 'onchange'=>"" ) ),
					 
					 'Публикация'				=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'Clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Заголовок'				=>	array( 'type'=>'input', 	'field'=>'caption', 		'params'=>array( 'size'=>75, 'hold'=>'Title', 'onchange'=>"" ) ),
					 
					 'Комментарий к статье'		=>	array( 'type'=>'area', 		'field'=>'comment', 		'params'=>array( 'size'=>50, 'hold'=>'Comment' ) ),
					 
					 'Clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'ID пользователя ('.$cardItem['user_email'].')'			=>	array( 'type'=>'input', 	'field'=>'user_id', 			'params'=>array( 'size'=>50, 'hold'=>'USER ID', 'onchange'=>"" ) ),
					 
					 'ID статьи('.$cardItem['prod_name'].')'				=>	array( 'type'=>'input', 	'field'=>'art_id', 			'params'=>array( 'size'=>50, 'hold'=>'ARTICLE ID', 'onchange'=>"" ) )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createArticleComment", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания отзыва к статье".((isset($params['copyItem']) && $params['copyItem'] > 0) ? "(Дубликат карточки #".$params['copyItem'].")" : "")."</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>