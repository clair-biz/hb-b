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
if(isset($_SESSION["user"])!=null && isset($_SESSION["user"])!=""
        && (Base::getUserType($_SESSION["user"])==11
        || Base::getUserType($_SESSION["user"])==1
        || ( Base::getUserType($_SESSION["user"])==3)) ) {
        ?>
<script>
                    var root="<?php echo $root; ?>";
                    window.location.href=root+"Logout";
</script>
<?php
    }

?>

    <div class="container-fluid" style=" margin-top: 80px; height: 70vh;">
<div class="signin-form row justify-content-center">
    
    <div class="col-md-4 col-sm-10">
    <div class="card" style=" margin-bottom: 10px;">

    
    <form class="form-signin" method="post" id="login-form">

<header class="container">
<h5 class="form-signin-heading text-center">Log In</h5>
</header>

<div class="container">
      
        <div id="error">
        <!-- error will be shown here ! -->
        </div>
        
        <div class="form-group">
        <label for="user_email">UserName</label>
            <input type="text" class="form-control" placeholder="User Name" autofocus name="user_email" id="user_email" />
        <span id="check-e"></span>
        </div>
        
        <div class="form-group">
        <label for="password">Password</label>
            <input type="password" class="form-control" placeholder="Password" name="password" id="password" />
        </div>
       
</div>

<footer class="container">
        <div class="form-group text-center">
            <button type="submit" class="btn btn-lg " name="btn-login" id="btn-login">
    		 Sign In
            </button> 
        </div>  
				  <div class="form-group text-center">
					New User? Register as <a  href="<?php echo $root."CustomerRegistration"; ?>" >Customer</a> or <a  href="<?php echo $root."StartSelling"; ?>" >Vendor</a><br />
					<a  href="<?php echo $root."ForgotPassword"; ?>" >Forgot Password?</a>
				  </div>
</footer>
      </form>
</div>
</div>
    
</div>
    </div>

    </section>
    <footer class="footer" ></footer>
    
</section>
    
<?php
require_once 'scripts.html';
?>
    </body>
</html>