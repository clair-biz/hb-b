/*
Author: Pradeep Khodke
URL: http://www.codingcage.com/
*/

$('document').ready(function() { 
     /* validation */
	 $("#login-form").validate({
      rules: {
			password: "required",
			user_email: "required"
	   },
       messages: {
            password:{
                      required: "please enter your password"
                     },
            user_email: "please enter your email address"
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* login submit */
	   function submitForm() {		
			var data = $("#login-form").serialize();
                        console.log(data);
			$.ajax({
				
			type : 'POST',
			url  : 'login_process.php',
			data : data,
			beforeSend: function() {	
				$("#error").fadeOut();
				$("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span>   sending ...');
			},
			success :  function(response) {
					if(response=="11"){
						$("#btn-login").html('<img src="login/btn-ajax-loader.gif" />   Signing In ...');
						$("#modal-update").modal('hide');
						setTimeout(' window.location.href = "admin-dashboard.php"; ',4000);
					}
					if(response=="1"){
						$("#btn-login").html('<img src="login/btn-ajax-loader.gif" />   Signing In ...');
						$("#modal-update").modal('hide');
						setTimeout(' window.location.href = "vendor-home.php"; ',4000);
					}
					if(response=="2"){
						$("#btn-login").html('<img src="login/btn-ajax-loader.gif" />   Signing In ...');
						$("#modal-update").modal('hide');
						setTimeout(' window.location.href = "./"; ',4000);
					}
					else{
									
				$("#error").fadeIn(1000, function(){						
				$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span>  '+response+' !</div>');
                                $("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span>   Sign In');
				});
					}
			  }
			});
				return false;
		}
	   /* login submit */
});