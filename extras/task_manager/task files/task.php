<?php

    require_once( "include/common.php") ;

	function get_update($project_num, $task_num , $update_num){
		if ($update_num){
			$GLOBALS['conn']->join("updates u" , "u.task_id = t.t_id" , "LEFT") ;
			$GLOBALS['conn']->join("project p" , "t.proj_id = p.p_id" , "LEFT") ;
			$GLOBALS['conn']->where("u_status",$update_num) ;
			$task = $GLOBALS['conn']->get ("task t") ;

			$a = "<table border='2' style='border-collapse:collapse'>
				<tr>
					<th> p_id </th>
					<th> p_name </th>
					<th> t_id </th>
					<th> t_name </th>
					<th> t_status </th>
					<th> u_id </th> 
					<th> u_status </th>
					<th> u_status_description </th>
					<th> u_status_updated_by </th>
					<th> u_insert_time </th>
					

				</tr>
				<tr>
					<td>". $task[0]['p_id'] ."</td>
					<td>". $task[0]['p_name'] ."</td>
					<td>". $task[0]['t_id'] ."</td>
					<td>". $task[0]['t_name'] ."</td>
					<td>". $task[0]['t_status'] ."</td>
					<td>". $task[0]['u_id'] ."</td> 
					<td>". $task[0]['u_status'] ."</td>
					<td>". $task[0]['u_status_description'] ."</td>
					<td>". $task[0]['u_status_updated_by'] ."</td>
					<td>". $task[0]['u_insert_time'] ."</td>
				</tr>
				</table>

				" ;
			echo $a ;

			
		}
		
		else{
			if ($task_num){
				$taskname = $GLOBALS['conn']->rawQuery("SELECT t_id from task where t_name = '$task_num'") ;
				$number = $taskname[0]['t_id'] ;
				$users = $GLOBALS['conn']->rawQuery("SELECT * from updates where task_id = $number ") ;
				if(!empty($users)){
					$a = "<table border='2' style='border-collapse:collapse' >
							<tr>
								<th> task_id </th>
								<th> u_id </th>
								<th> u_status </th>
								<th> u_status_description </th>
								<th> u_status_updated_by </th>
								<th> u_insert_time </th>
							</tr>" ;
					foreach ($users as $user) {
						$a.= "
							<tr>
								<td>". $user['task_id'] ."</td>
								<td>". $user['u_id'] ."</td>
								<td>". $user['u_status'] ."</td>
								<td>". $user['u_status_description'] ."</td>
								<td>". $user['u_status_updated_by'] ."</td>
								<td>". $user['u_insert_time'] ."</td>
							</tr> "
							 ;
					}
					$a.="</table>" ;
					echo $a ;
				}
				else{
					echo "No data to be shown<br />" ;
				}

			}
			
			else{

				if(!$project_num){
							$GLOBALS['conn']->join("updates u" , "u.task_id = t.t_id" , "LEFT") ;
							$GLOBALS['conn']->join("project p" , "t.proj_id = p.p_id" , "LEFT") ;
							$tasks = $GLOBALS['conn']->get ("task t") ;

							if(!empty($tasks)){
								$a = "<table border='2' style='border-collapse:collapse' >
										<tr>
											<th> p_id </th>
											<th> p_name </th>
											<th> p_created_by </th>
											<th> p_description </th>
											<th> p_status </th>
											<th> p_status_description </th>
											<th> p_status_updated_by </th>
											<th> p_statupdate_time </th>
											<th> p_date_of_delivery </th>
											<th> p_insert_time </th>

											<th> t_id </th>
											<th> t_name </th>
											<th> t_created_by </th>
											<th> t_status </th>
											<th> t_status_description </th>
											<th> t_status_updated_by </th>
											<th> t_statupdate_time </th>
											<th> t_insert_time </th>

											<th> u_id </th> 
											<th> u_status </th>
											<th> u_status_description </th>
											<th> u_status_updated_by </th>
											<th> u_insert_time </th>
										</tr>" ;

								foreach($tasks as $task){
											$a .= "
												<tr>
													<td>". $task['p_id'] ."</td>
													<td>". $task['p_name'] ."</td>
													<td>". $task['p_created_by'] ."</td>
													<td>". $task['p_description'] ."</td>
													<td>". $task['p_status'] ."</td>
													<td>". $task['p_status_description'] ."</td>
													<td>". $task['p_status_updated_by'] ."</td>
													<td>". $task['p_statupdate_time'] ."</td>
													<td>". $task['p_date_of_delivery'] ."</td>
													<td>". $task['p_insert_time'] ."</td>

													<td>". $task['t_id'] ."</td>
													<td>". $task['t_name'] ."</td>
													<td>". $task['t_created_by'] ."</td>
													<td>". $task['u_status'] ."</td>
													<td>". $task['u_status_description'] ."</td>
													<td>". $task['u_status_updated_by'] ."</td>
													<td>". $task['t_statupdate_time'] ."</td>
													<td>". $task['u_insert_time'] ."</td>

													<td>". $task['u_id'] ."</td> 
													<td>". $task['u_status'] ."</td>
													<td>". $task['u_status_description'] ."</td>
													<td>". $task['u_status_updated_by'] ."</td>
													<td>". $task['u_insert_time'] ."</td>
												</tr> " ;
								}
										
								$a .= "</table> "; 
								echo $a ;
							}
							else{
								echo "No data to be shown<br />" ;
							}
				}
				
				else{
					$projectname = $GLOBALS['conn']->rawQuery("SELECT p_id from project where p_name = '$project_num'") ;
					$number = $projectname[0]['p_id'] ;
					$GLOBALS['conn']->join("updates u" , "u.task_id = t.t_id" , "LEFT") ;
					$GLOBALS['conn']->join("project p" , "t.proj_id = p.p_id" , "LEFT") ;
					$GLOBALS['conn']->where("t.proj_id",$number) ;
					$tasks = $GLOBALS['conn']->get ("task t") ;

					if(!empty($tasks)){
						$a = "<table border='2' style='border-collapse:collapse' >
							<tr>
								<th> proj_id </th>
								<th> t_id </th>
								<th> t_name </th>
								<th> t_created_by </th>
								<th> t_status </th>
								<th> t_status_description </th> 
								<th> t_status_updated_by </th>
								<th> t_statupdate_time </th>
								<th> t_insert_time </th>
								<th> u_id </th> 
								<th> u_status </th>
								<th> u_status_description </th>
								<th> u_status_updated_by </th>
								<th> u_insert_time </th>
							<tr> " ;

						foreach ($tasks as $user){
								$a .= "
								<tr>
									<td>". $user['proj_id'] ."</td>
									<td>". $user['t_id'] ."</td>
									<td>". $user['t_name'] ."</td>
									<td>". $user['t_created_by'] ."</td>
									<td>". $user['t_status'] ."</td>
									<td>". $user['t_status_description'] ."</td>
									<td>". $user['t_status_updated_by'] ."</td>
									<td>". $user['t_statupdate_time'] ."</td>
									<td>". $user['t_insert_time'] ."</td>
									<td>". $user['u_id'] ."</td>
									<td>". $user['u_status'] ."</td>
									<td>". $user['u_status_description'] ."</td>
									<td>". $user['u_status_updated_by'] ."</td>
									<td>". $user['u_insert_time'] ."</td>
								</tr> " ;
							 
						}

						$a .= "</table>" ;
						echo $a ;
					}
					else{
						echo "No data to be shown<br />" ;
					}
				
				}
				
			}
			
		}
		
	}

	function get_ongoing_updates(){
		
			$GLOBALS['conn']->join("updates u" , "u.task_id = t.t_id" , "LEFT") ;
			$GLOBALS['conn']->join("project p" , "t.proj_id = p.p_id" , "LEFT") ;
			$GLOBALS['conn']->where("u.u_status","ongoing") ;
			$tasks = $GLOBALS['conn']->get ("task t") ;

			$a = "<table border='2' style='border-collapse:collapse' >
				<tr>
					<th> p_id </th>
					<th> p_name </th>
					<th> t_id </th>
					<th> t_name </th>
					<th> t_status </th>
					<th> u_id </th> 
					<th> u_status </th>
					<th> u_status_description </th>
					<th> u_status_updated_by </th>
					<th> u_insert_time </th>
					

				</tr> " ;

			foreach ( $tasks as $task ){
			$a .= "
				<tr>
					<td>". $task['p_id'] ."</td>
					<td>". $task['p_name'] ."</td>
					<td>". $task['t_id'] ."</td>
					<td>". $task['t_name'] ."</td>
					<td>". $task['t_status'] ."</td>
					<td>". $task['u_id'] ."</td> 
					<td>". $task['u_status'] ."</td>
					<td>". $task['u_status_description'] ."</td>
					<td>". $task['u_status_updated_by'] ."</td>
					<td>". $task['u_insert_time'] ."</td>
				</tr> " ;
			}

			$a .= "</table>" ;
			echo $a ;

	}

	function get_current_projects(){
		$GLOBALS['conn']->join("updates u" , "u.task_id = t.t_id" , "LEFT") ;
		$GLOBALS['conn']->join("project p" , "t.proj_id = p.p_id" , "LEFT") ;
		$GLOBALS['conn']->where("p.p_status","ongoing")   ;
		$tasks = $GLOBALS['conn']->get ("task t") ;

		
		$a = "<table border='2' style='border-collapse:collapse' >
				<tr>
					<th> p_id </th>
					<th> p_name </th>
					<th> p_created_by </th>
					<th> p_description </th>
					<th> p_status </th>
					<th> p_status_description </th>
					<th> p_status_updated_by </th>
					<th> p_statupdate_time </th>
					<th> p_date_of_delivery </th>
					<th> p_insert_time </th>
					
					<th> t_id </th>
					<th> t_name </th>
					<th> t_created_by </th>
					<th> t_status </th>
					<th> t_status_description </th>
					<th> t_status_updated_by </th>
					<th> t_statupdate_time </th>
					<th> t_insert_time </th>

					<th> u_id </th> 
					<th> u_status </th>
					<th> u_status_description </th>
					<th> u_status_updated_by </th>
					<th> u_insert_time </th>
															
				</tr>" ;

		foreach($tasks as $task){
			$a .= "
				<tr>
					<td>". $task['p_id'] ."</td>
					<td>". $task['p_name'] ."</td>
					<td>". $task['p_created_by'] ."</td>
					<td>". $task['p_description'] ."</td>
					<td>". $task['p_status'] ."</td>
					<td>". $task['p_status_description'] ."</td>
					<td>". $task['p_status_updated_by'] ."</td>
					<td>". $task['p_statupdate_time'] ."</td>
					<td>". $task['p_date_of_delivery'] ."</td>
					<td>". $task['p_insert_time'] ."</td>
							
					<td>". $task['t_id'] ."</td>
					<td>". $task['t_name'] ."</td>
					<td>". $task['t_created_by'] ."</td>
					<td>". $task['u_status'] ."</td>
					<td>". $task['u_status_description'] ."</td>
					<td>". $task['u_status_updated_by'] ."</td>
					<td>". $task['t_statupdate_time'] ."</td>
					<td>". $task['u_insert_time'] ."</td>

					<td>". $task['u_id'] ."</td> 
					<td>". $task['u_status'] ."</td>
					<td>". $task['u_status_description'] ."</td>
					<td>". $task['u_status_updated_by'] ."</td>
					<td>". $task['u_insert_time'] ."</td>
				</tr> " ;
		}

		$GLOBALS['conn']->join("updates u" , "u.task_id = t.t_id" , "LEFT") ;
		$GLOBALS['conn']->join("project p" , "t.proj_id = p.p_id" , "LEFT") ;
		$GLOBALS['conn']->where("p.p_status","pending")   ;
		$tasks = $GLOBALS['conn']->get ("task t") ;
		
		foreach($tasks as $task){
			$a .= "
				<tr>
					<td>". $task['p_id'] ."</td>
					<td>". $task['p_name'] ."</td>
					<td>". $task['p_created_by'] ."</td>
					<td>". $task['p_description'] ."</td>
					<td>". $task['p_status'] ."</td>
					<td>". $task['p_status_description'] ."</td>
					<td>". $task['p_status_updated_by'] ."</td>
					<td>". $task['p_statupdate_time'] ."</td>
					<td>". $task['p_date_of_delivery'] ."</td>
					<td>". $task['p_insert_time'] ."</td>
							
					<td>". $task['t_id'] ."</td>
					<td>". $task['t_name'] ."</td>
					<td>". $task['t_created_by'] ."</td>
					<td>". $task['u_status'] ."</td>
					<td>". $task['u_status_description'] ."</td>
					<td>". $task['u_status_updated_by'] ."</td>
					<td>". $task['t_statupdate_time'] ."</td>
					<td>". $task['u_insert_time'] ."</td>

					<td>". $task['u_id'] ."</td> 
					<td>". $task['u_status'] ."</td>
					<td>". $task['u_status_description'] ."</td>
					<td>". $task['u_status_updated_by'] ."</td>
					<td>". $task['u_insert_time'] ."</td>
				</tr> " ;
		}

		$a .= "</table> "; 
		echo $a ; 
	}

	function get_completed_projects(){
		$GLOBALS['conn']->join("updates u" , "u.task_id = t.t_id" , "LEFT") ;
		$GLOBALS['conn']->join("project p" , "t.proj_id = p.p_id" , "LEFT") ;
		$GLOBALS['conn']->where("p.p_status","completed")   ;
		$tasks = $GLOBALS['conn']->get ("task t") ;

		echo "<pre>" ;
		print_r($tasks) ;

		$a = "<table border='2' style='border-collapse:collapse' >
				<tr>
					<th> p_id </th>
					<th> p_name </th>
					<th> p_created_by </th>
					<th> p_description </th>
					<th> p_status_updated_by </th>
					<th> p_statupdate_time </th>
					<th> p_date_of_delivery </th>
					<th> p_insert_time </th>
				</tr>" ;

		foreach($tasks as $task){
			$a .= "
				<tr>
					<td>". $task['p_id'] ."</td>
					<td>". $task['p_name'] ."</td>
					<td>". $task['p_created_by'] ."</td>
					<td>". $task['p_description'] ."</td>
					<td>". $task['p_status_updated_by'] ."</td>
					<td>". $task['p_statupdate_time'] ."</td>
					<td>". $task['p_date_of_delivery'] ."</td>
					<td>". $task['p_insert_time'] ."</td>
				</tr> " ;
		}

		$a .= "</table> "; 
		echo $a ;
	}

	if(isset($_REQUEST["name"]) && !empty($_REQUEST["name"])){
		extract($_REQUEST);

		if ($category == 'project_num'){
			get_update($name,'','') ;
		}
		else if ($category == 'task_num'){
			get_update('',$name,'') ;
		}
		else if ($category == 'updates_num'){
			get_update('','',$name) ;
		}


	}

	
?>
	


	


