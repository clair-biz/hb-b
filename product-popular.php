<?php
require_once 'data.php';
?>
<div class="container-fluid">
<div class="card" style="margin-bottom: 30px; border:none;" >
<!--
New Products
-->
<div class="card-body row" style="padding: 0px !important;">
    <div class="col-sm-12">
        <h5 class="page-header mx-5">
            <span style="border-bottom: 2px solid #e31e24;">
                    <?php
                    $type=$_REQUEST["type"];
                    if($type== 'Product'){
                        ?>
                     <b>Top Trending Products</b>   
                    <?php
                     }
                    elseif($type== 'Service'){
                    ?>
                     <b>Top Trending Services</b>
                     <?php
                    }
                    ?>
                </span>
        </h5>
    </div>
      <!--hr style="border-color: #E31E24; color: #E31E24; border-width: 3px; border-top: #E31E24;" /-->
<section class="slider-popular col-sm-12" style="margin-top: 3px;" >

                      <?php
                      $city=$_REQUEST["city"];
                      
                      $obj=new Base;
                      $popularTags= $obj->popularTag($city,$type);
//                      $newArrivals= $obj->newArrivals($city,$type);
//                      echo json_encode($newArrivals);
                      
                    foreach ($popularTags as $item) {
//                        echo json_encode($item)."<br/><br />";
                        $is_available=0;
                    $today = date('d-m-Y');
                    $today=date('d-m-Y', strtotime($today));
    //echo $paymentDate; // echos today! 
    $na_from = date('d-m-Y', strtotime($item["na_from"]));
    $na_to= date('d-m-Y', strtotime($item["na_to"]));
    if (($today > $na_from) && ($today < $na_to))
                        $is_available=1;
//    echo $is_available;
/*    
switch($type) {
    case "prod"  :
                $strQuery2="SELECT distinct prod_name,product.prod_id,bname,prod_img,mrp+(mrp*(tax_table.cgst/100))+(mrp*(tax_table.sgst/100))+ (mrp*(tax_table.cess/100)) ,is_delivery_provided,product.area_served,prod_unit,mrp_for,mrp_unit,product.vs_id,date_format(vend_subscription.na_from,'%d/%m/%Y'),date_format(vend_subscription.na_to,'%d/%m/%Y'),vs_pay_status from tax_table,product,users,vend_subscription,product_price where tax_table.hsn_code=product.hsn_code and product_price.prod_id=product.prod_id and vend_subscription.u_id=users.u_id and product.vs_id=vend_subscription.vs_id and vend_subscription.vs_id=".$rspc4[0]." and product.vs_id<>0 and users.is_active='Y' and product.is_active='Y' and vs_pay_status in ('Enabled','Wait4FSSAI') and  city_served='".$_COOKIE["city"]."' order by prod_id desc limit 3; ";
break;
    case "serv"  :
                $strQuery2="SELECT distinct serv_name,service.serv_id,bname,serv_img,service.area_served,service.vs_id,date_format(vend_subscription.na_from,'%d/%m/%Y'),date_format(vend_subscription.na_to,'%d/%m/%Y'),vs_pay_status from service,cat_sub,users,vend_subscription where vend_subscription.u_id=users.u_id and service.vs_id=vend_subscription.vs_id and service.vs_id<>0 and users.is_active='Y' and service.is_active='Y' and vs_pay_status in ('Enabled','Wait4FSSAI') and city_served='".$_COOKIE["city"]."' and vend_subscription.vs_id=".$rspc4[0]." order by serv_id desc limit 3;";
break;
}
                $pc2=mysqli_query(Crm::con(),$strQuery2) or die("error due to ".mysqli_error(Crm::con()));
                    while($item = mysqli_fetch_array($pc2)) {*/
                        $img=$root."assets/images/small.png";
//                        if(!is_null($item->prod_id))
                        if($type=="Product")
          $img=$root."assets/products-services/".$item["prod_img"];
                        else
          $img=$root."assets/products-services/".$item["serv_img"];
                        if($type=="Product")
          $pass= str_replace(" ", "_", $item["prod_name"]);
                        else
          $pass= str_replace(" ", "_", $item["serv_name"]);
                                 ?>
                   
                            <div class=" card block-card-new" style="margin: 5px !important; ">
            <div class="card-img-top">
                <a class="" href="<?php
                        if($type=="Product" && $is_available==0)
                echo $root."Products/".$item["prod_id"]."/".$pass;
                        elseif($type=="Service" && $is_available==0)
                echo $root."Services/".$item["serv_id"]."/".$pass;
                        elseif($is_available==1)
                            echo "#";
                ?>"
                <?php
                if($is_available==1 && $type=="Product")
                    echo "id='na-prod'";
                if($is_available==1 && $type=="Service")
                    echo "id='na-serv'";
                ?>
                >
                    <img height="150" width="320" class="img-fluid image-zoom slick-img"
             data-lazy="<?php echo $img; ?>"
             onError="this.onerror=null;this.src='http://www.homebiz365.in/uploads/images/small.png';" />
                </a>
            </div>
                                <div class="card-body" itemscope itemtype="http://schema.org/Product" style="padding: 10px;">
                <h6  class="truncate" style="font-size: 16px;" >
                    <a class="text-dark" href="<?php
                        if($type=="Product" && $is_available==0)
                echo $root."Products/".$item["prod_id"]."/".$pass;
                        elseif($type=="Service" && $is_available==0)
                echo $root."Services/".$item["serv_id"]."/".$pass;
                        elseif($is_available==1)
                            echo "#";
                                      ?>" data-toggle="tooltip" 
                <?php
                if($is_available==1 && $type=="Product")
                    echo "id='na-prod'";
                if($is_available==1 && $type=="Service")
                    echo "id='na-serv'";
                ?>
                                         title="<?php  if($type=="Product") {
                                             echo $item["prod_name"];
                                             }
                                         if($type=="Service") {
                                             echo $item["serv_name"];
                                             }
                                         ?>">
                                 <b><span itemprop="name"><?php  if($type=="Product") {
                                             echo $item["prod_name"];
                                             }
                                         if($type=="Service") {
                                             echo $item["serv_name"];
                                             }
                                            ?></span></b></a></h6>
        <a class="" href="<?php 
                        if($type=="Product" && $is_available==0) 
                echo $root."Products/".$item["prod_id"]."/".$pass;
                        elseif($type=="Service" && $is_available==0)
                echo $root."Services/".$item["serv_id"]."/".$pass;
                        elseif($is_available==1)
                            echo "#";
        ?>"
                <?php
                if($is_available==1 && $type=="Product")
                    echo "id='na-prod'";
                elseif($is_available==1 && $type=="Service")
                    echo "id='na-serv'";
                ?>
                >
            <!--p class="text-left black-text" style="font-size: 12px;" itemscope
             itemtype="http://schema.org/Person" ><span itemprop="name"><?php
                        //if($type=="Product") 
                        //    echo "<b>@ &#8377; ".$item["mrp"]."/- Per ".$item["prod_qty"]." ".$item["prod_unit"]."</b>";
                        ?>
                </span>
            </p-->
            <?php
