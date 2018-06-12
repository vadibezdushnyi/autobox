<?php 
	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'appTable'=>$appTable, 'type'=>'' ); // menuLandingHeader
	$data['headContent'] = $zh->getLandingHeader($headParams);
	
	$itemsList = $zh->getResponsesList($params);
	$totalItems = $zh->getResponsesList($params,true);
	
	// PAGI
	$on_page = (isset($_COOKIE['global_on_page']) ? $_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
	$pages = ceil($totalItems/$on_page);
	$start_page = (isset($params['start']) ? $params['start'] : 1);
	$frst_page = 1;
	$prev_page = 1;
	$next_page = $pages;
	$last_page = $pages;
	if($start_page < $pages) $next_page = $start_page+1;
	if($start_page > 1) $prev_page = $start_page-1;
	// PAGI

	if(isset($_COOKIE['filter-1']) && $_COOKIE['filter-1']) $data['filter']['f1'] = 1;
	if(isset($_COOKIE['filter-2']) && $_COOKIE['filter-2']) $data['filter']['f2'] = 1;
	if(isset($_COOKIE['filter-3']) && $_COOKIE['filter-3']) $data['filter']['f3'] = 1;
	
	$filter1_options = [];
	$filter2_options = [];
	$filter3_options = [
		'sort' 	=> ['ID'=>'id', 'Названию'=>'name'],
		'order' => ['По возрастанию'=>'', 'По убыванию'=>' DESC'],
	];
	
	$filterFormParams = [	
		'params'=>$params, 
		'headParams'=>$headParams, 
		'filter1_options'=>$filter1_options, 
		'filter2_options'=>$filter2_options, 
		'filter3_options'=>$filter3_options, 
		'on_page'=>$on_page 
	];	


	$filterFormStr = $zh->getLandingFilterForm($filterFormParams);
	
	// Table structure
	
	$tableColumns = [
		'Checkbox'			=>	['type'=>'checkbox',	'field'=>''],
		'Организация'		=>	['type'=>'text',		'field'=>'organization'],
		'Проект'			=>	['type'=>'text',		'field'=>'project'],
		'Отклик'			=>	['type'=>'text',		'field'=>'text'],
		'Просмотр'			=>	['type'=>'cardView',	'field'=>'Смотреть', 'lpx'=>true],
		'Редактирование'	=>	['type'=>'cardEdit',	'field'=>'Редактировать', 'lpx'=>true],
	    'Модерация'			=>	['type'=>'text',		'field'=>'moderation',                           									
												'params'=>[
  													'type'=>'ajaxColumn',
  													'alias'=>'Ostatus',
  													'form'=>'trigger',
  													'data'=>['1'=>'Да','0'=>'Нет'],
  													'active'=>'moderation',
  													'clickFunction'=>'ResponsesBlockUpdate'
													]],	
		'ID'				=>	['type'=>'text',		'field'=>'id'],
	];
	
	$tableParams = [
		'itemsList'=>$itemsList, 
		'tableColumns'=>$tableColumns, 
		'headParams'=>$headParams
	];
	
	$pagiParams = [
		'headParams'=>$headParams, 
		'start_page'=>$start_page, 
		'pages'=>$pages, 
		'on_page'=>$on_page
	];
	
	// Join Content
	$tableStr = $zh->getItemsTable($tableParams);
	$pagiStr = $zh->getLandingPagination($pagiParams);
	$data['bodyContent'] = $filterFormStr.$tableStr.$pagiStr;

?>