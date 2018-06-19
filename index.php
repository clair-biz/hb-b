<!DOCTYPE html>
<html>
<body>
<?php
require_once('header.php');
        $type="prod";

?>
    <div class="container-fluid hide-on-small-and-down" style="margin-top: 40px;">
<div id="gototop"> </div>
<!-- 
Body Section 
-->
<div class="row container-fluid" style=" max-height: 200px !important;">
    
    <div class="col l5 m4 container-fluid" style="">
        <?php require 'company-advertisement.php';?>
    </div>
    <div class="col l2 m4 container-fluid" style="">
        <?php
        require 'page-type.php';?>
    </div>

    <div class="col l5 m4 container-fluid" style="">
        <?php require 'category-slider.php';?>
    </div>
</div>
<div class="">
    <marquee>
    <span class="logo-color-g" style="padding-right: 100px;">
        <b><i class="material-icons blink_text" style="width: 24px; color: #E31E24; ">star_rate</i>&nbsp;Special Introductory Offer! Flat 50% off on Annual Membership Subscription.... Hurry.... Offer valid for limited period only....!!!!&nbsp;<i class="material-icons blink_text" style="width: 24px; color: #E31E24; ">star_rate</i></b>
    </span>

     <span class="logo-color-b" style="padding-right: 100px;">
    <a class="logo-color-r" href="<?php echo Crm::root()."Contact"; ?>"><b>For advertisements, click here.</b></a>
	</span>    
    </marquee>
</div>
<div class="container-fluid row" style="margin-top: 20px;">
    <div class="col l2 m4" >
            <?php require_once 'shop-by.php';?>
            <?php require_once 'popular-tags.php';?>
            <?php require_once 'advertisement-1.php';?>
        
</div>
					
<div class="col m8 l8">

<?php require 'new-arrival.php';?>
<?php require 'product-main-block.php';?>

						
</div>
                <div class="col m4 l2 hide-on-med-and-down" >
            <?php require_once 'advertisement-2.php';?>
    </div>

    </div>
</div>


    <div class="hide-on-large-only">
<div id="gototop"> </div>
<!-- 
Body Section 
-->
<?php require 'category-navbar-mob.php';?>
<div class="container-fluid" style="margin-top: 5px !important;">
    
    <div class="row">
    <div class="col s12 container-fluid" style="">
        <?php require 'company-advertisement.php';?>
    </div>
    </div>
    
    <div class="row">
    <div class="col s12 container-fluid" style="">
        <?php require 'page-type.php';?>
    </div>
    </div>
    
    <div class="row">
    <div class="col s12 container-fluid" style="">
        <?php require 'category-slider.php';?>
    </div>
    </div>
<div class="">
    <marquee>
    <span class="logo-color-g" style="padding-right: 100px;">
        <b><i class="material-icons blink_text" style="width: 24px; color: #E31E24; ">star_rate</i>&nbsp;Special Introductory Offer! Flat 50% off on Annual Membership Subscription.... Hurry.... Offer valid for limited period only....!!!!&nbsp;<i class="material-icons blink_text" style="width: 24px; color: #E31E24; ">star_rate</i></b>
    </span>

     <span class="logo-color-b" style="padding-right: 100px;">
    <a class="logo-color-r" href="<?php echo Crm::root()."Contact"; ?>"><b>For advertisements, click here.</b></a>
	</span>    
    </marquee>
</div>

        <div class="row">
            <?php require_once 'advertisement-1.php';?>
        </div>
        

    <div class="row">
    <div class="col offset-s1 s10">
<?php require 'new-arrival.php';?>
    </div>
    </div>
    <div class="row">
    <div class="col offset-s1 s10">
<?php require 'product-main-block.php';?>
    </div>
    </div>

						
        <div class="row">
            <?php require_once 'advertisement-2.php';?>
        </div>
    </div>

</div>

<a href="#" class="gotop"><i class="icon-double-angle-up"></i></a>

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
<?php 
require_once 'footer.php';
?>

</body>
</html>
