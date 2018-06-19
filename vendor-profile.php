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
//$cust_id=$_COOKIE["cust"];
  
//$zip=Base::generateResult("select * from location where loc_zip<>0;");  
//Statement stmtcust=packcrm.Crm.con().createStatement();
$cust=Base::generateResult("select vend_fname,vend_cntc,vend_addr,loc_zip,vend_email,vend_dob from vendor,users where vendor.vend_id=users.vend_id and u_name='".$user->u_name."';");
            if($row=mysqli_fetch_array($cust)) {
?>
<div class="container-fluid" style="margin-top: 40px;">
         <div class="row">
    <div class="col-lg-2 col-md-2 d-none d-md-block">
                    <?php
                    require 'cust-menu.php'; 
                    ?>
                    </div>
                 <div class="col-md-10 col-lg-10">
            <form class="form-horizontal" id="vend-update" action="vendor-profile-update.php" method="post">
                     <div class="card">
                <h5 class="page-header text-center">Update Profile</h5>	
                <p class="text-center"><em class="red-text">Note: Fill only those fields which you want to update</em></p>
                <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Full Name:</p>
        <div class="col-md-8 col-sm-8 col-lg-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="fname" name="fname" placeholder="<?php echo $row[0]; ?>" />
        </div>
                </div>
              <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">DOB:</p>
        <div class="col-md-8 col-sm-8 col-lg-8 form-group">
            <input  type="text" data-toggle="datepicker" readonly class="form-control" autocomplete="off" id="dob" name="dob" value="<?php echo $row[5]; ?>"/>
        </div>
                </div>
                    <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Mobile Number:</p>
        <div class="col-md-8 col-sm-8 col-lg-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="cntc" name="cntc" placeholder="<?php echo $row[1]; ?>" />
        </div>
                </div>
            </div>
                
                <div class="col-lg-6 col-md-6 col-sm-12 ">
                     <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Email Id:</p>
        <div class="col-md-8 col-sm-8 col-lg-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="email1" name="email1" placeholder="<?php echo $row[4]; ?>" />
        </div>
                </div>
                     <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Address:</p>
        <div class="col-md-8 col-sm-8 col-lg-8 form-group">
            <textarea class="form-control" autocomplete="off" id="addr" name="addr" placeholder="<?php echo $row[2]; ?>" ></textarea>
        </div>
                </div>
                    
                     <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Pincode:</p>
        <div class="col-md-8 col-sm-8 col-lg-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="zip" name="zip" placeholder="<?php echo $row[3]; ?>" />
        </div>
                </div>
         
                </div>
                     </div>
              <div class="row">
       
            <div class="offset-md-5 col-sm-12 col-md-2">
                <button id="submit-vend-update" class="btn btn-block text-center" style="margin-bottom: 75px;">Submit</button>
	</div>
    
        </div>
	
   </div>
                </form>
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
<a href="#" class="gotop"><i class="icon-double-angle-up"></i></a>
    <!-- Placed at the end of the document so the pages load faster -->
    </body>
</html>