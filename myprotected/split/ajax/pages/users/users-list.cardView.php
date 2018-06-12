<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getUserInfo($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'ID'				=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Nickname'			=>	array( 'type'=>'text', 		'field'=>'name', 			'params'=>array() ),
					 'First name'		=>	array( 'type'=>'text', 		'field'=>'fname', 			'params'=>array() ),
					 'Last name'		=>	array( 'type'=>'text', 		'field'=>'lname', 			'params'=>array() ),
					 'Avatar'			=>	array( 'type'=>'image',		'field'=>'avatar',			'params'=>array( 'path'=>'/split/files/users/' ) ),
					 'Email'			=>	array( 'type'=>'text', 		'field'=>'email', 			'params'=>array() ),
					 'Login'			=>	array( 'type'=>'text', 		'field'=>'login', 			'params'=>array() ),
					 'Phone number'		=>	array( 'type'=>'text', 		'field'=>'phone', 			'params'=>array() ),
					 'Publish'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Yes', '1'=>'No') ) ),
					 'Activity'			=>	array( 'type'=>'text', 		'field'=>'active', 			'params'=>array( 'replace'=>array('0'=>'Not activated', '1'=>'Activated') ) ),
					 'Gender'			=>	array( 'type'=>'text', 		'field'=>'male', 			'params'=>array( 'replace'=>array('M'=>'Male', 'F'=>'Female') ) ),
					 //'Дочерние элементы'	=>	array( 'type'=>'arr_mult',	'field'=>'childs', 			'params'=>array( 'field'=>'name','link'=>array('parent'=>$parent,'alias'=>$alias,'id'=>$id,'item_id'=>1,'params'=>'{}') ) ),
					 'Users group'		=>	array( 'type'=>'arr_mono', 	'field'=>'typeInfo', 		'params'=>array( 'field'=>'name' ) ),
					 'Birth date'		=>	array( 'type'=>'date', 		'field'=>'birthday', 		'params'=>array( ) ),
					 
					 
					 
					 'Registered at'	=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array( ) ),
					 'Edited at'		=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array( ) )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>USER #$item_id VIEW</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>