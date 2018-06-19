jQuery(function($) {'use strict';
                var origin=window.location.origin+"/";
		var form_status = $('<div class="form_status"></div>');

                                    var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');

jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});

            function validateLogin() {
                
	 $("#login-form").validate({
      rules: {
			password: "required",
			user_email: "required"
	   },
       messages: {
            password:{
                      required: "please enter your password"
                     },
            user_email: "please enter your username"
       },
        errorElement : 'em',
        errorPlacement: function(error, element) {
          var placement = $(element).data('error');
          if (placement) {
            $(placement).append(error);
          } else {
            error.insertAfter(element);
          }
        },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* login submit */
	   function submitForm() {
			var data = $("#login-form").serialize();
                        console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : origin+'login_process.php',
			data : data,
			beforeSend: function() {	
				$("#error").fadeOut();
                                $("#btn-login").prop('disabled', true);
				$(".loader-block").html('<h5><i class="fa fa-spinner fa-spin"></i> Validating...</h5>').fadeIn();
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
				$("#btn-login").append(status);
			},
			success :  function(response) {
                            console.log("resp "+response);
                            response=JSON.parse(response);
                            if(response.home_url.length!="")
                                window.location.href=origin+response.home_url;
                            else if(response.home_url.length=="") {
			$.ajax({
				
			type : 'POST',
			url  : 'add-to-cart-from-session.php',
			beforeSend: function() {	
//				$("#error").fadeOut();
                                $("#btn-login").prop('disabled', true);
			},
			success :  function(response) {
                            console.log("resp "+response);
					if(response.search("ok")>-1){
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='text-center'>Product added to cart!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href= origin;
                });
//                                                alert('You would receive Vendor Details soon!');
//						setTimeout(' window.location.href = "./"; ',2000);
                                                updatecart();
                                    }
                                    else if(response.search("service")>-1) {
			$.ajax({
				
			type : 'POST',
			url  : 'serviceorder-insert.php',
			beforeSend: function() {
//				$("#error").fadeOut();
                                $("#btn-login").prop('disabled', true);
			},
			success :  function(response) {
                            console.log("resp "+response);
					if(response.search("ok")>-1){
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='text-center'>You would receive Service Provider's Details soon!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href=origin+"Services";
                });
//                                                alert('You would receive Service Provider Details soon!');
//						setTimeout(' window.location.href = "./"; ',2000);
                                                updatecart();
                                    }
					else{
						window.location.href = origin;
					}
			  }
			});
                        

                                    }
					else{
                                                console.log("service else");
						window.location.href = origin;
					}
			  }
			});
					}
					else{
                $("#error").html("<p style='vertical-align:central;' class='text-center bg-danger text-white'><i class='fa fa-exclamation' ></i>"+response+"!</p>").fadeIn().delay(5000).fadeOut();
//                                                alert(response+'!');
                                $("#btn-login").html('Sign In');
                                                $("#btn-login").prop('disabled', false);
/*									
				$("#error0").fadeIn(1000, function(){						
				$("#error0").html('<div class="red"> <span class="glyphicon glyphicon-info-sign"></span>Â  '+response+' !</div>');
                                                $("#btn-login").prop('disabled', false);
				});*/
					}
			  }
			});
				return false;
		}
	   /* login submit */
            }
            
            
            var path=window.location.pathname;
            console.log("path-"+path+"-");
            if(path.search("/")>-1) {
            path=path.split("/");
            path=path[1];
            }
            
        $('document').ready(function() { 
            if(path=="Login" || path=="login")
                validateLogin();
     /* validation */
});

        


});

