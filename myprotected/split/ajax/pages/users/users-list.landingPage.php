<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getLandingHeader($headParams);
	
	// Get page items
	
	$itemsList = $zh->getAllUsers($params);

	$totalItems = $zh->getAllUsers($params,true);
	
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
	
	// Get Users Types
	
	$usersTypes		= $zh->getUsersTypes();
	
	// Prepare arrays for filter
	
	$usersTypesFilter = array();
	foreach($usersTypes as $usersType)
	{
		$usersTypesFilter[$usersType['name']]=$usersType['id'];
	}
	
	// Filter arrays

	$filter1_options = array( 'По имени'=>'M.name','По ID'=>'M.id','По Email'=>'M.login' );
	
	$filter2_options = array( 
							'Публикация' => array( 'fieldName'=>'M.block', 'params' => array('Да'=>'0', 'Нет'=>'1') ),
							'Группа'   => array( 'fieldName'=>'M.type', 'params' => $usersTypesFilter )  
							);
							
	$filter3_options = array( 
							'sort' => array( 'ID'=>'id', 'Name'=>'name'),
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
						  'Checkbox'		=>	array('type'=>'checkbox',	'field'=>''),
						  'Name'			=>	array('type'=>'text',		'field'=>'name',				'params'=>array( 'secondField'=>'lname', 'separate'=>" " ) ),
						  'Users group'		=>	array('type'=>'text',		'field'=>'type_name'),
						  'Publish'	=>	array('type'=>'block',		'field'=>'block', 				'params'=> ['reverse'=>false]),
						  'Activity'	=>	array('type'=>'text',		'field'=>'active',				'params'=>array( 'replace'=>array( '0'=>'Not active','1'=>'Active') ) ),
						  'Created at'		=>	array('type'=>'date',		'field'=>'dateCreate', 			'params'=>array( ) ),
						  'View'			=>	array('type'=>'cardView',	'field'=>'View'),
						  'Edit'			=>	array('type'=>'cardEdit',	'field'=>'Edit'),
						  'ID'				=>	array('type'=>'text',		'field'=>'id')
						  );
	
	$tableParams = array( 'itemsList'=>$itemsList, 'tableColumns'=>$tableColumns, 'headParams'=>$headParams );
	
	$tableStr = $zh->getItemsTable($tableParams);
	
	// START PAGINATION
	
	$pagiParams = array( 'headParams'=>$headParams, 'start_page'=>$start_page, 'pages'=>$pages, 'on_page'=>$on_page );
	
	$pagiStr = $zh->getLandingPagination($pagiParams);
	
	// Join Content
	
	$data['bodyContent'] = $filterFormStr;
	
	$data['bodyContent'] .= $tableStr;
	
	$data['bodyContent'] .= $pagiStr;

?>