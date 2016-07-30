<?php 
  include('partials/header.php'); 
  include('function.php') ;
  require_once('include/common.php') ;
?>

<div class="row">
	<div class="col-mod-12">
		<ul class="breadcrumb">
			<li><a href="whiplist.php">DashBoard</a></li>
			<li>Recycle Bin</li>
		</ul>

		<h3 class="page-header"><i class="fa fa-trash-o" style="display:inline;"></i> Recycle Bin</h3>
	</div>
</div>


<div id="main_data_recycle">
<?php
    tasks_recycle() ;
    echo "<br><br>" ;
    projects_recycle() ;
?> 
</div>

<div id="restore_task_response">
</div>


<!-- model box for confirming restoration of task start -->  
  <div class="modal fade" id="myModalrestore_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" name="2" style="top:0px !important; overflow:scroll">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
          
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel_confirm_restore"><strong><center>ARE YOU SURE ?</center></strong></h4>
            </div>
            <br><br>
            
            <div id="task_id_pass_restore">
                 <input name="taskid_restore" id="taskid_restore" type="text" class="form-control marbot20" value="">
            </div>

            <div class="col-sm-12 " id="restore_task_response" align="center">
              <button type="button" class="btn btn-success" id="restore_task_yes" data-dismiss="modal">Yes</button>
              <button type="button" class="btn btn-danger" id="restore_task_no" data-dismiss="modal" style="margin-left:50px;">No
              </button>
            </div>
            <br>
          

        </div>
      
    </div>

  </div>
  <!-- model box close -->

<!-- model box for confirming restoration of task start -->  
  <div class="modal fade" id="myModalrestore_confirm_proj" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" name="2" style="top:0px !important; overflow:scroll">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
          
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel_confirm_restore_proj"><strong><center>ARE YOU SURE ?</center></strong></h4>
            </div>
            <br><br>
            
            <div id="project_id_pass_restore">
                 <input name="projectid_restore" id="projectid_restore" type="text" class="form-control marbot20" value="">
            </div>

            <div class="col-sm-12 " id="restore_project_response" align="center">
              <button type="button" class="btn btn-success" id="restore_project_yes" data-dismiss="modal">Yes</button>
              <button type="button" class="btn btn-danger" id="restore_project_no" data-dismiss="modal" style="margin-left:50px;">No
              </button>
            </div>
            <br>
          

        </div>
      
    </div>

  </div>
  <!-- model box close -->

<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

<link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> 

<script src="js/bootstrap.min.js"></script>
 
<script src="js/script.js"></script>

</body>
</html>