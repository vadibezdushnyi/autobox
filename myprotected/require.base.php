<?php 
require 'boot/boot.php';
$db = new DBManager($config);

$dbh = $db;

require 'helpers/functions.php';

require 'helpers/helper.php';
$helper = new Helper($db);

define("WP_LOGIN",$helper->checkAdminLogin());

if(!WP_LOGIN){
	die("You are not logged in, permission denied.");
}