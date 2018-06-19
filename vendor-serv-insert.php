<html>
<head>
        <title> Homebiz365-- Add new Service </title>

        <?php require_once 'stylesheets.html';?>
    </head>
<body>
<section class="body" >
    <section class="preloader" ></section>
    <section class="content" >
<?php
require_once 'data.php';


$cat=Base::generateResult("select cs_id,cs_name from cat_sub,category,vend_subscription,users where users.u_id=vend_subscription.u_id and category.cat_id=vend_subscription.cat_id and category.cat_id=cat_sub.cat_id and vs_id='".$_COOKIE["vs_id"]."' and cs_id<>0;");
//$cat=Base::generateResult("select cat_name from category,vend_subscription,users where users.u_id=vend_subscription.u_id and category.cat_id=vend_subscription.cat_id and cat_type='Service' and u_name='".$_SESSION["user"]."' and cat_id<>0;");
?>

   <div class="container-fluid" style="margin-top: 40px;">
<div class="row">
     <div class="col-md-2 col-lg-2">
                    <?php
                    require 'vendor-menu.php'; 
                    ?>
                    </div>
    <div class="col-md-10 card">
    <form class="form-horizontal" id="serv-insert" method="post" enctype="multipart/form-data">
         <div class="row">
                    <h5 class="page-header text-center container">Add New Service</h5>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->


            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Service Name <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8  form-group">
                <input type="text" class="form-control" autocomplete="off"  id="sname" name="sname" required />
        </div>
      </div>
                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Service Description <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8  form-group">
                 <textarea class="form-control" autocomplete="off" id="sdesc" name="sdesc" required ></textarea>
        </div> 
            </div>

            <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Area:</p>
        <div class="col-lg-8 col-md-8 col-sm-8  form-group">
                <input type="text" class="form-control" autocomplete="off"  id="area" name="area" />
        </div>
      </div>


          </div>

              <div class="col-lg-6 col-md-6 col-sm-12">

                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Service Image <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8  form-group">
  <input type="file" class="form-control" name="file" id="customFile">
                <div class="row">
                    <em>Note: The image size should not be more than 1 MB</em>
                </div>
	</div>
                </div>
	
                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Brochure/Flyer :</p>
        <div class="col-lg-8 col-md-8 col-sm-8  form-group">
  <input type="file" class="form-control" name="file1" id="customFile1">
        </div>
                <div class="row">
                    <em>Note: The PDF,docx,doc or image file size should not be more than 5 MB</em>
                </div>
    </div>    
                
            </div>

            
            
       
            <div class="container justify-content-center">
                <button id="submit-register" type="submit" class="btn waves-effect waves-light" style="margin-bottom: 75px; margin-left: auto; margin-right: auto; display: block">Submit
                <i class="material-icons right">send</i>
                </button>
	</div>
	
        

</div>
    </form>
</div>
        </div>
</div>

              </section>    
      <section class="footer" style="margin-top: 10px !important; width: auto !important;" ></section>
      
</section>
<?php
require_once 'scripts.html';
?>


    </body>
</html>
