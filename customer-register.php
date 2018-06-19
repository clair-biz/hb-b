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
    <div id="gototop"> </div>
<!-- 
Body Section 
-->
	<div class="row justify-content-center">
            <div class="col-md-8 ">
    	<div class="card" style="margin-top: 0;">
            <form class="form-horizontal" id="cust-register" method="post">
        <div class="container-fluid">
            <h5 class="text-center" >Customer Registration</h5>	
        </div>

            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Full Name <font style="color:red">*</font>:</p>
                <div class="col-md-8 col-sm-8 col-lg-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="fname" name="fname" required />
                </div>
                </div>

                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Mobile Number <font style="color:red">*</font>:</p>
                <div class="col-md-8 col-sm-8 col-lg-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="cntc" name="cntc" required />
                </div>
                </div>

                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Email Id <font style="color:red">*</font>:</p>
                <div class="col-md-8 col-sm-8 col-lg-8 form-group">
                <input type="email" class="form-control" autocomplete="off" id="email1" name="email1" required />
           </div>
        </div>
                
                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">DOB <font style="color:red">*</font>:</p>
                <div class="col-md-8 col-sm-8 col-lg-8 form-group">
                    <input  type="text" data-toggle="datepicker" class="form-control" readonly autocomplete="off" id="dob" name="dob" />
                </div>
                </div>
                       
                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Gender:</p>
                <div class="col-md-8 col-sm-8 col-lg-8">
                <select class="form-control" id="gen" name="gen" >
                    <option selected="true" value="" disabled="">-Select-</option>
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                </select>
        </div>
        </div>
        
              </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Address <font style="color:red">*</font>:</p>
                <div class="col-md-8 col-sm-8 col-lg-8 form-group">
                <textarea class="form-control" autocomplete="off" id="addr" name="addr" required ></textarea>
                </div>
                </div>

                  <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Pincode <font style="color:red">*</font>:</p>
                <div class="col-md-8 col-sm-8 col-lg-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="zip" name="zip" required />
                </div>
                  </div>
            

                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Preferred User Name <font style="color:red">*</font>:</p>
                <div class="col-md-8 col-sm-8 col-lg-8 form-group">
                   <input type="text" class="form-control" autocomplete="off" id="uname" name="uname" required />
           </div>
        </div>

        
                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Password <font style="color:red">*</font>:</p>
                <div class="col-md-8 col-sm-8 col-lg-8 form-group">
                <input type="password" class="form-control" autocomplete="off" id="pwd" name="pwd" required />
                </div>
                </div>
            
                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Confirm Password <font style="color:red">*</font>:</p>
                <div class="col-md-8 col-sm-8 col-lg-8 form-group">
                <input type="password" class="form-control" autocomplete="off" id="cpwd" name="cpwd" required />
                </div>
                </div>
        
              </div>
                <div class="col-md-4 offset-md-4 col-sm-12 form-group">
                    <img id="captcha" src="<?php echo $root."Classes/securimage/securimage_show.php"; ?>" alt="CAPTCHA Image" />
                    <input type="text" id="captcha_code" class="form-control" name="captcha_code" size="10" maxlength="6" />
                    <a href="#" onclick="document.getElementById('captcha').src = '<?php echo $root."Classes/securimage/securimage_show.php?"; ?>' + Math.random(); return false"><i class="material-icons">autorenew</i> Different Image</a>
                </div>
            </div>
        
                <div class="row justify-content-center">
                    <div class="col-md-4 col-md-offset-4 ">
                    <p >
                        <label class="question" for="accept">
                        <input type="checkbox" id="accept" name="accept" />
                            <span>
                                I Accept <a target="_BLANK" href="<?php echo $root."Terms"; ?>">terms and conditions</a>
                            </span>
                        </label>
                    </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 offset-md-4 justify-content-center text-center col-sm-12 submit-btn" style="display: none">
                <button id="submit-register" type="submit" class="btn waves-effect waves-light" style="margin-bottom: 75px;">Submit
                <i class="material-icons right">send</i>
                </button>
	</div>
        </div>
                
	</form>
</div>
            </div>
</div>

</div><!-- /container -->

<a href="#" class="gotop"><i class="icon-double-angle-up"></i></a>
</section>    
      <section class="footer" style="margin-top: 10px !important; width: auto !important;" ></section>
      
</section>
<?php
require_once 'scripts.html';
?>


    </body>
</html>