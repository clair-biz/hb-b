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
$prod_id=$_REQUEST['prod'];
$type="prod";
$cs_name="";
$min_qty=0;
$min_unit="";
$str="select product.prod_id as 'prod_id', `prod_name`,prod_desc,cs_name,cat_name, bname as 'vendor',vend_rating,'".Base::getDiscount($prod_id, 1)."' as 'mrp',vend_rating_off,prod_unit,prod_qty,product.prod_min_time as 'prod_min_time',mrp_for,mrp_unit,product.vs_id as 'vs_id',vs_pay_status,prod_replace,prod_return,r_within,prod_img,date_format( date_add(now(),interval prod_min_time day), '%Y-%m-%d' ) as 'lead_time',date_format( date_add(now(),interval prod_min_time+1 day), '%d-%m-%Y' ) as 'lead_time_display' from  product,cat_sub,vendor,category,product_price,vend_subscription,users,tax_table WHERE tax_table.hsn_code=product.hsn_code and vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and product_price.prod_id=product.prod_id and vend_subscription.vs_id=product.vs_id and product.prod_id=".$prod_id.";";
//echo $str;
$proddetailsres=Base::generateResult($str);
//$proddetailsres=$obj->getProductDetails($prod_id);
?>
    <div class="hide-on-med-and-up">
<?php// require 'category-navbar-mob.php';?>
    </div>
  
<div class="container-fluid row details-block">
    <div class="col-lg-2 col-md-4 d-none d-md-block" >
            <?php require_once 'product-menu.php';?>

            <?php// require_once 'popular-tags.php';?>

            <?php// require_once 'advertisement-1.php';?>
        </div>
        
           <div class="col-lg-10 col-md-8" >
