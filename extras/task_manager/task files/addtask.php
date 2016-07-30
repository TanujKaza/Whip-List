<?php
	require_once('include/common.php') ;

	$project_name = $_POST["project_name"] ;
	$projectid = $GLOBALS['conn']->rawQuery("SELECT p_id from projects where p_name = '$project_name'") ;

	$number = $projectid[0]['p_id'] ;

	$data_task = Array (
						"t_name" => $_POST["name"],
						"t_mode_of_brief" => $_POST["modeofbrief"] ,
						"t_date_of_brief" => strtotime($_POST["datebrief"]),
						"t_date_of_delivery" => strtotime($_POST["datedelivery"]),  
						"t_deliverables"=> $_POST["deliverables"] ,
						"t_status"=>"ongoing",
						"proj_id" => $number ,
						"t_insert_time" =>	time() ,
						"t_edited_time" => 	time()
						 );

	$id = $conn->insert('tasks',$data_task) ; 

	if($id){
		echo "User was created . Id=" . $id ;
	}
	else echo "User not created " . $conn->getLastError() ;
?>

