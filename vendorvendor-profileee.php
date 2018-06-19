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


$cust=Base::generateResult("select vend_fname,vend_cntc,vend_addr,loc_zip,vend_email,date_format(vend_dob,'%d-%m-%Y') from vendor,users where vendor.vend_id=users.vend_id and u_name='".$user->u_name."';");
            if($row=mysqli_fetch_array($cust)) {
                
?>
    <div class="container-fluid row" style="margin-top: 80px;">
<div class="offset-md-1 col-md-10 offset-lg-1 col-lg-10 card">
            <form class="form-horizontal" id="vend-update" method="post">
                <h5 class="page-header justify-content-center">Update Profile</h5>	
                <p class="center-align"><em class="red-text">Note: Fill only those fields which you want to update</em></p>
            <div class="row hide-on-small-and-down">
            <p class="col-md-3 offset-lg-1 offset-md-1 col-lg-3 text-right" ></p>
            <p class="text-left col-lg-3 col-md-3"><b>Previous Values</b></p>
            <p class="text-left col-lg-4 col-md-4"><b>New Values</b></p>
                </div>
                
            <div class="row">
            <p class="col-md-3 col-lg-3 offset-md-1 offset-lg-1 col-sm-6 text-center" >Full Name:</p>
                <p class="text-left col-sm-6 col-md-3 col-lg-3"><?php echo $row[0]; ?></p>
                <div class="form-control col-sm-12 col-md-4 ">
                        <input type="text" class="form-control" autocomplete="off" id="fname" name="fname" />
                    <label for="fname">Full Name:</label>
                </div>
            </div>
                
            <div class="row">
            <p class="col-md-3 col-lg-3 col-md-offset-1 col-lg-offset-1 col-sm-6 text-center" >DOB:</p>
                <p class="text-left col-sm-6 col-md-3 col-lg-3"><?php echo $row[5]; ?></p>
                <div class="form-control col-sm-12 col-md-4 ">
            <label for="dob">DOB:</label>
                <input type="date" autocomplete="off" id="dob" name="dob" />
                </div>
            </div>
                   
            <div class="row">
            <p class="col-md-3 col-lg-3 col-md-offset-1 col-lg-offset-1 col-sm-6 text-center" >Mobile Number:</p>
                <p class="text-left col-sm-6 col-md-3 col-lg-3"><?php echo $row[1]; ?></p>
                <div class="form-control col-sm-12 col-md-4 ">
                        <input type="text" class="form-control" autocomplete="off" id="cntc" name="cntc" />
                    <label for="cntc">Contact:</label>
                </div>
            </div>
                
            <div class="row">
            <p class="col-md-3 col-lg-3 col-md-offset-1 col-lg-offset-1 col-sm-6 text-center" >Email Id:</p>
                <p class="text-left col s12 m3 l3"><?php echo $row[4]; ?></p>
                <div class="form-control col-sm-12 col-md-4 ">
                        <input type="text" class="form-control" autocomplete="off" id="email1" name="email1" />
                    <label for="email1">Email Id:</label>
                </div>
            </div>
               
            <div class="row">
            <p class="col-md-3 col-lg-3 col-md-offset-1 col-lg-offset-1 col-sm-6 text-center" >Address:</p>
                <p class="text-left col s12 m3 l3"><?php echo $row[2]; ?></p>
                <div class="input-field  col s12 m4">
                    <textarea class="form-control" autocomplete="off" id="addr" name="addr" ></textarea>
                    <label for="addr">Address:</label>
                </div>
            </div>
                
           <div class="row">
            <p class="col-md-3 col-lg-3 col-md-offset-1 col-lg-offset-1 col-sm-6 text-center" >Pincode:</p>
            <p class="text-left col-sm-6 col-md-3 col-lg-3"><?php echo $row[3]; ?></p>
        <div class="col m4 input-field  s12">
            <label for="zip">Pincode:</label>
                <input type="text" class="form-control" autocomplete="off" id="zip" name="zip" />
        </div>
            </div>
              
            <div class="row">
                <button id="" class="btn btn-block center-align" style="margin-bottom: 75px; margin-bottom: 75px; margin-left: auto; margin-right: auto; display: block">Submit</button>
            </div>
	</form>
   </div>
</div>

 <?php
                        }
                       // require_once 'footer.php';
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