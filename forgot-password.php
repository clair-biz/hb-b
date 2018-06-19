<html>
    <head>
        <?php require_once 'stylesheets.html';?>
    </head>
<body>
<section class="body" >
    <section class="preloader" ></section>
    <section class="content" >
<?php
require_once 'data.php';
 ?>
    <div class="container-fluid" style="margin-top: 40px;">
<div class="signin-form row">
    
    <div class="col-md-4 offset-md-4 justify-content-center" style="margin-top: 10px; margin-bottom: 10px;">

<div class="card">
    <form class="form-signin" method="post" id="forgot-pwd">

<header class="container justify-content-center ">
<h5 class="form-signin-heading container-fluid text-center">Forgot Password</h5>
<p class="container-fluid">Please enter your User Name registered with us.</p>
</header>

<div class="container justify-content-center">
      
        <div id="error">
        <!-- error will be shown here ! -->
        </div>
    <div class="row justify-content-center">
        <div class="form-group">
        <label for="user_name">UserName</label>
        <input type="text" class="form-control" name="user_name" id="user_name" />
        <span id="check-e"></span>
        </div>
    </div>
               
</div>

<footer class="container">
       <div class="row justify-content-center">
			<div class="text-center">
				<button type="submit" class="btn btn-lg btn-block" name="btn-submit" id="btn-submit">
				Submit
				</button> 
			</div>  
        </div>
				  <div class="text-center justify-content-center">
                                      New User? Register as &nbsp;<a  href="<?php echo $root."CustomerRegistration"; ?>" >Customer</a> &nbsp;or&nbsp; <a  href="<?php echo $root."VendorRegistration"; ?>" >Vendor</a><br />
					<a  href="<?php echo $root."Login"; ?>" >Login</a>
				  </div>
</footer>
    </form>
</div>
</div>
    
</div>
        </div>
             </section>    
      <section class="footer" style="margin-top: 10px !important; width: auto !important;" ></section>
      
</section>
<?php
require_once 'scripts.html';
?>

    <script>
$( document ).ready( function () {

	 $("#forgot-pwd").validate({
      rules: {
			user_name: {
                                required: true,
                                remote:{
                                    url:"register-validation.php",
                                    type:"post"
                                }
                            }
	   },
       messages: {
            user_name: {
                required: "please enter your UserName!",
                remote: "UserName entered is not registered!"
       }
   },
        errorElement : 'div',
        errorPlacement: function(error, element) {
          var placement = $(element).data('error');
          if (placement) {
            $(placement).append(error);
          } else {
            error.insertAfter(element);
          }
        },
	   submitHandler: submitForgotPwdForm	
       });
	   /* validation */
	   
	   /* login submit */
	   function submitForgotPwdForm() {	
                var origin=window.location.origin+"/";
		var form_status = $('<div class="form_status"></div>');
            
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');

			var data = $("#forgot-pwd").serialize();
                        console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : 'forgot-password1.php',
			data : data,
			beforeSend: function() {
                             $("#btn-submit").prop('disabled', true);
				$("#btn-submit").append( form_status.html('<h5><i class="fa fa-spinner fa-spin"></i> Updating...</h5>').fadeIn() );
			},
			success :  function(response) {
                           // console.log("resp -"+response+"-");
				if(response.search("ok")>-1){
                                                $("#btn-submit").prop('disabled', false);
//                                                alert('Update Successful!');
              	form_status.html('<h5 class="text-success">Password Reset Link is sent to your registered Email Address!</h5>').delay(20000).fadeOut();                    
                window.location.href="CustomerProfile";
					}
					else{

                                $("#btn-submit").prop('disabled', false);
              	form_status.html('<h5 class="text-danger">Something went wrong! Please try again</h5>').delay(20000).fadeOut();                    
					}
			  }
			});
				return false;
		}
	   /* login submit */
		} );


        </script>
  </body>
</html>