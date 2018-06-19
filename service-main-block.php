<!DOCTYPE html>
<html>
<body>
<?php
mysqli_data_seek($serv_cat, 0);
            while($row = mysqli_fetch_array($serv_cat)) {
//    $strQuery3="SELECT count(*) from product,category where product.prod_cat_main=category.cat_id and category.prod_cat_main='".$row[0]."'";
//    $pc3=mysqli_query(Crm::con(),$strQuery3);
    
//            while($rspc3 = mysqli_fetch_array($pc3)) {
                if(Crm::getcountservcsname($row[0])>0)
    $strQuery4="SELECT distinct cs_name from category,cat_sub,vend_subscription where vend_subscription.cat_id=category.cat_id and category.cat_id=cat_sub.cat_id and city_served='".$_COOKIE["city"]."' and vs_pay_status='Enabled' and vend_subscription.u_id in (select u_id from users where is_active='Y') and cat_name='".$row[0]."'";
                else
    $strQuery4="SELECT distinct cs_name from category,cat_sub,vend_subscription where vend_subscription.cat_id=category.cat_id and category.cat_id=cat_sub.cat_id and city_served='".$_COOKIE["city"]."' and vs_pay_status='Enabled' and vend_subscription.u_id in (select u_id from users where is_active='Y') and cs_name<>'".$row[0]."' and cat_name='".$row[0]."'";
                
    $pc4=mysqli_query(Crm::con(),$strQuery4);
    if(Crm::getcountcatcontentforserv($row[0])>0 ) {
        
?>
	<!--
	Featured Products
	-->
        <section id="<?php echo $row[0]; ?>" >
<?php
$j=0;
?>
  <section id="<?php echo $rspc4[0]; ?>"  >
      <h5 style="font-size: 20px;"><b><?php echo $row[0]; ?></b></h5>
      <!--hr style="border-color: #E31E24; color: #E31E24; border-width: 3px; border-top: #E31E24;" /-->
                        <section class="regular slider" style="margin-top: 3px;" >

                      <?php
//                $strQuery2="SELECT distinct prod_name from product,cat_sub where cat_sub.cs_id=product.cs_id and cs_name='".$rspc4[0]."' and product.prod_id<>0 and product.vend_id<>0 order by prod_name";
//                $pc2=mysqli_query(Crm::con(),$strQuery2);
                    while($rspc2 = mysqli_fetch_array($pc4)) {
    if(Crm::getcountcscontentforserv($rspc2[0])>0 ) {
          $pass=str_replace(" ", "_", $rspc2[0]);
                      $img=Crm::root()."uploads/images/small.png";
                        if(!is_null(Service::getservimgbycsname($rspc2[0])))
          $img=Crm::root()."uploads/products-services/".Service::getservimgbycsname($rspc2[0]);
                                 ?>
                            
          <div class="card block-card" style="margin: 5px !important; ">
            <div class="card-image">
                <a href="<?php echo Crm::root()."Services/".rawurlencode($pass); ?>"><img class="responsive-img"
             style="height: 150px !important; width: auto !important;
             display: block !important; margin-left: auto !important;
             margin-right: auto !important;"
             data-lazy="<?php echo $img; ?>"
             onError="this.onerror=null;this.src=Crm::root().'uploads/images/small.png';" /></a>
            </div>
              <div class="card-content" style="padding: 10px;">
                <h6  class="truncate center-align black-text" style="font-size: 16px;">
                    <a class="black-text" href="<?php echo Crm::root()."Services/".rawurlencode($pass); ?>" data-toggle="tooltip" 
                                         title="<?php echo $rspc2[0]; ?>">
                                 <b><?php echo $rspc2[0]; ?></b></a></h6>
            </div>
          </div>

                    <?php
                        }
                    }
                    ?>
      </section>
  </section>
    <?php
//    $j++;
//            }
            ?>
	</section>
<?php
            }
        }
        
?>
</body>
</html>
