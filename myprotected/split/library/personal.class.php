<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Settings class
	
require("BasicHelp.php");

class personalHelp extends BasicHelp
{
   		public $dbh;
		
		public $table;
		public $id;
		public $item;
		
		public function __construct($dbh)
		{
			parent::__construct($dbh);
			$this->dbh = $dbh;
		} 
		
		///////////////////////////////////////////
		
		// TASKS FROM Shop (New Orders)
		
		///////////////////////////////////////////
		
		// Get all tasks
		
		public function getAllTasks($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.id, M.type, M.author_id, M.user_id, M.paid_status, M.pay_method, M.delivery_method, M.products_quant, M.sum, M.dateCreate,   
			
						(SELECT name FROM [pre]users WHERE `id`=M.author_id LIMIT 1) as author_name,
						
						(SELECT fname FROM [pre]users WHERE `id`=M.author_id LIMIT 1) as author_fname
						
						FROM [pre]shop_orders as M  
						
						WHERE M.status=1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT 10000";
						// LIMIT $start,$limit
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]shop_orders as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		///////////////////////////////////////////
		
		// TASKS FROM DIRECTOR (Admin)
		
		///////////////////////////////////////////
		
		// Get all director tasks
		
		public function getAllDirectorTasks($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.id, M.admin_id, T.dateCreate, T.type, T.status, T.subject, T.comment, T.date_finish, U.login as resp_email,      
			
						(SELECT name FROM [pre]users WHERE `id`=M.admin_id LIMIT 1) as author_name,
						
						(SELECT fname FROM [pre]users WHERE `id`=M.admin_id LIMIT 1) as author_fname,
						
						(SELECT name FROM [pre]users WHERE `id`=M.responsible_id LIMIT 1) as responsible_name,
						
						(SELECT fname FROM [pre]users WHERE `id`=M.responsible_id LIMIT 1) as responsible_fname
						
						FROM [pre]task_admin_ref as M, [pre]tasks as T, [pre]users as U    
						
						WHERE ( M.responsible_id='".ADMIN_ID."' OR M.admin_id='".ADMIN_ID."' ) AND M.task_id = T.id AND U.id=M.responsible_id  $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]task_admin_ref as M, [pre]tasks as T, [pre]users as U      
						
						WHERE ( M.responsible_id='".ADMIN_ID."' OR M.admin_id='".ADMIN_ID."' ) AND M.task_id = T.id AND U.id=M.responsible_id $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		// Get all dialogs
		
		public function getAllDialogs($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : " DESC");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.id, M.message, M.status, M.from_id, M.to_id, M.dateCreate, U.login as user_email,   
			
						(SELECT name FROM [pre]users WHERE `id`=M.from_id LIMIT 1) as from_name,
						
						(SELECT fname FROM [pre]users WHERE `id`=M.from_id LIMIT 1) as from_fname,
						
						(SELECT name FROM [pre]users WHERE `id`=M.to_id LIMIT 1) as to_name,
						
						(SELECT fname FROM [pre]users WHERE `id`=M.to_id LIMIT 1) as to_fname
						
						FROM [pre]users_dialogs as M, [pre]users as U 
						
						WHERE (M.from_id=".ADMIN_ID." OR M.to_id=".ADMIN_ID.") 
																				AND M.last=1
																				AND ( U.id != '".ADMIN_ID."' AND (U.id=M.from_id OR U.id=M.to_id) ) 
																				$filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]users_dialogs as M , [pre]users as U 
						
						WHERE (M.from_id=".ADMIN_ID." OR M.to_id=".ADMIN_ID.") AND M.last=1  
																				AND ( U.id != '".ADMIN_ID."' AND (U.id=M.from_id OR U.id=M.to_id) ) 
																				$filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		public function getDialogItem($id)
		{
			$query = "SELECT * FROM [pre]users_dialogs WHERE `id`=$id LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
		
		public function getDirectorTaskItem($id)
		{
			$query = "SELECT T.*, M.responsible_id as user_id, 
			
			(SELECT name FROM [pre]users WHERE `id`=M.admin_id LIMIT 1) as author_name,
						
			(SELECT fname FROM [pre]users WHERE `id`=M.admin_id LIMIT 1) as author_fname,
						
			(SELECT name FROM [pre]users WHERE `id`=M.responsible_id LIMIT 1) as responsible_name,
						
			(SELECT fname FROM [pre]users WHERE `id`=M.responsible_id LIMIT 1) as responsible_fname
			
			FROM [pre]task_admin_ref as M, [pre]tasks as T  
			
			WHERE M.id=$id AND M.task_id = T.id LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
		
		public function getUserInfo($id)
		{
			$query = "SELECT * FROM [pre]users WHERE `id`=$id LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
		
		public function getDialog($id1,$id2)
		{
			$query = "SELECT M.* ,
						(SELECT file FROM [pre]dialog_files_ref WHERE ref_id=M.id LIMIT 1) as file,
						(SELECT crop FROM [pre]dialog_files_ref WHERE ref_id=M.id LIMIT 1) as crop
						FROM [pre]users_dialogs as M 
						WHERE (`from_id`=$id1 AND `to_id`=$id2) OR (`from_id`=$id2 AND `to_id`=$id1) 
						ORDER BY id DESC LIMIT 10000";
			
			return $this->rs($query);
		}

		public function getQuestionItem($id)
		{
			$query = "
				SELECT M.*, A.name as cat_name
				FROM [pre]income_questions as M
				LEFT JOIN [pre]contact_categories AS A ON A.id = M.category
				WHERE M.id='$id' 
				LIMIT 1
			";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all articles
		
		public function getQuestions($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.*, A.name as cat_name 
			
						FROM [pre]income_questions as M
						LEFT JOIN [pre]contact_categories as A ON A.id = M.category  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]income_questions as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}

		public function setViewedStatus($id, $table){
			$query = "UPDATE [pre]$table SET `viewed`=1 WHERE `id` = '$id' LIMIT 1";
			$result = $this->rs($query);
		}

		public function getAllSupportTickets($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : " DESC");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT *
						
						FROM [pre]contact_form as M
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]contact_form as M
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}

		public function getSupportMessageItem($id)
		{
			$query = "SELECT *
			
			FROM [pre]contact_form
			
			WHERE `id`=$id LIMIT 1";

			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}			
		
    	public function __destruct(){}
}