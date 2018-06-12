<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams, $lpx);
	$lpx_name = ($lpx ? $lpx.'_' : '');
	
	// Start body content
	
	$cardItem = $zh->getFaqItem($item_id, $lpx);

	$langs = $zh->getAvailableLangs();

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'ID'			=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
		'Question'		=>	array( 'type'=>'text', 		'field'=>'question', 		'params'=>array() ),
		'Answer'		=>	array( 'type'=>'text', 		'field'=>'answer', 			'params'=>array() ),
		'Order number'	=>	array( 'type'=>'text', 		'field'=>'order_id', 		'params'=>array() ),
		'Publication'	=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
		'Created at'	=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array() ),
		'Edited at'		=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array() ),
	);

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'lpx'=>$lpx, 'langs'=>$langs, 'headParams'=>$headParams );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>FAQ #$item_id VIEW</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>