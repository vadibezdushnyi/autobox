<?php
	/*	KLYCHA WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Settings class
	
require("BasicHelp.php");
class articlesHelp extends BasicHelp
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
		
		// Get TABLES SECTIONS item
		
		public function getTableItem($id)
		{
			$query = "SELECT M.* FROM [pre]service_tables as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			if($result){
				$query = "SELECT M.* FROM [pre]service_tables_rows as M WHERE `table_id`='$id' ORDER BY M.id LIMIT 1000";
				
				$result['table'] = $this->rs($query);
			}
			
			return $result;
		}
	
		// Get all HOME MENU SECTIONS
		
		public function getTables($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.* 
			
						FROM [pre]service_tables as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]service_tables as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		
		///////////////////////////////////////////
		
		// CATEGORIES
		
		///////////////////////////////////////////
		
		// Get category item
		
		public function getArtCategoriesItem($id, $lpx = '')
		{
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "SELECT M.*, M.".$lpx."name as name, M.".$lpx."details as details FROM [pre]categories as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			$result = ($resultMassive ? $resultMassive[0] : array());
			return $result;
		}
	
		// Get all categories
		
		public function getArtCategories($params=array(),$typeCount=false)
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
			
						(SELECT COUNT(*) FROM [pre]articles WHERE `cat_id`=M.id LIMIT 1000) as arts_quant 
						
						FROM [pre]categories as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]categories as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		///////////////////////////////////////////
		
		// ARTICLES
		
		///////////////////////////////////////////
		
		// Get article item
		
		public function getArticleItem($id, $lpx="")
		{
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "SELECT M.*, M.".$lpx."name as name, M.".$lpx."content as content, (SELECT name FROM [pre]categories WHERE `id`=M.cat_id LIMIT 1) as cat_name  FROM [pre]articles as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			// Вытягиваем данные о картинках
			$query = "SELECT * FROM [pre]files_ref WHERE `ref_table`='articles' AND `ref_id`=$id LIMIT 100";
			$imagesMassive = $this->rs($query);
			$result['images'] = $imagesMassive ? $imagesMassive : [];
			
			if($result) {
				$tags = $this->rs("
					SELECT FTR.tag_id
		           	FROM [pre]article_tags_ref AS FTR
		            WHERE FTR.art_id = ".$result['id']."
	            ");
				$result['tags'] = $tags ? array_column($tags, 'tag_id') : []; 
			}

			return $result;
		}
	
		// Get all articles
		
		public function getArticles($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.id, M.name, M.alias, M.block, M.cat_id, 
			
						(SELECT name FROM [pre]categories WHERE `id`=M.cat_id LIMIT 1) as cat_name 
						
						FROM [pre]articles as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]articles as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}

		public function getCetificates($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.*
						FROM [pre]certificates as M  
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
						FROM [pre]certificates as M  
						WHERE 1 $filter_and 
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}

		public function getCertificateItem($id, $lpx="")
		{
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "SELECT M.*, M.".$lpx."name as name, M.".$lpx."content as content FROM [pre]certificates as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			// Вытягиваем данные о картинках
			$query = "SELECT * FROM [pre]files_ref WHERE `ref_table`='certificates' AND `ref_id`=$id LIMIT 100";
			$imagesMassive = $this->rs($query);
			$result['images'] = $imagesMassive ? $imagesMassive : [];
			
			if($result) {
				$tags = $this->rs("
					SELECT FTR.tag_id
		           	FROM [pre]article_tags_ref AS FTR
		            WHERE FTR.art_id = ".$result['id']."
	            ");
				$result['tags'] = $tags ? array_column($tags, 'tag_id') : []; 
			}

			return $result;
		}

		// Get cats List
		
		public function getCatsList()
		{
			$query = "SELECT id,name FROM [pre]categories WHERE 1 ORDER BY id LIMIT 1000";
			return $this->rs($query);
		}
		
		///////////////////////////////////////////
		
		// BANNERS
		
		///////////////////////////////////////////
		
		// Get banner item
		
		public function getBannerItem($id, $lpx="")
		{
			$lpx = ($lpx ? $lpx."_" : "");

			$query = "SELECT M.*  FROM [pre]banners as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all articles
		
		public function getBanners($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.*						
						FROM [pre]banners as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]banners as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		///////////////////////////////////////////
		
		// Galleries
		
		///////////////////////////////////////////
		
		// Get gallery item
		
		public function getGalleryItem($id, $lpx='')
		{

			$lpx = ($lpx ? $lpx."_" : "");
			$query = "SELECT M.id, M.block, M.dateCreate, M.dateModify, M.".$lpx."name as name, M.".$lpx."title as title FROM [pre]galleries as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			// Вытягиваем данные о картинках
				$result['images'] = array();
				
				$query = "SELECT * FROM [pre]files_ref WHERE `ref_table`='gallery' AND `ref_id`=$id LIMIT 100";
				$imagesMassive = $this->rs($query);
				
				if($imagesMassive)
				{
					$result['images'] = $imagesMassive;
				}
			
			return $result;
		}
	
		// Get all articles
		
		public function getGalleries($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.id, M.name, M.caption, M.title, M.block, M.dateCreate, M.dateModify
				
						FROM [pre]galleries as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]galleries as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		
		///////////////////////////////////////////
		
		// CONTENT BLOCKS
		
		///////////////////////////////////////////
		
		// Get content block item
		
		public function getContentBlockItem($id)
		{
			$query = "SELECT M.*, (SELECT name FROM [pre]site_positions WHERE `id`=M.pos_id LIMIT 1) as pos_name  FROM [pre]content_blocks as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all articles
		
		public function getContentBlocks($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.id, M.name, M.alias, M.block, M.pos_id, M.startPublish, M.finishPublish, 
			
						(SELECT name FROM [pre]site_positions WHERE `id`=M.pos_id LIMIT 1) as pos_name 
						
						FROM [pre]content_blocks as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]content_blocks as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		// Get site Positions
		
		public function getPositions()
		{
			$query = "SELECT id,name FROM [pre]site_positions WHERE 1 ORDER BY id LIMIT 1000";
			return $this->rs($query);
		}
		
		// Get menuFormats
		
		public function getMenuFormats()
		{
			$query = "SELECT id,name FROM [pre]menu_formats WHERE 1 ORDER BY id LIMIT 100";
			return $this->rs($query);
		}
		
		// Get galleries list
		
		public function getGalleriesList()
		{
			$query = "SELECT id,name FROM [pre]galleries WHERE 1 ORDER BY id LIMIT 10000";
			return $this->rs($query);
		}
		
		public function getMenuParents($item_id=0)
		{
			$query = "SELECT id,name FROM [pre]menu WHERE `parent_id`=0 AND `id`!='$item_id' ORDER BY id LIMIT 10000";
			return $this->rs($query);
		}

		///////////////////////////////////////////
		
		// FAQ
		
		///////////////////////////////////////////
		
		// Get FAQ item

		public function getTagArticles($lpx="") {
			$lpx = ($lpx ? $lpx."_" : "");
            $result = $this->rs("SELECT
	            A.id,
	            CONCAT(A.id, ' - ', A.".$lpx."name) as name
	            FROM [pre]articles AS A
            ");
            return $result;
		}

		public function getArticleTagItem($id, $lpx="") {
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "
			SELECT M.*
			FROM [pre]article_tags as M 
			WHERE `id`='$id' 
			LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());	

			if($result) {
				$posts = $this->rs("
					SELECT FTR.art_id
		           	FROM [pre]article_tags_ref AS FTR
		            WHERE FTR.tag_id = ".$result['id']."
	            ");
				$result['posts'] = $posts ? array_column($posts, 'art_id') : []; 

			}

			return $result;		
		}

		public function getArticleTags($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.*
						FROM [pre]article_tags as M  
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
						FROM [pre]article_tags as M  
						WHERE 1 $filter_and 
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}	

		public function getArticleItemTags($lpx="") {
			$lpx = ($lpx ? $lpx."_" : "");
            $result = $this->rs("SELECT
	            FT.id,
	            FT.".$lpx."name as name
	            FROM [pre]article_tags AS FT
	            WHERE FT.block = 0 AND FT.alias <> '*'
            ");
            return $result;
		}

		public function getFAQTags($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.*
						FROM [pre]faq_tags as M  
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
						FROM [pre]faq_tags as M  
						WHERE 1 $filter_and 
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}		
		
		public function getFaqItemTags($lpx="") {
			$lpx = ($lpx ? $lpx."_" : "");
            $result = $this->rs("SELECT
	            FT.id,
	            FT.".$lpx."name as name
	            FROM [pre]faq_tags AS FT
	            WHERE FT.block = 0 AND FT.alias <> '*'
            ");
            return $result;
		}

		public function getTagFaqs($lpx="") {
			$lpx = ($lpx ? $lpx."_" : "");
            $result = $this->rs("SELECT
	            F.id,
	            CONCAT(F.id, ' - ', F.".$lpx."question) as name
	            FROM [pre]faq AS F
            ");
            return $result;
		}

		public function getFaqTagItem($id, $lpx="") {
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "
			SELECT M.*
			FROM [pre]faq_tags as M 
			WHERE `id`='$id' 
			LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());	

			if($result) {
				$faqs = $this->rs("
					SELECT FTR.faq_id
		           	FROM [pre]faq_tags_ref AS FTR
		            WHERE FTR.tag_id = ".$result['id']."
	            ");
				$result['faqs'] = $faqs ? array_column($faqs, 'faq_id') : []; 

			}

			return $result;		
		}

		public function getFaqItem($id, $lpx="")
		{
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "
			SELECT M.*, M.".$lpx."question as question, M.".$lpx."answer as answer
			FROM [pre]faq as M 
			WHERE `id`='$id' 
			LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());

			if($result) {
				$tags = $this->rs("
					SELECT FTR.tag_id
		           	FROM [pre]faq_tags_ref AS FTR
		            WHERE FTR.faq_id = ".$result['id']."
	            ");
				$result['tags'] = $tags ? array_column($tags, 'tag_id') : []; 
			}

			return $result;
		}

		// Get all articles
		
		public function getFAQ($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.id, M.question, M.answer, M.block, M.order_id, M.dateCreate 
			
						FROM [pre]faq as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]faq as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}

		public function getProducerIndustriesList($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.*
			
						FROM [pre]pcatecories as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]pcatecories as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}

		public function getProducerIndustryItem($id, $lpx="")
		{
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "
			SELECT M.*
			FROM [pre]pcatecories as M 
			WHERE `id`='$id' 
			LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());

			if($result) {
				$refs = $this->rs("
					SELECT PC.producer_id
		           	FROM [pre]producers_categories AS PC
		            WHERE PC.category_id = ".$result['id']."
	            ");
				$result['refs'] = $refs ? array_column($refs, 'producer_id') : []; 
			}

			return $result;
		}

		public function getIndustryProducers($lpx="") {
			$lpx = ($lpx ? $lpx."_" : "");
            $result = $this->rs("SELECT
	            F.id,
	            CONCAT(F.id, ' - ', F.".$lpx."Name) as name
	            FROM [pre]producers AS F
            ");
            return $result;
		}

		public function getProducersList($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.*
			
						FROM [pre]producers as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]producers as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}		

		public function getProducerItem($id, $lpx="")
		{
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "
			SELECT M.*, 
			M.".$lpx."description as description,
			M.".$lpx."meta_keys as meta_keys,
			M.".$lpx."meta_desc as meta_desc,
			M.".$lpx."meta_title as meta_title
			FROM [pre]producers as M 
			WHERE `id`='$id' 
			LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());

			if($result) {
				$refs = $this->rs("
					SELECT PC.category_id
		           	FROM [pre]producers_categories AS PC
		            WHERE PC.producer_id = ".$result['id']."
	            ");
				$result['refs'] = $refs ? array_column($refs, 'category_id') : []; 
			}

			return $result;
		}

		public function getProducerIndustries($lpx="") {
			$lpx = ($lpx ? $lpx."_" : "");
            $result = $this->rs("SELECT
	            F.id,
	            CONCAT(F.id, ' - ', F.".$lpx."name) as name
	            FROM [pre]pcatecories AS F
            ");
            return $result;
		}

		public function getTeam($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.*
						FROM [pre]page_about_team_list as M  
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
				
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
						FROM [pre]page_about_team_list as M  
						WHERE 1 $filter_and 
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}		
		
		public function getTeamItem($id, $lpx="")
		{
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "
			SELECT M.*, M.".$lpx."name as name, M.".$lpx."position as position
			FROM [pre]page_about_team_list as M 
			WHERE `id`='$id' 
			LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			if(!empty($result)) {
				$result['languages'] = array_column(json_decode($result['languages'], true), 'name');
			}
			return $result;
		}

		public function getAcceptedLanguages() {
			return [
      			[ 'name' => 'English',	 'value' => json_encode(['name' => 'English', 	'name_s'=>'en', 'logo' => 'en.png'])],
      			[ 'name' => 'German',	 'value' => json_encode(['name' => 'German', 	'name_s'=>'de', 'logo' => 'de.png'])],
      			[ 'name' => 'Russian',	 'value' => json_encode(['name' => 'Russian', 	'name_s'=>'ru', 'logo' => 'ru.png'])],
      			[ 'name' => 'Czech',	 'value' => json_encode(['name' => 'Czech', 	'name_s'=>'cz', 'logo' => 'cz.png'])],
      			[ 'name' => 'Slovak',	 'value' => json_encode(['name' => 'Slovak', 	'name_s'=>'sk', 'logo' => 'sk.png'])],
      			[ 'name' => 'Turkish',	 'value' => json_encode(['name' => 'Turkish', 	'name_s'=>'tr', 'logo' => 'tr.png'])],
      			[ 'name' => 'Spanish',	 'value' => json_encode(['name' => 'Spanish', 	'name_s'=>'es', 'logo' => 'es.png'])],
      			[ 'name' => 'Arabic',	 'value' => json_encode(['name' => 'Arabic', 	'name_s'=>'ar', 'logo' => 'eg.png'])],
			];
		}

		public function getHomeWhyUs($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.*
						FROM [pre]page_home_whyus as M  
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
				
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
						FROM [pre]page_home_whyus as M  
						WHERE 1 $filter_and 
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}		
		
		public function getHomeWhyUsItem($id)
		{
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "
			SELECT M.*
			FROM [pre]page_home_whyus as M 
			WHERE `id`='$id' 
			LIMIT 1";
			$resultMassive = $this->rs($query);
			$result = ($resultMassive ? $resultMassive[0] : array());

			return $result;
		}		

		///////////////////////////////////////////
		
		// HOME MENU SECTIONS
		
		///////////////////////////////////////////
		
		// Get HOME MENU SECTIONS item
		
		public function getMenuHomeSectionsItem($id)
		{
			$query = "SELECT M.* FROM [pre]menu_home as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all HOME MENU SECTIONS
		
		public function getMenuHomeSections($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.* 
			
						FROM [pre]menu_home as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]menu_home as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		///////////////////////////////////////////
		
		// CONTENT BLOCKS
		
		///////////////////////////////////////////
		
		// Get content block item
		
		public function getMenuItem($id, $lpx="")
		{
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "
				SELECT M.*, M.".$lpx."name as name 
				FROM [pre]menu as M 
				WHERE 
					`id`='$id' 
				LIMIT 1
				";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			// Вытягиваем данные о картинках
				$result['docs'] = array();
				
				$query = "SELECT id,file,crop,path FROM [pre]docs_ref WHERE `ref_table`='menu' AND `ref_id`=$id LIMIT 1000";
				$docsMassive = $this->rs($query);
				
				if($docsMassive)
				{
					$result['docs'] = $docsMassive;
				}
			
			return $result;
		}
	
		// Get all articles
		
		public function getMenu($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.*, M.".$lpx."name as name
						
						FROM [pre]menu as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]menu as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		public function getPartners($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.*
						FROM [pre]partners as M  
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
						FROM [pre]partners as M  
						WHERE 1 $filter_and 
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}	
		public function getReviews($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.*
						FROM [pre]reviews as M  
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
						FROM [pre]reviews as M  
						WHERE 1 $filter_and 
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}	
		public function getClients($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.*
						FROM [pre]clients as M  
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
						FROM [pre]clients as M  
						WHERE 1 $filter_and 
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}	
		public function getPartner($id, $lpx="")
		{
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "
				SELECT M.*
				FROM [pre]partners as M 
				WHERE `id`='$id' 
				LIMIT 1
				";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
		public function getReview($id, $lpx="")
		{
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "
				SELECT M.*
				FROM [pre]reviews as M 
				WHERE `id`='$id' 
				LIMIT 1
				";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
		public function getClient($id, $lpx="")
		{
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "
				SELECT M.*
				FROM [pre]clients as M 
				WHERE `id`='$id' 
				LIMIT 1
				";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}		
		public function getIngredients($params=array(),$typeCount=false)
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
            			(SELECT `name` FROM [pre]ingredients_types WHERE `id` = M.type_id LIMIT 1) as type,
            			(SELECT `caption` FROM [pre]page_production WHERE `id` = M.production_id LIMIT 1) as category
						FROM [pre]ingredients as M  
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
						FROM [pre]ingredients as M  
						WHERE 1 $filter_and 
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}		
		
		public function getIngredient($id, $lpx="")
		{
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "
				SELECT M.*, 
	    			(SELECT `name` FROM [pre]ingredients_types WHERE `id` = M.type_id LIMIT 1) as type,
	    			(SELECT `caption` FROM [pre]page_production WHERE `id` = M.production_id LIMIT 1) as category
				FROM [pre]ingredients as M 
				WHERE `id`='$id' 
				LIMIT 1
				";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			if(!empty($result)) {
                $result['process'] = $this->rs("SELECT * FROM [pre]ingredients_process WHERE `ing_id` = ".$result['id']." ORDER BY `order_id`");
                $result['characteristics'] = $this->rs("SELECT * FROM [pre]ingredients_characteristics WHERE `ing_id` = ".$result['id']." ORDER BY `order_id`");
                $result['recipes'] = $this->rs("
                    SELECT `value1`,`value2`,`value3`,`value4`,`value5`,`value6`,`value7`,`value8`,`value9`,`value10` 
                    FROM [pre]ingredients_recipes WHERE `ing_id` = ".$result['id']." ORDER BY `order_id`
                ");				
			}
			
			return $result;
		}
		public function getIngredientTypes() {
			$query = "
				SELECT M.id, M.name
				FROM [pre]ingredients_types as M 
			";
			$result = $this->rs($query);
			return $result;
		}
		public function getIngredientCategories() {
			$query = "
				SELECT M.id, M.caption as name
				FROM [pre]page_production as M 
			";
			$result = $this->rs($query);
			return $result;
		}
		// ARTICLE COMMENTS
		public function getArticleComments($params=array(),$typeCount=false)
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
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id, M.block");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : " DESC");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.*,   
			
						(SELECT name FROM [pre]users WHERE `id`=M.user_id) as user_name,
						(SELECT login FROM [pre]users WHERE `id`=M.user_id) as user_email,
						(SELECT name FROM [pre]articles WHERE `id`=M.art_id) as prod_name		
						
						FROM [pre]article_comments as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]article_comments as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		public function getArticleCommentItem($id)
		{
			$query = "SELECT M.*, 
						(SELECT name FROM [pre]users WHERE `id`=M.user_id) as user_name,
						(SELECT login FROM [pre]users WHERE `id`=M.user_id) as user_email,
						(SELECT name FROM [pre]articles WHERE `id`=M.art_id) as prod_name 
						FROM [pre]article_comments as M 
						WHERE `id`=$id 
						LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
		// Get FAQ item
		
		public function getLangItem($id)
		{
			$query = "SELECT M.block, L.name, L.alias, M.id 
			FROM [pre]site_languages as M
			LEFT JOIN [pre]languages AS L ON L.id = M.lang_id
			WHERE M.id='$id' 
			LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all articles
		
		public function getLanguages($params=array(),$typeCount=false)
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
			
				$query = "SELECT L.name, L.alias, M.block, M.id 
			
						FROM [pre]site_languages AS M 
						LEFT JOIN [pre]languages AS L ON L.id = M.lang_id 
						
						WHERE 1 $filter_and AND L.alias != '".DEF_LANG."'
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]site_languages as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		public function getAllLangs(){
			$q = "
				SELECT * FROM [pre]languages WHERE `used` = 0 LIMIT 1000 
			";
			return $this->rs($q);
		}
		public function getAvailableLangs(){
				$query = "
					SELECT L.name, L.alias, M.block, M.id 
					FROM [pre]site_languages AS M 
					LEFT JOIN [pre]languages AS L ON L.id = M.lang_id 
					WHERE 1 $filter_and AND L.alias != '".DEF_LANG."'
					ORDER BY M.id
					LIMIT 1000
				";
						
				return $this->rs($query);
		}
		public function getImageAlts($item_id, $lpx=""){
			$lpx = ($lpx ? $lpx."_" : "");
			$q = "
				SELECT M.".$lpx."data AS data
				FROM [pre]article_images_alts AS M
				WHERE M.art_id = '$item_id'
				LIMIT 1
			";
			return $this->rs($q);
		}
		///////////////////////////////////////////
		
		// PRIVACY
		
		///////////////////////////////////////////
		
		// Get PRIVACY item
		
		public function getPrivacyItem($id, $lpx="")
		{
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "SELECT M.*, M.".$lpx."q as q, M.".$lpx."a as a FROM [pre]privacy as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all articles
		
		public function getPrivacy($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.* 
			
						FROM [pre]privacy as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]privacy as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		public function getAllTemplates($params=array(), $status, $typeCount=false)
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

                $query = "SELECT M.*
				        FROM [pre]email_templates as M
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";

                return $this->rs($query);

            }else
            {
                $query = "SELECT COUNT(*)  
			
						FROM [pre]email_templates as M
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";

                $result = $this->rs($query);
                return $result[0]['COUNT(*)'];
            }
        }

        public function getTemplateInfo($id,$lpx="")
        {
        	$lpx = ($lpx ? $lpx."_" : "");

            $query = "SELECT 
            			M.* 
            			,".$lpx."subject as subject
            			,".$lpx."body as body 
            			FROM [pre]email_templates as M 
            			WHERE 
            			M.id=$id 
            			LIMIT 1;
            			";

            $resultMassive = $this->rs($query);

            $result = ($resultMassive ? $resultMassive[0] : array());

            return $result;
        }		
		
    	public function __destruct(){}
}
