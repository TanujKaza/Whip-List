<?php 
  include('partials/header.php'); 
  include('function.php') ;
  require_once('include/common.php') ;

  /*if (!isset($_COOKIE['username']) && empty($_COOKIE['username'])){
    header('Location:index.php') ;
  } */

?>

  						<div class="row">
  							<div class="col-mod-12">

  								<ul class="breadcrumb">
  									<li><a href="whiplist.php">Dashboard</a></li>
                    <li>Dashboard</li>
  								</ul>

  								<h3 class="page-header"><i class="fa fa fa-dashboard" style="display:inline;"></i> Dashboard
                  <button class="buttontask btn btn-primary" data-toggle="modal" data-target="#myModal_kind_task" id="button_add_task" onclick="remove_error_task()" > Add Task </button>
                  <button class="buttonproject btn btn-primary" data-toggle="modal" data-target="#myModalproject" id="button_add_project" onclick="remove_error_project()"> Add Project</button></h3>
  							</div>
  						</div>

<div id="form_filter">
    <h4 style="display:inline; margin-right:10px;"> From</h4>
    <input name="date_from" id="datepicker_date_from" type="text" value="" style="margin-right:10px;" class="input-sm">
    <h4 style="display:inline; margin-right:10px;"> To</h4>
    <input name="date_to" id="datepicker_date_to" type="text" value="" style="margin-right:10px;" class="input-sm">  

    <select name="task_status_filter_dropdown" id="status_filter_dropdown" class="input-sm" style="font-size:13px;">
      <option value="">Filter by Status</option>
      <option value="ongoing">Ongoing</option>
      <option value="completed">Completed</option>
    </select>

    <?php
        $columns = array('p_name','p_id') ;
        $conn->where('p_status',Array("Ongoing","ongoing"),'IN') ;
        $users = $conn->get(TABLE_PROJECTS,null,$columns) ;
    ?>

    <select class="project_name_filter input-sm" name = 'project_name_filter' id="project_name_filter" style="font-size:13px;" >
      <option value="" >Filter By project:</option> 

    <?php
      foreach($users as $user){
    ?>

    <option value="<?php echo $user['p_id']?> "> <?php echo $user['p_name']?> </option>

    <?php 
     }
   ?> 
    </select>

    <button class="button_data_filter btn btn-success" id="button_data_filter" > Submit </button>
</div>

<div id="date_filter_error">
</div><br>

<div id="search_box">
  <div class="container-1" id="container_search">
    <span class="icon"><i class="fa fa-search"></i></span>
    <input name="search_table" id="search_table" type="text" value="" placeholder="Search">
  </div>
</div>

<div id="main_data">
<?php
    ongoing_tasks() ;
?> 
</div>

<div id="add_task_response">
</div>

<div id="add_press_response">
</div>

<div id="add_project_response">
</div>

<div id="edit_task_response">
</div>

<div id="edit_update_response">
</div>

<div id="edit_task_response">
</div>

<div id="export_data" style="margin-top:40px;margin-bottom:40px;">
  <form method ='post' action="exportcsv.php" id="export_currentdata_csv">
    <input type="hidden" value="" name="date_from_pass" id="date_from_pass">
    <input type="hidden" value="" name="date_to_pass" id="date_to_pass">
    <input type="hidden" value="" name="task_status_pass" id="task_status_pass">
    <input type="hidden" value="" name="project_id_pass" id="project_id_pass">
   <!--  <button class="btn btn-primary" id="export_currentdata" style="margin-left:724px;"> Export Current Data</button> -->
  </form>

  <form method = 'post' action="exportexcel.php" id="export_alldata_excel">
    <button class="export_excel btn btn-primary pull-right" id="export_excel" style="margin-right:20px;">Export All</button> 
  </form>
</div>

<!-- modal box for kind of task -->
  <div class="modal fade" id="myModal_kind_task" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" name="2" style="top:0px !important; overflow:scroll;">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
          
           <br>
             
            <div class="col-sm-12 " align="center">
              <button type="button" class="btn btn-success" id="task_kind_normal" data-toggle="modal" data-target="#myModaltask"data-dismiss="modal">Task</button>
              <button type="button" class="btn btn-success" id="task_kind_press" data-toggle="modal" data-target="#myModalpressrelease"data-dismiss="modal" style="margin-left:50px;">Press Release
              </button>
            </div>
            <br>

        </div>
      
    </div>

  </div>
