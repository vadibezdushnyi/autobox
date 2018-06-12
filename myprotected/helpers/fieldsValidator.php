<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: KAM STUDIO		*/
	/*	***************************	*/
	/*	Developed: from 2016		*/
	/*	***************************	*/
	
	// Common SQL methods, Custom class
	
class fieldsValidator
{
	public $dbh;
	
	public function __construct($dbh){
		
		$this->dbh = $dbh;
	} 

	// Get class vars
	public static function expose(){
		
		return get_class_vars(__CLASS__);
	}
	
	// Integer number
	public function numberInteger( $val ){
		return (filter_var($val, FILTER_VALIDATE_INT) ? array('status'=>true,'value'=>$val,'message'=>'') : array('status'=>false,'value'=>'','message'=>"Ожидается целое число"));
	}
	
	// Float number
	public function numberFloat( $val ){
		return (filter_var($val, FILTER_VALIDATE_FLOAT) ? array('status'=>true,'value'=>$val,'message'=>'') : array('status'=>false,'value'=>'','message'=>"Ожидается дробное число"));
	}
	
	// Strip tags strings
	public function stringStripTags( $val ){
		return ($val==strip_tags($val) ? array('status'=>true,'value'=>$val,'message'=>'') : array('status'=>false,'value'=>'','message'=>"Найдены недопустимые HTML теги"));
	}
	
	// Email
	public function email( $val ){
		return (filter_var($val, FILTER_VALIDATE_EMAIL) ? array('status'=>true,'value'=>$val,'message'=>'') : array('status'=>false,'value'=>'','message'=>"Некорректный Email адрес"));
	}
	
	// URL
	public function url( $val ){
		return (filter_var($val, FILTER_VALIDATE_URL) ? array('status'=>true,'value'=>$val,'message'=>'') : array('status'=>false,'value'=>'','message'=>"Некорректный URL адрес"));
	}
	
	// IP
	public function ip( $val ){
		return (filter_var($val, FILTER_VALIDATE_IP) ? array('status'=>true,'value'=>$val,'message'=>'') : array('status'=>false,'value'=>'','message'=>"Некорректный IP адрес"));
	}
	
	// Boolean
	public function boolFlag( $val ){
		return (filter_var($val, FILTER_VALIDATE_BOOLEAN) ? array('status'=>true,'value'=>$val,'message'=>'') : array('status'=>false,'value'=>'','message'=>"Ожидается значение 0(false) либо 1(true)"));
	}
	
	// Date
	function dateFlag( $val ){
	  
	  $Stamp = strtotime( $val );
	  $Month = date( 'm', $Stamp );
	  $Day   = date( 'd', $Stamp );
	  $Year  = date( 'Y', $Stamp );
	
	  return (checkdate( $Month, $Day, $Year ) ? array('status'=>true,'value'=>$val,'message'=>'') : array('status'=>false,'value'=>'','message'=>"Ожидается значение в формате ДАТА (Y/m/d)"));
	}
	
	// Product manufacturer
	public function productMf( $val ){
		$value  = (int)$val;
		if(isset( $_POST['new_mf_name'] ) && !$value){
			$newMfName = trim(strip_tags($_POST['new_mf_name']));
			if(!empty($newMfName)){
					$q = "INSERT INTO [pre]shop_mf (`name`) VALUES ('$newMfName')";
					$value = $this->dbh->q($q,0,1,true);
				}
		}
		return ($value ? array('status'=>true,'value'=>$value,'message'=>'') : array('status'=>false,'value'=>'','message'=>"Производитель не указан"));
	}
	
	public function __destruct(){}
}