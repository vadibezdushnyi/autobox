<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RELOAD CATEGORY GROUP CHARS - LOAD IN HTML</title>
</head>

<?php
	$id = (int)$_GET['id'];
	
	$pid = 0;
	if(isset($_GET['pid'])) $pid = (int)$_GET['pid'];
?>

<body>
			<?php
			$query = "SELECT specs_group_id FROM [pre]shop_catalog WHERE `id`='".$id."' ORDER BY id LIMIT 1";
	
				$_stmt = $dbh->prepare($query);
				$_arr = $_stmt->execute();
				$_arr = $_arr->fetchallAssoc();
            	
			$group_id = $_arr[0]['specs_group_id'];
			
			$query = "SELECT * FROM [pre]shop_chars_groups WHERE `id`='".$group_id."' ORDER BY id LIMIT 1";
	
				$_stmt = $dbh->prepare($query);
				$_arr = $_stmt->execute();
				$_arr = $_arr->fetchallAssoc();
            	
			$group = $_arr[0];
			
			$query = "SELECT * FROM [pre]shop_chars WHERE `group_id`='".$group_id."' ORDER BY id LIMIT 100";
	
				$_stmt = $dbh->prepare($query);
				$_arr = $_stmt->execute();
				$chars = $_arr->fetchallAssoc();
            	
			if(sizeof($chars) == 0)
			{
				echo "<br><p>Для выбранной категории не назначена ни одна группа характеристик.</p><br>";
			}else
			{
			
			?>
            <br><p title="<?php echo $group['details'] ?>">Группа свойств: <b><?php echo $group['name'] ?></b></p><br>
			<table class="chars-table">
			<?php
				foreach($chars as $char)
				{
					if($pid)
					{
						$query = "SELECT id,value FROM [pre]shop_chars_prod_ref WHERE `char_id`='".$char['id']."' AND `prod_id`='".$pid."' LIMIT 1";
							
							$_stmt = $dbh->prepare($query);
							$_res = $_stmt->execute();
							
					
						$cvs = $_res->fetchallAssoc();
						$cv = ($cvs ? $cvs[0]['value'] : "");
					}else
					{
						$cv = "";
					}
					?>
					<tr>
                    	<td><?php echo $char['name']; if(trim($char['measure']) != "") echo ", ".$char['measure'] ?></td>
                        <td>
					<?php
							if($char['type'] == "DATETIME")
							{
								$cv = date("Y-m-d",strtotime($cv));
						?>		
                				<input	id="char-<?php echo $char['id'] ?>" 
                                		class="my-field"
                                		type="date" 
                                        placeholder="Выберите дату" 
                                        value="<?php echo $cv ?>" 
                                        name="char[<?php echo $char['id'] ?>]"
                                />
						<?php	
							}else
							{
						?>
								<input	id="char-<?php echo $char['id'] ?>" 
                                		class="my-field"
                                		type="text" 
                                        placeholder="<?php echo $char['name'] ?>" 
                                        value="<?php echo $cv ?>" 
                                        name="char[<?php echo $char['id'] ?>]" 
                                        size="25"
                                        maxlength="100"
                                />
						<?php
							}
						?>
						</td>
						<?php
				}
			?>
			</table>
			<?php
			}
			?>
</body>
</html>