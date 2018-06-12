<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'appTable'=>$appTable, 'type'=>'tasks' );
	
	$data['headContent'] = $zh->getLandingHeader($headParams);
	
	// Get page items
	
	$itemsList = $zh->getAllDirectorTasks($params);

	$totalItems = $zh->getAllDirectorTasks($params,true);
	
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

	$filter1_options = array( 'По ID'=>'M.id','По тексту'=>'T.comment','По E-mail'=>'U.login' );
	
	$filter2_options = array( 
							'Статус' => array( 'fieldName'=>'T.status', 'params' => array('Не выполнено'=>'0','На ревизии'=>'1','Выполнено'=>'2') ) 
							);
							
	$filter3_options = array( 
							'sort' => array( 'ID'=>'id', 'Дате создания'=>'T.dateCreate', 'Дедлайну'=>'T.date_finish', 'Постановщику'=>'M.admin_id', 'Ответственным'=>'M.responsible_id', 'Статусу'=>'T.status' ),
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
						  'Checkbox'			=>	array('type'=>'checkbox',	'field'=>''),
						  //'Тип задачи'				=>	array('type'=>'text',		'field'=>'type',			'params'=>array( 'replace'=>(array('1'=>'Задание администратора')) ) ),
						  'Описание'				=>	array('type'=>'text',		'field'=>'subject' ),
						  'Дедлайн'				=>	array('type'=>'date',		'field'=>'date_finish', 	'params'=>array( 'format'=>'d-m-Y') ),
						  'Постановщик'			=>	array('type'=>'text',		'field'=>'author_name', 	'params'=>array( 'secondField'=>'author_fname', 'separate'=>" " ) ),
						  'Ответственный'			=>	array('type'=>'text',		'field'=>'responsible_name', 'params'=>array( 'secondField'=>'responsible_fname', 'separate'=>" " ) ),
						  'Статус'				=>	array('type'=>'text',		'field'=>'status',			'params'=>array( 'replace'=>(array('0'=>'Не выполнено','1'=>'На ревизии','2'=>'Выполнено')) ) ),
						  'Создан'				=>	array('type'=>'date',		'field'=>'dateCreate', 		'params'=>array( 'format'=>'d-m-Y') ),
						  'Просмотр'				=>	array('type'=>'cardView',	'field'=>'Смотреть' )
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