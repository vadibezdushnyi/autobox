<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: KAM STUDIO		*/
	/*	***************************	*/
	/*	Developed: from 2016		*/
	/*	***************************	*/
	
	// Form Html Helper Functions, Custom class
	
class formHtml {
	
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
	
	public function input($name, $val, $onchange, $attrClass=""){
			$value = $val;
			return "<div class='zif-wrap $attrClass'><input class='my-field' name='$name' value=\"".htmlentities($val)."\" onchange=\"".htmlentities($onchange)."\"; /></div>";
		}
	public function select($name, $val, $values, $onchange, $attrClass=""){
			$value = $val;
			$r =  "<div class='zif-wrap-select styled-select $attrClass' style='width:300px;'>";
				ob_start();
					?>
					<select style="width:280px;" class="sampling_changed" name="<?= $name ?>">
                    	<option value="-1">-- No selected --</option>
                        <?php
                        foreach($values as $item){
							$selected = ($item['id']==$val ? "selected" : "");
							?>
                            <option <?= $selected ?> value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
							<?php
							}
						?>
                    </select>
					<?php
				$r .= ob_get_contents();
				ob_get_clean();
			$r .= "</div>";
			return $r;
		}
	
	public function __destruct(){}
}