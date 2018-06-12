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
<title>RELOAD USER EXTRA FIELDS - LOAD IN HTML</title>
</head>

<?php
	$id = (int)$_GET['id'];
?>

<body>
			<?php
			
			$reg_user_ef_groups_query = "SELECT * FROM [pre]users_types_extra_field_ref WHERE `group_id`='".$id."' ORDER BY id LIMIT 100";
	
				$reg_user_ef_groups_stmt = $dbh->prepare($reg_user_ef_groups_query);
				$reg_user_ef_groups_arr = $reg_user_ef_groups_stmt->execute();
				$reg_user_ef_groups = $reg_user_ef_groups_arr->fetchallAssoc();
            	
				foreach($reg_user_ef_groups as $reg_user_ef_group)
				{
					$ef_group_id = $reg_user_ef_group['ef_group_id'];
					// Вытягиваем группу дополнительных полей из таблицы users_extra_fields_groups
					$ef_group_query = "SELECT * FROM [pre]users_extra_fields_groups WHERE `id`='".$ef_group_id."' LIMIT 1";
	
						$ef_group_stmt = $dbh->prepare($ef_group_query);
						$ef_group_arr = $ef_group_stmt->execute();
						$ef_group = $ef_group_stmt->fetchallAssoc();
						$ef_group = $ef_group[0];
						
						// Выводим название группы дополнительных полей
						?>
							<div class="clear"></div>
                        	<h4><?php echo $ef_group['name'] ?></h4>
						<?php
					
					// Вытягиваем дополнительные поля группы из таблиц users_ef_group_ref и user_extra_fields
					$extra_fields_query = "SELECT * FROM [pre]user_extra_fields as EF
											   LEFT JOIN [pre]users_ef_group_ref AS REF on EF.id = REF.ef_id
											   WHERE REF.group_id = '".$ef_group_id."'
											   ORDER BY EF.id
											   LIMIT 100";
	
						$extra_fields_stmt = $dbh->prepare($extra_fields_query);
						$extra_fields_arr = $extra_fields_stmt->execute();
						$extra_fields = $extra_fields_stmt->fetchallAssoc();
						
						foreach($extra_fields as $ef) // Выводим дополниьедльные поля в HTML
						{
							if($ef['type'] == "DATETIME")
							{
						?>
							<div class="zen-form-item">
								<label for="extra-field-<?php echo $ef['ef_id'] ?>" title="<?php echo $ef['details'] ?>"><?php echo $ef['name'] ?></label><br>
								<div class="zif-wrap-date">
                				<input	id="extra-field-<?php echo $ef['ef_id'] ?>" 
                                		class="my-field"
                                		type="date" 
                                        placeholder="Выберите дату" 
                                        value="" 
                                        name="ef_date[<?php echo $ef['ef_id'] ?>]"
                                />
                				</div>
            				</div>
						<?php	
							}else
							{
						?>
							<div class="zen-form-item">
								<label for="create-type" title="<?php echo $ef['details'] ?>"><?php echo $ef['name'] ?></label><br>
								<div class="zif-wrap">
                				<input	id="extra-field-<?php echo $ef['ef_id'] ?>" 
                                		class="my-field"
                                		type="text" 
                                        placeholder="<?php echo $ef['name'] ?>" 
                                        value="<?php echo $ef['default'] ?>" 
                                        name="ef[<?php echo $ef['ef_id'] ?>]" 
                                        size="<?php echo $ef['length'] ?>"
                                        maxlength="<?php echo $ef['length'] ?>"
                                />
                				</div>
            				</div>
						<?php
							}
						}
				}
			?>
</body>
</html>