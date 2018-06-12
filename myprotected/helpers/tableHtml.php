<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: KAM STUDIO		*/
	/*	***************************	*/
	/*	Developed: from 2016		*/
	/*	***************************	*/
	
	// Table Html Helper Functions, Custom class
	
class tableHtml {
	
	public $dbh;
	public $secretKey = "ioncr8by24c2djn8j";
	
	public function __construct($dbh)
	{
		$this->dbh = $dbh;
	} 

	// Get class vars

	public static function expose()
	{
		return get_class_vars(__CLASS__);
	}
	
	public function simpleText($val, $attrClass=""){
			return "<span class='$attrClass'>$val</span>";
		}
	public function concatText($val_1, $val_2, $val_3, $separator=" ", $attrClass=""){
			$value =	($val_1 ? $val_1 : "Empty") . 
						($val_2 ? $separator . $val_2 : "") . 
						($val_3 ? $separator . $val_2 : "");
			return "<span class='$class'>$value</span>";
		}
	public function dateFormat($val,$format="Y-m-d", $attrClass=""){
			return "<span class='$class'>". date($format, strtotime($val)) ."</span>";
		}
	public function boolTrigger($val,$reverse=true, $yes="Yes", $no="No", $attrClass=""){
			$value = ($reverse ? (!$val ? $yes : $no) : ($val ? $yes : $no));
			return "<span class='$class'>$value</span>";
		}
	public function image($val, $path, $attrClass=""){
			return "<span class='$class'><img src='".$path . $val."' /></span>";
		}
	public function block($val){
			return "<span class='publication'>
							<div class='".(!$val ? "published" : "not-published")."'></div>
							<span>".(!$val ? "Yes" : "No")."</span>
						</span>";
		}
	public function updateCatPostition($val,$item_id,$attrClass=""){
			return "<span class='$attrClass'><input style='width:50px; text-align:center;' name='cat_pos' id='cat_pos_$item_id' value='".$val."' onchange='update_cat_pos($item_id,$(this).val());' /></span>";
		}
	public function test($val, $onchange, $attrClass=""){
			$value = ($val ? "Yahoo" : "Google");
			return "<span class='$attrClass'><input value='$value' onchange=\"".htmlentities($onchange)."\"; /></span>";
		}
		
	public function color($val, $attrClass="color",$w=30,$h=30){
			$value = ($val%2 ? "green" : "red");
			return "<span class='$attrClass'><div style='width:".$w."px; height:".$h."px; background:$value;'></div></span>";
		}
	public function yesno($val){
			$value = ($val%2 ? "YES" : "NO");
			return "<span>$value</span>";
		}
	
	public function __destruct(){}
}