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
 $u_name=$_REQUEST['name'];
 ?>
    <div class="container-fluid"  style=" margin-top: 40px; height: 70vh;">
<div class=" row">
    <div class="col-lg-2 col-md-2 d-none d-md-block">
                    <?php
                    require 'cust-menu.php'; 
                    ?>
                    </div>
    
    <div class="col-md-6 col-lg-4 offset-md-2 offset-lg-2" style="margin-top: 10px; margin-bottom: 10px;">

<div class="card">
    <form method="post" id="new-pwd" action="new1.php">

<header class="container">
    <h5 class="form-signin-heading" style="margin-bottom: 20px;">Enter your new password </h5>
</header>

<div class="container-fluid">
      
        <div id="error">
        <!-- error will be shown here ! -->
        </div>
        
        <div class="form-group">
            <input type="password" class="form-control" name="pwd" id="pwd" required />
            <label for="pwd">Password</label>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="cpwd" id="cpwd" required />
            <label for="cpwd">Confirm Password</label>
        </div>
               
</div>

<footer class="row align-items-center justify-content-center">
        <div class="row">
            <input type="hidden" name="uname" value="<?php echo $u_name; ?>"/>
            <button type="submit" class="btn btn-lg btn-block" name="btn-submit" style="margin-left: auto; margin-right: auto; display: block; " id="btn-submit-pwd">
    		Submit
            </button>
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
jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});


	$("#new-pwd").validate({
      rules: {
			pwd: {
                required: true,
                minlength:6
            },
                        cpwd: {
                            required: true,
                            equalTo: "#pwd"
                        }
	   },
       messages: {
            pwd: {
                required: "please enter new Password!",
                minlength: "Passsword should be atleast 6 characters!"
       },
					cpwd: {
                                           required: "Please enter Confirm Password",
                                           equalTo: "Passwords do not match!"
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
	   submitHandler: submitNewPwdForm	
       });
	var data = $("#new-pwd").serialize();
    console.log("data "+data);

	   /* validation */
//	   console.log("var"+val);
	   /* login submit */
	   function submitNewPwdForm() {
               
               var form_status = $('<div class="form_status"></div>');
            
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
                                
			var data = $("#new-pwd").serialize();
                        console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : window.location.origin+'/new1.php',
			data : data,
			beforeSend: function() {	
				$("#btn-submit-pwd").prop('disabled', true);
				$("#btn-submit-pwd").append( form_status.html('<h5><i class="fa fa-spinner fa-spin"></i> Updating...</h5>').fadeIn() );
			},
			success :  function(response) {
                            console.log("resp -"+response+"-");
					if(response.search("ok")>-1){
                                $("#btn-submit-pwd").prop('disabled', false);
                               form_status.html('<h5 class="text-success">Updated.</h5>').delay(20000).fadeOut();                    
//                window.location.href="CustomerProfile";

					}
					else{

                                $("#btn-submit-pwd").prop('disabled', false);
                                                alert(response+'!');
                                $("#btn-submit-pwd").html('<span class="glyphicon glyphicon-log-in"></span> Submit');
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