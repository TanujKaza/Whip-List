<?php

	require_once("include/common.php") ;

	for($i = 1 ; $i <= 30 ; $i++){
		$data_task = Array (
						"u_status" => "ongoing",
						"u_status_description" => "Trial stage" ,
						"u_created_by" => "Carlyle" ,
						"u_edited_by" => "Nitin",  
						"u_edited_time"=> "1464997748" ,
						"u_insert_time"=> "1464777748" , 
						"task_id" => $i );

		$id = $conn->insert('updates',$data_task) ; 

		if($id){
			echo "User was created . Id=" . $id ;
		}
		else echo "User not created " . $conn->getLastError() ; 
	}
?>





