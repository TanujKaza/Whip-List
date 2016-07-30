<?php
	require_once('include/common.php') ;

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=tasks.csv');

	$output = fopen('php://output', 'w');

	$conn->join(TABLE_UPDATES." u" , "u.task_id = t.t_id" , "LEFT") ;
	$conn->join(TABLE_PROJECTS." p" , "t.proj_id = p.p_id" , "LEFT") ;
	
	$epoch_from = $_POST["date_from_pass"] ;
	$epoch_to = $_POST["date_to_pass"] ;

	$task_status = $_POST["task_status_pass"] ;
	$project_id = $_POST["project_id_pass"] ;

	if($epoch_from == 'NaN') {
		$epoch_from = 0 ;
	}

	if($epoch_to == 'NaN'){
		$epoch_to = 0;
	}

	if($epoch_from && !$epoch_to){
		$conn->where("t_edited_time",$epoch_from,">=") ;  
	}
	else if(!$epoch_from && $epoch_to){
		$conn->where("t_edited_time",$epoch_to,"<=") ;
	}
	else if($epoch_from && $epoch_to){
		$conn->where("t_edited_time",$epoch_from,">=") ;
		$conn->where("t_edited_time",$epoch_to,"<=") ;
	}
	else if(!$epoch_from && !$epoch_to && !$task_status && !$project_id){
		$conn->where("t_status","ongoing") ;
	}

	if($task_status){
		$conn->where("t_status",$task_status) ;
	}

	if($project_id){
		$conn->where("proj_id",$project_id) ;
	}

	$data = $conn->get(TABLE_TASKS." t") ;

	$task_id_initial = $data[0]['t_id'] ;
	$count = 0 ;
	$number_of_entries = 0 ;
	$count_array = array() ;
	$max_status = 0;
	$total_entries = 0 ;

	foreach($data as $row){
		$total_entries++ ;
		if($row['t_id'] == $task_id_initial) {
			$count++ ; 
		}
		else{
			if($max_status < $count) {
				$max_status = $count ;
			}
			$count_array[$number_of_entries] = $count ;
			$number_of_entries++ ;
			$count = 1 ;
			$task_id_initial = $row['t_id'] ;
		}
	}

	$count_array[$number_of_entries] = $count ;
	$number_of_entries++ ;
	
	if($max_status == 0){
		$max_status = $count ;
	}

	$columns = array('Project Name','Task Name', 'Date of Brief' , 'Mode of Brief' , 'Date of Delivery' , 'Deliverables') ;

	for($i = 1 ; $i < $max_status + 1 ; $i++){
		$columns[$i+5] = "Status " ;
		$columns[$i+5] .= $i ;
	}

	fputcsv($output, $columns);
	fputcsv($output, array());

	$i = 0 ;
	$display_entries = 0 ;

	while($i < $total_entries){
		$epoch = $data[$i]['t_date_of_brief'] + 19800;
        $date_of_brief = new DateTime("@$epoch");

        $epoch = $data[$i]['t_date_of_delivery'] + 19800;
        $date_of_delivery = new DateTime("@$epoch");

		$display_array = array($data[$i]['p_name'],$data[$i]['t_name'],$date_of_brief->format('F jS, Y'),$data[$i]['t_mode_of_brief'],$date_of_delivery->format('F jS, Y'),$data[$i]['t_deliverables']) ;
		for($inner = 0 ; $inner < $count_array[$display_entries] ; $inner++){
			$display_array[$inner+6] = $data[$i]['u_status'] ;
			$i++ ;
		}
		$display_entries++ ;
		fputcsv($output, $display_array);
	}
?>