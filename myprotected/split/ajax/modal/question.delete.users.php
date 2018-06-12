<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	//require_once "../../../require.base.php";
 ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Question DELETE USERS</title>
</head>

<body>
	<button class="close-modal" onclick="close_modal();">Закрыть окно</button>
    <div class="modalW" id="modalW-1">
    	<h4>Действительно удалить отчеченных пользователей?</h4>
        
        <a href="#" class="modalYes" onclick="delete_checked_users();">Да, подтверждаю удаление.</a>&nbsp;&nbsp;
        <a href="#" class="modalNo" onclick="close_modal();">Нет, отменить действие.</a>
    </div>
<?php 
	$answer_path = $_POST['answer_path'];
?>
</body>

<script type="text/javascript" language="javascript">
	function delete_checked_users()
	{
		var cur_users = [];
		$('input.table-checkbox[type=checkbox]:checked').each(function(){
				var cur_user_id = $(this).val();
				if(cur_user_id != 'null')
				{
					cur_users.push(cur_user_id);
					$('tr#'+cur_user_id).hide();
				}
			});
		var data = { 'users[]':cur_users }
		$('#modalW-1').load('<?php echo $answer_path ?>',data);
	}
</script>

</html>