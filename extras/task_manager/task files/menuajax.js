$(document).ready(function(){
  $( ".project" ).change(function() {

        sel = document.getElementById('selected') ;
        if(sel !== null && sel !== this ) {
            sel.selectedIndex = 0 ;
            $(sel).removeAttr("id") ;

        }

        if(sel !== this) {
            $(this).attr('id','selected') ; 
        }

        var dataSet = { "name" : this.value, "category": this.name };
        var url = "task.php";
        $.ajax({
                cache: false,
                type: "POST",
                timeout: (typeof timeout === "undefined") ? "60000" : timeout,
                url: url,
                data: dataSet,
                async: true,
                dataType: (typeof responseType === "undefined") ? "text" : responseType,
                success: function (response) {

                 //eval(callback(response));
                 console.log(response);
                 $("#showhere").html(response);

                },
                error: function () {
                    // failed request; give feedback to user
                    $('#ajax-error-panel').html('<p class="error"><strong>Oops!</strong> Try that again in a few moments.</p>');
                }
        });
         
    });

});


	



    