<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
	
	class EditHelp
	{
		public $dbh;
		
		public $table;
		public $id;
		public $cd;
		public $mysql_date;
			
		public function __construct($dbh,$table,$id,$card_data)
		{
			$this->dbh		= $dbh;
			$this->table	= $table;
			$this->id		= $id;
			$this->cd		= $card_data;
			$this->mysql_date	= date("Y-m-d H:i:s",time());
		}
		
		public function rs($query)
		{
			try
			{
				$_stmt	= $this->dbh->prepare($query);
				$_res	= $_stmt->execute();
				$_arr 	= $_res->fetchallAssoc();
				
				return $_arr;
			}catch(Exception $e)
			{
				echo 'WP WARNING: '.$e;
				return array();
			}
		}
		
		public function doit($query)
		{
			try
			{
				$_stmt	= $this->dbh->prepare($query);
				$_stmt->execute();
				
				return true;
			}catch(Exception $e)
			{
				echo 'WP WARNING: '.$e;
				return false;
			}
		}
	} // end of Class
	
	$eh = new EditHelp($dbh,$_POST['table'],$_POST['id'],unserialize($_POST['card_data']));
	
	$query = "SELECT  * FROM [pre]admin_tmp 
				WHERE `admin_id`='".ADMIN_ID."' 
				ORDER BY id DESC";
				
	$result = $eh->rs($query);
	$tmp = ($result ? $result[0]['tmp'] : 0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Action EDIT CARD OBJECT</title>
</head>

<body>
<?php 
	echo '<pre>'; print_r($_POST); echo '</pre>'; // die("STOP");
	
	if($eh->cd)
	{
		foreach($eh->cd as $step)
		{
			switch($step['type'])
			{
				case	'simple':{
						$query = "UPDATE [pre]".$step['table']." SET `dateModify`='".$eh->mysql_date."', `adminMod`='".ADMIN_ID."'";
						foreach($step['fields'] as $sf)
						{
							switch($sf['type'])
							{
								case	'int':{
										$value = (int)$_POST[$sf['field']];
										break;
									}
								case	'float':{
										$value = (float)$_POST[$sf['field']];
										break;
									}
								case	'varchar':{
										$value = strip_tags(trim($_POST[$sf['field']]));
										break;
									}
								case	'text':{
										$value = trim($_POST[$sf['field']]);
										break;
									}
								case	'date':{
										$value = date("Y-m-d H:i:s",strtotime($_POST[$sf['field']]));
										break;
									}
								case	'rotator':{
										$value = $_POST[$sf['field']][0];
										break;
									}
								default:{
										$value = $_POST[$sf['field']];
										break;
									}
							}
							$value = str_replace("'","\'",$value);
							$query .= ",`".$sf['field']."`='".$value."'";
						}
						
						$query .= " WHERE `id`='".$eh->id."' LIMIT 1";
						
						if($eh->doit($query))
						{
							echo "<p>Запись успешно обновлена.</p>";
						}else
						{
							echo "<p>Не удалось редактировать запись.</p>";
						}
						
						break;
					}
				case	'require':{
						require_once("../require/".$step['path']);
						break;
					}
				default: break;
			}
		}
	}else
	{
		echo '<p>Неверный формат переменной CARD_DATA</p>';
	}								
	
	echo "<p>Message: ".$message."</p>";
	
	$status_query = "INSERT INTO [pre]admin_tmp (`admin_id`,`tmp`) VALUES ('".ADMIN_ID."','".$message."')";

		$status_stmt = $dbh->prepare($status_query);
		$status_stmt->execute();
		
/*
INSERT INTO `next_shop_prod_group_ref` (prod_id, group_id)
SELECT 'prod_id', 'group_id' FROM DUAL 
WHERE NOT EXISTS (SELECT * FROM `next_shop_prod_group_ref` 
      WHERE prod_id='1' AND group_id='2') 
LIMIT 1 

step 1. CREATE UNIQUE INDEX id ON `next_shop_prod_group_ref` (`prod_id`,`group_id`);

step 2. INSERT IGNORE INTO `next_shop_prod_group_ref` (`prod_id`,`group_id`) VALUES (1,3)
		*/
?>
</body>
</html>