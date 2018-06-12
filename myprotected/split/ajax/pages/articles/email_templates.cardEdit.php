<?php
// Start header content

$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable);

$data['headContent'] = $zh->getCardEditHeader($headParams);

// Start body content

$cardItem = $zh->getTemplateInfo($item_id, $lpx);
$langs = $zh->getAvailableLangs();
$lpx_name = strtoupper($lpx ? $lpx : 'en');

$rootPath = "../../../../..";

$cardTmp = array(
    'LPX'      =>  array( 'type'=>'hidden',    'field'=>'lpx', 'value'=>$lpx ),
    'Name'                  =>  array( 'type'=>'hidden',        'field'=>'name' ),
    'Template name'         =>  array( 'type'=>'input',         'field'=>'name',        'params'=>array( 'size'=>50, 'disabled'=>true) ),
    'clear-3'                   =>  array( 'type'=>'clear' ),
    'Sender'                =>  array( 'type'=>'input',         'field'=>'email_from',  'params'=>array( 'size'=>50)),
    'clear-1'                   =>  array( 'type'=>'clear' ),
    '['.$lpx_name.']'.' Letter subject'        =>  array( 'type'=>'input',         'field'=>'subject',     'params'=>array( 'size'=>100) ),
    'clear-2'                   =>  array( 'type'=>'clear' ),
    '['.$lpx_name.']'.' Letter body'            =>  array( 'type'=>'redactor',      'field'=>'body',        'params'=>array( 'size'=>50) ),
);

$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editETemplate", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );

$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);

// Join content

$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>TEMPLATE #$item_id EDIT</h3>";

$data['bodyContent'] .= $cardEditFormStr;

$data['bodyContent'] .=	"
		</div>
	";

?>