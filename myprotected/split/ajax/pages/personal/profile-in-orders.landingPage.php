<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'appTable'=>$appTable, 'type'=>'in-orders' );
	
	$data['headContent'] = "";//$zh->getLandingHeader($headParams);
	
	// Get page items
	
	$itemsList = $zh->getAllTasks($params);

	$totalItems = $zh->getAllTasks($params,true);
	
	// Pagination operations
	
	$on_page = (isset($_COOKIE['global_on_page']) ? $_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
	
	$pages = ceil($totalItems/$on_page);
	
	$start_page = (isset($params['start']) ? $params['start'] : 1);
	
	$frst_page = 1;
	$prev_page = 1;
	$next_page = $pages;
	$last_page = $pages;
				
	if($start_page < $pages) $next_page = $start_page+1;
	if($start_page > 1) $prev_page = $start_page-1;
	
	// Filter JS open
	
	if(isset($_COOKIE['filter-1']) && $_COOKIE['filter-1']) $data['filter']['f1'] = 1;
	if(isset($_COOKIE['filter-2']) && $_COOKIE['filter-2']) $data['filter']['f2'] = 1;
	if(isset($_COOKIE['filter-3']) && $_COOKIE['filter-3']) $data['filter']['f3'] = 1;
	
	// Filter arrays

	$filter1_options = array( 'По ID'=>'M.id' );
	
	$filter2_options = array( 
							//'Publish' => array( 'fieldName'=>'M.block', 'params' => array('Yes'=>'0', 'No'=>'1') ) 
							);
							
	$filter3_options = array( 
							'sort' => array( 'ID'=>'id' ),
							'order' => array( 'По возрастанию'=>'', 'По убыванию'=>' DESC' ) 
							);
	// Start data content
	
	$filterFormParams = array(	'params'=>$params, 
								'headParams'=>$headParams, 
								'filter1_options'=>$filter1_options, 
								'filter2_options'=>$filter2_options, 
								'filter3_options'=>$filter3_options, 
								'on_page'=>$on_page 
							  );
	
	$filterFormStr = $zh->getLandingFilterForm($filterFormParams);
	
	// Table structure
	
	$tableColumns = array(
						  ''					=>	array('type'=>'firstColumn',	'field'=>''),
						  //'Checkbox'			=>	array('type'=>'checkbox',	'field'=>''),
						  //'Тип задачи'				=>	array('type'=>'text',		'field'=>'type',			'params'=>array( 'replace'=>(array('internet_shop'=>'Заказ с интернет магазина')) ) ),
						  'Номер заказа'			=>	array('type'=>'text',		'field'=>'id', 				'params'=>array( 'math'=>"+",'value'=>5000) ),
						  'Клиент'				=>	array('type'=>'text',		'field'=>'author_name', 	'params'=>array( 'secondField'=>'author_fname', 'separate'=>" " ) ),
						  'Создан'				=>	array('type'=>'date',		'field'=>'dateCreate', 		'params'=>array( 'format'=>'d-m-Y') ),
						  'Просмотр'				=>	array('type'=>'cardView',	'field'=>'Смотреть',			'params'=>array( 'type'=>'orderViewTask' ) )
						  );
	
	$tableParams = array( 'itemsList'=>$itemsList, 'tableColumns'=>$tableColumns, 'headParams'=>$headParams );
	
	$tableStr = $zh->getItemsTable($tableParams);
	
	// START PAGINATION
	
	$pagiParams = array( 'headParams'=>$headParams, 'start_page'=>$start_page, 'pages'=>$pages, 'on_page'=>$on_page );
	
	$pagiStr = $zh->getLandingPagination($pagiParams);
	
	// Join Content
	
	//$data['bodyContent'] = $filterFormStr;
	
	$data['bodyContent'] .= $tableStr;
	
	//$data['bodyContent'] .= $pagiStr;

?>