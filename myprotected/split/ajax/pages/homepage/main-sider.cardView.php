<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams, $lpx);
	$pref = ($lpx ? $lpx.'_' : '');
	
	// Start body content
	
	$cardItem = $zh->getBannerItem($item_id, $lpx);
	$langs = $zh->getAvailableLangs();

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 'ID'						=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Name'						=>	array( 'type'=>'text', 		'field'=>'name', 		'params'=>array() ),
					 'Text'						=>	array( 'type'=>'text', 		'field'=>$pref.'data', 		'params'=>array() ),
					 'Position'					=>	array( 'type'=>'text', 		'field'=>'order_id', 		'params'=>array() ),
					 'Image'					=>	array( 'type'=>'image',		'field'=>'file',			'params'=>array( 'path'=>FILESROOT.'/img/content/' ) ),
					 'Publication'				=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Yes', '1'=>'No') ) ),
					 //'Alias'					=>	array( 'type'=>'text', 		'field'=>'alias', 			'params'=>array() ),
					 //'Link'					=>	array( 'type'=>'text', 		'field'=>'link', 			'params'=>array() ),
					 //'New tab?'	=>	array( 'type'=>'text', 		'field'=>'target', 			'params'=>array( 'replace'=>array('0'=>'Нет', '1'=>'Да') ) ),
					 'Date Create'			=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array() ),
					 //'Alt '.$lpx						=>	array( 'type'=>'text', 		'field'=>$pref.'alt', 			'params'=>array() ),
					 //'Title '.$lpx					=>	array( 'type'=>'text', 		'field'=>$pref.'title', 			'params'=>array() ),
					 'Date Modify'		=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array() )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Detailed view of banner #$item_id</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>