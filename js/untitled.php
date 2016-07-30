<?php
	require_once('include/common.php') ;
	function ongoing_tasks($epoch_from=0,$epoch_to=0){
      $GLOBALS['conn']->join("updates u" , "u.task_id = t.t_id" , "LEFT") ;
      $GLOBALS['conn']->join("projects p" , "t.proj_id = p.p_id" , "LEFT") ;
     
      if(!$epoch_from && !$epoch_to) {
      	$GLOBALS['conn']->where("t_status","ongoing") ;
      }
      /*else if(!$epoch_from && $epoch_to){
      	$GLOBALS['conn']->where("t_edited_time",$epoch_to,"<=") ;
      }
      else if($epoch_from && !$epoch_to){
		$GLOBALS['conn']->where("t_edited_time",$epoch_from,">=") ;    
	  }
      else if($epoch_from && $epoch_to){
        $GLOBALS['conn']->where("t_edited_time",$epoch_from,">=") ;
        $GLOBALS['conn']->where("t_edited_time",$epoch_to,"<=") ;
      }*/

      $tasks = $GLOBALS['conn']->get ("tasks t") ;


      $users = $tasks ;
      $count = -1 ;

      $a =  "<table class='table table-bordered table-hover table-striped display' id='example' >
              <thead>
                <tr>
                 <th style='text-align:center;'>Task Name</th>
                 <th style='width:220px;text-align:center;'>Project Name</th>
                 <th style='width:180px;text-align:center;'>Update Time</th>
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
          if(!$task['u_edited_time']){}
          else {
            $epoch = $task['u_edited_time'] + 19800;
            $dt = new DateTime("@$epoch");
          }
          $no_update = "No update to be shown" ;
          $a .= "<tr class='gradeA'>
              <td style='text-align:center;'>" . $task['t_name'] . "</td>
              <td style='text-align:center;'>" . $task['p_name'] . "</td>" ;
              

          if(!$task['u_edited_time']) $a .= "<td> --- </td>" ;
          else  $a .= "<td>" . $dt->format('Y-m-d H:i:s') ."</td>" ;

          $a .=   "</tr>" ;
          if(!$task['u_status']) $a .= "<tr><td colspan='2'>" . $no_update . "</td>" ;
              else $a .= "<tr><td colspan='2'>" .$task['u_status'] . "</td>" ; 
          
          $a .= "<td style='text-align:center;'> <button class='button_edit' data-toggle='modal' data-target='#myModalupdate' onclick='remove_error_update()' id=".$task['t_id']." style='text-align:center;'>Edit</button> </td></tr>" ;
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


	if(isset($_REQUEST["action"]) && !empty($_REQUEST["action"])){
		extract($_REQUEST);
		$output="";
		switch ($action) {
			case 'edit_task':
				$conn->join("updates u" , "u.task_id = t.t_id" , "LEFT") ;
				$conn->join("projects p" , "t.proj_id = p.p_id" , "LEFT") ;
				$conn->where("t_id",$task_id) ;
				$task = $GLOBALS['conn']->get ("tasks t") ;

				$output['data'] = $task ;
				break;
			
			case 'date_range_both':
        		ongoing_tasks($epoch_from,$epoch_to) ;
        		break ;

        	case 'date_range_from':
        		ongoing_tasks($epoch_from,0) ;
        		break ;

        	case 'date_range_to':
        		ongoing_tasks(0,$epoch_to) ;
        		break ;

        	case 'date_range_none':
        		ongoing_tasks();
        		break;

			default:
				# code...
				break;
		}
		echo json_encode($output);
	}	
?>







$(document).ready(function(){

  function ajaxCaller(url, data, callback, responseType, timeout) {
    if (typeof url !== 'undefined' && typeof data !== "undefined") {
          $.ajax({
                cache: false,
                type: "POST",
                timeout: (typeof timeout === "undefined") ? "60000" : timeout,
                url: url,
                data: data,
                async: true,
                dataType: (typeof responseType === "undefined") ? "text" : responseType,
                success: function (response) {
          eval(callback(response));
        },
                error: function () {
                    // failed request; give feedback to user
                    // $('#ajax-error-panel').html('<p class="error"><strong>Oops!</strong> Try that again in a few moments.</p>');
                }
            });
      }
  }

  function change_value(response){
    objData = JSON.parse(response);
    $("#showupdates_on_edit").empty()  ;
    $("#add_update_input").hide() ;
    $("#task_id_pass").hide() ;
    for(count = 0 ; count < objData.data.length ; count++){
      $("#showupdates_on_edit").append("<li>"+objData.data[count].u_status+"</li>");
      $("#showupdates_on_edit").append("<br>");
    }
    var initial = new Date(0) ;
    initial.setUTCSeconds(objData.data[0].t_date_of_brief);
    initial = initial + 19800 ;

    var date = new Date(initial);
    var dateofbrief = date.getFullYear() + '-' + ('0'+(date.getMonth()+1)).slice(-2) + '-' + ('0'+(date.getDate())).slice(-2);

    initial = new Date(0) ;
    initial.setUTCSeconds(objData.data[0].t_date_of_delivery);
    initial = initial + 19800 ;

    date = new Date(initial);
    var dateofdelivery = date.getFullYear() + '-' + ('0'+(date.getMonth()+1)).slice(-2) + '-' + ('0'+(date.getDate())).slice(-2);

    // $("#projectname_edit").attr("value",objData.data[0].p_name);
    //$("#taskname_edit").attr("value",objData.data[0].t_name);
    $("#taskname_edit").val(objData.data[0].t_name);
    $("#modebrief_edit").val(objData.data[0].t_mode_of_brief);
    $("#datebrief_edit").val(dateofbrief);
    $("#datedelivery_edit").val(dateofdelivery);
    $("#deliverables_edit").val(objData.data[0].t_deliverables);
    $("#taskid_notforedit").val(objData.data[0].t_id);


  }

  function date_filter(response){
    $("#main_data").html(response) ;

  }

  function start_screen(response){
    $("#main_data").html(response) ;
  }

    $("#myModaltask").on('change','#project_num',function () { 
      $("input").removeAttr('disabled'); 
    });

    $(".button_edit").click(function(){
      var dataSet = "action=edit_task&task_id="+this.id;
      var url ="ajax.php" ;
      
      ajaxCaller(url,dataSet,change_value) ;
    });

    $("#addupdate_edit").click(function(){
      $("#add_update_input").toggle() ;
      $(this).text(function(i, text){
          return text === "Add Update" ? "Update not to be added" : "Add Update";
        });
    });

    $("#date_form_filter").on('change','#date_to,#date_from',function(){
      $("#date_filter_error").empty() ;
      
    var current_from = new Date($("#date_from").val()) ;
    var epoch_from = (current_from.getTime() / 1000) ;

    //alert(epoch_from) ;

    var current_to = new Date($("#date_to").val()) ;
    var epoch_to = (current_to.getTime() / 1000) + 86400 ;

    //alert(epoch_to) ;

      if(!$("#date_from").val() && $("#date_to").val()){
        $("#main_data").empty() ;
        var dataSet = "action=date_range_to&epoch_from="0+"&epoch_to="+epoch_to;
        var url ="ajax.php" ;
        
        ajaxCaller(url,dataSet,date_filter) ;
      }
      else if($("#date_from").val() && !$("#date_to").val()){
        $("#main_data").empty() ;
        var dataSet = "action=date_range_from&epoch_from="epoch_from+"&epoch_to="+0;
        var url ="ajax.php" ;
        
        ajaxCaller(url,dataSet,date_filter) ;
      }
      else if(epoch_from <= epoch_to){
        $("#main_data").empty() ;
        var dataSet = "action=date_range_both&epoch_from="+epoch_from+"&epoch_to="+epoch_to;
        var url ="ajax.php" ;
        
        ajaxCaller(url,dataSet,date_filter) ;

      }
      else if(epoch_from > epoch_to){
        $("#date_filter_error").append("<font color = 'red'>Please enter a valid date range</font><br>") ;
      }
    });

    var dataSet = "action=date_range_none&epoch_from="+0+"&epoch_to="+0;
    var url="ajax.php";

    ajaxCaller(url,dataSet,start_screen) ;

});