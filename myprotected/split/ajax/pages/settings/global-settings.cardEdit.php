<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'global-settings' );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getSiteConfigs($item_id, $lpx);

	$langs = $zh->getAvailableLangs();
	$lpx_name = strtoupper($lpx ? $lpx : DEF_LANG);

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					'LPX'		=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ),
					 'Site domain'			=>	array( 'type'=>'input', 	'field'=>'sitename', 			'params'=>array( 'size'=>50, 'hold'=>'Sitename', 'onchange'=>"change_alias();" ) ),
					 'Support email'		=>	array( 'type'=>'input', 	'field'=>'support_email', 		'params'=>array( 'size'=>50, 'hold'=>'Email' ) ),
					 'Address'				=>	array( 'type'=>'input', 	'field'=>'address', 			'params'=>array( 'size'=>50, 'hold'=>'Karl-Ferdinand-Braun-Str. 2550170 Kerpen, Germany' ) ),
					 'clear4'				=>	array( 'type'=>'clear' ),
					 'Phone number'			=>	array( 'type'=>'input', 	'field'=>'phone_number', 			'params'=>array( 'size'=>50, 'hold'=>'(000) 000 00 00' ) ),
					 'clear'				=>	array( 'type'=>'clear' ),
					 'Socials'				=>	array( 'type'=>'header'),
					 'Facebook'				=>	array( 'type'=>'input', 	'field'=>'fb_link', 			'params'=>array( 'size'=>100, 'hold'=>'https://your.social' ) ),
					 'Twitter'				=>	array( 'type'=>'input', 	'field'=>'tw_link', 			'params'=>array( 'size'=>100, 'hold'=>'https://your.social' ) ),
					 'Youtube'				=>	array( 'type'=>'input', 	'field'=>'yt_link', 			'params'=>array( 'size'=>100, 'hold'=>'https://your.social' ) ),
					 'LinkedIn'				=>	array( 'type'=>'input', 	'field'=>'in_link', 			'params'=>array( 'size'=>100, 'hold'=>'https://your.social' ) ),
					 'Instagram'			=>	array( 'type'=>'input', 	'field'=>'ins_link', 			'params'=>array( 'size'=>100, 'hold'=>'https://your.social' ) ),
					 'Skype'				=>	array( 'type'=>'input', 	'field'=>'sk_link', 			'params'=>array( 'size'=>100, 'hold'=>'account name' ) ),

					 'Global seo settings'	=>	array( 'type'=>'header'),
					 'Site indexing'		=>	array( 'type'=>'block', 	'field'=>'index', 				'params'=>array( 'reverse'=>false ) ),
					 'clear2'				=>	array( 'type'=>'clear' ),
					 '['.$lpx_name.'] '.'Fallbacks title'		=>	array( 'type'=>'input', 	'field'=>'meta_title', 			'params'=>array( 'size'=>100, 'hold'=>'Title', 'onchange'=>"" ) ),
					 'clear3'				=>	array( 'type'=>'clear' ),
					 '['.$lpx_name.'] '.'Fallbacks keywords'	=>	array( 'type'=>'area', 		'field'=>'meta_keys', 			'params'=>array( 'size'=>100, 'hold'=>'Keywords', 'onchange'=>"" ) ),
					 '['.$lpx_name.'] '.'Fallbacks description'=>	array( 'type'=>'area', 		'field'=>'meta_desc', 			'params'=>array( 'size'=>100, 'hold'=>'Description' ) ),

					 'Additional scripts'	=>	array( 'type'=>'header'),
					 'Head scripts'			=>	array( 'type'=>'area', 		'field'=>'afterHead', 			'params'=>array( 'size'=>100, 'hold'=>'<script>...</script>', 'onchange'=>"" ) ),
					 'Body scripts'			=>	array( 'type'=>'area', 		'field'=>'afterBody', 			'params'=>array( 'size'=>100, 'hold'=>'<script>...</script>', 'onchange'=>"" ) )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editSiteConfig", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>SITE GLOBAL SETTING (EDIT MODE)</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>