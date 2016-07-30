<?php 
  include('partials/header.php'); 
  include('function.php') ;
  require_once('include/common.php') ;
?>

<div class="row">
	<div class="col-mod-12">
		<ul class="breadcrumb">
			<li><a href="whiplist.php">Dashboard</a></li>
			<li>Projects</li>
		</ul>

		<h3 class="page-header"><i class="fa fa fa-dashboard" style="display:inline;"></i> Projects</h3>
	</div>
</div>

<div id="main_data_project">
<?php
    projects_info() ;
?>
</div>

<div id="edit_project_save">
</div>

<!-- model box for editing project start -->  
<div class="modal fade" id="myModaledit_project" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" name="2" style="top:0px !important; overflow:scroll">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   

            <div class="modal-header" id="header_edit_project">
                <h4 class="modal-title" id="myModalLabel_editproject"><strong>Edit Project</strong></h4>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close_edit_project">Close</button>
            </div>

              <div class="modal-body clearfix" id="disablecheck">
                <form method='post' class="career" name="career" id="form_2" action="" enctype="multipart/form-data">

                  <div class="col-sm-12 " align="center">
                  
                </div>

            <div class="col-sm-12">
              <div id="divNameFormName" class="form-group has-feedback marbot20">
              Project Name :
              <input name="projectname_edit" id="projectname_edit" type="text" class="form-control marbot20" value="" onblur ="check(this.value,'projectnamevalid_edit')">
              <span id = "projectnamevalid_edit"></span>
              </div>
            </div>
            <br>

            <div id="project_id_pass">
                 <input name="projectid_notforedit" id="projectid_notforedit" type="text" class="form-control marbot20" value="">
            </div>

            <div class="col-sm-12 " align="center" id="edit_project_action">
              <button type="button" class="btn btn-success" id="edit_project_submit" onclick="validate_project_edit()">Save</button>
               <button type="button" class="btn btn-danger" id="delete_project_submit" style="margin-left:50px;" data-dismiss="modal"
               data-toggle="modal" data-target="#myModalConfirmProjectDelete">Delete</button>
            </div>
          </form>
              </div>
        </div>
      
    </div>

</div>
<!-- model box close -->

<!-- model box for confirming delete of project start -->  
  <div class="modal fade" id="myModalConfirmProjectDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" name="2" style="top:0px !important; overflow:scroll">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
          
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel_confirm_projectdeletion"><strong><center>ARE YOU SURE ?</center></strong></h4>
            </div>
            <br><br>
             
            <div class="col-sm-12 " align="center">
              <button type="button" class="btn btn-success" id="delete_project_yes" data-dismiss="modal">Yes</button>
              <button type="button" class="btn btn-danger" id="delete_project_no" data-dismiss="modal" style="margin-left:50px;">No
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