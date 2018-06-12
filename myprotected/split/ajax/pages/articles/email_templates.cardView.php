<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getTemplateInfo($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
        'ID'				=>	array('type'=>'text',		'field'=>'id'),
        'Template name'	    =>	array('type'=>'text',		'field'=>'name'),
        'Sender'			=>	array('type'=>'text',		'field'=>'email_from'),
        'Letter subkect'   	=>	array('type'=>'text',		'field'=>'subject'),
        'Letter body'		=>	array('type'=>'text',		'field'=>'body'),
    );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>TEMPLATE #$item_id VIEW</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>