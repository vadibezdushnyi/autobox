<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams, $lpx);
	$lpx_name = ($lpx ? $lpx.'_' : '');
	
	// Start body content
	
	$cardItem = $zh->getTeamItem($item_id, $lpx);

	$langs = $zh->getAvailableLangs();
	$lpx_name = strtoupper($lpx ? $lpx : DEF_LANG);
	$_loc = '['.$lpx_name.'] ';
	$rootPath = ROOT_PATH;
	

	$cardTmp = array(
		'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
		'Display number'		=>	array( 'type'=>'text', 		'field'=>'order_id', 		'params'=>array() ),
		$_loc.'Name'			=>	array( 'type'=>'text', 		'field'=>'name', 			'params'=>array() ),
		$_loc.'Position'		=>	array( 'type'=>'text', 		'field'=>'position', 		'params'=>array() ),
		'Type'					=>	array( 'type'=>'text',		'field'=>'type', 			'params'=>array('replace'=>array('1'=>'Management', '2'=>'Other'))),
		'Publication'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array('replace'=>array('0'=>'Yes', '1'=>'No') ) ),
		'Support'				=>	array( 'type'=>'text',		'field'=>'support', 		'params'=>array('replace'=>array('1'=>'Yes', '0'=>'No') ) ),
		'Image'					=>	array( 'type'=>'image',		'field'=>'cover',			'params'=>array( 'path'=>FILESROOT.'/img/content/' ) ),
		'Phone 1'				=>	array( 'type'=>'text', 		'field'=>'phone_1', 		'params'=>array() ),
		'Phone 2'				=>	array( 'type'=>'text', 		'field'=>'phone_2', 		'params'=>array() ),
		'Phone 3'				=>	array( 'type'=>'text', 		'field'=>'phone_3', 		'params'=>array() ),
		'Fax'					=>	array( 'type'=>'text', 		'field'=>'fax', 		'params'=>array() ),
		'Email'					=>	array( 'type'=>'text', 		'field'=>'email', 		'params'=>array() ),
		'Facebook'				=>	array( 'type'=>'text', 		'field'=>'fb_link', 		'params'=>array() ),
		'Twitter'				=>	array( 'type'=>'text', 		'field'=>'tw_link', 		'params'=>array() ),
		'Instagram'				=>	array( 'type'=>'text', 		'field'=>'ins_link', 		'params'=>array() ),
		'Skype'					=>	array( 'type'=>'text', 		'field'=>'sk_link', 		'params'=>array() ),
		'Linked In'				=>	array( 'type'=>'text', 		'field'=>'in_link', 		'params'=>array() ),
		'Created at'			=>	array( 'type'=>'date', 		'field'=>'created', 		'params'=>array() ),
		'Edited at'				=>	array( 'type'=>'date', 		'field'=>'modified', 		'params'=>array() ),
	);

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'lpx'=>$lpx, 'langs'=>$langs, 'headParams'=>$headParams );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>TEAM MEMBER #$item_id VIEW</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>