<?php 
// Start header content

$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );

$data['headContent'] = $zh->getCardCreateHeader($headParams);

// Start body content

$cardItem = $zh->getAllTemplates($item_id);

$rootPath = "../../../../..";

$cardTmp = array(
    'Template name'         =>  array( 'type'=>'input',         'field'=>'name',        'params'=>array( 'size'=>50) ),
    'clear-3'                   =>  array( 'type'=>'clear' ),
    'Sender'		    =>	array( 'type'=>'input', 		'field'=>'email_from', 	'params'=>array( 'size'=>50)),
    'clear-1'                   =>  array( 'type'=>'clear' ),
    'Letter subject'        =>  array( 'type'=>'input',         'field'=>'subject',     'params'=>array( 'size'=>100) ),
    'clear-2'                   =>  array( 'type'=>'clear' ),
    'Letter body'           =>  array( 'type'=>'redactor',      'field'=>'body',        'params'=>array( 'size'=>50) ),
);

$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createETemplate", 'ajaxFolder'=>'create', 'appTable'=>$appTable );

$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);

// Join content

$data['bodyContent'] .= "
    <div class='ipad-20' id='order_conteinter'>
        <h3 class='new-line'>NEW TEMPLATE</h3>";

$data['bodyContent'] .= $cardEditFormStr;

$data['bodyContent'] .=	"
    </div>
";

?>