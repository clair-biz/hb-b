<!DOCTYPE html>
<html>
<body>
<?php
require_once 'header.php';
if($_SESSION["user"]==null || $_SESSION["user"]=="" || Crm::getUserType($_SESSION["user"])!=1) {
        ?>
<script>
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Logging out!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"Logout";
                });
                });
//alert("Logging Out");
//window.location.href="logout.php";
</script>
<?php
    }

?>

    <div class="container-fluid" style="margin-top: 80px; margin-bottom: 80px;">
<div class="signin-form row">
    
    <div class="card col-md-offset-4 col-lg-offset-4 col-sm-offset-1 col-md-4 col-lg-4 col-sm-10" style=" margin-bottom: 10px;">

    
<header class="container">
<h5 class="form-signin-heading">Verification summary.</h5>
</header>

<div class="container">
      
        <div id="error">
        <!-- error will be shown here ! -->
        </div>
        
    <div class="row">
        <form action="<?php echo "validate-vend.php"; ?>" method="post" >
        <div class="form-group">
        <input type="text" class="form-control" name="user_email" id="user_email" />
        <label for="user_email">OTP received on email</label>
        <span id="check-e"></span>
        </div>
        <div class="row">
            <button type="submit" class="btn col-lg-5 col-md-5 col-sm-5" >Verify Email Id</button>
            <button type="submit" class="btn orange col-md-offset-2 col-lg-offset-2 col-sm-offset-2 col-lg-5 col-md-5 col-sm-5" >Resend OTP</button>
        </div>
        </form>
    </div>
        
    <div class="row">
        <form action="<?php echo "validate-vend.php"; ?>" method="post" >
        <div class="form-group">
        <input type="text" class="form-control" name="user_email" id="user_email" />
        <label for="user_email">OTP received on email</label>
        <span id="check-e"></span>
        </div>
        <div class="row">
            <button type="submit" class="btn col-lg-5 col-md-5 col-sm-5" >Verify Email Id</button>
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
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* login submit */
	   function submitForm() {		
			var data = $("#login-form").serialize();
                        console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : '<?php echo Crm::root()."login_process.php"; ?>',
			data : data,
			beforeSend: function() {	
				$("#error").fadeOut();
                                $("#btn-login").prop('disabled', true);
				$("#btn-login").html(preloader());
			},
			success :  function(response) {
                            console.log("resp "+response);
					if(response=="11"){
                                                $("#btn-login").prop('disabled', true);
                				$("#btn-login").html(preloader());
						setTimeout(' window.location.href = "admin-dashboard.php"; ',2000);
					}
					else if(response=="prod"){
                                                $("#btn-login").prop('disabled', true);
                				$("#btn-login").html(preloader());
						setTimeout(' window.location.href = "vendor-product.php"; ',2000);
					}
					else if(response=="serv"){
                                                $("#btn-login").prop('disabled', true);
                				$("#btn-login").html(preloader());
						setTimeout(' window.location.href = "vendor-service.php"; ',2000);
					}
					else if(response=="verify"){
                                                $("#btn-login").prop('disabled', true);
                				$("#btn-login").html(preloader());
						setTimeout(' window.location.href = "verification.php"; ',2000);
					}
					else if(response=="2"){
                                                $("#btn-login").prop('disabled', true);
                				$("#btn-login").html(preloader());
//						setTimeout(' window.location.href = "cart-insert.php"; ',2000);
			$.ajax({
				
			type : 'POST',
			url  : 'productorder-insert.php',
			beforeSend: function() {	
//				$("#error").fadeOut();
                                $("#btn-login").prop('disabled', true);
				$("#btn-login").html(preloader());
			},
			success :  function(response) {
                            console.log("resp "+response);
					if(response=="ok"){
                                                alert('You would receive Vendor Details soon!');
                				$("#btn-login").html(preloader());
						setTimeout(' window.location.href = "./"; ',2000);
                                                updatecart();
                                    }
                                    else if(response=="service") {
                				$("#btn-login").html(preloader());
			$.ajax({
				
			type : 'POST',
			url  : 'serviceorder-insert.php',
			beforeSend: function() {	
//				$("#error").fadeOut();
                                $("#btn-login").prop('disabled', true);
				$("#btn-login").html(preloader());
			},
			success :  function(response) {
                            console.log("resp "+response);
					if(response=="ok"){
                                                alert('You would receive Service Provider Details soon!');
                				$("#btn-login").html(preloader());
						setTimeout(' window.location.href = "./"; ',2000);
                                                updatecart();
                                    }
					else{
                				$("#btn-login").html(preloader());
						setTimeout(' window.location.href = "./"; ',2000);
					}
			  }
			});
                        

                                    }
					else{
                				$("#btn-login").html(preloader());
                                                console.log("service else");
						setTimeout(' window.location.href = "./"; ',2000);
					}
			  }
			});
					}
					else{
                                                alert(response+'!');
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
});
        </script>
<?php
require_once 'footer.php';
?>
    </body>
</html>