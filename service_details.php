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
$serv_id=$_REQUEST['serv'];
$type="serv";
?>
<div class="container-fluid d-sm-none d-md-block" style="margin-top: 40px;">
<div class="row" >
    <div class="col-lg-2 col-md-4" >
            <?php require_once 'service-menu.php';?>
        
	</div>

           <div class="col-lg-10 col-md-8" >
                
<?php
     $str="SELECT distinct serv_name,serv_file,serv_desc,cat_name,bname,serv_img,vend_rating,vend_rating_off,city_served,service.vs_id,date_format(vend_subscription.na_from,'%d/%m/%Y'),date_format(vend_subscription.na_to,'%d/%m/%Y'),vs_pay_status FROM category,service,vendor,users,vend_subscription,cat_sub WHERE category.cat_id=cat_sub.cat_id and service.cs_id=cat_sub.cs_id and vend_subscription.vs_id=service.vs_id and vendor.vend_id=users.vend_id and category.cat_id=vend_subscription.cat_id and users.is_active='Y' and service.is_active='Y' and service.serv_id=".$serv_id.";";
    $servres=Base::generateResult($str);
    if($serv_details=mysqli_fetch_array($servres)) {
        $is_available=Vendor::checkOfflinePeriod($serv_details[9]);
         if($serv_details["vs_pay_status"]=="Wait4FSSAI")
                            $is_available=1;
                $n= explode(" ", $serv_details["serv_name"]);
                $serv_name= implode("_", $n);
                 $link_cat= str_replace(" ","_", $serv_details["cat_name"]);
   ?>
                    
    <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><a class="logo-color-b" href="<?php echo $root;?>">Services</a></li>
    <li class="breadcrumb-item">
        <a class="logo-color-b" href="<?php echo $root."Services/".$link_cat;?>" >
            <?php echo $serv_details["cat_name"]; ?>
        </a>
    </li>
        <li class="breadcrumb-item active" aria-current="page" style="font-size: 1rem;"
                title="<?php echo $serv_details[0]; ?>">
        <b class="logo-color-g"> <?php echo $serv_details[0]; ?></b>
    </li>
  </ol>
</nav>

       <div class="row">             
      <div class="col-lg-4 col-md-4 product-img" >
    <a >
        <img class="responsive-img product-img"
             style="margin-left: auto !important; height: 200px !important; width: auto !important;
 margin-right: auto !important; margin-top: 15px !important; vertical-align: central;"
             src="<?php echo $root."assets/products-services/".$serv_details[5]; ?>" />
    </a>
      </div>
 
	<div class="col-lg-8 col-md-8">
                    <div class="row text-center">
                                      <h5 data-toggle="tooltip" class="logo-color-b"
                                         title="<?php echo $serv_details[0]; ?>">
                                          <b> <?php echo $serv_details[0]; ?></b>
                                    </h5>

                    </div>
                        <span  class="text-left" style="font-size: 14px;">
                            <span class="logo-color-g"> <b>Service Provider:</b></span>  <b><?php echo $serv_details[4]." (".$serv_details[8].")"; ?></b>
		<?php
                $rating=0;
                if($serv_details[6]!=0 && $serv_details[7]!=0)
                $rating=(int)$serv_details[6]/$serv_details[7];
                ?> <span class="" style="<?php
                        if($rating==0)
                            echo "display:none";
                        elseif($rating>=1 && $rating<=2.9)
                            echo "background-color:red;  color: white";
                        elseif($rating>=3 && $rating<=3.9)
                            echo "background-color:yellow";
                        elseif($rating>=4 && $rating<=5)
                            echo "background-color:green;  color: white";
                        ?>">&nbsp;&nbsp;<?php echo intval($rating)." &#x2605;"; ?>&nbsp;&nbsp;</span>
                        </span>
          <?php
            $c=Campaign::getcampcountonservice($serv_id);
            if($c>0) { ?>
         <p class="">
            <span class="logo-color-g"> <b>Offers:</b></span>           <?php 
                echo $c." Offer(s) applicable.";
                echo "<br />".Campaign::getcampnamesbyservid($serv_id);
                ?>
         </p>
                <?php
                }
                ?>
          <p class="">
           <span class="logo-color-g"> <b>Description:</b></span> <?php echo $serv_details[2]; ?>
          </p>
          <?php 
            if($is_available==1)
            echo '<em class="text-left red-text" style="font-size:12px;">Unavailable<br />from '.$serv_details[10].' to '.$serv_details[11].'</em>';
            ?>

            
            <div class="row">
				<button type="button" class="view-file defaultBtn mr-3" data-val="<?php echo $serv_id; ?>" id="<?php echo $serv_details[0]; ?>"><span class="glyphicon  glyphicon-arrow-down"></span> View Brochure/Flyer</button>
      <button id="<?php echo "submit_serv_".$serv_details[0]; ?>" name="serv"
              <?php
              if($is_available==1)
                  echo "disabled";
              ?>
              type="button" value="<?php echo $serv_id; ?>"  class="btn button red btn-call-4-service">
        Contact Service Provider
      </button>
            </div>
        </div>
                    
                </div>
            
                                <?php
    }
    ?>
                        
            
        

