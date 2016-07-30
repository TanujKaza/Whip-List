<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"> 
	</script>
</head>

<body>
	<?php 
		include_once ( "MysqliDb.php") ;

		$servername="localhost" ;
		$username="root" ;
		$password="tangoalpha77151";
		$databasename ="task_manager" ;

		$conn = new MysqliDb ($servername,$username,$password,$databasename);

		if($conn->connect_error){
			die("Unable to connect" . $conn->connect_error) ;
		}

		$users = $GLOBALS['conn']->rawQuery("SELECT p_id from project",Array(10)) ;
		$tasks = $GLOBALS['conn']->rawQuery("SELECT t_id from task",Array(10)) ;
		$updates = $GLOBALS['conn']->rawQuery("SELECT u_id from updates",Array(10)) ;


	?>
			
	<form action="">
		<select name="project" onchange="showdata(this.value,'project_num')">
		<option value="">Select a project:</option> 

	<?php
		foreach($users as $user){
	?>

	<option value="<?php echo $user['p_id']?> "> <?php echo $user['p_id']?> </option>

	<?php 
		}
	?>

		</select>

	</form>
	<br />

	<form action="">
		<select name="project" onchange="showdata(this.value,'task_num')">
		<option value="">Select a task:</option> 

	<?php
		foreach($tasks as $task){
	?>

	<option value="<?php echo $task['t_id']?> "> <?php echo $task['t_id']?> </option>

	<?php 
		}
	?>

		</select>

	</form>
	<br />

	<form action="">
		<select name="project" onchange="showdata('41','update_num')">
		<option value="">Select an update:</option> 

	<?php
		foreach($updates as $upd){
	?>

	<option value="<?php echo $upd['u_id']?> "> <?php echo $upd['u_id']?> </option>

	<?php 
		}
	?>

		</select>

	</form>
	<br />

	<script>
		function showdata(str1,str2){
			if (str1 == "") {
		        document.getElementById("data").innerHTML = "Data will be shown here";
		        return;
		    }
		    else{
		    	$.ajax({ url : "task.php?p=" + str1 + "&q=" + str2 ,method : "GET" , success: function(result){
            		$("#data").html(result);
        			}
        		});
			}
		}
		
	</script>

	<div id = "data"> Data will be shown here </div>

</body>
</html>