<!-- modal box close -->

<!-- model box for add task start -->  
  <div class="modal fade" id="myModaltask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" name="2" style="top:0px !important; overflow:scroll;">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
          
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel_addtask"><strong>Add Task</strong></h4>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close_add_task">Close</button>
            </div>

              <div class="modal-body clearfix" id="disablecheck">
                <form method='post' class="addtaskform" name="addtaskform" id="addtaskform" action="" enctype="multipart/form-data">

                  <div class="col-sm-12 " align="center">
                  
                </div>

            <?php
              $conn->where('p_status',Array("ongoing","Ongoing"),'IN');
              $users = $conn->get(TABLE_PROJECTS,null,'p_name') ;
            ?>

            <center>
              
              <select class="project input-sm" name = 'project_name' id="project_name">
              <option value="">Select a project:</option> 

              <?php
                foreach($users as $user){
                  if($user['p_name'] != "Press Releases"){
              ?>

              <option value="<?php echo $user['p_name']?> "> <?php echo $user['p_name']?> </option>

              <?php 
                }
              }
              ?>

              </select><br>
               <span id = "project_name_valid"></span>
             
            </center>
            <br />


            <div class="col-sm-12 ">
              <div id="divNameFormName" class="form-group has-feedback marbot20">
              Name :
              <input name="name" id="name" type="text" class="form-control marbot20" value="" placeholder="Name" onblur ="check(this.value,'namevalid')" disabled="disabled">
              <span id = "namevalid"></span>
              </div>
            </div>
        
            <div class="col-sm-12 ">
              <div id="divNameFormModeOfBrief" class="form-group has-feedback marbot20">
                Mode of Brief :
                <input name="modeofbrief" id="modeofbrief" type="text" class="form-control marbot20" value="" placeholder="Mode of Brief" disabled="disabled">
                <span id = "modevalid"></span>
              </div>
            </div>
            <div class="col-sm-12">
              Date of Brief:
              <div id="divNameFormDateBrief" class="form-group has-feedback marbot20">
                <input class="form-control marbot20" name="datebrief" id="datepicker_datebrief_add" type="text" placeholder="Date of Brief"  disabled="disabled">
                <span id = "datebriefvalid"></span>
              </div>  
            </div>
            <div class="col-sm-12" id="divName">
              Targeted Date of delivery:
              <div id="divNameFormDateDelivery" class="form-group has-feedback marbot20">
                <input class="form-control marbot20" name="datedelivery" id="datepicker_datedelivery_add" type="text" placeholder="Date of Delivery" disabled="disabled">
                <span id = "datedeliveryvalid"></span>
              </div>
            </div>
            <div class="col-sm-12 ">
              Deliverables:
              <div id="divNameFormDeliverables" class="form-group has-feedback marbot20">
                <input class="form-control marbot20" name="deliverables" id="deliverables" type="text" placeholder="Deliverables"   disabled="disabled">
                <span id = "deliverablesvalid"></span>
              </div>  
            </div>

            <div id="add_update_input_addtask">
              <div class="col-sm-12 ">
                <div id="divNameFormName" class="form-group has-feedback marbot20">
                Update:
                <input name="updatestatus_edit_addtask" id="updatestatus_edit_addtask" type="text" class="form-control marbot20" value="" placeholder="Status" onblur ="check(this.value,'updatestatusvalid_edit_addtask')">
                <span id ="updatestatusvalid_edit_addtask"></span>
                </div>
              </div>
            </div>

            <center>
              <button class="addupdate_edit_addtask btn btn-primary" id="addupdate_edit_addtask" type="button" onclick="remove_update_error_addtask()">Add Update</button>
            </center>
            <br>
            
            <div class="col-sm-12 " align="center">
              <button type="button" class="btn btn-success" id="add_task_submit" onclick="validate_task_add()">Add</button>
            </div>
          </form>
              </div>
        </div>
      
    </div>

  </div>
  <!-- model box close -->

  <!-- model box for add press release start -->  
  <div class="modal fade" id="myModalpressrelease" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" name="2" style="top:0px !important; overflow:scroll;">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
          
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel_addpress"><strong>Add Press Release</strong></h4>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close_add_press">Close</button>
            </div>

              <div class="modal-body clearfix" id="disablecheck">
                <form method='post' class="addtaskform" name="addpressform" id="addpressform" action="" enctype="multipart/form-data">

                  <div class="col-sm-12 " align="center">
                  
                </div>

            <div class="col-sm-12 ">
              <div id="divNameFormName" class="form-group has-feedback marbot20">
              Press Release Name :
              <input name="pressrelease_name" id="pressrelease_name" type="text" class="form-control marbot20" value="" placeholder="Press Release Name" onblur ="check(this.value,'pressreleasenamevalid')" >
              <span id = "pressreleasenamevalid"></span>
              </div>
            </div>
        
            <div class="col-sm-12">
              Date of Brief:
              <div id="divNameFormDateBrief_press" class="form-group has-feedback marbot20">
                <input class="form-control marbot20" name="datebrief" id="datepicker_datebrief_add_press" type="text" placeholder="Date of Brief">
                <span id = "datebriefvalid_press"></span>
              </div>  
            </div>

            <div class="col-sm-12" id="divName">
              Targeted Date of delivery:
              <div id="divNameFormDateDelivery_press" class="form-group has-feedback marbot20">
                <input class="form-control marbot20" name="datedelivery" id="datepicker_datedelivery_add_press" type="text" placeholder="Date of Delivery">
                <span id = "datedeliveryvalid_press"></span>
              </div>
            </div>

            <div class="col-sm-12 ">
              Website Upload:
              <div id="divNameFormwebupload" class="form-group has-feedback marbot20">
                <input class="form-control marbot20" name="webupload" id="webupload" type="text" placeholder="Website Upload">
                <span id = "webupload_press"></span>
              </div>  
            </div>

            <div class="col-sm-12 ">
              Social Media Upload:
              <div id="divNameFormwebupload" class="form-group has-feedback marbot20">
                <input class="form-control marbot20" name="social_mediaupload" id="social_mediaupload" type="text" placeholder="Social Media Upload">
                <span id = "social_mediaupload_press"></span>
              </div>  
            </div>

            <div id="add_update_input_addpress">
              <div class="col-sm-12 ">
                <div id="divNameFormName" class="form-group has-feedback marbot20">
                Update:
                <input name="updatestatus_edit_addpress" id="updatestatus_edit_addpress" type="text" class="form-control marbot20" value="" placeholder="Status" onblur ="check(this.value,'updatestatusvalid_edit_addpress')">
                <span id = "updatestatusvalid_edit_addpress"></span>
                </div>
              </div>
            </div>

            <center>
              <button class="addupdate_edit_addpress btn btn-primary" id="addupdate_edit_addpress" type="button" onclick="remove_update_error_addpress()">Add Update</button>
            </center>
            <br>
            
            <div class="col-sm-12 " align="center">
              <button type="button" class="btn btn-success" id="add_press_submit" onclick="validate_press_add()">Add</button>
            </div>
          </form>
              </div>
        </div>
      
    </div>

  </div>
  <!-- model box close -->

  <!-- model box for add project start -->  
  <div class="modal fade" id="myModalproject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" name="2" style="top:0px !important; overflow:scroll;">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
          
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel_addproject"><strong>Add Project</strong></h4>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close_add_project">Close</button>
            </div>

              <div class="modal-body clearfix" id="disablecheck">
                <form method='post' class="career" name="career" id="form_2" action="" enctype="multipart/form-data">

                  <div class="col-sm-12 " align="center">
                 
                </div>

            <div class="col-sm-12 ">
              <div id="divNameFormName" class="form-group has-feedback marbot20">
              Name:
              <input name="projectname" id="projectname" type="text" class="form-control marbot20" value="" placeholder="Name" onblur ="check(this.value,'projectnamevalid')" >
              <span id = "projectnamevalid"></span>
              </div>
            </div>

            <div class="col-sm-12 " align="center">
              <button type="button" class="btn btn-success" id="add_project_submit" onclick="validate_project_add()">Add</button>
            </div>
          </form>
              </div>
        </div>
      
    </div>

  </div>
  <!-- model box close -->

