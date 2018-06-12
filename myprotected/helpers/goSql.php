<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: KAM STUDIO		*/
	/*	***************************	*/
	/*	Developed: from 2016		*/
	/*	***************************	*/
	
	// Common SQL methods, Custom class
	
class goSql
{
	public $dbh;
	
	public function __construct($dbh){
		
		$this->dbh = $dbh;
	} 

	// Get class vars
	public static function expose(){
		
		return get_class_vars(__CLASS__);
	}
	
	// Get users Types
	public function getUsersTypes( $cardItem=array() ){
		
		$query = "SELECT * FROM [pre]users_types ORDER BY id LIMIT 1000";
		return $this->dbh->q($query);
	}
	
	// Get users Types
	public function getUsersTypes2( $cardItem=array() ){
		
		$query = "SELECT * FROM [pre]users_types ORDER BY id LIMIT 1000";
		return $this->dbh->q($query);
	}
	
	public function __destruct(){}
}