<html>
    <head>
        <?php require_once 'stylesheets.html';?>
    </head>
    <body>
<section class="body" >
        <section class="preloader" ></section>
    <section class="content" >
<?php
$search_val="";
if(isset($_REQUEST["prod"])!="")
$search_val= str_replace("_"," ",urldecode($_REQUEST['prod']));
require_once 'data.php';
$type="prod";
$min_qty=0;
$min_unit="";

$strQuery="select  `prod_name`,prod_img from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='$city' and users.is_active='Y' and product.is_active='Y' and prod_name like '%".$search_val."%'";
$strQuery.=" union select `prod_name`,prod_img from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='$city' and users.is_active='Y' and product.is_active='Y' and  product.area_served like '%".$search_val."%'";
$strQuery.=" union select `prod_name`,prod_img from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='$city' and users.is_active='Y' and product.is_active='Y' and  bname like '%".$search_val."%'";
$strQuery.=" union select `prod_name`,prod_img from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='$city' and users.is_active='Y' and product.is_active='Y' and  cs_name like '%".$search_val."%'";
$strQuery.=" union select `prod_name`,prod_img from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='$city' and users.is_active='Y' and product.is_active='Y' and  cat_name like '%".$search_val."%'";
$strQuery.=" union select `prod_name`,prod_img from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='$city' and users.is_active='Y' and product.is_active='Y' and  vend_addr like '%".$search_val."%'";
$strQuery.=" union select `prod_name`,prod_img from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='$city' and users.is_active='Y' and product.is_active='Y' and  loc_zip like '%".$search_val."%'";

//echo $strQuery;
	$prodres=Base::generateResult($strQuery);
//        print_r($prodres);
	$numofrow=mysqli_num_rows($prodres);
//        echo "-->$numofrow<--";
?>
    <div class="hide-on-med-and-up">
<?php// require 'category-navbar-mob.php';?>
    </div>
  
<div class="container-fluid details-block">
    <div class="row">
    <div class="col-md-2 category-menu d-none d-md-block" >
        
    </div>
<?php

//	$prodres=mysqli_query(Crm::con(), $strQuery1);
//	$numofrow=mysqli_num_rows($prodres);
?>					
    <div class="col-md-10 col-sm-12">
<?php
      if($numofrow>0)  { ?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><a class="logo-color-b" href="<?php echo $root;?>">Products</a></li>
    <li class="breadcrumb-item active" aria-current="page" style="font-size: 1rem;"
                title="<?php echo $search_val; ?>">
        <b class="result logo-color-g"> <?php echo $search_val; ?></b>
    </li>
  </ol>
</nav>
      <?php
      }
      ?>
        <div class="row">
          
    <div class="col-sm-12 product-list"  style="margin-top: 5px; margin-bottom: 5px; display:none !important;" >
        <div class="card product-list-title" style="margin-bottom: 0 !important; margin-top: 0 !important; ">
				  <h5  class="truncate justify-content-center card-body p-1" data-toggle="tooltip" style="margin-bottom: 0 !important; margin-top: 0 !important; ">
                                      <b><span class="prod_name logo-color-b"></span></b>
                                      <button class="product-list-close btn btn-danger float-right" ><i class="material-icons h6">close</i></button>
                                  </h5>
    </div>
    <div class="justify-content-center product-list-menu">

    </div>
        

</div> 
          
          
      <!--hr style="border-color: #E31E24; color: #E31E24; border-width: 3px; border-top: #E31E24;" /-->
<?php
$count=1;
//mysqli_data_seek($prodres, 0);

            while($prods = mysqli_fetch_assoc($prodres)) {
//            while($prods = mysqli_fetch_array($prodres)) {
                $n= explode(" ", $prods["prod_name"]);
                $prod_name= implode("_", $n);
          $img=$root."assets/products-services/".$prods["prod_img"];
//if($count==1) {
?>
<!--  div class="row" style="margin-bottom: 10px;"-->
    <?php
//}
?>
<div class="product col-sm-6 col-md-3" id="<?php echo "product_".$prod_name;?>" style="margin-bottom: 0 !important;" >
        <div class="product-display" id="<?php echo "product_display_".$prod_name;?>" style="padding: 0 !important;" >
          <div class="card ">
            <div class="card-img-top">
                <a class="" href="#">
                    <img class="img-fluid products-img"
             src="<?php echo $img; ?>"
             onError="this.onerror=null;this.src='http://www.homebiz365.in/uploads/images/small.png';" />
                </a>
            </div>
              <div class="card-body" style="padding: 10px;">
                <h6  class="truncate justify-content-center black-text" style="font-size: 16px;">
                    <a class="text-dark" href="#" data-toggle="tooltip" 
                                         title="<?php echo $prods["prod_name"]; ?>">
                                 <b><?php echo $prods["prod_name"]; ?></b></a></h6>
            </div>
          </div>
</div>
        
</div>

    <?php
//    if($count==4){
//    $count=1;
    ?>
<!--  /div-->

                        <?php //}
//                        else
//                        $count++;
}?>

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
        
<script>
$('.image-zoom')
.wrap('<span style="display:inline-block"></span>')
.css('display', 'block')
.parent()
.zoom({
  url: $(this).find('img').attr('data-zoom')
});
</script>

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