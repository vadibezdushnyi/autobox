<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'support_message');
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getSupportMessageItem($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
						  'ID'				=>	array('type'=>'text',		'field'=>'id'),
						  'Name'		=>	array('type'=>'text',		'field'=>'name' ),
						  'Email'			=>	array('type'=>'text',		'field'=>'email'),
						  'Message'		=>	array('type'=>'text',		'field'=>'message'),
						  'Created at'		=>	array('type'=>'date',		'field'=>'dateCreate', 		'params'=>array( 'format'=>'d-m-Y', 'function'=>'long') ),
						  'Status'			=>	array('type'=>'text',		'field'=>'answered', 		'params'=>array( 'replace'=>(array('0'=>'Not replied','1'=>'Replied')) ) ),
						  'Reply'			=>	array('type'=>'text',		'field'=>'reply'),
						  'Replied at'		=>	array('type'=>'date',		'field'=>'dateReply', 		'params'=>array( 'format'=>'d-m-Y', 'function'=>'long') )

					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>MESSAGE #$item_id VIEW</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>