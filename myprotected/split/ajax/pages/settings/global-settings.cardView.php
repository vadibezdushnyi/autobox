<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'global-settings' );
	$data['headContent'] = $zh->getCardViewHeader($headParams, $lpx);
	$pref = ($lpx ? $lpx.'_' : '');
	$lpx_name = strtoupper($lpx ? $lpx : DEF_LANG);
	// Start body content
	
	$cardItem = $zh->getSiteConfigs($item_id, $lpx);

	$langs = $zh->getAvailableLangs();


	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 'Site domain'			=>	array( 'type'=>'text', 		'field'=>'sitename', 		'params'=>array() ),
					 'Support email'		=>	array( 'type'=>'text', 		'field'=>'support_email', 	'params'=>array() ),
					 'Phone 1'				=>	array( 'type'=>'text', 		'field'=>'phone_number', 	'params'=>array() ),
					 'Address'				=>	array( 'type'=>'text', 		'field'=>'address', 		'params'=>array() ),
					 'Skype'				=>	array( 'type'=>'text', 		'field'=>'sk_link', 		'params'=>array() ),
					 'Facebook'				=>	array( 'type'=>'text', 		'field'=>'fb_link', 		'params'=>array() ),
					 'Google+'				=>	array( 'type'=>'text', 		'field'=>'gp_link', 		'params'=>array() ),
					 'Twitter'				=>	array( 'type'=>'text', 		'field'=>'tw_link', 		'params'=>array() ),
					 'Youtube'				=>	array( 'type'=>'text', 		'field'=>'yt_link', 		'params'=>array() ),
					 'LinkedIn'				=>	array( 'type'=>'text', 		'field'=>'in_link', 		'params'=>array() ),
					 'Instagram'			=>	array( 'type'=>'text', 		'field'=>'ins_link', 		'params'=>array() ),
					 '['.$lpx_name.'] '.'Seo fallbacks title'		=>	array( 'type'=>'text', 		'field'=>$pref.'meta_title', 		'params'=>array() ),
					 '['.$lpx_name.'] '.'Seo fallbacks keywords'	=>	array( 'type'=>'text', 		'field'=>$pref.'meta_keys', 		'params'=>array() ),
					 '['.$lpx_name.'] '.'Seo fallbacks description'	=>	array( 'type'=>'text', 		'field'=>$pref.'meta_desc', 		'params'=>array() ),
					 'Site indexing'		=>	array( 'type'=>'text', 		'field'=>'index', 			'params'=>array( 'replace'=>array('1'=>'Yes', '0'=>'No') ) ),
					 'Edited at'			=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array() )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>SITE GLOBAL SETTING (VIEW MODE)</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>