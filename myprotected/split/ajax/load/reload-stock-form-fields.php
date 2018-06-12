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
	$object_id = (int)$_POST['object_id'];
	
	$stocks_query = "SELECT * FROM [pre]stocks WHERE 1 ORDER BY id LIMIT 1000";
			
		$stocks_stmt = $dbh->prepare($stocks_query);
		$stocks_arr = $stocks_stmt->execute();
		$stocks = $stocks_stmt->fetchallAssoc();
?>

<body>
<?php
	switch($object_id)
	{
		case 0: {
					?>
					
            <div class="zen-form-item">
				<label for="create-name">Название* (ABC)</label><br>
				<div class="zif-wrap">
                	<input id="create-name" class="my-field" type="text" placeholder="Введите букву" value="" name="zona" size="20" maxlength="1" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="radio-block-yes">Публикация</label><br>
                <div class="hidden">
                	<input type="radio" name="block[]" id="radio-block-yes" value="0" checked="checked">
                    <input type="radio" name="block[]" id="radio-block-no" value="1">
                </div>
				<div class="zif-wrap-rotator">
                	<div class="check_yn">
                    	<div class="item_yn active" id="block-yes" onclick="change_rotator('block','yes','no');">Да</div>
                        <div class="item_yn" id="block-no" onclick="change_rotator('block','no','yes');">Нет</div>
                    </div>
                </div>
            </div>
					<?php
					break;
				}
		case 1: {
					?>
            
            <div class="zen-form-item">
            <label for="create-zona">Зона</label><br>
				<div class="zif-wrap-select styled-select" id="actual_zones">               	
					<select class="sampling_changed" id="create-zona" name="zona">
						<option value="0" selected="selected" data-skip="1">Укажите зону</option>
					</select>
				</div>
			</div>
            
            <div class="zen-form-item">
				<label for="create-rack">Стеллаж</label><br>
				<div class="zif-wrap">
                	<input id="create-rack" class="my-field" type="number" placeholder="Введите номер" value="" name="rack" size="20" maxlength="1" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-section">Секций</label><br>
				<div class="zif-wrap">
                	<input id="create-section" class="my-field" type="number" placeholder="Укажите к-во" value="" name="section" size="20" maxlength="1" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-shelf">Полок</label><br>
				<div class="zif-wrap">
                	<input id="create-shelf" class="my-field" type="number" placeholder="Укажите к-во" value="" name="shelf" size="20" maxlength="1" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="radio-block-yes">Публикация</label><br>
                <div class="hidden">
                	<input type="radio" name="block[]" id="radio-block-yes" value="0" checked="checked">
                    <input type="radio" name="block[]" id="radio-block-no" value="1">
                </div>
				<div class="zif-wrap-rotator">
                	<div class="check_yn">
                    	<div class="item_yn active" id="block-yes" onclick="change_rotator('block','yes','no');">Да</div>
                        <div class="item_yn" id="block-no" onclick="change_rotator('block','no','yes');">Нет</div>
                    </div>
                </div>
            </div>
					<?php
					break;
				}
		case 2: {
					?>
            
            <div class="zen-form-item">
            <label for="create-zona">Зона</label><br>
				<div class="zif-wrap-select styled-select" id="actual_zones">               	
					<select class="sampling_changed" id="create-zona" name="zona">
						<option value="0" selected="selected" data-skip="1">Укажите зону</option>
					</select>
				</div>
			</div>
            
            <div class="zen-form-item">
            <label for="create-rack">Стеллаж</label><br>
				<div class="zif-wrap-select styled-select" id="actual_racks">               	
					<select class="sampling_changed" id="create-rack" name="rack">
						<option value="0" selected="selected" data-skip="1">Укажите стеллаж</option>
					</select>
				</div>
			</div>
            
            <div class="zen-form-item">
				<label for="create-section">Секция</label><br>
				<div class="zif-wrap">
                	<input id="create-section" class="my-field" type="number" placeholder="Введите номер" value="" name="section" size="20" maxlength="1" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-shelf">Полок</label><br>
				<div class="zif-wrap">
                	<input id="create-shelf" class="my-field" type="number" placeholder="Укажите к-во" value="" name="shelf" size="20" maxlength="1" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="radio-block-yes">Публикация</label><br>
                <div class="hidden">
                	<input type="radio" name="block[]" id="radio-block-yes" value="0" checked="checked">
                    <input type="radio" name="block[]" id="radio-block-no" value="1">
                </div>
				<div class="zif-wrap-rotator">
                	<div class="check_yn">
                    	<div class="item_yn active" id="block-yes" onclick="change_rotator('block','yes','no');">Да</div>
                        <div class="item_yn" id="block-no" onclick="change_rotator('block','no','yes');">Нет</div>
                    </div>
                </div>
            </div>
					<?php
					break;
				}
		case 3: {
					?>
            
            <div class="zen-form-item">
            <label for="create-zona">Зона</label><br>
				<div class="zif-wrap-select styled-select" id="actual_zones">               	
					<select class="sampling_changed" id="create-zona" name="zona" onchange="show_actual_racks($(this).val());">
						<option value="0" selected="selected" data-skip="1">Укажите зону</option>
					</select>
				</div>
			</div>
            
            <div class="zen-form-item">
            <label for="create-rack">Стеллаж</label><br>
				<div class="zif-wrap-select styled-select" id="actual_racks">               	
					<select class="sampling_changed" id="create-rack" name="rack" onchange="show_actual_sections($(this).val());">
						<option value="0" selected="selected" data-skip="1">Укажите стеллаж</option>
					</select>
				</div>
			</div>
            
            <div class="zen-form-item">
            <label for="create-section">Секция</label><br>
				<div class="zif-wrap-select styled-select" id="actual_sections">               	
					<select class="sampling_changed" id="create-section" name="section">
						<option value="0" selected="selected" data-skip="1">Укажите секцию</option>
					</select>
				</div>
			</div>
            
            
            <div class="zen-form-item">
				<label for="create-shelf">Полка</label><br>
				<div class="zif-wrap">
                	<input id="create-shelf" class="my-field" type="number" placeholder="Введите номер" value="" name="shelf" size="20" maxlength="1" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="radio-block-yes">Публикация</label><br>
                <div class="hidden">
                	<input type="radio" name="block[]" id="radio-block-yes" value="0" checked="checked">
                    <input type="radio" name="block[]" id="radio-block-no" value="1">
                </div>
				<div class="zif-wrap-rotator">
                	<div class="check_yn">
                    	<div class="item_yn active" id="block-yes" onclick="change_rotator('block','yes','no');">Да</div>
                        <div class="item_yn" id="block-no" onclick="change_rotator('block','no','yes');">Нет</div>
                    </div>
                </div>
            </div>
					<?php
					break;
				}
		default: {
					echo 'Обекта с таким идентификатором не существует.';
					break;
				 }
	}
?>
</body>
<script type="text/javascript">
	$(function(){
			var stock_id = $('#create-stock').val();
			show_actual_zones(stock_id);
		});
</script>
</html>