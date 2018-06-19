<html>
    <body>

<?php
$prod_name=str_replace("_"," ",$_REQUEST['prod']);
require_once 'data.php';

$count=1;
$str="select product.prod_id as 'prod_id', `prod_name`,prod_desc,cs_name,cat_name, bname as 'vendor',vend_rating,mrp+(mrp*(tax_table.cgst/100))+(mrp*(tax_table.sgst/100))+ (mrp*(tax_table.cess/100)) as 'mrp' ,vend_rating_off,prod_unit,prod_qty,product.prod_min_time,mrp_for,mrp_unit,product.vs_id as 'vs_id',date_format(vend_subscription.na_from,'%d/%m/%Y') as 'na_from',date_format(vend_subscription.na_to,'%d/%m/%Y') as 'na_to',vs_pay_status,prod_replace,prod_return,r_within from  tax_table,product,cat_sub,vendor,category,product_price,vend_subscription,users WHERE tax_table.hsn_code=product.hsn_code and vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and product_price.prod_id=product.prod_id and vend_subscription.vs_id=product.vs_id and city_served='$city' and users.is_active='Y' and product.is_active='Y' and prod_name like '%".$prod_name."%'";
	$proddetailres=Base::generateResult($str);
//$products_res=$obj->getProductsList($prod_name,$city);
//        foreach ($products_res as $prod_details) {
            while($prod_details = mysqli_fetch_assoc($proddetailres)) {
        $min_unit=$prod_details["prod_unit"];
        $min_qty=$prod_details["prod_qty"];
                        $is_available=Vendor::checkOfflinePeriod($prod_details["vs_id"]);
                        if($prod_details["vs_pay_status"]=="Wait4FSSAI")
                            $is_available=1;
                $n= explode(" ", $prod_details["prod_name"]);
                $prod_name= implode("_", $n);
          $img=$root."assets/products-services/".Product::getprodimgbyname($prod_details["prod_name"]);
                ?>
<div class="product-details hide-on-small-and-down0" id="<?php echo "product_".$prod_name;?>" >
          <div class="card block-card" style="margin-bottom: 0 !important; margin-top: 0 !important; ">
              <div class="card-body" style="padding: 10px;">
                        <form id="<?php echo "form_".$prod_details["prod_id"];?>" class="form-cart" method="post">
                  <div class="row" style="margin-bottom: 0 !important;">
                <div class="col col-md-3 col-sm-12 product-img">
                    <a href="<?php
                    if($is_available==0)
                    echo $root."Products/".$prod_details["prod_id"]."/".$prod_name;
                    else
                        echo "#";
                    ?>">
        <img class="img-fluid image-zoom"
             style="height: auto !important; width: auto !important;
             display: block !important; margin-left: auto !important;
             margin-right: auto !important;"
             src="<?php echo $img; ?>" 
             data-zoom-image="<?php echo $img; ?>"
             onError="this.onerror=null;this.src='http://www.homebiz365.in/uploads/images/small.png';" />
                    </a>
                </div>
        <div class="product-box col-md-9 col-sm-12" >
            <div class="row" style="margin-bottom: 0 !important; ">
            <div class="row col-md-5 col-sm-12" style="margin-bottom: 0px;">
                <p  class="truncate text-left" style="font-size: 16px;">

                            <span class="logo-color-g"> <b>Vendor:</b></span>  <b><?php echo $prod_details["vendor"]; ?></b>
		<?php
                $rating=0;
                $vend_rating=$prod_details["vend_rating"];
                $vend_rating_off=$prod_details["vend_rating_off"];
                if($vend_rating!=0 && $vend_rating_off!=0)
                $rating=(int)$vend_rating/$vend_rating_off;
                ?> <span class="" style="<?php
                        if($rating==0)
                            echo "display:none";
                        elseif($rating>=1 && $rating<=2.9)
                            echo "color:red;  font-weight: bolder";
                        elseif($rating>=3 && $rating<=3.9)
                            echo "color:yellow; font-weight: bolder";
                        elseif($rating>=4 && $rating<=5)
                            echo "color:green; font-weight: bolder ";
                        ?>">&nbsp;&nbsp;<?php echo intval($rating)." &#x2605;"; ?></span>
	<!--span id="<?php //echo "prc_".$prod_details["0"]; ?>" class="right text-right text-danger prc">@ &#8377; <?php //echo $prod_details[7]."<font style='font-size: 14px !important;'>";
	/*if($prod_details[9]=="Kg" || $prod_details[9]=="gm" || $prod_details[9]=="mg")
	echo " per Kg";
	
	elseif($prod_details[9]=="L" || $prod_details[9]=="ml")
	    echo " per Litre";
	elseif($prod_details[9]=="Piece")
	    echo "";
	echo "</font>";*/ ?></span-->
                                  </p>
          <p class="text-left">
              <span class="logo-color-g"> <b>Price:</b></span> &#8377;<?php echo $prod_details["mrp"]." Per ".$prod_details["prod_qty"]." ".$prod_details["prod_unit"]; ?>
          </p>
          <?php
            $c=Campaign::getcampcountonproduct($prod_details["prod_id"]);
            if($c>0) { ?>
         <p class="text-left">
            <span class="logo-color-g"> <b>Offers:</b></span>           <?php 
                echo $c." Offer(s) applicable.";
                echo "<br />".Campaign::getcampnamesbyprodid($prod_details["prod_id"]);
                ?>
         </p>
                <?php
                }
                if(!empty($prod_details["prod_min_time"])) {
                ?>
          <p class="text-left">
           <span class="logo-color-g"> <b>Lead time:</b></span> <?php echo $prod_details["prod_min_time"]." Day(s)"; ?>
          </p>
          <?php
                }
                if($prod_details["prod_replace"]=="Y") {
                ?>
          <p class="text-left">
           <span class="logo-color-g"> <b>Replacement within</b></span> <?php echo $prod_details["r_within"]." Day(s)"; ?>
          </p>
          <?php
                }
                if($prod_details["prod_return"]=="Y") {
                ?>
          <p class="text-left">
           <span class="logo-color-g"> <b>Return within</b></span> <?php echo $prod_details["r_within"]." Day(s)"; ?>
          </p>
          <?php
                }
                ?>


      </div>
                <div class="col-md-7 col-sm-12" style="margin-bottom: 0 !important;">
                    <div class="row">
    <div class="col-md-7 col-sm-12 padding-small form-group">
    <label class="left">Required on</label>
    <input id="<?php echo "reqd_".$prod_details["prod_id"]; ?>" name="reqd" type="text" readonly data-lead="<?php echo $prod_details["prod_min_time"]; ?>"  data-toggle="datepicker" class="dt form-control"   required />
    </div>
    
    <div class="col-md-5 col-sm-12 padding-small form-group">
        <?php
//        if($prod_details[4]=="Food Items") {
        ?>
    <label class="left">Time Slot</label>
                <select class="form-control" id="slot" name="slot">
                    <option selected="true" disabled value="">-Select-</option>
                    <?php
                    $strslots="select bs_id,bs_from,bs_to from booking_slots order by bs_id;";
                    $resslot=Base::generateResult($strslots);
//                    $resslot= mysqli_query(Crm::con(), $strslots);
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
    
                
                <div class="row">
                 <div class="col-md-4 col-sm-12">
    <div class="form-group">
    <label for="name" >Quantity</label>
             <input type="hidden" name="min_qty" value="<?php echo $prod_details["prod_qty"]; ?>" />
             <input type="hidden" name="min_qty_unit" value="<?php echo $prod_details["prod_unit"]; ?>" />
    <input class="qty form-control" id="<?php echo "qty_".$prod_details["prod_id"]; ?>"  name="qty" type="number" min="1" value="1" placeholder="Quantity" required />
    </div>
        
    </div> 
                
                
    <div class="col-md-8 d-flex align-items-center" style="margin-bottom: 0px !important;">
    <p id="<?php echo "subtotal_".$prod_details["prod_id"]; ?>"
       class=" col-sm-12  text-center" style="margin-bottom: 5px;">Subtotal <span class="subtotal badge red white-text"><?php echo "&#8377; ".$prod_details["mrp"]."/-";?></span>
    </p>
    </div>
            </div>
                    
                    </div>
                
    <div class="container-fluid" style="margin-bottom: 0px !important;">
        <a href="#" class="show_desc left col-md-6 col-sm-12" id="<?php echo "show_desc_".$prod_details["prod_id"];?>">Show Details</a> 
            <button id="<?php echo "submit_prod_".$prod_details["prod_id"]; ?>"
              <?php
              if($is_available==1)
                  echo "disabled";
              ?>
                    name="prod_id" type="submit" value="<?php echo $prod_details["prod_id"]; ?>"  class="btn button red btn-add-to-cart float-right col-md-6 col-sm-12">
        <i class="material-icons">shopping_cart</i> Add to Cart
      </button>
    </div>


                </div>
        </div>




      </div>
</form>
    
            </div>
             
                  <div class="container-fluid desc_block" id="<?php echo "desc_block_".$prod_details["prod_id"]; ?>" style="display: none">
      <ul class="nav nav-tabs"  id="myTab" role="tablist">
          <li class="nav-item">
              <a class="active nav-link" id="description-tab"
                 data-toggle="tab" role="tab" aria-controls="description"
                 aria-selected="true" href="#description">
                  Product Description
              </a> 
          </li>
      </ul>
      <div id="myTabContent" class="tab-content col-sm-12">
      <div id="description" class="col col-sm-12 tab-pane fade show active" role="tabpanel" aria-labelledby="description-tab">
          <pre class="text-left"><?php echo $prod_details["prod_desc"]; ?></pre>
    </div>
  </div>

            </div>


</div>
</div>
    <?php
    }
    ?>

    </body>
</html>