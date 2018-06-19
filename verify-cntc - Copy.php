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

$obj=unserialize($_SESSION["regobj"]);
print_r(serialize($obj));
echo "<br /><br />";
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
        
    unset($_SESSION["regobj"]);
    $_SESSION["regobj"]=serialize($obj);
    if(Sms::newCntcVerification($cntc,$obj->is_cntc_validated)) {
    print_r($_SESSION["regobj"]);
?>

    <div class="container-fluid" style="margin-top: 80px; margin-bottom: 80px;">
<div class="signin-form row">
    <div class="card offset-md-4 offset-sm-1 col-md-4 col-sm-10" style=" margin-bottom: 10px;">
<header class="container">
    <h5 class="form-signin-heading" style="font-size: 18px;">Verify Your Mobile Number.</h5>
</header>

<div class="container">
      
        <div id="error">
        <!-- error will be shown here ! -->
        </div>
        
    <div class="row">
        <form id="sms-verification" method="post" >
        <div class="form-group">
        <label for="sms_otp">Enter OTP received on <?php echo $cntc; ?></label>
        <input type="text" class="form-control" name="sms_otp" placeholder="Enter OTP" id="sms_otp" />
        <span id="check-e"></span>
        </div>
        <div class="row">
            <button type="submit" id="btn-verify-sms" class="btn col l5 m5 s5" >Verify Mobile Number</button>
            <a href="<?php echo $root."VerifyMobileNumber"; ?>" class="btn orange col offset-m2 offset-l2 offset-s2 l5 m5 s5" >Resend OTP</a>
        </div>
        </form>
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
     
jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});
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
                    var root=window.location.origin;
			var data = $("#sms-verification").serialize();
                        console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : root+'/verify-cntc2.php',
			data : data,
			beforeSend: function() {	
				$("#error").fadeOut();
                                $("#btn-verify-sms").prop('disabled', true);
			},
			success :  function(response) {
                            console.log("resp "+response);
                            var type="<?php echo $type; ?>";
					if(response.search("ok")>-1){
                                $("#btn-verify-sms").prop('disabled', true);
				$("#btn-verify-sms").html(preloader());
                                if(type=="vendor") {
                    window.location.href=root+"/Login";

                                }
//                                alert("Registration successful\nYou can login and subscribe");
                                else if(type.search("customer")>-1) {
                                    
//                                alert("Registration successful");
						window.location.href = "./Login";
					}
                                        }
                                        else if(response.search("subscribe")>-1) {
                                $("#btn-verify-sms").prop('disabled', true);
                    var root=window.location.host;
                    window.location.href=root+"/NewSubscription";
					}
                                        else if(response.search("invalid")>-1) {
				$("#error").html('<div class="red">'+response+'!</div>');
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