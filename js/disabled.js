$(document).ready(function(){
    $("#myModaltask").on('change','#project_num',function () { 
    	$("input").removeAttr('disabled'); 
    });

    $(".button_edit").click(function(){
    	var dataSet = { "id" : this.data-id };
    	var url = "edittask.php" ;

    	$.ajax({
                cache: false,
                type: "POST",
                timeout: (typeof timeout === "undefined") ? "60000" : timeout,
                url: url,
                data: dataSet,
                async: true,
                dataType: (typeof responseType === "undefined") ? "text" : responseType,
                success: function (response) {
                 console.log(response);
                 $("#name_edit").attr("value",response);

                },
                error: function () {
                    // failed request; give feedback to user
                    $('#ajax-error-panel').html('<p class="error"><strong>Oops!</strong> Try that again in a few moments.</p>');
                }
        });
    });
});