<?php
//foreach ($proddetailsres as $prod_details) {
    if($prod_details=mysqli_fetch_array($proddetailsres)) {
        $min_unit=$prod_details["prod_unit"];
        $min_qty=$prod_details["prod_qty"];
                        $is_available=Vendor::checkOfflinePeriod($prod_details["vs_id"]);
                        if($prod_details["vs_pay_status"]=="Wait4FSSAI")
                            $is_available=1;
                $n= explode(" ", $prod_details["prod_id"]);
                $prod_name= implode("_", $n);
                $cs_name=$prod_details["cs_name"];
          $img=$root."assets/products-services/".$prod_details["prod_img"];
          //echo $img;

          $link_prod= str_replace(" ","_", $prod_details["prod_name"]);
          $link_cs= str_replace(" ","_", $prod_details["cs_name"]);
          $link_cat= str_replace(" ","_", $prod_details["cat_name"]);
    ?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><a class="logo-color-b" href="<?php echo $root;?>">Products</a></li>
    <li class="breadcrumb-item">
        <a class="logo-color-b" href="<?php echo $root."Products/".$link_cat;?>" >
            <?php echo $prod_details["cat_name"]; ?>
        </a>
    </li>
    <li class="breadcrumb-item">
        <a class="logo-color-b" href="<?php echo $root."Products/".$link_cs;?>" >
            <?php echo $prod_details["cs_name"]; ?>
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page" style="font-size: 1rem;"
                title="<?php echo $prod_details[1]; ?>">
        <b class="logo-color-g"> <?php echo $prod_details[1]; ?></b>
    </li>
  </ol>
</nav>
<div class="row">               
<div class="col-md-12 col-lg-12 col-sm-12">
    <div class="row">
      <div class="col-md-6 col-sm-12 product-img" >
          
    <a >
        <img class="img-fluid product-img image-zoom"
             style="margin-left: auto !important;
             margin-right: auto !important;"
             src="<?php echo $img; ?>"
             data-zoom-image="<?php echo $img; ?>"
             onError="this.onerror=null;this.src='http://www.homebiz365.in/uploads/images/small.png';" />
    </a>
      

      </div>
 
	<div class="col-sm-12 col-md-6">
                <h5  class="truncate text-left mb-2" style="font-size: 16px;">

                        <span  class="text-left logo-color-g"> <b>Vendor:</b></span>  <b><?php echo $prod_details["vendor"]; ?></b>
		<?php
                $rating=0;
                if($prod_details[6]!=0 && $prod_details[8]!=0)
                $rating=(int)$prod_details[6]/$prod_details[8];
                ?> <span class="" style="<?php
                        if($rating==0)
                            echo "display:none";
                        elseif($rating>=1 && $rating<=2.9)
                            echo "background-color:red;  color: white";
                        elseif($rating>=3 && $rating<=3.9)
                            echo "background-color:yellow";
                        elseif($rating>=4 && $rating<=5)
                            echo "background-color:green;  color: white";
                        ?>">&nbsp;&nbsp;<?php echo intval($rating)." &#x2605;"; ?>&nbsp;&nbsp;
                        </span>
	<!--span id="<?php //echo "prc_".$prod_details["0"]; ?>" class="right text-right text-danger prc">@ &#8377; <?php //echo $prod_details[7]."<font style='font-size: 14px !important;'>";
	/*if($prod_details["prod_unit"]=="Kg" || $prod_details["prod_unit"]=="gm" || $prod_details["prod_unit"]=="mg")
	echo " per Kg";
	
	elseif($prod_details["prod_unit"]=="L" || $prod_details["prod_unit"]=="ml")
	    echo " per Litre";
	elseif($prod_details["prod_unit"]=="Piece")
	    echo "";
	echo "</font>";*/ ?></span-->
                                  </h5>
          <p class="mb-2">
              <span class="logo-color-g"> <b>Price:</b></span><?php echo " &#8377; ".$prod_details["mrp"]."/- for ".$prod_details["prod_qty"]." ".$prod_details["prod_unit"]; ?>
          </p>
          <?php
                if(!empty($prod_details["prod_min_time"])) {
                ?>
          <p class="mb-2">
           <span class="logo-color-g"> <b>Lead time:</b></span> <?php  echo $prod_details["prod_min_time"]." Day(s)"; ?>
          </p>
          <?php
                }
                
            $c=Campaign::getcampcountonproduct($prod_details["prod_id"]);
             ?>
         <p class="mb-2">
            <span class="logo-color-g"> <b>Offers:</b></span>           
                <?php
                if($c>0) {
                echo $c." Offer(s) applicable.";
                echo "<br />".Campaign::getcampnamesbyprodid($prod_details["prod_id"]);
                ?>
         </p>
                <?php
                }
                else{
                    echo "No offers applicable currently";
                }
                
                ?>
          <p class="mb-2">
           <span class="logo-color-g"> <b>Replacement:</b></span> 
               <?php 
               if($prod_details["prod_replace"]=="Y") {
               echo "within ".$prod_details["r_within"]." Day(s)";
               }
               else{
               echo "No Replacement";
               }
               ?>
          </p>
                
          <p class="mb-2">
           <span class="logo-color-g"> <b>Return: </b></span>
               <?php 
               if($prod_details["prod_return"]=="Y") {
               echo "within ".$prod_details["r_within"]." Day(s)";
               }
               else{
               echo "No Return";
               }
               ?>
          </p>

          <div class="col-md-12 col-lg-12 col-sm-12">
                 <form id="<?php echo "form_".$prod_details["prod_id"];?>" class="form-cart" method="post">
                    <div class="row">
                   <div class="col-lg-4 col-md-4 col-sm-12 padding-small">
        <?php
//        if($prod_details[4]=="Food Items") {
        ?>
    <label class="left" style="font-weight: 500;">Required on</label>
    <input id="<?php echo "reqd_".$prod_details["prod_id"]; ?>" readonly data-lead="<?php echo $prod_details["lead_time"]; ?>" name="reqd" type="text" value="<?php echo $prod_details["lead_time_display"]; ?>" data-toggle="datepicker" class="datepicker dt form-control"   required />
    <?php
//    }
    ?>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 padding-small">
        <?php
//        if($prod_details[4]=="Food Items") {
        ?>
    <label class="left" style="font-weight: 500;">Time Slot</label>
                <select class="form-control" id="slot" name="slot">
                    <option selected="true" disabled value="">-Select-</option>
                    <?php
                    $strslots="select bs_id,bs_from,bs_to from booking_slots order by bs_id;";
                    $resslot= Base::generateResult($strslots);
                    while($rowslot= mysqli_fetch_assoc($resslot)) {
                    ?>
                    <option value="<?php echo $rowslot["bs_id"]; ?>"><?php echo $rowslot["bs_from"]."-".$rowslot["bs_to"]; ?></option>
                    <?php
                    }
                    ?>
                </select>
    <?php
//    }
    ?>
    </div>
                    </div>
    <div class="row mt-5">
    <div class="col-lg-4 col-md-4 col-sm-12">
    <div class="form-group">
    <label for="name" style="font-weight: 500;">Quantity</label>
             <input type="hidden" name="min_qty" value="<?php echo $prod_details["prod_qty"]; ?>" />
             <input type="hidden" name="min_qty_unit" value="<?php echo $prod_details["prod_unit"]; ?>" />
    <input class="qty form-control" id="<?php echo "qty_".$prod_details["prod_id"]; ?>" name="qty" type="number" min="1" value="1" placeholder="Quantity" class="qty" required />
    </div>
        
    </div>
                     
        <div class="col-lg-4 col-md-4 col-sm-12">
                   <div class="row product-footer" style="margin-bottom: 5px; ">
    <p id="<?php echo "subtotal_".$prod_details["prod_id"]; ?>"
       class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom: 5px;">Subtotal <span class="subtotal badge red white-text"><?php echo "&#8377; ".$prod_details[7]."/-";?></span>
    </p>
    <!--div class="status col-sm-6"></div-->
        <div class="col-lg-4 col-md-4 col-sm-12">
            <button id="<?php echo "submit_prod_".$prod_details["prod_id"]; ?>"
              <?php
              if($is_available==1)
                  echo "disabled";
              ?>
                    name="prod_id" type="submit" value="<?php echo $prod_details["prod_id"]; ?>"  class="btn button red btn-add-to-cart">
        <i class="material-icons">shopping_cart</i> Add to Cart
      </button>
    </div>
    </div>
    </div>
          </div>
</form>
                   </div>
        
        </div>
</div>
</div>
</div>             
               
               
               
  <div class="container-fluid">
<!-- Nav tabs -->
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#home">Product Description</a>
  </li>
</ul>      
<div class="tab-content">
    <div id="description" class="tab-pane container-fluid active">
        <pre><?php echo $prod_details["prod_desc"]; ?></pre>
    </div>
  </div>
  </div>
<?php
    }
?>

    </div>
                <div class="col-md-4 col-lg-2 hide-on-med-and-down" >
        <div class="row">
            <?php //require_once 'advertisement-2.php';?>
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
  

    

</script>       
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