</div>
    </div>

</div>



    <div class="d-lg-none d-block">
<div id="gototop"> </div>
<!-- 
Body Section 
-->
<?php //require 'category-navbar-mob.php';?>
<div class="container-fluid" style="margin-top: 5px !important;">

        <div class="row">
            <?php //require_once 'advertisement-1.php';?>
        </div>

           <div class="row" >
                <div class="row">
<?php
     $str="SELECT distinct serv_name,serv_file,serv_desc,cat_name,bname,serv_img,vend_rating,vend_rating_off,city_served FROM category,service,vendor,users,vend_subscription,cat_sub WHERE category.cat_id=cat_sub.cat_id and service.cs_id=cat_sub.cs_id and  vend_subscription.vs_id=service.vs_id and vendor.vend_id=users.vend_id and category.cat_id=vend_subscription.cat_id and service.serv_id=".$serv_id.";";
    $servres=Base::generateResult($str);
    if($serv_details=mysqli_fetch_array($servres)) {
    ?>
            <div class="row">
				  <h5  class="truncate">
                                        <b data-toggle="tooltip" 
                                         title="<?php echo $serv_details[0]; ?>">
                                        <?php echo $serv_details[0]; ?>
                                        </b>
                                  </h5>
            </div>
      <div class="row product-img" >
    <a >
        <img class="responsive-img product-img"
             style="margin-left: auto !important;
             margin-right: auto !important;"
             src="<?php echo $root."uploads/products-services/".$serv_details[5]; ?>"
             onError="this.onerror=null;this.src='uploads/images/small.png';" />
    </a>
      </div>
 
	<div class="col-sm-12">
            

            <div class="row">
                        <p  class="text-left" style="">
                by <b><?php echo $serv_details[4]." (".$serv_details[8].")"; ?></b>
		<?php
                $rating=0;
                if($serv_details[6]!=0 && $serv_details[7]!=0)
                $rating=(int)$serv_details[6]/$serv_details[7];
                ?><span class="badge" style="<?php
                        if($rating==0)
                            echo "display:none";
                        elseif($rating>=1 && $rating<=2.9)
                            echo "background-color:red;  color: white";
                        elseif($rating>=3 && $rating<=3.9)
                            echo "background-color:yellow";
                        elseif($rating>=4 && $rating<=5)
                            echo "background-color:green;  color: white";
                        ?>"><?php echo intval($rating)." &#x2605;"; ?></span></p>
            </div>
            <div class="row">
            <?php echo $serv_details[2]; ?></div>
            <div class="row">
				<button type="button" class="view-file defaultBtn text-center row" data-val="<?php echo $serv_id; ?>"><span class="glyphicon  glyphicon-arrow-down"></span> View Brochure/Flyer</button>
      <button id="<?php echo "submit_serv_".$serv_details[0]; ?>" name="serv" type="button" value="<?php echo $serv_id; ?>"  class="btn button red btn-call-4-service">
        Contact Service Provider
      </button>
            </div>
        </div>
            
                                <?php
    }
    ?>
                        
            
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
function categorytab(inArr) {
    $("#category-product, #category-service").on('mouseenter',function () {
    if(inArr.category_product==true ) 
        showproductcat();
    else if(inArr.category_service==true )
        showservicecat();
        
          $('#modal-category').modal("open"); 
    
    });

    $("#category-product, #category-service").on('mouseleave',function () {
        $("#modal-category").on('mouseleave',function () {
    if(inArr.modal_category==false) {
//        console.log("inArrleave\n"+inArr.modal_category+"\n"+inArr.category_product+"\n"+inArr.category_service);
          $('#modal-category').modal("close"); 
      }
  });
    });
}


var inArr = {modal_category:false, category_product:false, category_service:false};

$('#modal-category').mouseover(function(){
    inArr.modal_category = true;
//    console.log("in modcat mouseover"+inArr.modal_category);
});
$('#category-product').mouseover(function(){
    inArr.category_product = true;
//    console.log("in prodcat mouseover"+inArr.category_product);
});
$('#category-service').mouseover(function(){
    inArr.category_service = true;
//    console.log("in servcat mouseover"+inArr.category_service);
});

$('#modal-category').mouseout(function(){
    inArr.modal_category = false;
//    console.log("modcat\n"+inArr.modal_category+"\n"+inArr.category_product+"\n"+inArr.category_service);
});
$('#category-product').mouseout(function(){
    inArr.category_product = false;
//    console.log("in prodcat mouseout"+inArr.category_product);
});
$('#category-service').mouseout(function(){
    inArr.category_service = false;
//    console.log("in servcat mouseout"+inArr.category_service);
});

    
    categorytab(inArr);

</script>

    </body>
</html>