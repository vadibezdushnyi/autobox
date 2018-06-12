<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: KAM STUDIO		*/
	/*	***************************	*/
	/*	Developed: from 2016		*/
	/*	***************************	*/
	
	// Common SQL methods, Custom class
	
class editSql
{
	public $dbh;
	
	public function __construct($dbh){
		
		$this->dbh = $dbh;
	} 

	// Get class vars
	public static function expose(){
		
		return get_class_vars(__CLASS__);
	}
	
	// Update product Groups
	public function saveProductGroups( $id, $postname='product_groups' ){
		
		if(!isset($_POST[ $postname ])) return false;
		
		$productGroups = $_POST[ $postname ];
		
		$query = "SELECT id, group_id   
					[pre]shop_prod_group_ref 
					WHERE 
						prod_id = '$id' 
					LIMIT 100
				";
		$currProductGroups = $this->dbh->q($query);
		
		foreach($currProductGroups as $curr_item)
		{
			$currKey = array_search($curr_item['group_id'], $productGroups, true);
			if( $currKey !== FALSE ){
				$query = "DELETE FROM [pre]shop_prod_group_ref 
							WHERE 
								`id`=".$curr_item['id']." 
							LIMIT 1
						";
				$this->dbh->q($query,0,1);
			}
			else{
				unset( $productGroups[ $currKey ] );
			}
		}
		foreach($productGroups as $group_id)
		{
			$query = "INSERT INTO [pre]shop_prod_group_ref (`prod_id`,`group_id`) VALUES ('$id','$group_id')";
			$this->dbh->q($query,0,1);
		}
		
		return true;
	}
	
	public function __destruct(){}
}