<!-- model box for edit task(adding update) start -->  
<div class="modal fade" id="myModalupdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" name="2" style="top:0px !important; overflow:scroll;">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   

            <div class="modal-header" id="header_edit_task">
                <h4 class="modal-title" id="myModalLabel_edittask"><strong>Edit Task</strong></h4>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close_edit_task">Close</button>
            </div>

              <div class="modal-body clearfix" id="disablecheck">
                <form method='post' class="career" name="career" id="form_2" action="" enctype="multipart/form-data">

                  <div class="col-sm-12 " align="center">
                  
                </div>

              <center>
                <span id="taskstatus_edit"><span>
                <select class="project  input-sm" name = 'task_status' id="task_status" style="margin-right:20px;">
                  <option value="Ongoing">Ongoing</option>
                  <option value="Completed">Completed</option>
                </select>

              <?php
                $columns=Array('p_id','p_name');
                $conn->where('p_status',Array("ongoing","Ongoing"),'IN');
                $users = $conn->get(TABLE_PROJECTS,null,$columns) ;
              ?>

              <select class="project input-sm" name = 'change_project_name' id="change_project_name">

              <?php
                foreach($users as $user){
                  if($user['p_name'] != "Press Releases"){
              ?>

              <option value="<?php echo $user['p_id']?> "> <?php echo $user['p_name']?> </option>

              <?php 
                }
              }
              ?>
              </select>
            </center>
            <br />

            <div class="col-sm-12 ">
              <div id="divNameFormName" class="form-group has-feedback marbot20">
              Task Name :
              <input name="taskname_edit" id="taskname_edit" type="text" class="form-control marbot20" value="" onblur ="check(this.value,'tasknamevalid_edit')">
              <span id = "tasknamevalid_edit"></span>
              </div>
            </div>

            <div class="col-sm-12 ">
              <div id="divNameFormName" class="form-group has-feedback marbot20">
              Mode of Brief :
              <input name="modebrief_edit" id="modebrief_edit" type="text" class="form-control marbot20" value=""  >
              <span id = "modebriefvalid_edit"></span>
              </div>
            </div>

            <div class="col-sm-12 ">
              <div id="divNameFormName" class="form-group has-feedback marbot20">
              Date of Brief :
              <input name="datebrief_edit" id="datepicker_datebrief_edit" type="text" class="form-control marbot20" value=""  >
              <span id = "datebriefvalid_edit"></span>
              </div>
            </div>

            <div class="col-sm-12 ">
              <div id="divNameFormName" class="form-group has-feedback marbot20">
              Targeted Date of Delivery :
              <input name="datedelivery_edit" id="datepicker_datedelivery_edit" type="text" class="form-control marbot20" value="" >
              <span id = "datedeliveryvalid_edit"></span>
              </div>
            </div>

            <div class="col-sm-12 ">
              <div id="divNameFormName" class="form-group has-feedback marbot20">
              Deliverables :
              <input name="deliverables_edit" id="deliverables_edit" type="text" class="form-control marbot20" value="" >
              <span id = "deliverablesvalid_edit"></span>
              </div>
            </div>

            <div class="col-sm-12" id="showupdates_on_edit">
            </div>

            <div id="add_update_input">
              <div class="col-sm-12 ">
                <div id="divNameFormName" class="form-group has-feedback marbot20">
                Update:
                <input name="updatestatus_edit" id="updatestatus_edit" type="text" class="form-control marbot20" value="" placeholder="Status" onblur ="check(this.value,'updatestatusvalid_edit')" >
                <span id = "updatestatusvalid_edit"></span>
                </div>
              </div>
            </div>

            <div id="task_id_pass">
                 <input name="taskid_notforedit" id="taskid_notforedit" type="text" class="form-control marbot20" value="">
            </div>

            <center>
              <button class="addupdate_edit btn btn-primary" id="addupdate_edit" type="button" onclick="remove_update_toggle_error()">Add Update</button>
            </center>
            <br>

            <div class="col-sm-12 " align="center">
              <button type="button" class="btn btn-success" id="edit_task_submit" onclick="validate_task_edit()">Save</button>
               <button type="button" class="btn btn-danger" id="delete_task_submit" style="margin-left:50px;" data-dismiss="modal"
               data-toggle="modal" data-target="#myModalConfirmTaskDelete">Delete</button>
            </div>
          </form>
              </div>
          <!-- <div style="text-align:center;display:none;" id="thankyou_2" class="thankyou">
              The Task has been updated!
          </div>  -->

        </div>
      
    </div>

  </div>
  <!-- model box close -->

  <!-- model box for edit press release(adding update) start -->  
