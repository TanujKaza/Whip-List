<?php
	
	ini_set("error_reporting", E_ALL);
	ini_set("display_errors", 1);


		
	DEFINE('DB_HOST','localhost');
	DEFINE('DB_USER','root');
	DEFINE('DB_PASSWORD','tangoalpha77151');
	DEFINE('DB_NAME','task_manager');

	require_once('MysqliDb.php');
	$conn = new Mysqlidb (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

?>
