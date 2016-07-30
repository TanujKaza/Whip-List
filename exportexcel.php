<?php
	require_once('PHPExcel/Classes/PHPExcel.php') ;
	require_once('include/common.php') ;

	$filename = "TATA Steel Daily Activity Sheet_";
	$current_epoch_time = time() + 19800 ;
	$current_date = new DateTime("@$current_epoch_time");
	$formatted_date = $current_date->format('jS F');
	$filename .= $formatted_date ;

	header("Content-Type: application/vnd.ms-excel; charset=utf-8");
	header('Content-Disposition: attachment; filename="'.$filename.'.xls"');
	header("Cache-Control: max-age=0");

	$excel = new PHPExcel();

	$objWorkSheet = $excel->createSheet(0)->setTitle("TS-Corp");
	$objWorkSheet = $excel->createSheet(1)->setTitle("TS-Closed");
	$objWorkSheet = $excel->createSheet(2)->setTitle("Press Releases");
	$objWorkSheet = $excel->createSheet(3)->setTitle("Valueabled");
	$objWorkSheet = $excel->createSheet(4)->setTitle("Valueabled(Closed)");
	$objWorkSheet = $excel->createSheet(5)->setTitle("Projects");
	$objWorkSheet = $excel->createSheet(6)->setTitle("Projects(Closed)");
	$objWorkSheet = $excel->createSheet(7)->setTitle("Long Term Projects");

	function input_data($task_status,$proj_id,$sheet_index){
		$GLOBALS['conn']->join(TABLE_UPDATES." u" , "u.task_id = t.t_id" , "LEFT") ;
		$GLOBALS['conn']->join(TABLE_PROJECTS." p" , "t.proj_id = p.p_id" , "LEFT") ;
		if($task_status){
			$GLOBALS['conn']->where("t_status",$task_status) ;
		}
		else{
			$GLOBALS['conn']->where ("(t_status = ? or t_status = ?)", Array("Ongoing","Completed"));
		}
		$GLOBALS['conn']->where("proj_id",$proj_id) ;
		$GLOBALS['conn']->orderBy("t_edited_time","Desc");

		$data = $GLOBALS['conn']->get(TABLE_TASKS." t") ;

		$styleArray = array(
		    'font'  => array(
		        'size'  => 10,
		        'name'  => 'Frutiger LT 45 Light'
		    ));

		if($data && $data[0]['p_status'] != "deleted" && $data[0]['p_status'] != "Deleted"){
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
			
			if($max_status == 0 || $max_status < $count){
				$max_status = $count ;
			}

			$GLOBALS['excel']->setActiveSheetIndex($sheet_index) ;
			$sheet = $GLOBALS['excel']->getActiveSheet() ;
			if($task_status){
				$sheet->setCellValue("A1", "Task Name")->setCellValue("B1","Date of Brief")->setCellValue("C1","Mode of Brief")->setCellValue("D1","Date of Delivery")->setCellValue("E1","Deliverables");
			}
			else{
				$sheet->setCellValue("A1", "Press Release Name")->setCellValue("B1","Date of Brief")->setCellValue("C1","Status")->setCellValue("D1","Web Upload")->setCellValue("E1","Social Media Post")->setCellValue("F1","Date of Delivery");
			}
			$sheet->getRowDimension(1)->setRowHeight(20);

			$sheet->getColumnDimension("A")->setWidth(55);
			$sheet->getColumnDimension("B")->setWidth(21);
			$sheet->getColumnDimension("C")->setWidth(14);
			$sheet->getColumnDimension("D")->setWidth(17);
			if($task_status){
				$sheet->getColumnDimension("E")->setWidth(36);
			}
			else{
				$sheet->getColumnDimension("E")->setWidth(20);
				$sheet->getColumnDimension("F")->setWidth(17);
			}

			$BStyle = array(
			  'borders' => array(
			    'allborders' => array(
			      'style' => PHPExcel_Style_Border::BORDER_THIN 
			    )
			  )
			);

			$sheet->getDefaultStyle()->applyFromArray($BStyle);

			$sheet->getDefaultStyle()->applyFromArray($styleArray);

			// $sheet->getStyle('A1:Z999')->getAlignment()->setWrapText(true); 

			$sheet->getStyle('A1:F1')->getFont()->setBold(true);
			$sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$row = 1;

			if($task_status) $column = 'F' ;
			else $column = 'G' ;

			for($iterator = 1 ; $iterator < $max_status + 1 ; $iterator++){
				$sheet->setCellValue($column.$row, "Status".$iterator) ;
				$sheet->getColumnDimension($column)->setWidth(50);
				$sheet->getStyle($column.$row)->getFont()->setBold(true);
				$sheet->getStyle($column.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$column++ ;
			}

			$i = 0 ;
			$display_entries = 0 ;
			$num_rows = 0 ;
			$store_month = "" ;

			while($i < $total_entries){
				$row = $num_rows + 2;
				$sheet->getRowDimension($row)->setRowHeight(20);

		        if($data[$i]['t_date_of_delivery']){
		        	$epoch = $data[$i]['t_date_of_delivery'] + 19800;
		       		$date_of_delivery = new DateTime("@$epoch");
		       	}
		       	else{
		       		$date_of_delivery = "" ;
		       	}

		        $epoch =  $data[$i]['t_edited_time'] + 19800;
		        $task_edited_time = new DateTime("@$epoch");
		        $month = $task_edited_time->format('F');
		        $year = $task_edited_time->format('Y');

		        $date_formatted = $month." ".$year;

		        if(($display_entries == 0 || $month != $store_month) && $data[$i]['p_id'] != 10){
		        	$styleArray = array(
				    	'font'  => array(
					        'bold'  => true,
					        'color' => array('rgb' => 'FFFFFF')
				    ));

		        	$num_rows++ ;
		        	$row = $num_rows + 2;
		        	$sheet->getRowDimension($row)->setRowHeight(20);
		        	$store_month=$month;
		        	$sheet->setCellValue("A".$row, $date_formatted);
		        	$sheet->getStyle("A".$row)->applyFromArray($styleArray);
		        	$sheet->getStyle("A".$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('3399CC');
		        	$from_cell = "A".$row ;
		        	$to_cell = "AZ".$row ;
		        	$sheet->mergeCells($from_cell.':'.$to_cell);
		        	$num_rows++ ;
		        }
		        if($row != $num_rows + 2){
		        	$row = $num_rows + 2;
		        	$sheet->getRowDimension($row)->setRowHeight(20);
		        }
		        if($date_of_delivery){
			        if($task_status){
			        	$sheet->setCellValue("A".$row, $data[$i]['t_name'])->setCellValue("B".$row,$data[$i]['t_date_of_brief'])->setCellValue("C".$row,$data[$i]['t_mode_of_brief'])->setCellValue("D".$row,$date_of_delivery->format('F jS, Y'))->setCellValue("E".$row,$data[$i]['t_deliverables']);

			        	$column = 'F' ;
			    	}
			    	else{
			    		$sheet->setCellValue("A".$row, $data[$i]['t_name'])->setCellValue("B".$row,$data[$i]['t_date_of_brief'])->setCellValue("C".$row,$data[$i]['t_status'])->setCellValue("D".$row,$data[$i]['t_web_upload'])->setCellValue("E".$row,$data[$i]['t_social_media_upload'])->setCellValue("F".$row,$date_of_delivery->format('F jS, Y'));
			    		$column = 'G' ;
			    	}
			    }
			    else{
			    	if($task_status){
			        	$sheet->setCellValue("A".$row, $data[$i]['t_name'])->setCellValue("B".$row,$data[$i]['t_date_of_brief'])->setCellValue("C".$row,$data[$i]['t_mode_of_brief'])->setCellValue("D".$row,$date_of_delivery)->setCellValue("E".$row,$data[$i]['t_deliverables']);

			        	$column = 'F' ;
			    	}
			    	else{
			    		$sheet->setCellValue("A".$row, $data[$i]['t_name'])->setCellValue("B".$row,$data[$i]['t_date_of_brief'])->setCellValue("C".$row,$data[$i]['t_status'])->setCellValue("D".$row,$data[$i]['t_web_upload'])->setCellValue("E".$row,$data[$i]['t_social_media_upload'])->setCellValue("F".$row,$date_of_delivery);
			    		$column = 'G' ;
			    	}
			    }

		    	$sheet->getStyle("A".$row)->getFont()->setBold(true);

				for($inner = 0 ; $inner < $count_array[$display_entries] ; $inner++){
					$sheet->setCellValue($column.$row, $data[$i]['u_status']) ;
					if($inner == $count_array[$display_entries] - 1){
						$sheet->getStyle($column.$row)->getAlignment()->setWrapText(true);
						$sheet->getStyle($column.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					}
					$column++ ;
					$i++ ;
				}
				$display_entries++ ;
				$num_rows++ ;
			}
		}
		else{
			$GLOBALS['excel']->setActiveSheetIndex($sheet_index) ;
			$sheet = $GLOBALS['excel']->getActiveSheet() ;

			$sheet->setCellValue("A1", "There is no data to be shown");
			$sheet->getColumnDimension("A")->setWidth(55);

			$sheet->getDefaultStyle()->applyFromArray($styleArray);
			$sheet->getStyle('A1:F1')->getFont()->setBold(true);
		}
	}

	input_data("ongoing","1","0");
	input_data("completed","1","1");
	input_data("","9","2") ;
	input_data("ongoing","3","3");
	input_data("completed","3","4");
	input_data("ongoing","5","5");
	input_data("completed","5","6");
	input_data("ongoing","10","7");

	$excel->setActiveSheetIndex(0) ;
	$excel->removeSheetByIndex(8);

	$objWriter = PHPExcel_IOFactory::createWriter($excel, "Excel5");
	$objWriter->save("php://output");

	exit;

?>