<div class="modal fade" id="myModalupdate_press" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" name="2" style="top:0px !important; overflow:scroll;">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   

            <div class="modal-header" id="header_edit_task">
                <h4 class="modal-title" id="myModalLabel_editpress"><strong>Edit Press Release</strong></h4>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close_edit_press">Close</button>
            </div>

              <div class="modal-body clearfix" id="disablecheck">
                <form method='post' class="career" name="career" id="form_2" action="" enctype="multipart/form-data">

                  <div class="col-sm-12 " align="center">
                  
                </div>

              <center>
                <span id="pressstatus_edit" style="padding-right:20px;"> Press Release Status <span>
                <select class="project  input-sm" name = 'press_status' id="press_status" style="padding-left:10px;">
                  <option value="Ongoing">Ongoing</option>
                  <option value="Completed">Completed</option>
                </select>
              </center>
              <br>
    
            <div class="col-sm-12 ">
              <div id="divNameFormName" class="form-group has-feedback marbot20">
              Press Release Name :
              <input name="pressname_edit" id="pressname_edit" type="text" class="form-control marbot20" value="" onblur ="check(this.value,'pressnamevalid_edit')" placeholder="Press Release Name">
              <span id = "pressnamevalid_edit"></span>
              </div>
            </div>

            <div class="col-sm-12 ">
              <div id="divNameFormName" class="form-group has-feedback marbot20">
              Date of Brief :
              <input name="datebrief_edit_press" id="datepicker_datebrief_edit_press" type="text" class="form-control marbot20" value="" placeholder="Date of Brief">
              <span id = "datebriefvalid_edit_press"></span>
              </div>
            </div>

            <div class="col-sm-12 ">
              <div id="divNameFormName" class="form-group has-feedback marbot20">
              Targeted Date of Delivery :
              <input name="datedelivery_edit_press" id="datepicker_datedelivery_edit_press" type="text" class="form-control marbot20" value="" placeholder="Date of Delivery">
              <span id = "datedeliveryvalid_edit_press"></span>
              </div>
            </div>

            <div class="col-sm-12 ">
              Website Upload:
              <div id="divNameFormwebupload" class="form-group has-feedback marbot20">
                <input class="form-control marbot20" name="webupload_edit" id="webupload_edit" type="text" placeholder="Website Upload">
                <span id = "webupload_press_edit"></span>
              </div>  
            </div>

            <div class="col-sm-12 ">
              Social Media Upload:
              <div id="divNameFormwebupload" class="form-group has-feedback marbot20">
                <input class="form-control marbot20" name="social_mediaupload_edit" id="social_mediaupload_edit" type="text" placeholder="Social Media Upload">
                <span id = "social_mediaupload_press_edit"></span>
              </div>  
            </div>

            <div class="col-sm-12" id="showupdates_on_edit_press">
            </div>

            <div id="add_update_input_press">
              <div class="col-sm-12 ">
                <div id="divNameFormName" class="form-group has-feedback marbot20">
                Update:
                <input name="updatestatus_edit_press" id="updatestatus_edit_press" type="text" class="form-control marbot20" value="" placeholder="Status" onblur ="check(this.value,'updatestatusvalid_edit_press')" >
                <span id = "updatestatusvalid_edit_press"></span>
                </div>
              </div>
            </div>

            <div id="task_id_pass_press">
                 <input name="taskid_notforedit_press" id="taskid_notforedit_press" type="text" class="form-control marbot20" value="">
            </div>

            <center>
              <button class="addupdate_edit btn btn-primary" id="addupdate_edit_press" type="button" onclick="remove_update_toggle_error_press()">Add Update</button>
            </center>
            <br>

            <div class="col-sm-12 " align="center">
              <button type="button" class="btn btn-success" id="edit_task_submit_press" onclick="validate_task_edit()">Save</input>
               <button type="button" class="btn btn-danger" id="delete_task_submit_press" style="margin-left:50px;" data-dismiss="modal"
               data-toggle="modal" data-target="#myModalConfirmPressDelete">Delete</input>
            </div>
          </form>
              </div>
          <!-- <div style="text-align:center;display:none;" id="thankyou_2" class="thankyou">
              The Task has been updated!
          </div>  -->

        </div>
      
    </div>

  </div>
  <!-- model box close -->

