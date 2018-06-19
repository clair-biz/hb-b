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

$obj=new Base;
//    print_r(json_decode($_SESSION["user"]));
    $user= json_decode($_SESSION["user"]);
$vend_name=$user->u_name;
$vs_id= $user->vs_id;
$q="select service.serv_id,serv_img,serv_name,serv_desc,serv_file from users,service,vend_subscription where users.u_id=vend_subscription.u_id and vend_subscription.vs_id=service.vs_id and service.is_active='Y' and service.vs_id=$vs_id;";
$prod=Base::generateResult($q);
//$prod=mysqli_query($obj->con,$q);
$cat=Base::generateResult("select DISTINCT cs_name, cs_id from cat_sub,vendor,category,users,vend_subscription where users.vend_id=vendor.vend_id and category.cat_id=cat_sub.cat_id and vend_subscription.cat_id=category.cat_id and u_name='$vend_name'");
//$cat=mysqli_query($obj->con,"select DISTINCT cs_name, cs_id from cat_sub,vendor,category,users,vend_subscription where users.vend_id=vendor.vend_id and category.cat_id=cat_sub.cat_id and vend_subscription.cat_id=category.cat_id and u_name='$vend_name'");
?>
               
     <div class="container-fluid" style="margin-top: 40px;">
    
            <div class="row">
                <div class="col-md-2 col-lg-2 hide-on-small-and-down">
                    <?php
                    require 'vendor-menu.php'; 
                    ?>
                    </div>
                
                
        <div class=" col-lg-10 col-md-10 col-sm-12">
        <div class="card container-fluid service-content">
        </div>
        <div class="card container-fluid service-update-block">
        </div>
        </div>
            
                        <!-- /.panel-body -->

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
