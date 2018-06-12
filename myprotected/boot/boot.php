<?php
//********************
//** GLOBAL SETTINGS
//********************
date_default_timezone_set("Europe/Kiev");
mb_internal_encoding("UTF-8");
error_reporting(0);
ini_set('display_errors', 0);
//********************
//** GLOBAL DEFINES
//********************
define("DEF_LANG","en"); 
define("VIEW_RSF","/delice");
define("RSF","..");
//define("FILESROOT", "/beta/public");
define("FILESROOT", "/public");
define("NATIVE_LANG", DEF_LANG);
define("ADMIN_PATH","myprotected/");
define("WP_FOLDER","split/");
define("EXT_SEM",true);
define("ADMIN_ID",(isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : 0));
define("GLOBAL_ON_PAGE",10);
//********************
//** DATABASE CONFIG
//********************
$config = [
	'host'		=>'localhost',
	'user'		=>'root',
	'pass'		=>'9IHOboGvHW',
	'db'		=>'autobox',
	'charset'	=>'utf8',
	'prefix'	=>'osc_'
];
class DBManager {
	protected $conn;
	public $prefix;
	function __construct($config) 
	{
		$host 	= $config['host'];
		$user 	= $config['user'];
		$pass 	= $config['pass'];
		$db 	= $config['db'];
		$charset= $config['charset'];
		$prefix = $config['prefix'];
                
        $this->conn = mysqli_connect($host,$user,$pass,$db);
		$this->prefix = $prefix;
		if (mysqli_connect_errno()) {
			return false;
		} else {
			return true;
		}
		mysqli_set_charset($conn,$charset);
	}
	public function q($query,$fetch=false,$update=false,$insert_id=false) 
	{
		$query = str_replace('[pre]',$this->prefix,$query);
		mysqli_query($this->conn,'SET NAMES utf8');
		$result = [];
		if ($query = mysqli_query($this->conn,$query)) {
		    while($row = mysqli_fetch_assoc($query)) $result[]=$row;
		    mysqli_free_result($query);
                    if($update)
                        if($insert_id)
                            return mysqli_insert_id($this->conn);
                        else 
                            return true;
		}
                if($update) return false;
		return ($fetch && $result ? $result[0] : $result);
	}
	function __destruct() 
	{
		mysqli_close($this->conn);
	}
}