<!-- Modal box for editing the update after edit task is clicked -->
<div class="modal fade" id="myModaleditupdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" name="2" style="top:0px !important; overflow:scroll;">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
          
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel_editupdate"><strong>Edit Update</strong></h4>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close_edit_update" style="margin-left:345px;">Close</button>
            </div>

              <div class="modal-body clearfix" id="disablecheck_editupdate">
                <form method='post' class="edit_update_useless" name="edit_update_useless" action="" enctype="multipart/form-data">

                  <div class="col-sm-12 " align="center">
                 
              </div>

            <div class="col-sm-12 ">
              <div id="divNameFormUpdate_edit" class="form-group has-feedback marbot20">
              Update:
              <textarea rows="4" name="modified_update" id="modified_update" type="text" class="form-control marbot20" value="" placeholder="Name">
              </textarea>
              </div>
            </div>

            <div id="update_id_pass">
                 <input name="updateid_notforedit" id="updateid_notforedit" type="text" class="form-control marbot20" value="">
            </div>

            <div class="col-sm-12 " align="center">
              <button type="button" class="btn btn-success" id="edit_update_submit" data-dismiss="modal">Save</button>
              <button type="button" class="btn btn-danger" id="delete_update_submit" data-dismiss="modal" style="margin-left:50px;" data-toggle="modal" data-target="#myModalConfirmUpdateDelete" >Delete</button> 
             </div>
          </form>
              </div>
        </div>
      
    </div>

  </div>
  <!-- Modal box closes -->



   <!-- model box for confirming delete of update start -->  
  <div class="modal fade" id="myModalConfirmUpdateDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" name="2" style="top:0px !important; overflow:scroll;">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
          
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel_confirm_updatedeletion"><strong><center>ARE YOU SURE ?</center></strong></h4>
            </div>
            <br><br>
             
            <div class="col-sm-12 " align="center">
              <button type="button" class="btn btn-success" id="delete_update_yes" data-dismiss="modal">Yes</button>
              <button type="button" class="btn btn-danger" id="delete_update_no" data-dismiss="modal" style="margin-left:50px;">No
              </button>
            </div>
            <br>
          

        </div>
      
    </div>

  </div>
  <!-- model box close -->

   <!-- model box for confirming delete of task start -->  
  <div class="modal fade" id="myModalConfirmTaskDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" name="2">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
          
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel_confirm_taskdeletion"><strong><center>ARE YOU SURE ?</center></strong></h4>
            </div>
            <br><br>
             
            <div class="col-sm-12 " align="center">
              <button type="button" class="btn btn-success" id="delete_task_yes" data-dismiss="modal">Yes</button>
              <button type="button" class="btn btn-danger" id="delete_task_no" data-dismiss="modal" style="margin-left:50px;">No
              </button>
            </div>
            <br>
          

        </div>
      
    </div>

  </div>
  <!-- model box close -->

  <!-- model box for confirming delete of press release start -->  
  <div class="modal fade" id="myModalConfirmPressDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" name="2" style="top:0px !important; overflow:scroll;">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
          
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel_confirm_taskdeletion"><strong><center>ARE YOU SURE ?</center></strong></h4>
            </div>
            <br><br>
             
            <div class="col-sm-12 " align="center">
              <button type="button" class="btn btn-success" id="delete_press_yes" data-dismiss="modal">Yes</button>
              <button type="button" class="btn btn-danger" id="delete_press_no" data-dismiss="modal" style="margin-left:50px;">No
              </button>
            </div>
            <br>
          

        </div>
      
    </div>

  </div>
  <!-- model box close -->      
  
