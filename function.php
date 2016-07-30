<?php
	require_once('include/common.php') ;

	function ongoing_tasks($epoch_from=0,$epoch_to=0,$task_status="",$project_id=0,$page=1){
      $GLOBALS['conn']->join(TABLE_UPDATES." u" , "u.task_id = t.t_id" , "LEFT") ;
      $GLOBALS['conn']->join(TABLE_PROJECTS ." p" , "t.proj_id = p.p_id" , "LEFT") ;
     
      if(!$epoch_from && !$epoch_to && !$task_status && !$project_id){
        $GLOBALS['conn']->where("t_status","ongoing") ;
      }
      else if(!$epoch_from && $epoch_to){
        $GLOBALS['conn']->where("t_edited_time",$epoch_to,"<=") ;
      }
      else if($epoch_from && !$epoch_to){
        $GLOBALS['conn']->where("t_edited_time",$epoch_from,">=") ;    
      }
      else if($epoch_from && $epoch_to){
        $GLOBALS['conn']->where("t_edited_time",$epoch_from,">=") ;
        $GLOBALS['conn']->where("t_edited_time",$epoch_to,"<=") ;
      }

      if($task_status){
      	$GLOBALS['conn']->where("t_status",$task_status) ;
      }

      if($project_id){
      	$GLOBALS['conn']->where("proj_id",$project_id) ;
      }

      $GLOBALS['conn']->orderBy("t_edited_time","Desc");
      $tasks = $GLOBALS['conn']->get(TABLE_TASKS." t");
     
      $start_length = array();

      array_push($start_length,0);

      $numrows = 0;
      $rowsperpage = 30 ;

      for($iterator=0;$iterator<sizeof($tasks);$iterator++){
      	$task_id_store = $tasks[$iterator]['t_id'] ;
      	while($tasks[$iterator]['t_id'] == $task_id_store){
          	if($iterator != sizeof($tasks)-1){
				$iterator++ ;
			}
          	else{
          		break;
          	}
        }

        if($tasks[$iterator]['t_id'] != $task_id_store){
          	$iterator-- ;
		}

		if($tasks[$iterator]['t_status'] != "deleted"){
			$numrows++ ;
		}

		if(($numrows%$rowsperpage) == 0){
    		$next_start = $iterator + 1;
    		array_push($start_length,$next_start);
    	}
      }	

      $totalpages = ceil($numrows / $rowsperpage);

      $num_rows_shown = 0;

      $starting_entry = (($page - 1) * $rowsperpage) + 1 ;

      if($page != $totalpages && $totalpages != 0){
      	$last_entry = $page * $rowsperpage ;
      }
      else if($page == $totalpages && $totalpages != 0){
      	$last_entry = $numrows ;
      }
      else if($totalpages == 0){
      	$starting_entry = 0;
      	$last_entry = 0;
      }

      $a = "";

     /* $a .= "<span class='pull-right' style='margin-right:20px;'><strong>Showing ". $starting_entry . "-" . $last_entry ." of " . $numrows . " entries </strong></span><br><br> " ;*/

  	 $a .=  "<table class='table table-bordered table-hover table-striped display' id='example'>
              <thead>
                <tr>
                 <th style='text-align:center;'>Task Name</th>
                 <th style='width:200px;text-align:center;'>Project Name</th>
                 <th style='width:200px;text-align:center;'>Update Time</th>
                </tr>
            </thead>
             <tbody>";

 	  for($iterator=0;$iterator<sizeof($tasks);$iterator++){
 	  		$task_id_store = $tasks[$iterator]['t_id'] ;

	        while($tasks[$iterator]['t_id'] == $task_id_store){
	          	if($iterator != sizeof($tasks)-1){
					$iterator++ ;
				}
	          	else{
	          		break;
	          	}
	        }

	        if($tasks[$iterator]['t_id'] != $task_id_store){
	          	$iterator-- ;
			}

	        if($tasks[$iterator]['t_status'] != "deleted"){
		          if($tasks[$iterator]['t_edited_time']){
		          	$epoch = $tasks[$iterator]['t_edited_time'] + 19800;
		            $dt = new DateTime("@$epoch");
		          }
		          $no_update = "No update to be shown" ;
		          $a .= "<tr class='gradeA'>
			            <td><strong><span style='border-bottom: 1px solid black;'>" . $tasks[$iterator]['t_name'] . "</span></strong><br>";

			      if(!$tasks[$iterator]['u_status']) $a .= "<div>" . $no_update . "" ;
		              else $a .= "<div>" .$tasks[$iterator]['u_status'] . "" ; 

			      $a .=  "</div></td>
			            <td style='text-align:center;'>" . $tasks[$iterator]['p_name'] . "</td> 
			            <td style='text-align:center;'><span style='border-bottom: 1px solid black'>" . $dt->format('H:i , F jS, Y') ."<span><br>";
		          
		          if($tasks[$iterator]['p_name'] != "Press Releases"){
		          	$a .= "<button class='button_edit' data-toggle='modal' data-target='#myModalupdate' onclick='remove_error_update()' id=".$tasks[$iterator]['t_id']." style='text-align:center;margin-top:10px;'>Edit</button></td></tr>" ;
		          }
		          else if($tasks[$iterator]['p_name'] == "Press Releases"){
		          	$a .= "<button class='button_edit_press' data-toggle='modal' data-target='#myModalupdate_press' onclick='remove_error_update_press()' id=".$tasks[$iterator]['t_id']." style='text-align:center;margin-top:10px;'>Edit</button></td></tr>" ;
		          }
		          $num_rows_shown++ ;
	        }
	  }

	  /*$totalpages=3;
	  $num_rows_shown = 0;*/

      /*foreach($tasks as $task){
        if($count == -1){
          $count = 0 ;
          foreach($users as $user){
            if ( $user['t_id'] == $task['t_id'] && $user['p_id'] == $task['p_id']) $count++ ;
          }
        }
        if($count > 0){
          $count-- ;
        }
        if($count == 0){
        	if($task['t_status'] != "deleted"){
	          if($task['t_edited_time']){
	          	$epoch = $task['t_edited_time'] + 19800;
	            $dt = new DateTime("@$epoch");
	          }
	          $no_update = "No update to be shown" ;
	          $a .= "<tr class='gradeA'>
	              <td><strong>" . $task['t_name'] . "</strong></td>
	              <td style='text-align:center;'>" . $task['p_name'] . "</td> 
	              <td style='text-align:center;'>" . $dt->format('H:i , F jS, Y') ."</td> 
	              </tr>" ;

	          if(!$task['u_status']) $a .= "<tr><td colspan='2'>" . $no_update . "</td>" ;
	              else $a .= "<tr><td colspan='2'>" .$task['u_status'] . "</td>" ; 
	          
	          if($task['p_name'] != "Press Releases"){
	          	$a .= "<td style='text-align:center;'> <button class='button_edit' data-toggle='modal' data-target='#myModalupdate' onclick='remove_error_update()' id=".$task['t_id']." style='text-align:center;'>Edit</button> </td></tr>" ;
	          }
	          else if($task['p_name'] == "Press Releases"){
	          	$a .= "<td style='text-align:center;'> <button class='button_edit_press' data-toggle='modal' data-target='#myModalupdate_press' onclick='remove_error_update_press()' id=".$task['t_id']." style='text-align:center;'>Edit</button> </td></tr>" ;
	          }
	       }
          $count = -1 ;
        }
      }*/

      $a .= "</tbody>
             <tfoot>
              <tr>
               <th style='text-align:center;'>Task Name</th>
               <th style='text-align:center;'>Project Name</th>
            
               <th style='text-align:center;'>Update Time</th>
               
              </tr> 
             </tfoot>
           </table>" ;

       /*$a.= "<ul class='pagination'>
       		<li><a href='#' id='show_previous_pages'>«</a></li>";
       for($count = 1 ;$count <= $totalpages ; $count++){
       		$a.= "<li><a href='#' class='pagination_values' id='".$count."'>".$count."</a></li>" ;
       }
       $a .= "<li><a href='#' id='show_next_pages'>»</a></li></ul>" ;*/
      echo $a ;
    }

    function tasks_recycle(){
    	$GLOBALS['conn']->where("t_status","deleted") ;
    	$GLOBALS['conn']->orderBy("t_edited_time","Desc");
      	$tasks = $GLOBALS['conn']->get(TABLE_TASKS." t") ;

      	$a =  "<table class='table table-bordered table-hover table-striped display' id='example' >
              <thead>
                <tr>
                 <th style='text-align:center;'>Task Name</th>
                 <th style='width:200px;text-align:center;'>Project Name</th>
                 <th style='width:200px;text-align:center;'>Action</th>
                </tr>
            </thead>
             <tbody>";

        foreach($tasks as $task){
        	$GLOBALS['conn']->where("p_id",$task['proj_id']) ;
        	$projects = $GLOBALS['conn']->get(TABLE_PROJECTS) ;

        	if($projects[0]['p_status'] != "deleted" && $projects[0]['p_status'] != "Deleted"){
        		$a .= "<tr class='gradeA'>
	              <td>" . $task['t_name'] . "</td>
	              <td style='text-align:center;'>" . $projects[0]['p_name'] . "</td> 
	              <td style='text-align:center;'> <button class='button_restore_task' data-toggle='modal' data-target='#myModalrestore_confirm' id=".$task['t_id']." style='text-align:center;'>Restore</button> </td></tr>";
        	}
        }

        $a .= "</tbody>
             <tfoot>
              <tr>
               <th style='text-align:center;'>Task Name</th>
               <th style='text-align:center;'>Project Name</th>
            
               <th style='text-align:center;'>Action</th>
               
              </tr> 
             </tfoot>
           </table>" ;
      echo $a ;
    }

    function projects_recycle(){
		$GLOBALS['conn']->where("p_status","deleted") ;
    	$GLOBALS['conn']->orderBy("p_edited_time","Desc");
      	$projects = $GLOBALS['conn']->get(TABLE_PROJECTS) ;

      	$a =  "<table class='table table-bordered table-hover table-striped display' id='example' >
              <thead>
                <tr>
                 <th style='text-align:center;'>Project Name</th>
                 <th style='width:200px;text-align:center;'>Deletion Date</th>
                 <th style='width:200px;text-align:center;'>Action</th>
                </tr>
            </thead>
             <tbody>";

        foreach($projects as $project){ 
        		$epoch = $project['p_edited_time'] + 19800;
            	$dt = new DateTime("@$epoch");  

        		$a .= "<tr class='gradeA'>
	              <td>" . $project['p_name'] . "</td> 
	              <td style='text-align:center;'>".$dt->format('H:i , F jS, Y') . "</td>
	              <td style='text-align:center;'> <button class='button_restore_project' data-toggle='modal' data-target='#myModalrestore_confirm_proj' id=".$project['p_id']." style='text-align:center;'>Restore</button> </td></tr>";
        }

        $a .= "</tbody>
             <tfoot>
              <tr>
               <th style='text-align:center;'>Project Name</th>
               <th style='text-align:center;'>Deletion Date</th>
               <th style='text-align:center;'>Action</th>
              </tr> 
             </tfoot>
           </table>" ;
      echo $a ;
	}

    function projects_info(){
    	$GLOBALS['conn']->where('p_status',Array("Ongoing","ongoing"),'IN');
    	$projects = $GLOBALS['conn']->get(TABLE_PROJECTS) ;

    	$a =  "<table class='table table-bordered table-hover table-striped display' id='example' >
              <thead>
                <tr>
                 <th style='width:300px;text-align:center;'>Project Name</th>
                 <th style='width:100px;text-align:center;'>Status</th>
                 <th style='width:100px;text-align:center;'>Action</th>
                </tr>
            </thead>
             <tbody>";

        foreach($projects as $project){
        	$a .= "<tr class='gradeA'>
              <td style='text-align:center;'>" . $project['p_name'] . "</td> 
              <td style='text-align:center;'>" . $project['p_status'] . "</td> 
              <td style='text-align:center;'> <button class='button_edit_project' data-toggle='modal' data-target='#myModaledit_project' id=".$project['p_id']." style='text-align:center;'>Edit</button> </td></tr>";
        }

        $a .= "</tbody>
             <tfoot>
              <tr>
               <th style='text-align:center;'>Project Name</th>
               <th style='text-align:center;'>Status</th>
            
               <th style='text-align:center;'>Action</th>
               
              </tr> 
             </tfoot>
           </table>" ;
      echo $a ;
	}

    function add_task($project_name,$task_name,$mode_of_brief,$date_of_brief,$date_of_delivery,$deliverables,$update_status){
		$project_id = $GLOBALS['conn']->rawQuery("SELECT p_id from ". TABLE_PROJECTS ." where p_name = '$project_name'") ;

		$number = $project_id[0]['p_id'] ;

		$data_task = Array (
							"t_name" => $task_name,
							"t_mode_of_brief" => $mode_of_brief ,
							"t_date_of_brief" => $date_of_brief,
							"t_date_of_delivery" => strtotime($date_of_delivery),  
							"t_deliverables"=> $deliverables ,
							"t_status"=>"ongoing",
							"proj_id" => $number ,
							"t_insert_time" =>	time() ,
							"t_edited_time" => 	time()
							 );

		$id = $GLOBALS['conn']->insert(TABLE_TASKS,$data_task) ; 

		/*if($id){
			echo "The task has been added" ;
		}
		else{
			echo "An error was encountered" ;
		} */

		if($update_status){
			$data_update = Array (
								"task_id" => $id ,
								"u_status"=> $update_status ,
								"u_edited_time" => time() ,
								"u_insert_time" => time()
							);
			$id = $GLOBALS['conn']->insert(TABLE_UPDATES,$data_update) ; 

			/*if($id){
				echo "Update was added. Id=" . $id ;
			}
			else {
				echo "Update not added" . $GLOBALS['conn']->getLastError() ;
			}*/
		}
	    
	}
	
	function add_press($press_name,$date_of_brief,$date_of_delivery,$webupload,$social_mediaupload,$update_status){
		$data_press = Array (
							"t_name" => $press_name,
							"t_date_of_brief" => $date_of_brief,
							"t_date_of_delivery" => strtotime($date_of_delivery), 
							"t_web_upload"=>$webupload,
							"t_social_media_upload"=>$social_mediaupload,
							"t_status"=>"Ongoing",
							"proj_id" => "9" ,
							"t_insert_time" =>	time() ,
							"t_edited_time" => 	time()
						);
		$id = $GLOBALS['conn']->insert(TABLE_TASKS,$data_press) ; 

		/*if($id){
			echo "The Press Release has been added" ;
		}
		else{
			echo "An error was encountered" ;
		} */

		if($update_status){
			$data_update = Array (
								"task_id" => $id ,
								"u_status"=> $update_status ,
								"u_edited_time" => time() ,
								"u_insert_time" => time()
							);
			$id = $GLOBALS['conn']->insert(TABLE_UPDATES,$data_update) ; 

			/*if($id){
				echo "Update was added. Id=" . $id ;
			}
			else {
				echo "Update not added" . $GLOBALS['conn']->getLastError() ;
			}*/
		}

	}

	function add_project($project_name){
		$data_project = Array (
						"p_name" => $project_name ,
						"p_status" => "Ongoing" ,
						"p_edited_time" => time() , 
						"p_insert_time" => time() 
						 );

		$id = $GLOBALS['conn']->insert(TABLE_PROJECTS,$data_project) ; 

		/*if($id){
			echo "The project has been added" ;
		}
		else {
			echo "An error was encountered" ;
		}*/
	}

	function edit_task($task_id,$task_name,$mode_of_brief,$date_of_brief,$date_of_delivery,$deliverables,$task_status,$update_status,$project_id){
		
		if($project_id == 10 && ($task_status == "Completed" || $task_status == "completed")){
			$project_id = 1;
		}
		
		$data_task = Array (
						"t_name" => $task_name,
						"t_mode_of_brief" => $mode_of_brief ,
						"t_date_of_brief" => $date_of_brief ,
						"t_date_of_delivery" => strtotime($date_of_delivery),  
						"t_deliverables"=> $deliverables ,
						"t_status"=> $task_status ,
						"proj_id"=>$project_id,
						"t_edited_time" => 	time()
						 );

		$GLOBALS['conn']->where('t_id', $task_id);

		$id = $GLOBALS['conn']->update(TABLE_TASKS, $data_task) ;

		/*if ($id){
		    echo "The task has been updated" ;
		}
		else{
			echo "There was an error in task updating" ;
		}
*/
		if($update_status){
			$data_update = Array (
								"task_id" => $task_id,
								"u_status"=> $update_status ,
								"u_edited_time" => time() ,
								"u_insert_time" => time()
							);
			$id = $GLOBALS['conn']->insert(TABLE_UPDATES,$data_update) ; 

			/*if($id){
				echo "Update was added. Id=" . $id ;
			}
			else {
				echo "Update not added" . $GLOBALS['conn']->getLastError() ;
			}*/
		}
	}

	function edit_press($task_id,$press_name,$date_of_brief,$date_of_delivery,$web_upload,$social_mediaupload,$task_status,$update_status){
		$data_task = Array (
						"t_name" => $press_name,
						"t_date_of_brief" => $date_of_brief ,
						"t_date_of_delivery" => strtotime($date_of_delivery),  
						"t_web_upload"=> $web_upload ,
						"t_social_media_upload"=> $social_mediaupload ,
						"t_status"=> $task_status ,
						"t_edited_time" => 	time()
						 );

		$GLOBALS['conn']->where('t_id', $task_id);

		$id = $GLOBALS['conn']->update(TABLE_TASKS, $data_task) ;

		/*if ($id){
		    echo "The task has been updated" ;
		}
		else{
			echo "There was an error in task updating" ;
		}
*/
		if($update_status){
			$data_update = Array (
								"task_id" => $task_id,
								"u_status"=> $update_status ,
								"u_edited_time" => time() ,
								"u_insert_time" => time()
							);
			$id = $GLOBALS['conn']->insert(TABLE_UPDATES,$data_update) ; 

			/*if($id){
				echo "Update was added. Id=" . $id ;
			}
			else {
				echo "Update not added" . $GLOBALS['conn']->getLastError() ;
			}*/
		}

	}

	function edit_update($update,$update_id){
			$data_update = Array (
								"u_status"=> $update ,
								"u_edited_time" => time() 
							);

			$GLOBALS['conn']->where('u_id', $update_id);
			$id = $GLOBALS['conn']->update(TABLE_UPDATES, $data_update) ;

			/*if ($id){
			    echo "The update has been modified" ;
			}
			else{
				echo "There was an error in update modification" ;
			}
*/
			$task_id = $GLOBALS['conn']->rawQuery("SELECT task_id from ". TABLE_UPDATES ." where u_id = '$update_id'") ;

			$number = $task_id[0]['task_id'] ;

			$data_task = Array (
								"t_edited_time" => time()
								);

			$GLOBALS['conn']->where('t_id', $number);

			$id = $GLOBALS['conn']->update(TABLE_TASKS, $data_task) ;

			/*if ($id){
			    echo $GLOBALS['conn']->count . ' record in tasks was updated';
			}
			else{
				echo 'update failed: ' . $GLOBALS['conn']->getLastError();
			}*/


		
	}

	function delete_update($update_id){
		$GLOBALS['conn']->where('u_id', $update_id);
		if($GLOBALS['conn']->delete(TABLE_UPDATES)) {
			//echo 'The update was successfully deleted';
		}
		else{
			//echo 'There was an error in deletion' ;
		}
	}

	function delete_task($task_id){
		$data_task = Array (
								"t_status" => "deleted" ,
								"t_edited_time" => time() 
							);

		$GLOBALS['conn']->where('t_id', $task_id);
		$id = $GLOBALS['conn']->update(TABLE_TASKS, $data_task) ;

		/*if($id) {
			echo 'The task has been successfully deleted';
		}
		else{
			echo "There was an error in Deletion" ;
		}*/
	}

	function search_site($keyword,$epoch_from,$epoch_to,$task_status,$project_id){
		
		if($keyword){
			$GLOBALS['conn']->join(TABLE_UPDATES." u" , "u.task_id = t.t_id" , "LEFT") ;
	      	$GLOBALS['conn']->join(TABLE_PROJECTS." p" , "t.proj_id = p.p_id" , "LEFT") ;

			$GLOBALS['conn']->where("p_name  LIKE '%{$keyword}%'") ;
			$GLOBALS['conn']->orWhere("t_name  LIKE '%{$keyword}%'"); 
			$GLOBALS['conn']->orWhere("t_deliverables  LIKE '%{$keyword}%'"); 
			$GLOBALS['conn']->orWhere("t_date_of_brief  LIKE '%{$keyword}%'"); 
			$GLOBALS['conn']->orWhere("u_status  LIKE '%{$keyword}%'") ;
			

			/*if($epoch_from){
	      		$GLOBALS['conn']->where("t_edited_time",$epoch_from,">=") ;
	      	}

	      	if($epoch_to){
	      		$GLOBALS['conn']->where("t_edited_time",$epoch_to,"<=") ;
	      	}

	      	if($task_status){
	      		$GLOBALS['conn']->where("t_status",$task_status) ;
	      	}

	      	if($project_id){
	      		$GLOBALS['conn']->where("proj_id",$project_id) ;
	      	}*/

			$data_search = $GLOBALS['conn']->get(TABLE_TASKS." t");

			$data_length = sizeof($data_search); 

			if($data_length){
				$task_id = array() ;
				$initial_id = $data_search[0]['t_id'] ;
				array_push($task_id,$data_search[0]['t_id']) ;
				$count = 1 ;

				foreach($data_search as $row){
					if($row['t_id'] != $initial_id){
						array_push($task_id,$row['t_id']);
						$initial_id = $row['t_id'] ;
						$count++ ;
					}
				}

				$GLOBALS['conn']->join(TABLE_UPDATES." u" , "u.task_id = t.t_id" , "LEFT") ;
	  			$GLOBALS['conn']->join(TABLE_PROJECTS." p" , "t.proj_id = p.p_id" , "LEFT") ; 

				for($i = 0;$i < $count ; $i++){
	      			if($i > 0) $GLOBALS['conn']->orWhere('t_id', $task_id[$i]);
	      			else $GLOBALS['conn']->where('t_id', $task_id[$i]);
	      		}
	      		$tasks = $GLOBALS['conn']->get(TABLE_TASKS." t") ;
	      		
		  		$users = $tasks ;
			    $count = -1 ;

		        $a =  "<table class='table table-bordered table-hover table-striped display' id='example' >
		              <thead>
		                <tr>
		                 <th style='text-align:center;'>Task Name</th>
		                 <th style='width:200px;text-align:center;'>Project Name</th>
		                 <th style='width:200px;text-align:center;'>Update Time</th>
		                </tr>
		              </thead>
		             <tbody>";

		        foreach($tasks as $task){
			        if($count == -1){
			          $count = 0 ;
			          foreach($users as $user){
			            if ( $user['t_id'] == $task['t_id'] && $user['p_id'] == $task['p_id']) $count++ ;
			          }
			        }
			        if($count > 0){
			          $count-- ;
			        }
			        if($count == 0){
			          if($task['t_edited_time']){
		          		$epoch = $task['t_edited_time'] + 19800;
		            	$dt = new DateTime("@$epoch");
		          	  }
			          $no_update = "No update to be shown" ;
			          $a .= "<tr class='gradeA'>
				            <td><strong><span style='border-bottom: 1px solid black;'>" . $task['t_name'] . "</span></strong><br>";

				      if(!$task['u_status']) $a .= "<div>" . $no_update . "" ;
			              else $a .= "<div>" .$task['u_status'] . "" ; 

				      $a .=  "</div></td>
				            <td style='text-align:center;'>" . $task['p_name'] . "</td> 
				            <td style='text-align:center;'><span style='border-bottom: 1px solid black'>" . $dt->format('H:i , F jS, Y') ."<span><br>";
			          
			          if($task['p_name'] != "Press Releases"){
			          	$a .= "<button class='button_edit' data-toggle='modal' data-target='#myModalupdate' onclick='remove_error_update()' id=".$task['t_id']." style='text-align:center;margin-top:10px;'>Edit</button></td></tr>" ;
			          }
			          else if($task['p_name'] == "Press Releases"){
			          	$a .= "<button class='button_edit_press' data-toggle='modal' data-target='#myModalupdate_press' onclick='remove_error_update_press()' id=".$task['t_id']." style='text-align:center;margin-top:10px;'>Edit</button></td></tr>" ;
			          }
			          $count = -1 ;
			        } 
			    }
			    $a .= "</tbody>
			             <tfoot>
			              <tr>
			               <th style='text-align:center;'>Task Name</th>
			               <th style='text-align:center;'>Project Name</th>
			            
			               <th style='text-align:center;'>Update Time</th>
			               
			              </tr> 
			             </tfoot>
			           </table>" ;
		        echo $a ;
		    }
		    else{
		    	$a =  "<table class='table table-bordered table-hover table-striped display' id='example' >
		              <thead>
		                <tr>
		                 <th style='text-align:center;'>Task Name</th>
		                 <th style='width:200px;text-align:center;'>Project Name</th>
		                 <th style='width:200px;text-align:center;'>Update Time</th>
		                </tr>
		              </thead>
		             <tbody></tbody>
			             <tfoot>
			              <tr>
			               <th style='text-align:center;'>Task Name</th>
			               <th style='text-align:center;'>Project Name</th>
			            
			               <th style='text-align:center;'>Update Time</th>
			               
			              </tr> 
			             </tfoot>
			           </table>" ;
			    echo $a ;
		    }
		}
		else{
			ongoing_tasks($epoch_from,$epoch_to,$task_status,$project_id) ;
		}
	}

	function restore_task($task_id){
		$data_task = Array (
								"t_status" => "Ongoing" ,
								"t_edited_time" => time() 
							);

		$GLOBALS['conn']->where('t_id', $task_id);
		$id = $GLOBALS['conn']->update(TABLE_TASKS, $data_task) ;

		/*if($id) {
			echo 'The task has been successfully restored';
		}
		else{
			echo "There was an error in Restoration" ;
		}*/
	}

	function restore_project($project_id){
		$data_project = Array (
								"p_status" => "Ongoing" ,
								"p_edited_time" => time() 
							);
		$GLOBALS['conn']->where('p_id', $project_id);
		$id = $GLOBALS['conn']->update(TABLE_PROJECTS, $data_project) ;

		/*if($id) {
			echo 'The project has been successfully restored';
		}
		else{
			echo "There was an error in Restoration" ;
		}*/

		$GLOBALS['conn']->where('proj_id', $project_id);
		$tasks = $GLOBALS['conn']->get(TABLE_TASKS)	;

		foreach($tasks as $task){
			$data_task = Array(
								"t_status" => "Ongoing"
							);
			$GLOBALS['conn']->where('t_id', $task['t_id']);
			$id = $GLOBALS['conn']->update(TABLE_TASKS, $data_task) ;

			/*if($id) {
				echo 'The tasks has been successfully restored';
			}
			else{
				echo "There was an error in Restoration" ;
			}*/
		}

	}

	function edit_project($project_id,$project_name){
		$data_project = Array(
							"p_name" => $project_name,
							"p_edited_time" => time() 
						);

		$GLOBALS['conn']->where('p_id', $project_id);
		$id = $GLOBALS['conn']->update(TABLE_PROJECTS, $data_project) ;

		/*if($id) {
			echo 'The project has been successfully modified';
		}
		else{
			echo "There was an error in Modification" ;
		}*/

	}

	function delete_project($project_id){
		$data_project = Array (
								"p_status" => "deleted" ,
								"p_edited_time" => time() 
							);

		$GLOBALS['conn']->where('p_id', $project_id);
		$id = $GLOBALS['conn']->update(TABLE_PROJECTS, $data_project) ;

		/*if($id) {
			echo 'The project has been successfully deleted';
		}
		else{
			echo "There was an error in Deletion" ;
		}*/	

		$GLOBALS['conn']->where('proj_id', $project_id);	
		$tasks = $GLOBALS['conn']->get(TABLE_TASKS) ;

		foreach($tasks as $task){
			$data_task = Array (
								"t_status" => "deleted" ,
								"t_edited_time" => time() 
							);

			$GLOBALS['conn']->where('t_id', $task['t_id']);
			$id = $GLOBALS['conn']->update(TABLE_TASKS, $data_task) ;

			/*if($id) {
				echo 'The task has been successfully deleted';
			}
			else{
				echo "There was an error in Deletion" ;
			}*/
		}
	}

?>
