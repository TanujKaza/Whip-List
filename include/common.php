<?php
	require_once('MysqliDb.php');

	ini_set("error_reporting", E_ALL);
	ini_set("display_errors", 1);


		
	DEFINE('DB_HOST','localhost');
	DEFINE('DB_USER','root');
	DEFINE('DB_PASSWORD','tangoalpha77151');
	DEFINE('DB_NAME','task_scheduler');

	DEFINE('TABLE_PROJECTS','whiplist_projects');
	DEFINE('TABLE_TASKS','whiplist_tasks');
	DEFINE('TABLE_UPDATES','whiplist_updates');
	
	$conn = new Mysqlidb (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	function dd($data){
		echo "<pre>";
		echo print_r($data);
		echo "</pre>";
	}   
?>
