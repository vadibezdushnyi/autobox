<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
	
	//require_once "../../../../split/library/wp_lib.php";
	//$wp = new wp_Lib($db_pref);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Action LOAD BUFFER LAST FILE</title>
</head>

<body>
<?php 
	//echo '<pre>'; print_r($_POST); echo '</pre>'; die();
	
	$query = "SELECT  * FROM [pre]files_ref WHERE `adminMod`='".$_POST['admin_id']."' AND `ref_table`='".$_POST['ref_table']."' AND `ref_id`='".$_POST['ref_id']."' ORDER BY id DESC LIMIT 1";

	//echo $query; die();

		$result_stmt = $dbh->prepare($query);
		$result_arr = $result_stmt->execute();
		$result = $result_arr->fetchallAssoc();
		
	$rf = $result[0];
	
	if($rf != null)
	{
			$rf_data = '';
				if($rf['is_link'])
				{
					$rf_data .= '<a href="'.$rf['href'].'" ';
					if($rf['target'])
					{
						$rf_data .= 'target="_blank" ';
					}
					$rf_data .= '>';
				}
				
				$rf_data .= '<img alt="Not found" src="/'.WP_FOLDER.$rf['path'].$rf['file'].'">'; 
				
				if($rf['is_link'])
				{
					$rf_data .= '</a>';
				}
		?>
				<div class="item" id="rf-item-<?php echo $rf['id'] ?>">
                	<img class="close-file-item" alt="X" src="<?php echo WP_FOLDER ?>img/close-icon.png" onclick="delete_rf(<?php echo $rf['id'] ?>);">
                	<div class="item-inside">
                    	<img alt="File not found" src="/split/<?php echo $rf['path'] ?>crop/<?php echo $rf['crop'] ?>">
                    <div class="icode" contenteditable="true" 
                    	onmouseover="$(this).stop().animate({'bottom':'0px'},400,'easeInOutExpo');"
                        onmouseout="$(this).stop().animate({'bottom':'-80px'},400,'easeInOutExpo');">
                    	<xmp><?php echo $rf_data ?></xmp>
                    </div>
                    </div>
                </div>
		<?php
	}else
	{
		echo '<pre>'; print_r($rf); echo '</pre>';
	}
?>
</body>
</html>