<!-- Load JS here for Faster site load =============================-->
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script> 
<script src="js/jquery-1.11.3.min.js"></script>
<link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
<!-- <script src="http://code.jquery.com/jquery-1.10.2.js"></script> -->
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script src="js/less-1.5.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- <script src="js/application.js"></script> -->
<!-- <script src="js/moment.min.js"></script> -->
<!--<script src="js/jquery.dataTables.min.js"></script>-->
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/jquery.sortable.js"></script>
<!-- <script src="js/jquery.nicescroll.min.js"></script> -->
<script src="js/jquery.accordion.js"></script>
<!-- <script src="js/skylo.js"></script>
<script src="js/theme-options.js"></script> -->

<!-- <script src="js/bootstrap-progressbar.js"></script>
<script src="js/bootstrap-progressbar-custom.js"></script>
<script src="js/bootstrap-colorpicker.min.js"></script>
<script src="js/bootstrap-colorpicker-custom.js"></script> 
 -->
<!-- Form Validation -->
<script src="js/script.js"></script>
<!-- <script src="js/validate.js"></script>
<script src="js/validation-custom.js"></script> -->

<!-- Core Jquery File  =============================-->
<!-- <script src="js/core.js"></script> 
<script src="js/dashboard-custom.js"></script> -->


</body>
</html>

