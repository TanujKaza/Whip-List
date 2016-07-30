<?php
	require_once('include/common.php') ;

	$data_task = Array (
						"p_name" => $_POST["projectname"],
						"p_status" => $_POST["project_status"] ,
						"p_edited_time" => time() , 
						"p_insert_time" => time() 
						 );

	$id = $conn->insert('projects',$data_task) ; 

	if($id){
		echo "User was created . Id=" . $id ;
	}
	else echo "User not created " . $conn->getLastError() ;
?>