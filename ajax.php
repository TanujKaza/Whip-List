<?php
	require_once('include/common.php') ;
	include('function.php') ;

	if(isset($_REQUEST["action"]) && !empty($_REQUEST["action"])){
		extract($_REQUEST);
		$output="";
		switch ($action) {
			case 'edit_task':
				$conn->join(TABLE_UPDATES." u" , "u.task_id = t.t_id" , "LEFT") ;
				$conn->join(TABLE_PROJECTS." p" , "t.proj_id = p.p_id" , "LEFT") ;
				$conn->where("t_id",$task_id) ;
				$task = $GLOBALS['conn']->get (TABLE_TASKS." t") ;

				$output['data'] = $task ;
				echo json_encode($output);
				break;
			
			case 'date_range_both':
				ongoing_tasks($epoch_from,$epoch_to,$task_status,$project_id) ; 
        		        break ;

                	case 'date_range_from':
                		ongoing_tasks($epoch_from,0,$task_status,$project_id) ;
                		break ;

                	case 'date_range_to':
                		ongoing_tasks(0,$epoch_to,$task_status,$project_id) ;
                		break ;

                	case 'date_range_none':
                		ongoing_tasks(0,0,$task_status,$project_id);
                		break;

                	case 'add_task':
                		add_task($project_name,$task_name,$mode_of_brief,$date_of_brief,$date_of_delivery,$deliverables,
                                        $update_status) ;
                		break ;

                        case 'add_press':
                                add_press($press_name,$date_of_brief,$date_of_delivery,$webupload,$social_mediaupload,$update_status);
                                break;

                	case 'add_project':
                		add_project($project_name) ;
                		break ;

                	case 'edit_task_update':
                		edit_task($task_id,$task_name,$mode_of_brief,$date_of_brief,$date_of_delivery,$deliverables,$task_status,$update_status,$project_id);
                		break ;
        	
                        case 'edit_press_update':
                                edit_press($task_id,$press_name,$date_of_brief,$date_of_delivery,$web_upload,$social_mediaupload,$task_status,$update_status);
                                break;

                        case 'edit_update_on_edit_task':
                                $update = $GLOBALS['conn']->rawQuery("SELECT u_status from ". TABLE_UPDATES ." where u_id = '$update_id'") ;
                                $output['data'] = $update ;
                                echo json_encode($output);
                                break ;

                        case 'edit_update_on_save':
                                edit_update($update,$update_id) ;
                                break ;

                        case 'edit_update_on_delete':
                                delete_update($update_id) ;
                                break ;

                        case 'edit_task_on_delete':
                                delete_task($task_id) ;
                                break ;

                        case 'search_site':
                                search_site($keyword,$epoch_from,$epoch_to,$task_status,$project_id) ;
                                break ;

                        case 'restore_task':
                                restore_task($task_id) ;
                                break;

                        case 'edit_project':
                                $conn->where("p_id",$project_id) ;
                                $project = $GLOBALS['conn']->get (TABLE_PROJECTS." p") ;
                                $output['data'] = $project ;
                                echo json_encode($output);
                                break;

                        case 'edit_project_submit':
                                edit_project($project_id,$project_name) ;
                                break;

                        case 'delete_project':
                                delete_project($project_id);
                                break;

                        case 'restore_project':
                                restore_project($project_id);
                                break;

                        case 'paginate_data':
                                ongoing_tasks($epoch_from,$epoch_to,$task_status,$project_id,$page_number) ; 
                                break;
                                    
        		default:
        			# code...
        			break;
		}
	}	
?>



