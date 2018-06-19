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


//print_r($_SESSION["regobj"]);
$obj= unserialize($_SESSION["regobj"]);
    $obj->is_cntc_validated=Base::generateRandomString();
    $cntc="";
    $type="";
    if($obj instanceof Vendor) {
        $cntc=$obj->vend_cntc;
        $type="vendor";
    }
    elseif($obj instanceof Customer) {
        $cntc=$obj->cust_cntc;
        $type="customer";
        }
        echo "<script>console.log('".$obj->is_cntc_validated."');</script>";
    if(Sms::newCntcVerification($cntc,$obj->is_cntc_validated)) {
    $_SESSION["regobj"]= serialize($obj);
//    print_r($_SESSION["regobj"]);
?>

    <div class="container-fluid" style="margin-top: 80px; margin-bottom: 80px;">
<div class="signin-form row justify-content-center">
    <div class="col-md-4">
    <div class="card " style=" margin-bottom: 10px;">
<header class="container">
    <h5 class="form-signin-heading text-center container" style="font-size: 18px;">Verify Your Mobile Number.</h5>
</header>

<div class="container">
      
        <div id="error">
        <!-- error will be shown here ! -->
        </div>
        
    <div class="container justify-content-center">
        <form id="sms-verification" method="post" >
        <div class="form-group">
        <label for="sms_otp">Enter OTP received on <?php echo $cntc; ?></label>
        <input type="text" class="form-control" name="sms_otp" placeholder="Enter OTP" id="sms_otp" />
        <span id="check-e"></span>
        </div>
        <div class="mt-2 form-group justify-content-center d-flex align-items-center">
            <button type="submit" id="btn-verify-sms" class="btn " >Verify Mobile Number</button>
            <a href="<?php echo Base::root()."VerifyMobileNumber"; ?>" class="btn orange col offset-m2 offset-l2 offset-s2 l5 m5 s5" >Resend OTP</a>
        </div>
        </form>
    </div>
        
</div>

</div>
</div>
</div>
    </div>
        <?php
    }
    ?>
        
      </section>    
      <section class="footer" style="margin-top: 10px !important; width: auto !important;" ></section>
      
</section>
<?php
require_once 'scripts.html';
?>


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
     
	 $("#sms-verification").validate({
      rules: {
			sms_otp: "required"
	   },
       messages: {
            email_otp: "please enter OTP obtained SMS"
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
		var form_status = $('<div class="form_status"></div>');
            
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
			var data = $("#sms-verification").serialize();
                        console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : 'verify-cntc2.php',
			data : data,
			beforeSend: function() {	
				$("#error").fadeOut();
                                $("#btn-verify-sms").prop('disabled', true);
				$("#btn-verify-sms").append(status);
			},
			success :  function(response) {
                            console.log("resp "+response);
                            var type="<?php echo $type; ?>";
					if(response.search("ok")>-1){
				$("#sms-verification").prepend("<p style='vertical-align:central;' class='text-center bg-success msg text-white'><i class='fa fa-exclamation' ></i> Registration Successful!</p>").fadeIn();
                                setTimeout(function() { $(".msg").fadeOut();
                                window.location.href=window.location.origin+"/Login";
                                },5000);
                                }
//                                alert("Registration successful\nYou can login and subscribe");
                                else if(type.search("customer")>-1) {
				$("#sms-verification").prepend("<p style='vertical-align:central;' class='text-center bg-success msg text-white'><i class='fa fa-exclamation' ></i> Registration Successful!</p>").fadeIn();
                                setTimeout(function() { $(".msg").fadeOut();
                                window.location.href=window.location.origin+"/Login";
                                },5000);
					}
                                        else if(response.search("invalid")>-1) {
				$("#sms-verification").prepend("<p style='vertical-align:central;' class='text-center bg-danger msg text-white'><i class='fa fa-exclamation' ></i> Invalid Input!</p>").fadeIn();
                                setTimeout(function() { $(".msg").fadeOut();
                                window.location.reload();
                                },5000);
                                $("#btn-verify-sms").prop('disabled', false);
				$("#btn-verify-sms").html("Verify OTP");
					}
			  
                          }
			});
				return false;
		}
	   /* login submit */
});
        </script>
    </body>
</html>