    $(document).ready(function(){
	"use strict";
      $("#send").click(function(){
	"use strict";
        var name   = $("#name").val();
        var email  = $("#email").val();
        var message  = $("#message").val();

        var error = false;

         if(email.length == 0 || email.indexOf("@") == "-1" || email.indexOf(".") == "-1"){
           var error = true;
           $("#error_email").fadeIn(500);
         }else{
           $("#error_email").fadeOut(500);
         }
         if(message.length == 0){
            var error = true;
            $("#error_message").fadeIn(500);
         }else{
            $("#error_message").fadeOut(500);
         }
         
         if(error == false){
           $("#send").attr({"disabled" : "true", "value" : "Loading..." });
            
           $.ajax({
             type: "POST",
             url : "send.php",    
             data: "name=" + name + "&email=" + email + "&subject=" + "You Got Email" + "&message=" + message,
             success: function(data){    
              if(data == 'success'){
                $("#btnsubmit").remove();
                $("#mail_success").fadeIn(500);
              }else{
                $("#mail_failed").html(data).fadeIn(500);
                $("#send").removeAttr("disabled").attr("value", "send");
              }     
             }  
           });  
        }
		    return false;                      
      });    
    });
