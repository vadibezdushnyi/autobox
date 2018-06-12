<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Settings class
	
require("BasicHelp.php");

class usersHelp extends BasicHelp
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
		
		// TASKS
		
		///////////////////////////////////////////
		
		// Get all users

		public function getAllOrganizations($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.* ,
						(SELECT `ru_name` FROM osc_users_specializations WHERE `id`=M.spec) as spec
						FROM [pre]users_organizations as M  
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]users_organizations as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}

		public function getOrganizationInfo($id) {
			$query = "SELECT M.*, M.spec as spec_id, (SELECT `ru_name` FROM osc_users_specializations WHERE `id`=M.spec) as spec FROM [pre]users_organizations as M WHERE `id`=$id LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}

		public function getOrgSpecs() {
			$query = "SELECT `ru_name` as name, `name` as ua_name, `id` FROM osc_users_specializations";
			$result = $this->rs($query);
			return $result;
		}

		public function getProjectSpecs() {
			$query = "SELECT `ru_name` as name, `name` as ua_name, `id` FROM osc_projects_specializations";
			$result = $this->rs($query);
			return $result;
		}


		public function getProjectStatuses() {
			$query = "SELECT * FROM osc_projects_statuses";
			$result = $this->rs($query);
			return $result;
		}

		public function getProblemsStatuses() {
			$query = "SELECT * FROM osc_problems_statuses";
			$result = $this->rs($query);
			return $result;
		}

		public function getAllUsers($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.id, M.type, M.name, M.fname, M.block, M.active, M.dateCreate,   
						(SELECT name FROM [pre]users_types WHERE id=M.type) as type_name
						FROM [pre]users as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]users as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		
		public function getUserInfo($id)
		{
			$query = "SELECT * FROM [pre]users WHERE `id`=$id LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			if($result)
			{
				// Get type Info
				$result['typeInfo'] = array();
				$query = "SELECT * FROM [pre]users_types WHERE `id`='".$result['type']."' LIMIT 1";
				$typeMass = $this->rs($query);
				
				if($typeMass)
				{
					$result['typeInfo'] = $typeMass[0];
				}
				
				// Get extra field groups
				
				$result['ef_groups'] = array();
				
			}
			
			return $result;
		}
		
		//
		
		public function getUsersTypes()
		{
			$query = "SELECT * FROM [pre]users_types ORDER BY id LIMIT 1000";
			return $this->rs($query);
		}
		
		//
		
		public function getExtraFieldsGroups()
		{
			return array();
		}
		
		// Get users types list
		
		// Get all users
		
		public function getAllUsersTypes($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.id, M.name, M.alias, M.block,  
						(SELECT COUNT(id) FROM [pre]users WHERE type=M.id) as users_quant
						FROM [pre]users_types as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]users_types as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		// Get users types access references
		
		public function getUserTypeInfo($typeId)
		{
			$query = "SELECT M.*
					  FROM [pre]users_types as M 
					  WHERE M.id=$typeId
					  LIMIT 1
					 ";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			if(true) // $result
			{
				// Get admin menu parents 
				$query = "SELECT id,name FROM [pre]admin_menu WHERE `parent`=0 ORDER BY id LIMIT 100";
				$adminMenuParents = $this->rs($query);
				
				if($adminMenuParents)
				{
					$result['parents'] = $adminMenuParents;
					
					// Get admin menu access
					foreach($adminMenuParents as $ami => $amParent)
					{
						$query = "SELECT M.id,M.name,
						  (SELECT access FROM [pre]user_type_access WHERE `type_id`='$typeId' AND `menu_id`=M.id ORDER BY id DESC LIMIT 1) as access  
						  FROM [pre]admin_menu as M
						  WHERE M.parent='".$amParent['id']."'
						  ORDER BY M.id 
						  LIMIT 100;
						 ";
						 
						$result['parents'][$ami]['childs'] = $this->rs($query); 
					}	
				}
			}
			
			return $result;
		}


		///////////////////////////////////////////
		
		// FAQ
		
		///////////////////////////////////////////
		
		// Get FAQ item
		
		public function getUserData($id)
		{
			$query = "SELECT M.* FROM [pre]client_data_storage as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all articles
		
		public function getUsersData($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.*,
						(SELECT `login` FROM osc_users_organizations WHERE `id`=M.user_id) as email,
						(SELECT `org_name` FROM osc_users_organizations WHERE `id`=M.user_id) as org
			
						FROM [pre]users_subscribes as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]users_subscribes as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		
    	public function __destruct(){}
}