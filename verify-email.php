<!DOCTYPE html>
<html>
<body>
<?php
require_once 'header.php';
if($_SESSION["user"]==null || $_SESSION["user"]=="") {
        ?>
<script>
alert("Logging Out");
window.location.href="logout.php";
</script>
<?php
    }
elseif(Crm::getUserType($_SESSION["user"])==1 && Vendor::is_email_validated(Vendor::getvendidbyuname($_SESSION["user"]))=="Y") {
        ?>
<script>
window.location.href="verify-cntc.php";
</script>
<?php
    }
?>

    <div class="container-fluid" style="margin-top: 80px; margin-bottom: 80px;">
<div class="signin-form row">
    
    <div class="card col-md-offset-4 col-lg-offset-4 col-sm-offset-1 col-md-4 col-lg-4 col-sm-10" style=" margin-bottom: 10px;">
<header class="container">
<h5 class="form-signin-heading">Verify your Email ID.</h5>
</header>

<div class="container">
      
        <div id="error">
        <!-- error will be shown here ! -->
        </div>
        
    <div class="row">
        <form id="email-verification" method="post" >
        <div class="form-group">
        <label for="email_otp">OTP received on email</label>
        <input type="text" class="form-control" name="email_otp" placeholder="Enter OTP" id="email_otp" />
        <span id="check-e"></span>
        </div>
        <div class="row">
            <button type="submit" id="btn-verify-email" class="btn col-lg-5 col-md-5 col-sm-5" >Verify Email Id</button>
            <button type="submit" class="btn orange col-md-offset-2 col-lg-offset-2 col-sm-offset-2 col-lg-5 col-md-5 col-sm-5" >Resend OTP</button>
        </div>
        </form>
    </div>
        
</div>

</div>
    
</div>
    </div>
    <script>
        $('document').ready(function() { 
     /* validation */
/*	 $("#btn-login").on('click',function() {
            var email=$("#user_email").val(); 
            var pass=$("#password").val(); 
            var ser=$("#login-form").serialize();
            console.log("email "+email); 
            console.log("pass "+pass); 
            console.log("pass "+ser); 
         });*/
     
	 $("#email-verification").validate({
      rules: {
			email_otp: "required"
	   },
       messages: {
            email_otp: "please enter OTP obtained in email"
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
			var data = $("#email-verification").serialize();
                        console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : 'verify-email2.php',
			data : data,
			beforeSend: function() {	
				$("#error").fadeOut();
                                $("#btn-verify-email").prop('disabled', true);
				$("#btn-verify-email").html(preloader());
			},
			success :  function(response) {
                            console.log("resp "+response);
					if(response=="ok"){
                                $("#btn-verify-email").prop('disabled', true);
				$("#btn-verify-email").html(preloader());
						setTimeout(' window.location.href = "verify-cntc.php"; ',2000);
					}
                                        else if(response=="invalid") {
				$("#error").html('<div class="red">'+response+'!</div>');
                                $("#btn-verify-email").prop('disabled', false);
				$("#btn-verify-email").html("Verify OTP");
					}
			  }
			});
				return false;
		}
	   /* login submit */
});
        </script>
<?php
require_once 'footer.php';
?>
    </body>
</html>