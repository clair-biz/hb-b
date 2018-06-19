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
$q="select cust_fname,cust_cntc,cust_alt_cntc,cust_addr,loc_zip,date_format(cust_dob,'%d-%m-%Y'),cust_gen,cust_email from customer where customer.cust_id=".$user->cust_id.";";
//echo $q;
$cust=Base::generateResult($q);  
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
            <form class="form-horizontal" id="cust-update" action="customer-profile-update.php" method="post">
                     <div class="card container-fluid">
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
            <input type="text" data-toggle="datepicker" readonly class="form-control" autocomplete="off" id="dob" name="dob" value="<?php echo $row[5]; ?>"/>
        </div>
                </div>

                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right mb-4" >Gender:</p>
            <div class="col-md-8 col-sm-8 col-lg-8"  style="z-index: 1000 !important;">
                <select class="form-control" id="gen" name="gen"  >
                    <option selected="true" value="<?php echo $row[6]; ?>" ><?php echo $row[6]; ?></option>
                    <?php 
                    if($row[6]=="Female") { ?>
                    <option value="Male">Male</option>
                    <?php
                    }
                    else { ?>
                    <option value="Female">Female</option>
                    <?php
                    }
                    ?>
                </select>
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
                <input type="text" class="form-control" autocomplete="off" id="email1" name="email1" placeholder="<?php echo $row[7]; ?>" />
        </div>
                </div>
                     <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Address:</p>
        <div class="col-md-8 col-sm-8 col-lg-8 form-group">
            <textarea class="form-control" autocomplete="off" id="addr" name="addr" ><?php echo $row[3]; ?></textarea>
        </div>
                </div>
                    
                     <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Pincode:</p>
        <div class="col-md-8 col-sm-8 col-lg-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="zip" name="zip" placeholder="<?php echo $row[4]; ?>" />
        </div>
                </div>
         
                </div>
                     </div>
              <div class="row">
       
            <div class="offset-md-5 col-sm-12 col-md-2">
                <button id="submit-cust-update" class="btn btn-block text-center" style="margin-bottom: 75px;">Submit</button>
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