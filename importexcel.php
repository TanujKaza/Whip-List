<?php
	require_once('PHPExcel/Classes/PHPExcel.php') ;
	require_once('include/common.php') ;

	$excel = PHPExcel_IOFactory::load("whiplist.ods");

	function get_epoch_time($month){
		if($month == "DEC"){
			return 1448955053;
		}
		else if($month == "JAN"){
			return 1451633453;
		}
		else if($month == "FEB"){
			return 1454311853;
		}
		else if($month == "MARCH"){
			return 1456817453;
		}
		else if($month == "APRIL"){
			return 1459495853;
		}
		else if($month == "MAY"){
			return 1462087853;
		}
		else if($month == "JUNE"){
			return 1464766253;
		}
	}

	function is_cell_merged($index,$row){
		$GLOBALS['excel']->setActiveSheetIndex($index) ;
		$sheet = $GLOBALS['excel']->getActiveSheet() ;

		$column = 'A';
		$cell = $sheet->getCell($column.$row);

		foreach ($sheet->getMergeCells() as $cells) {
		    if ($cell->isInRange($cells)) {
		        return true ;
		    }
		}
		return false;
	}

	function output_data($index,$maxrow){
		$GLOBALS['excel']->setActiveSheetIndex($index) ;
		$sheet = $GLOBALS['excel']->getActiveSheet() ;
		$title = $sheet->getTitle();

		$column = 'A';
		$row=2;
		$month = $sheet->getCell($column.$row)->getValue();
		$insert_time = get_epoch_time($month);
		$row++ ;
		$highestrow = $maxrow; 

		while($row <= $highestrow){
			if(!is_cell_merged($index,$row)){
				$delicolumn = 'D' ;
				$nextrow = $row+1;
				$format_error = false ;
				if(!$sheet->getCell($column.$nextrow)->getValue() && $sheet->getCell($column.$row)->getValue()){
					$task_name = $sheet->getCell($column.$row)->getValue();
					$task_name.= "-";
					$task_name.= $sheet->getCell($delicolumn.$row)->getValue();
					$task_name_store = $sheet->getCell($column.$row)->getValue();
				}
				else if(!$sheet->getCell($column.$row)->getValue()){
					$task_name = $task_name_store;
					$task_name.= "-";
					$task_name.= $sheet->getCell($delicolumn.$row)->getValue();
				}
				else if($sheet->getCell($column.$nextrow)->getValue() && $sheet->getCell($column.$row)->getValue()){
					$task_name = $sheet->getCell($column.$row)->getValue();
					$task_name_store="";
				}
				$column++;
				$date_of_brief = $sheet->getCell($column.$row)->getValue();
				if(PHPExcel_Shared_Date::isDateTime($sheet->getCell($column.$row))) {
				     $date_of_brief = date("F jS, Y", PHPExcel_Shared_Date::ExcelToPHP($date_of_brief)); 
				}
				else if(PHPExcel_Shared_Date::isDateTime($sheet->getCell($column.$row)) && !$date_of_brief){
					$format_error = true ;
					$date_of_brief = "";
				}
				$column++;
				$mode_of_brief = $sheet->getCell($column.$row)->getValue();
				$column++;
				$deliverables = $sheet->getCell($column.$row)->getValue();
				$column++;
				$date_of_delivery = $sheet->getCell($column.$row)->getValue();
				if(PHPExcel_Shared_Date::isDateTime($sheet->getCell($column.$row))) {
				     $date_of_delivery = strtotime(date("m/d/y", PHPExcel_Shared_Date::ExcelToPHP($date_of_delivery))); 
				}
				$column++;
				$updates = array();
				while($sheet->getCell($column.$row)->getValue() && $sheet->getCell($column.$row)->getValue() != "Closed"){
					$status = $sheet->getCell($column.$row)->getValue();
					array_push($updates,$status);
					$column++ ;
				}

				$creator = "Jovita D'Silva" ;
				$status = "Completed" ;
				$project_id = "5" ;

				if(!$format_error){
					$data_task = Array (
								"t_name" => $task_name ,
								"t_created_by" => $creator,
								"t_mode_of_brief" => $mode_of_brief,
								"t_date_of_brief" => $date_of_brief,
								"t_status" => $status,
								"t_date_of_delivery" =>  $date_of_delivery,
								"t_deliverables" => $deliverables,
								"t_edited_time" => $insert_time,
								"t_edited_by"=> $creator,
								"t_insert_time" => $insert_time,
								"proj_id" => $project_id );
				}
				else{
					$data_task = Array (
								"t_name" => $task_name ,
								"t_created_by" => $creator,
								"t_mode_of_brief" => $mode_of_brief,
								"t_date_of_brief" => $date_of_brief,
								"t_status" => $status,
								"t_date_of_delivery" =>  $date_of_delivery,
								"t_deliverables" => $deliverables,
								"t_edited_time" => $insert_time,
								"t_edited_by"=> $creator,
								"t_insert_time" => $insert_time,
								"t_modify" => "Yes" , 
								"proj_id" => $project_id );
				}

				$task_id = $GLOBALS['conn']->insert(TABLE_TASKS,$data_task) ; 

				if($task_id){
					echo "Task was added . Id=" . $task_id ."<br>";
				}
				else {
					echo "Task not added " . $GLOBALS['conn']->getLastError() ."<br>"; 
				}

				for($count = 0;$count < sizeof($updates) ; $count++){
					$data_update = Array (
									"task_id" => $task_id ,
									"u_status"=> $updates[$count] ,
									"u_edited_time" => $insert_time ,
									"u_created_by" => $creator ,
									"u_edited_by" => $creator,
									"u_insert_time" => $insert_time
								);
					$id = $GLOBALS['conn']->insert(TABLE_UPDATES,$data_update) ;

					if($id){
						echo "Update was added. Id=" . $id . "<br>" ;
					}
					else {
						echo "Update not added" . $GLOBALS['conn']->getLastError() . "<br>" ;
					}
				}

				/*echo $task_name." <br>".$date_of_brief." <br>".$mode_of_brief." <br>".$deliverables." <br>".$date_of_delivery."<br>";
				echo "<pre>";
				print_r($updates);
*/
				$column='A';
				$row++ ;
			}
			else{
				$month = $sheet->getCell($column.$row)->getValue();
				$insert_time = get_epoch_time($month);
				$row++;
			}
		}
	}

	function press_release($index,$maxrow){
		$GLOBALS['excel']->setActiveSheetIndex($index) ;
		$sheet = $GLOBALS['excel']->getActiveSheet() ;
		$title = $sheet->getTitle();

		$column = 'A';
		$row=2;
		$month = $sheet->getCell($column.$row)->getValue();
		$insert_time = get_epoch_time($month);
		$row++ ;
		$highestrow = $maxrow; 

		while($row <= $highestrow){
			if(!is_cell_merged($index,$row)){
				$format_error = false ;
				$press_name = $sheet->getCell($column.$row)->getValue();
				$column++;
				$date_of_brief = $sheet->getCell($column.$row)->getValue();
				$column++;
				$web_upload = $sheet->getCell($column.$row)->getValue();
				$column++;
				$social_post = $sheet->getCell($column.$row)->getValue();
				$column++;
				$date_of_delivery = $sheet->getCell($column.$row)->getValue();
				if(PHPExcel_Shared_Date::isDateTime($sheet->getCell($column.$row))) {
				     $date_of_delivery = strtotime(date("m/d/y", PHPExcel_Shared_Date::ExcelToPHP($date_of_delivery))); 
				}
				else if(PHPExcel_Shared_Date::isDateTime($sheet->getCell($column.$row)) && !$date_of_delivery){
					$format_error = true ;
					$date_of_delivery = "";
				}
				$column++;
				$updates = array();
				while($sheet->getCell($column.$row)->getValue() && $sheet->getCell($column.$row)->getValue() != "Closed"){
					$status = $sheet->getCell($column.$row)->getValue();
					array_push($updates,$status);
					$column++ ;
				}

				$creator = "Devika Nair" ;
				$status = "Ongoing" ;
				$project_id = "9" ;

				if(!$format_error){
					$data_task = Array (
								"t_name" => $press_name ,
								"t_created_by" => $creator,
								"t_date_of_brief" => $date_of_brief,
								"t_status" => $status,
								"t_date_of_delivery" =>  $date_of_delivery,
								"t_web_upload" => $web_upload,
								"t_social_media_upload" => $social_post,
								"t_edited_time" => $insert_time,
								"t_edited_by"=> $creator,
								"t_insert_time" => $insert_time,
								"proj_id" => $project_id );
				}
				else{
					$data_task = Array (
								"t_name" => $task_name ,
								"t_created_by" => $creator,
								"t_mode_of_brief" => $mode_of_brief,
								"t_date_of_brief" => $date_of_brief,
								"t_status" => $status,
								"t_date_of_delivery" =>  $date_of_delivery,
								"t_deliverables" => $deliverables,
								"t_edited_time" => $insert_time,
								"t_edited_by"=> $creator,
								"t_insert_time" => $insert_time,
								"t_modify" => "Yes" , 
								"proj_id" => $project_id );
				}

				$task_id = $GLOBALS['conn']->insert(TABLE_TASKS,$data_task) ; 

				if($task_id){
					echo "Task was added . Id=" . $task_id ."<br>";
				}
				else {
					echo "Task not added " . $GLOBALS['conn']->getLastError() ."<br>"; 
				}

				for($count = 0;$count < sizeof($updates) ; $count++){
					$data_update = Array (
									"task_id" => $task_id ,
									"u_status"=> $updates[$count] ,
									"u_edited_time" => $insert_time ,
									"u_created_by" => $creator ,
									"u_edited_by" => $creator,
									"u_insert_time" => $insert_time
								);
					$id = $GLOBALS['conn']->insert(TABLE_UPDATES,$data_update) ;

					if($id){
						echo "Update was added. Id=" . $id . "<br>" ;
					}
					else {
						echo "Update not added" . $GLOBALS['conn']->getLastError() . "<br>" ;
					}
				}

				/*echo $press_name." <br>".$date_of_brief." <br>".$web_upload." <br>".$social_post." <br>".$date_of_delivery."<br>";
				echo "<pre>";
				print_r($updates);*/

				$column='A';
				$row++ ;
			}
			else{
				$month = $sheet->getCell($column.$row)->getValue();
				$insert_time = get_epoch_time($month);
				$row++;
			}
		}
	}

	// output_data(6,4);
	press_release(2,29);
?>