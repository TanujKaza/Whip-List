<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"> </script>
	<script src="menuajax.js"></script> 
</head>

<body>
	<?php 
		require_once ( "include/common.php") ;

		$users = $conn->get('project',null,'p_name') ;
		$tasks = $conn->get('task',null,'t_name') ;
		$updates = $conn->get('updates',null,'u_status') ;


	?>
			
	<form action="">
		<select class="project" name = 'project_num' >
		<option value="">Select a project:</option> 

	<?php
		foreach($users as $user){
	?>

	<option value="<?php echo $user['p_name']?> "> <?php echo $user['p_name']?> </option>

	<?php 
		}
	?>

		</select>

	</form>
	<br />

	<form action="">
		<select class="project" name = 'task_num'>
		<option value="">Select a task:</option> 

	<?php
		foreach($tasks as $task){
	?>

	<option value="<?php echo $task['t_name']?> "> <?php echo $task['t_name']?> </option>

	<?php 
		}
	?>

		</select>

	</form>
	<br />

	<form action="">
		<select class="project" name = 'updates_num'>
		<option value="">Select an update:</option> 

	<?php
		foreach($updates as $upd){
	?>

	<option value="<?php echo $upd['u_status']?> "> <?php echo $upd['u_status']?> </option>

	<?php 
		}
	?>

		</select>

	</form>
	<br />

	<div id="showhere"> Data will be shown here </div> 

</body>
</html>

