<?php 
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
session_start();
ob_start();
//DB_HOST, DB_USER, DB_PASSWORD DB_NAME
    define("DB_HOST", "localhost");
	define("DB_USER", "root");
	define("DB_PASSWORD", "");
	define('DB_DRIVER', 'mysql');					
	define("DB_DATABASE", "agile_test");
	require_once("functions.php");
	// basic options for PDO 
	$dboptions = array(
		PDO::ATTR_PERSISTENT => TRUE,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_EMULATE_PREPARES, false,
    );						
	//connect with the server
	try {
		$DB = new PDO(DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_DATABASE, DB_USER, DB_PASSWORD, $dboptions);
	 } catch (Exception $ex) {
	   echo($ex->getMessage());
    	die;
	}
	
?>

