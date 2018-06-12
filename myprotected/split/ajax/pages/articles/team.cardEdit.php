<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$lang_fields = array(
		'question',
		'answer',
	);

	$cardItem = $zh->getTeamItem($item_id, $lpx);
	$languages = $zh->getAcceptedLanguages($lpx);
	$rootPath = ROOT_PATH;

	$langs = $zh->getAvailableLangs();
	$lpx_name = strtoupper($lpx ? $lpx : DEF_LANG);

	$cardTmp = array(
		'LPX'							=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ), 
		'Publication'					=>	array( 'type'=>'block', 	'field'=>'block', 		'params'=>array( 'reverse'=>true ) ),
		'Support'						=>	array( 'type'=>'block', 	'field'=>'support', 		'params'=>array( 'reverse'=>false ) ),
		'clear-0'						=>	array( 'type'=>'clear' ),
		'Type'							=>	array( 'type'=>'select', 	'field'=>'type', 		'params'=>array( 
																									'list'=>[['id'=>1,'name'=>'Management'],['id'=>2,'name'=>'Other']],
 																									'fieldValue'=>'id', 
																									'fieldTitle'=>'name',
																									'currValue'=>$cardItem['type'],
																								) ),	
		'Display number'					=>	array( 'type'=>'number', 	'field'=>'order_id' ),
		'clear-5'						=>	array( 'type'=>'clear' ),
		'['.$lpx_name.'] '.'Name'		=>	array( 'type'=>'input', 	'field'=>'name', 		'params'=>array( 'size'=>100, 'hold'=>'full name' ) ),
		'['.$lpx_name.'] '.'Position'	=>	array( 'type'=>'input', 	'field'=>'position', 	'params'=>array( 'size'=>100, 'hold'=>'current position' ) ),
		'clear-2'						=>	array( 'type'=>'clear' ),
		'Phone 1'						=>	array( 'type'=>'input', 	'field'=>'phone_1', 	'params'=>array( 'size'=>28, 'hold'=>'phone' ) ),
		'Phone 2'						=>	array( 'type'=>'input', 	'field'=>'phone_2', 	'params'=>array( 'size'=>27, 'hold'=>'phone' ) ),
		'Phone 3'						=>	array( 'type'=>'input', 	'field'=>'phone_3', 	'params'=>array( 'size'=>27, 'hold'=>'phone' ) ),
		'Fax'							=>	array( 'type'=>'input', 	'field'=>'fax', 		'params'=>array( 'size'=>27, 'hold'=>'fax' ) ),
		'Email'							=>	array( 'type'=>'input', 	'field'=>'email', 		'params'=>array( 'size'=>27, 'hold'=>'email' ) ),
		'Skype'							=>	array( 'type'=>'input', 	'field'=>'sk_link', 	'params'=>array( 'size'=>28, 'hold'=>'skype' ) ),
		'clear-4'						=>	array( 'type'=>'clear' ),
		'Languages'						=>	array( 'type'=>'select_multiple', 	'field'=>'languages', 	'params'=>array( 
																											'selected'=>$cardItem['languages'],
																											'elements'=>$languages, 
																											'name_key'=>'name', 
					 																						'value_key'=>'value', 
					 																						'selected_key'=>'name', 
																										) ),
		'Socials'			=> 	array( 'type'=>'header' ),
		'Facebook'			=>	array( 'type'=>'input', 	'field'=>'fb_link', 	'params'=>array( 'size'=>100, 'hold'=>'https://network.com/account_id' ) ),
		'Twitter'			=>	array( 'type'=>'input', 	'field'=>'tw_link', 	'params'=>array( 'size'=>100, 'hold'=>'https://network.com/account_id' ) ),
		'Instagram'			=>	array( 'type'=>'input', 	'field'=>'ins_link', 	'params'=>array( 'size'=>100, 'hold'=>'https://network.com/account_id' ) ),
		'Linked In'			=>	array( 'type'=>'input', 	'field'=>'in_link', 	'params'=>array( 'size'=>100, 'hold'=>'https://network.com/account_id' ) ),
		'Image'				=>	array( 'type'=>'header'),
	 	'File'				=>	array( 'type'=>'image_mono','field'=>'cover', 			'params'=>array( 'path'=>FILESROOT."/img/content/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
	 	'Image current'		=>	array( 'type'=>'hidden',	'field'=>'curr_filename', 	'params'=>array( 'field'=>"cover" ) ),
	 );

	$cardEditFormParams = array( 
		'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editTeamMember", 'ajaxFolder'=>'edit', 
		'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs  
	);
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>TEAM MEMBER #$item_id EDIT</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>