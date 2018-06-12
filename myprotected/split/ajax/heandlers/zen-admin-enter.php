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
<title>ZEN ADMIN ENTER</title>
</head>

<?php
	$login = strip_tags($_POST['login']);
	$pass = strip_tags($_POST['pass']);
	
	$user_query = "SELECT * FROM [pre]users WHERE login = '".$login."' AND pass = '".md5($pass)."' AND `block` = 0 AND `active`=1 LIMIT 1";
	$user_stmt = $dbh->prepare($user_query);
	$user_stmt->execute();
                	
	$user_result = new DB_Result($user_stmt);
?>
<body>
	<?php
		$user = $user_result->Next();
		
		if($user->id != null && $user->id != "" && $user->id != "0")
		{
			$query = "SELECT * FROM [pre]users_types WHERE id = '".$user->type."' AND 'block' = 0 LIMIT 1";
			
				$_stmt	= $dbh->prepare($query);
				$_arr	= $_stmt->execute();
			
			$_res = $_arr->fetchallAssoc();
			
			if(sizeof($_res) > 0)
			{
				$type = $_res[0];
				
				if($type['admin_enter'] == 1)
				{
					?>
					<script type="text/javascript" language="javascript">
						jQuery.cookie('user_id',<?php echo $user->id ?>);
						jQuery.cookie('user_pass','<?php echo "[p1gH".$user->pass ?>');
						document.location.href = "/wpmanager";
            		</script>
            		<?php
				}else{
					?>
					<script type="text/javascript" language="javascript"> // alert(3);
						$('#login-input-cont').animate({'marginLeft':'-20px'},200,function(){
								$('#login-input-cont').animate({'marginLeft':'0px'},400,'easeOutBounce');
							});
            		</script>
					<?php
					}
			}else{
				?>
				<script type="text/javascript" language="javascript"> // alert(2);
					$('#login-input-cont').animate({'marginLeft':'-20px'},200,function(){
							$('#login-input-cont').animate({'marginLeft':'0px'},400,'easeOutBounce');
						});
            	</script>
				<?php
				}
		}else
		{
			?>
			<script type="text/javascript" language="javascript"> // alert(1);
				$('#login-input-cont').animate({'marginLeft':'-20px'},200,function(){
						$('#login-input-cont').animate({'marginLeft':'0px'},400,'easeOutBounce');
					});
            </script>
			<?php
		}
	?>
</body>
</html>