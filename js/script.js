  function check(str1,str2){
      if (!str1) {
        document.getElementById(str2).innerHTML = "<font color = 'red'>You can't leave this empty </font> <br />" ;
      }
      else{
        document.getElementById(str2).innerHTML = "" ;
      }

  }

  function validate_project_add(){
      var count = 0 ;
      if(!document.getElementById('projectname').value){
        document.getElementById('projectnamevalid').innerHTML ="<font color = 'red'>You can't leave this empty </font> <br />" ;
        count++ ;
      } 

      return !count ;
  }

  function validate_task_add(){
      if(!document.getElementById('project_name').selectedIndex){
        document.getElementById('project_name_valid').innerHTML = "<font color = 'red'>You must select a project</font> <br />" ;
      }
      else{
        var count = 0 ;
        if(!document.getElementById('name').value){
          document.getElementById('namevalid').innerHTML ="<font color = 'red'>You can't leave this empty </font> <br />" ;
          count++ ;
        } 
        /*if(!document.getElementById('modeofbrief').value){
          document.getElementById('modevalid').innerHTML ="<font color = 'red'>You can't leave this empty </font> <br />" ;
          count++ ;
        } 
        if(!document.getElementById('datepicker_datebrief_add').value){
          document.getElementById('datebriefvalid').innerHTML ="<font color = 'red'>You can't leave this empty </font> <br />" ;
          count++ ;
        } 
        if(!document.getElementById('datepicker_datedelivery_add').value){
          document.getElementById('datedeliveryvalid').innerHTML ="<font color = 'red'>You can't leave this empty </font> <br />" ;
          count++ ;
        }
        if(!document.getElementById('deliverables').value){
          document.getElementById('deliverablesvalid').innerHTML ="<font color = 'red'>You can't leave this empty </font> <br />" ;
          count++ ;
        }*/

        if(!document.getElementById('add_update_input_addtask').offsetParent){}
        else{
            if(!document.getElementById('updatestatus_edit_addtask').value){
              document.getElementById('updatestatusvalid_edit_addtask').innerHTML ="<font color = 'red'>You can't leave this empty </font> <br />";
              count++ ;
            } 
        } 
     
        return !count ;
      }
  }  

  function validate_press_add(){
      var count = 0 ;
      if(!document.getElementById('pressrelease_name').value){
        document.getElementById('pressreleasenamevalid').innerHTML ="<font color = 'red'>You can't leave this empty </font> <br />" ;
        count++ ;
      } 
      if(!document.getElementById('add_update_input_addpress').offsetParent){}
        else{
            if(!document.getElementById('updatestatus_edit_addpress').value){
              document.getElementById('updatestatusvalid_edit_addpress').innerHTML ="<font color = 'red'>You can't leave this empty </font> <br />";
              count++ ;
            } 
        } 
     
      return !count ;
  }

  function validate_task_edit(){
      var count = 0 ;
      if(!document.getElementById('taskname_edit').value){
        document.getElementById('tasknamevalid_edit').innerHTML ="<font color = 'red'>You can't leave this empty </font> <br />" ;
        count++ ;
      } 
      /*if(!document.getElementById('modebrief_edit').value){
        document.getElementById('modebriefvalid_edit').innerHTML ="<font color = 'red'>You can't leave this empty </font> <br />" ;
        count++ ;
      } 
      if(!document.getElementById('datepicker_datebrief_edit').value){
        document.getElementById('datebriefvalid_edit').innerHTML ="<font color = 'red'>You can't leave this empty </font> <br />" ;
        count++ ;
      }
      if(!document.getElementById('datepicker_datedelivery_edit').value){
        document.getElementById('datedeliveryvalid_edit').innerHTML ="<font color = 'red'>You can't leave this empty </font> <br />" ;
        count++ ;
      }
      if(!document.getElementById('deliverables_edit').value){
        document.getElementById('deliverablesvalid_edit').innerHTML ="<font color = 'red'>You can't leave this empty </font> <br />" ;
        count++ ;
      } */
      
      if(!document.getElementById('add_update_input').offsetParent){}
      else{
          if(!document.getElementById('updatestatus_edit').value){
            document.getElementById('updatestatusvalid_edit').innerHTML ="<font color = 'red'>You can't leave this empty </font> <br />";
            count++ ;
          } 
      } 

      return !count ;
  }

  function validate_project_edit(){
    if(!document.getElementById('projectname_edit').value){
        document.getElementById('projectnamevalid_edit').innerHTML ="<font color = 'red'>You can't leave this empty </font> <br />" ;
    } 
  }

  function remove_error_update(){
          document.getElementById('tasknamevalid_edit').innerHTML ="" ;
          document.getElementById('modebriefvalid_edit').innerHTML ="" ;
          document.getElementById('datebriefvalid_edit').innerHTML ="" ;
          document.getElementById('datedeliveryvalid_edit').innerHTML ="" ;
          document.getElementById('deliverablesvalid_edit').innerHTML ="" ;
          document.getElementById('updatestatus_edit').value = "";
  }

  function remove_error_update_press(){
          document.getElementById('pressreleasenamevalid').innerHTML ="" ;
          document.getElementById('updatestatusvalid_edit_addpress').innerHTML ="" ;
  }

  function remove_error_task(){
          document.getElementById('name').value = "" ;
          document.getElementById('modeofbrief').value = "" ;
          document.getElementById('datepicker_datebrief_add').value = "" ;
          document.getElementById('datepicker_datedelivery_add').value = "" ;
          document.getElementById('deliverables').value ="";
          document.getElementById('updatestatus_edit_addtask').value="";
          document.getElementById('project_name').selectedIndex = 0 ;
          document.getElementById('project_name_valid').innerHTML = "" ;
          document.getElementById('namevalid').innerHTML ="" ;
          document.getElementById('modevalid').innerHTML ="" ;
          document.getElementById('datebriefvalid').innerHTML ="" ;
          document.getElementById('datedeliveryvalid').innerHTML ="" ;
          document.getElementById('deliverablesvalid').innerHTML ="" ;
          document.getElementById('updatestatusvalid_edit_addtask').innerHTML = "" ;
  }

  function remove_error_project(){
          document.getElementById('projectnamevalid').innerHTML = "" ;
          document.getElementById('projectname').value = "" ;
  }

  function remove_update_toggle_error(){
          document.getElementById('updatestatus_edit').value = "" ;
          document.getElementById('updatestatusvalid_edit').innerHTML = "" ;
  }

  function remove_update_error_addtask(){
          document.getElementById('updatestatus_edit_addtask').value = "" ;
          document.getElementById('updatestatusvalid_edit_addtask').innerHTML = "" ;
  }

  function remove_update_error_addpress(){
          document.getElementById('updatestatus_edit_addpress').value = "" ;
          document.getElementById('updatestatusvalid_edit_addpress').innerHTML = "" ;
  }

  function remove_update_toggle_error_press(){
          document.getElementById('updatestatus_edit_press').value = "" ;
          document.getElementById('updatestatusvalid_edit_press').innerHTML = "" ;
  }


  $(document).ready(function(){

    function ajaxCaller(url, data, callback, responseType, timeout) {
      if (typeof url !== 'undefined' && typeof data !== "undefined") {
            $.ajax({
                  cache: false,
                  type: "POST",
                  timeout: (typeof timeout === "undefined") ? "60000" : timeout,
                  url: url,
                  data: data,
                  dataType: (typeof responseType === "undefined") ? "text" : responseType,
                  success: function (response) {
      		          eval(callback(response));
      		        },
                  error: function (response) {
                    console.log(response);
                  }
            });
        }
    }

  function change_value(response){
	    objData = JSON.parse(response);
	    $("#showupdates_on_edit").empty()  ;
	    $("#add_update_input").hide() ;
	    $("#task_id_pass").hide() ;

      var table = "<table class='table table-bordered table-hover table-striped display' id='table_update_edit'><thead><tr><th width='400' style='text-align:center;'>Update</th><th style='text-align:center;'>Action</th></tr></thead><tbody>";
      if(objData.data[0].u_id != null ){
		    for(count = 0 ; count < objData.data.length ; count++){
		      table = table + ("<tr><td>"+objData.data[count].u_status+"</td><td style='text-align:center;'><button type='button' class='btn btn-xs btn-success  button_edit_update'  id='"+objData.data[count].u_id+"' data-toggle='modal' data-target='#myModaleditupdate'>Edit</button></td></tr>");
		    }
		  }
	    else {
	    	$("#showupdates_on_edit").append("<li> No Update to be shown </li>");
	        $("#showupdates_on_edit").append("<br>");
	    }

      table = table + "</tbody><tfoot><tr><th style='text-align:center;'>Update</th><th style='text-align:center;'>Action</th></tr></tfoot></table>" ;
      if (objData.data[0].u_id != null ) {
        $("#showupdates_on_edit").append(table) ;
      }

	    initial = new Date(0) ;
	    initial.setUTCSeconds(objData.data[0].t_date_of_delivery);
	    initial = initial + 19800 ;

	    date = new Date(initial);
	    var dateofdelivery = ('0'+(date.getMonth()+1)).slice(-2) + '/' + ('0'+(date.getDate())).slice(-2) + '/' + date.getFullYear();

      if(dateofdelivery == "01/01/1970"){
        dateofdelivery = "" ;
      }

      if (objData.data[0].t_status == 'ongoing' || objData.data[0].t_status == 'Ongoing'){
          $("#task_status").prop('selectedIndex',0) ;
      }
      else if(objData.data[0].t_status == 'completed' || objData.data[0].t_status == 'Completed'){
          $("#task_status").prop('selectedIndex',1) ;
      }
      else{
          $("#task_status").prop('selectedIndex',0) ;
      }

      if(objData.data[0].p_id == 1){
        $("#change_project_name").prop('selectedIndex',0);
      }
      else if(objData.data[0].p_id == 3){
        $("#change_project_name").prop('selectedIndex',1);
      }
      else if(objData.data[0].p_id == 5){
        $("#change_project_name").prop('selectedIndex',2);
      }
      else if(objData.data[0].p_id == 7){
        $("#change_project_name").prop('selectedIndex',3);
      }
      else if(objData.data[0].p_id == 10){
        $("#change_project_name").prop('selectedIndex',4);
      }

	    $("#taskname_edit").val(objData.data[0].t_name);
	    $("#modebrief_edit").val(objData.data[0].t_mode_of_brief);
	    $("#datepicker_datebrief_edit").val(objData.data[0].t_date_of_brief);
	    $("#datepicker_datedelivery_edit").val(dateofdelivery);
	    $("#deliverables_edit").val(objData.data[0].t_deliverables);
	    $("#taskid_notforedit").val(objData.data[0].t_id);

      $("#addupdate_edit").text("Add Update") ;
            
  }

  function change_value_press(response){
      objData = JSON.parse(response);
      $("#showupdates_on_edit_press").empty()  ;
      $("#add_update_input_press").hide() ;
      $("#task_id_pass_press").hide() ;

      var table = "<table class='table table-bordered table-hover table-striped display' id='table_update_edit'><thead><tr><th width='400' style='text-align:center;'>Update</th><th style='text-align:center;'>Action</th></tr></thead><tbody>";
      if(objData.data[0].u_id != null ){
        for(count = 0 ; count < objData.data.length ; count++){
          table = table + ("<tr><td>"+objData.data[count].u_status+"</td><td style='text-align:center;'><button type='button' class='btn btn-xs btn-success  button_edit_update_press'  id='"+objData.data[count].u_id+"' data-toggle='modal' data-target='#myModaleditupdate'>Edit</button></td></tr>");
        }
      }
      else {
        $("#showupdates_on_edit_press").append("<li> No Update to be shown </li>");
          $("#showupdates_on_edit_press").append("<br>");
      }

      table = table + "</tbody><tfoot><tr><th style='text-align:center;'>Update</th><th style='text-align:center;'>Action</th></tr></tfoot></table>" ;
      if (objData.data[0].u_id != null ) {
        $("#showupdates_on_edit_press").append(table) ;
      }

      initial = new Date(0) ;
      initial.setUTCSeconds(objData.data[0].t_date_of_delivery);
      initial = initial + 19800 ;

      date = new Date(initial);
      var dateofdelivery = ('0'+(date.getMonth()+1)).slice(-2) + '/' + ('0'+(date.getDate())).slice(-2) + '/' + date.getFullYear();

      if(dateofdelivery == "01/01/1970"){
        dateofdelivery = "" ;
      }

      if (objData.data[0].t_status == 'ongoing' || objData.data[0].t_status == 'Ongoing'){
          $("#press_status").prop('selectedIndex',0) ;
      }
      else if(objData.data[0].t_status == 'completed' || objData.data[0].t_status == 'Completed'){
          $("#press_status").prop('selectedIndex',1) ;
      }
      else{
          $("#press_status").prop('selectedIndex',0) ;
      }

      $("#pressname_edit").val(objData.data[0].t_name);
      $("#datepicker_datebrief_edit_press").val(objData.data[0].t_date_of_brief);
      $("#datepicker_datedelivery_edit_press").val(dateofdelivery);
      $("#webupload_edit").val(objData.data[0].t_web_upload);
      $("#social_mediaupload_edit").val(objData.data[0].t_social_media_upload);
      $("#taskid_notforedit_press").val(objData.data[0].t_id);

      $("#addupdate_edit_press").text("Add Update") ;
            
  }

  function change_value_project(response){
    objData = JSON.parse(response);
    if (objData.data[0].p_status == 'ongoing' || objData.data[0].p_status == 'Ongoing'){
        $("#project_status").prop('selectedIndex',0) ;
    }
    else if(objData.data[0].p_status == 'completed' || objData.data[0].p_status == 'Completed'){
        $("#project_status").prop('selectedIndex',1) ;
    }
    else{
        $("#project_status").prop('selectedIndex',0) ;
    }
    $("#projectname_edit").val(objData.data[0].p_name);
  }

  function search_filter(response){
    $("#main_data").html(response) ;
    add_pagination()
  }

  function task_response(response){
    $("#edit_task_response").html(response) ;
  }

  function update_response(response){
    $("#edit_update_response").html(response) ;
  }

  function value_update(response){
       objData = JSON.parse(response);
       $("#modified_update").val(objData.data[0].u_status);
  };

  function date_filter(response){
      $("#main_data").html(response);
      add_pagination();
  }

  function paginate_data(response){
    $("#main_data").html(response);

  }

  function add_task(response){
  	$("#add_task_response").html(response) ;
  }

  function add_press(response){
    $("#add_press_response").html(response) ;
  }

  function add_project(response){
  	$("#add_project_response").html(response) ;
  }

  function edit_task(response){
  	$("#edit_task_response").html(response) ;
  }

  function csv_display(response){
     alert(response) ;
  }

  function restore_task(response){
    $("#restore_task_response").html(response) ;
  }

  function edit_project_save(response){
    $("#edit_project_save").html(response) ;
  }

  function project_response(response){
   $("#edit_project_save").html(response) ;
  }

  function restore_project(response){
    $("#restore_task_response").html(response) ;
  }

  function add_pagination(){
    $("#example").DataTable({
        "pagingType": "full_numbers",
         "bFilter": false,
         "aaSorting": [],
    });
    $("#example").find("th").off("click.DT");
  }

  $("#myModaltask").on('change','#project_name',function () { 
  	if(!$("#project_name").val()){
  		$("#name,#modeofbrief,#datepicker_datebrief_add,#datepicker_datedelivery_add,#deliverables,#updatestatus_edit_addtask").attr("disabled","disabled");
  		$("#namevalid,#modevalid,#datebriefvalid,#datedeliveryvalid,#deliverablesvalid,#updatestatusvalid_edit_addtask").empty() ;
  	}
  	else{
  		$("input").removeAttr('disabled'); 
  		$("#project_name_valid").empty() ;
  	}
  });

    $("#showupdates_on_edit").on('click','.button_edit_update',function(){
        var dataSet = "action=edit_update_on_edit_task&update_id="+this.id ;
        var url = "ajax.php" ;

        $("#update_id_pass").hide() ;
        $("#updateid_notforedit").val(this.id) ;

        ajaxCaller(url,dataSet,value_update) ;
    });

    $("#showupdates_on_edit_press").on('click','.button_edit_update_press',function(){
        var dataSet = "action=edit_update_on_edit_task&update_id="+this.id ;
        var url = "ajax.php" ;

        $("#update_id_pass").hide() ;
        $("#updateid_notforedit").val(this.id) ;

        ajaxCaller(url,dataSet,value_update) ;
    });

    $(".buttontask").click(function(){
    	$("#add_task_submit").removeAttr('data-dismiss');
      $("#add_press_submit").removeAttr('data-dismiss');
    	$("#name,#modeofbrief,#datepicker_datebrief_add,#datepicker_datedelivery_add,#deliverables,#updatestatus_edit_addtask").attr("disabled","disabled");
    });

    $("#button_add_project").click(function(){
    	$("#add_project_submit").removeAttr('data-dismiss');
    });

    $("#button_add_task").click(function(){
        $("#add_update_input_addtask").hide() ;
        $("#add_update_input_addpress").hide();

        $("#addupdate_edit_addtask").text("Add Update") ;
        $("#addupdate_edit_addpress").text("Add Update") ;
        
    });

    $("#main_data").on('click',".button_edit",function(){
    	$("#edit_task_submit").removeAttr('data-dismiss');
	    var dataSet = "action=edit_task&task_id="+this.id;
	    var url ="ajax.php" ;
	      
	    ajaxCaller(url,dataSet,change_value) ;
    });

    $("#main_data_recycle").on('click',".button_restore_task",function(){
      $("#task_id_pass_restore").hide() ;
      var task_id = this.id ;
      $("#taskid_restore").val(task_id) ;
    });

    $("#main_data_recycle").on('click',".button_restore_project",function(){
      $("#project_id_pass_restore").hide() ;
      var project_id = this.id ;
      $("#projectid_restore").val(project_id) ;
    });

    $("#myModalrestore_confirm").on('click',"#restore_task_yes",function(){
      var task_id = $("#taskid_restore").val() ;

      var dataSet = "action=restore_task&task_id="+task_id;
      var url ="ajax.php" ;

      ajaxCaller(url,dataSet,restore_task) ;
    });

    $("#myModalrestore_confirm_proj").on('click',"#restore_project_yes",function(){
      var project_id = $("#projectid_restore").val() ;

      var dataSet = "action=restore_project&project_id="+project_id;
      var url ="ajax.php" ;

      ajaxCaller(url,dataSet,restore_project) ;
    });

    $("#main_data").on('click',".button_edit_press",function(){
      $("#edit_task_submit_press").removeAttr('data-dismiss');

      var dataSet = "action=edit_task&task_id="+this.id;
      var url ="ajax.php" ;

      ajaxCaller(url,dataSet,change_value_press) ;
    });

    $("#main_data_project").on('click',".button_edit_project",function(){
      $("#project_id_pass").hide() ;
      var project_id = this.id ;
      var dataSet = "action=edit_project&project_id="+project_id;
      var url ="ajax.php" ;

      $("#projectid_notforedit").val(project_id);
      ajaxCaller(url,dataSet,change_value_project) ;
    });

    $("#addupdate_edit_press").click(function(){
      $("#add_update_input_press").toggle() ;
      $(this).text(function(i, text){
          return text === "Add Update" ? "Update not to be added" : "Add Update";
        });
    });

    $("#addupdate_edit").click(function(){
      $("#add_update_input").toggle() ;
      $(this).text(function(i, text){
          return text === "Add Update" ? "Update not to be added" : "Add Update";
        });
    });

    $("#addupdate_edit_addtask").click(function(){
      $("#add_update_input_addtask").toggle() ;
      $(this).text(function(i, text){
          return text === "Add Update" ? "Update not to be added" : "Add Update";
        });
    });

    $("#addupdate_edit_addpress").click(function(){
      $("#add_update_input_addpress").toggle() ;
      $(this).text(function(i, text){
          return text === "Add Update" ? "Update not to be added" : "Add Update";
        });
    });
    
    $("#edit_project_action").on('click','#edit_project_submit',function(){
        var project_name = $("#projectname_edit").val() ;
        var project_id = $("#projectid_notforedit").val() ;

        var dataSet = "action=edit_project_submit&project_id="+project_id+"&project_name="+project_name;
        var url="ajax.php";

        if(project_name){
          var attr = $("#edit_project_submit").attr('data-dismiss');

          if (typeof attr == typeof undefined || attr == false) {
            ajaxCaller(url,dataSet,edit_project_save) ;
          }

          $("#edit_project_submit").attr("data-dismiss","modal") ;
        }
    });

   	$("#add_task_submit").click(function(){
   		var project_name = $("#project_name").val() ;
   		var task_name = $("#name").val() ;
   		var mode_of_brief = $("#modeofbrief").val() ;
   		var date_of_brief = $("#datepicker_datebrief_add").val() ;
   		var date_of_delivery = $("#datepicker_datedelivery_add").val() ;
   		var deliverables = $("#deliverables").val() ;
      var update_status = $("#updatestatus_edit_addtask").val() ;
   
      var update_typed_in = $("#updatestatusvalid_edit_addtask").text() ; 

   		var dataSet = "action=add_task&project_name="+project_name+"&task_name="+task_name+"&mode_of_brief="+mode_of_brief
   		+"&date_of_brief="+date_of_brief+"&date_of_delivery="+date_of_delivery+"&deliverables="+deliverables+"&update_status="+update_status;
   		var url ="ajax.php" ;

   		if(project_name && task_name &&!update_typed_in){
        var attr = $("#add_task_submit").attr('data-dismiss');

   			if (typeof attr == typeof undefined || attr == false) {
          ajaxCaller(url,dataSet,add_task) ;
        }

        $("#add_task_submit").attr("data-dismiss","modal") ;
   		}
   	});

    $("#add_press_submit").click(function(){
      var press_name = $("#pressrelease_name").val() ;
      var date_of_brief = $("#datepicker_datebrief_add_press").val() ;
      var date_of_delivery = $("#datepicker_datedelivery_add_press").val() ;
      var webupload = $("#webupload").val() ;
      var social_mediaupload = $("#social_mediaupload").val() ;
      var update_status = $("#updatestatus_edit_addpress").val() ;
   
      var update_typed_in = $("#updatestatusvalid_edit_addpress").text() ; 

      var dataSet = "action=add_press&press_name="+press_name+"&date_of_brief="+date_of_brief+"&date_of_delivery="+date_of_delivery+"&webupload="
      +webupload+"&social_mediaupload="+social_mediaupload+"&update_status="+update_status;
      var url ="ajax.php" ;

      if(press_name &&!update_typed_in){
        var attr = $("#add_press_submit").attr('data-dismiss');

        if (typeof attr == typeof undefined || attr == false) {
          ajaxCaller(url,dataSet,add_press) ;
        }

        $("#add_press_submit").attr("data-dismiss","modal") ;
      }
    });
   	
   	$("#myModalproject").on('click',"#add_project_submit",function(){
   		var project_name = $("#projectname").val() ;

   		var dataSet = "action=add_project&project_name="+project_name ;
   		var url = "ajax.php" ;

   		if(project_name){
        var attr = $("#add_project_submit").attr('data-dismiss');

        if (typeof attr == typeof undefined || attr == false) {
   			  ajaxCaller(url,dataSet,add_project) ;
        }
        $("#add_project_submit").attr("data-dismiss","modal") ;
   		}
   	});

    $("#myModaleditupdate").on('click','#edit_update_submit',function(){
        var update = $("#modified_update").val() ;
        var update_id = $("#updateid_notforedit").val() ;

        var dataSet = "action=edit_update_on_save&update="+update+"&update_id="+update_id;
        var url = "ajax.php";

        ajaxCaller(url,dataSet,update_response) ;

    });

    $("#myModalConfirmUpdateDelete").on('click','#delete_update_yes',function(){
        var update_id = $("#updateid_notforedit").val() ;

        var dataSet = "action=edit_update_on_delete&update_id="+update_id;
        var url = "ajax.php";

        ajaxCaller(url,dataSet,update_response) ;

    });

   	$("#myModalupdate").on('click',"#edit_task_submit",function(){
   		var task_name = $("#taskname_edit").val() ;
   		var mode_of_brief = $("#modebrief_edit").val() ;
   		var date_of_brief = $("#datepicker_datebrief_edit").val() ;
   		var date_of_delivery = $("#datepicker_datedelivery_edit").val() ;
   		var deliverables = $("#deliverables_edit").val() ;
  		var task_id = $("#taskid_notforedit").val() ;
  		var status = $("#task_status").val() ;
  		var update_status = $("#updatestatus_edit").val() ;

      var project_id  = $("#change_project_name").val();
   
   		var update_typed_in = $("#updatestatusvalid_edit").text() ;	

   		var dataSet = "action=edit_task_update&task_id="+task_id+"&task_name="+task_name+"&mode_of_brief="+mode_of_brief
   		+"&date_of_brief="+date_of_brief+"&date_of_delivery="+date_of_delivery+"&deliverables="+deliverables+"&task_status="
   		+status+"&update_status="+update_status+"&project_id="+project_id;
   		var url = "ajax.php" ;

   		if(task_name && !update_typed_in){
        var attr = $("#edit_task_submit").attr('data-dismiss');
   			if (typeof attr == typeof undefined || attr == false) {
   			  ajaxCaller(url,dataSet,edit_task) ;
        }
        $("#edit_task_submit").attr("data-dismiss","modal") ;
   		}
   	});

    $("#myModalupdate_press").on('click',"#edit_task_submit_press",function(){
      var press_name = $("#pressname_edit").val() ;
      var date_of_brief = $("#datepicker_datebrief_edit_press").val() ;
      var date_of_delivery = $("#datepicker_datedelivery_edit_press").val() ;
      var web_upload = $("#webupload_edit").val() ;
      var social_mediaupload = $("#social_mediaupload_edit").val() ;
      var task_id = $("#taskid_notforedit_press").val() ;
      var status = $("#press_status").val() ;
      var update_status = $("#updatestatus_edit_press").val() ;
   
      var update_typed_in = $("#updatestatusvalid_edit_press").text() ; 

      var dataSet = "action=edit_press_update&task_id="+task_id+"&press_name="+press_name+"&date_of_brief="+date_of_brief+"&date_of_delivery="
      +date_of_delivery+"&web_upload="+web_upload+"&social_mediaupload="+social_mediaupload+"&task_status="+status+"&update_status="+update_status;
      var url = "ajax.php" ;

      if(press_name && !update_typed_in){
        var attr = $("#edit_task_submit_press").attr('data-dismiss');
        if (typeof attr == typeof undefined || attr == false) {
          ajaxCaller(url,dataSet,edit_task) ;
        }
        $("#edit_task_submit_press").attr("data-dismiss","modal") ;
      }
    });

  $("#myModalConfirmTaskDelete").on('click',"#delete_task_yes",function(){
      var task_id = $("#taskid_notforedit").val() ;

      var dataSet = "action=edit_task_on_delete&task_id="+task_id;
      var url = "ajax.php";

      ajaxCaller(url,dataSet,task_response) ;
  });

  $("#myModalConfirmProjectDelete").on('click',"#delete_project_yes",function(){
      var project_id = $("#projectid_notforedit").val() ;

      var dataSet = "action=delete_project&project_id="+project_id;
      var url = "ajax.php";

      ajaxCaller(url,dataSet,project_response) ;
  });

  $("#myModalConfirmPressDelete").on('click',"#delete_press_yes",function(){
      var task_id = $("#taskid_notforedit_press").val() ;

      var dataSet = "action=edit_task_on_delete&task_id="+task_id;
      var url = "ajax.php";

      ajaxCaller(url,dataSet,task_response) ;
  });

	$( "#datepicker_date_from,#datepicker_date_to,#datepicker_datedelivery_add,#datepicker_datedelivery_edit,#datepicker_datedelivery_add_press,#datepicker_datedelivery_edit_press").datepicker();
	 
	/*$("#export_data").on('change','#export_as_options',function(){
		  var current_from = new Date($("#datepicker_date_from").val()) ;
	    var epoch_from = (current_from.getTime() / 1000) ;

	    var current_to = new Date($("#datepicker_date_to").val()) ;
	    var epoch_to = (current_to.getTime() / 1000) + 86400 ;

		  var dataSet = "action=export_csv&epoch_from="+epoch_from+"&epoch_to="+epoch_to;
    	var url="ajax.php";

    	ajaxCaller(url,dataSet,csv_display) ;
	})
*/
    $("#form_filter").on('click','#button_data_filter',function(){
      	$("#date_filter_error").empty() ;
        $("#main_data").html('<img src="images/loading.gif" style="width:64px;height:64px;margin-left:431px;">') ;
      
	    var current_from = new Date($("#datepicker_date_from").val()) ;
	    var epoch_from = (current_from.getTime() / 1000) ;

	    var current_to = new Date($("#datepicker_date_to").val()) ;
	    var epoch_to = (current_to.getTime() / 1000) + 86400 ;

	    $("#date_from_pass").val(epoch_from) ;
	    $("#date_to_pass").val(epoch_to) ;

      var task_status = $("#status_filter_dropdown").val() ;
      var project_id = $("#project_name_filter").val() ;

      $("#task_status_pass").val(task_status);
      $("#project_id_pass").val(project_id);

	      if(!$("#datepicker_date_from").val() && $("#datepicker_date_to").val()){
	        var dataSet = "action=date_range_to&epoch_from=0&epoch_to="+epoch_to+"&task_status="+task_status+"&project_id="+project_id;
	        var url ="ajax.php" ;
	        
	        ajaxCaller(url,dataSet,date_filter) ;
	      }
	      else if($("#datepicker_date_from").val() && !$("#datepicker_date_to").val()){
	        var dataSet = "action=date_range_from&epoch_from="+epoch_from+"&epoch_to=0"+"&task_status="+task_status+"&project_id="+project_id;
	        var url ="ajax.php" ;
	        
	        ajaxCaller(url,dataSet,date_filter) ;
	      }
        else if(!$("#datepicker_date_from").val() && !$("#datepicker_date_to").val()){
          var dataSet = "action=date_range_none&epoch_from=0&epoch_to=0"+"&task_status="+task_status+"&project_id="+project_id;
          var url ="ajax.php" ;
          
          ajaxCaller(url,dataSet,date_filter) ;
        }
	      else if(epoch_from < epoch_to){
	        var dataSet = "action=date_range_both&epoch_from="+epoch_from+"&epoch_to="+epoch_to+"&task_status="+task_status+"&project_id="+project_id;
	        var url ="ajax.php" ;
	        
	        ajaxCaller(url,dataSet,date_filter) ;

	      }
	      else if(epoch_from >= epoch_to){
	        $("#date_filter_error").append("<font color = 'red'>Please enter a valid date range</font><br>") ;
	      }
    });

    $("#search_box").on('keyup','#search_table',function(){
          var keyword = $("#search_table").val() ;
          $("#main_data").html('<img src="images/loading.gif" style="width:64px;height:64px;margin-left:431px;">') ;

          var current_from = new Date($("#datepicker_date_from").val()) ;
          if(!$("#datepicker_date_from").val()) var epoch_from = 0 ;
          else var epoch_from = (current_from.getTime() / 1000) ;

          var current_to = new Date($("#datepicker_date_to").val()) ;
          if(!$("#datepicker_date_to").val()) var epoch_to = 0 ;
          else var epoch_to = (current_to.getTime() / 1000) + 86400 ;

          var task_status = $("#status_filter_dropdown").val() ;
          var project_id = $("#project_name_filter").val() ;

          var dataSet = "action=search_site&keyword="+keyword+"&epoch_from="+epoch_from+"&epoch_to="+epoch_to+"&task_status="+task_status
          +"&project_id="+project_id;
          var url = "ajax.php";

          ajaxCaller(url,dataSet,search_filter) ;
    });

    $("#main_data").on('click','.pagination_values',function(){
        var page_number = this.id;
        $("#main_data").html('<img src="images/loading.gif" style="width:64px;height:64px;margin-left:431px;">') ;
 
        /*$(".pagination_values").removeClass("selected_page") ;
        $(this).addClass("selected_page") ;*/

        /*if($(this).hasClass("selected_page")){
          alert("Has");
        }
        else{
          alert("has not");
        }*/

        var current_from = new Date($("#datepicker_date_from").val()) ;
        if(!$("#datepicker_date_from").val()) var epoch_from = 0 ;
        else var epoch_from = (current_from.getTime() / 1000) ;

        var current_to = new Date($("#datepicker_date_to").val()) ;
        if(!$("#datepicker_date_to").val()) var epoch_to = 0 ;
        else var epoch_to = (current_to.getTime() / 1000) + 86400 ;

        var task_status = $("#status_filter_dropdown").val() ;
        var project_id = $("#project_name_filter").val() ;

        var dataSet = "action=paginate_data&epoch_from="+epoch_from+"&epoch_to="+epoch_to+"&task_status="+task_status
          +"&project_id="+project_id+"&page_number="+page_number;
        var url = "ajax.php";

        ajaxCaller(url,dataSet,paginate_data) ;
    });

    add_pagination();
});