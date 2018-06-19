<html>
    <body>
<?php
require_once("data.php");
$stmtcatprod=Base::generateResult("select cat_id,cat_name from category where cat_type='Product' and cat_id<>0;");  
$stmtcatserv=Base::generateResult("select cat_id,cat_name from category where cat_type='Service' and cat_id<>0;");  
$stmtcity=Base::generateResult("select distinct city_served from vend_subscription;");  
?>
    
    <form class="form-horizontal card col-md-offset-1 col-md-10" id="vend-register" method="post" style="background-color: rgba(255, 255, 255, .6);">
        <div class="row">
            <h5 class="text-center container text-light"  >Vendor Registration</h5>	
        </div>


            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Full Name" data-toggle="tooltip" data-html="true" title="Full Name <font style='color:red'>*</font>:</label>" autocomplete="off" autofocus  id="fname" name="fname" required />
                </div>

                    <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" data-toggle="tooltip" data-html="true" title="Email <font style='color:red'>*</font>:</label>"  autocomplete="off" id="email1" name="email1" required />
                    </div>
                
                <div class=" form-group">
                <input type="text" class="form-control" placeholder="Mobile No." data-toggle="tooltip" data-html="true" title="Mobile No. <font style='color:red'>*</font>:</label>"  autocomplete="off" id="cntc" name="cntc" required />
                </div>
                
                <div class="form-group">
                    <input  type="text" data-toggle="datepicker" readonly class="form-control" placeholder="DOB" data-toggle="tooltip" data-html="true" title="DOB :</label>"  autocomplete="off" id="dob" name="dob" />
                </div>
         <div class="form-group">
                <textarea class="form-control" placeholder="Address" data-toggle="tooltip" data-html="true" title="Address <font style='color:red'>*</font>:</label>"  autocomplete="off" id="addr" name="addr" required ></textarea>
                </div>
                
  		</div>
                
                <div class="col-lg-6 col-md-6 col-sm-12">
                  
                <div class="form-group">
                <input   type="text" class="form-control" placeholder="Pincode" data-toggle="tooltip" data-html="true" title="Pincode <font style='color:red'>*</font>:</label>" autocomplete="off" id="zip" name="zip" required />
                </div>
                
                <div class="form-group">
                <input type="text" class="form-control" placeholder="Preferred User Name" data-toggle="tooltip" data-html="true" title="Preferred User Name <font style='color:red'>*</font>:</label>" autocomplete="off" id="uname" name="uname" required />
                </div>
                    
                <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" data-toggle="tooltip" data-html="true" title="Password <font style='color:red'>*</font>:</label>"  autocomplete="off" id="pwd" name="pwd" required />
                </div>
                
                <div class="form-group">
                <input type="password" class="form-control" placeholder="Confirm Password" data-toggle="tooltip" data-html="true" title="Confirm Password <font style='color:red'>*</font>:</label>"  autocomplete="off" id="cpwd" name="cpwd" required />
                </div>
                    
                </div>
                <div class="col-sm-12 form-group">
                    <div class="row">
                        <div class="col-md-5">
                        <img id="captcha" class="img-fluid" src="<?php echo $root."Classes/securimage/securimage_show.php"; ?>" alt="CAPTCHA Image" />
                        </div>
                        <div class="col-md-7 form-group">
                        <input type="text" id="captcha_code" class="form-control" name="captcha_code" size="10" maxlength="6" />
                        <a href="#" onclick="document.getElementById('captcha').src = '<?php echo $root."Classes/securimage/securimage_show.php?"; ?>' + Math.random(); return false"><i class="material-icons">autorenew</i> Different Image</a>
                        </div>
                    </div>
                </div>
            </div>
        
                <div class="row justify-content-center">
                    <div class="col-md-8 justify-content-center align-items-center">
                        <p class="text-center" >
                        <label class="question" for="accept">
                        <input type="checkbox" id="accept" name="accept" />
                            <span>
                                I Accept <a target="_BLANK" href="<?php echo $root."Terms"; ?>">terms and conditions</a>
                            </span>
                        </label>
                    </p>
                    </div>
                    <div class="col-md-4 submit-btn" style="display: none">
                <button id="submit-vendor-register" type="submit" class="btn waves-effect waves-light" >Submit</button>
	</div>
        </div>
                
	</form>
    </body>
</html>       
        
   