/*
        if($item[7]=="Kg" || $item[7]=="gm" || $item[7]=="mg")
            echo " per Kg";
	
	elseif($item[7]=="L" || $item[7]=="ml")
	    echo " per Litre";
	elseif($item[7]=="Piece")
	    echo "";
    *
        if($item[5]=='Y' && !empty($item[6]))
                                echo "<br />Delivery provided in ".$item[6];
                        }
                        elseif($type=="Service") {
                            if(!empty($item->mrp))
                                echo "<br />Service provided in ".$item->mrp;
                        }
             
              ?></span></p>
        <?php*
        if($type=="Product" &&  $count=Campaign::getcampcountonproduct($item->prod_id)>0)
            echo "<p class=\"text-left black-text\" style=\"font-size: 12px;\" itemscope  itemtype=\"http://schema.org/Person\" ><span itemprop=\"name\">".$count." Offers applicable.</span></p>";
        if($type=="Service" &&  $count=Campaign::getcampcountonservice($item->prod_id)>0)
            echo "<p class=\"text-left black-text\" style=\"font-size: 12px;\" itemscope  itemtype=\"http://schema.org/Person\" ><span itemprop=\"name\">".$count." Offers applicable.</span></p>";
*/        
                if( $item["vendor_status"]=="Wait4FSSAI" || $item["vendor_status"]=="Enabled" || $item["vendor_status"]=="Wait4FSSAI" || $item["vendor_status"]=="Enabled") {
                    if($is_available==1) {
            echo '<p class="text-left red-text" style="font-size:12px;">Unavailable<br />from '.$item["na_from"].' to '.$item["na_to"].'</p>';
                    }
                    elseif($item["vendor_status"]=="Wait4FSSAI" || $item["vendor_status"]=="Wait4FSSAI")
            echo '<p class="text-left red-text" style="font-size:12px;">Coming Soon</p>';
                        
                }
        ?>
        </a>
            </div>
          </div>

                        <?php 
                        
                    }
                    
                    ?>
      </section>
      <div class="col-sm-2 advertisement-block" >
      </div>
</div>
</div>
</div>