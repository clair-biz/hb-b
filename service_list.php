<html>
    <body>

<?php
$serv_name= urldecode($_REQUEST['serv']);
$serv_name=str_replace("_"," ",$serv_name);
require_once 'data.php';
$strQuery1="select service.serv_id as 'serv_id', `serv_name`, `serv_img`,serv_desc,cs_name, bname as 'vendor',city_served,vend_rating,vend_rating_off,service.vs_id,date_format(vend_subscription.na_from,'%d/%m/%Y'),date_format(vend_subscription.na_to,'%d/%m/%Y') from  service,vendor,category,cat_sub,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and service.cs_id=cat_sub.cs_id and vend_subscription.vs_id=service.vs_id and users.is_active='Y' and service.is_active='Y' and  serv_name like '%".$serv_name."%'";
$service_res=Base::generateResult($strQuery1);
//$products_res=$obj->getServicesList($serv_name);
while ($serv_details= mysqli_fetch_assoc($service_res)) {
//        foreach ($products_res as $serv_details) {
                        $is_available=Vendor::checkOfflinePeriod($serv_details["vs_id"]);
                $n= explode(" ", $serv_details["serv_name"]);
                $serv_id= $serv_details["serv_id"];
                $serv_name= implode("_", $n);
                ?>
<div class="service-details d-none d-md-block" id="<?php echo "service_".$serv_name;?>" >
          <div class="card">
            <div class="card-content">
                <div class="row">
      <div class="col-lg-4 col-md-4 product-img" >
                    <a href="<?php
                    if($is_available==0)
                    echo $root."Services/".$serv_details["serv_id"]."/".$serv_details["serv_name"];
                    else
                        echo "#";
                    ?>">
        <img class="responsive-img product-img"
             style="
             height: 200px !important; width: auto !important;
             margin-left: auto !important;
             margin-right: auto !important;"
             src="<?php echo $root."assets/products-services/".$serv_details["serv_img"]; ?>"
             onError="this.onerror=null;this.src='http://www.homebiz365.in/uploads/images/small.png';" />
    </a>
      </div>
 
	<div class="col-lg-8 col-md-8">
            <div class="row">
            <p class="text-left container-fluid">
                        <span  style="font-size: 14px;">
                            <span class="logo-color-g"> <b>Vendor:</b></span>  <b><?php echo $serv_details["vendor"]; ?></b>
		<?php
                $rating=0;
                if($serv_details["vend_rating"]!=0 && $serv_details["vend_rating_off"]!=0)
                $rating=(int)$prod_details["vend_rating"]/$prod_details["vend_rating_off"];
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
            </p>
                <?php
            $c=Campaign::getcampcountonservice($serv_details["serv_id"]);
            if($c>0) { ?>
         <p class="text-left container-fluid">
            <span class="logo-color-g"> <b>Offers:</b></span>
            <?php
                echo $c." Offer(s) applicable.";
                echo "<br />".Campaign::getcampnamesbyservid($serv_id);
                ?>
         </p>
         <?php
                }
?>
          <p class="text-left container-fluid">
           <span class="logo-color-g"> <b>Description:</b></span> <?php echo $serv_details["serv_desc"]; ?>
          </p>
            </div>
            
            <div class="row container-fluid">
          <p class="text-left left">
            <?php
            if($is_available==1)
            echo '<em class="text-left red-text" style="font-size:12px;">Unavailable<br />from '.$serv_details["na_from"].' to '.$serv_details["na_to"].'</em>';
            ?>
          </p>
            </div>
            <div class="row">
<a class="view-file defaultBtn btn btn-link" href="<?php
            if($is_available==1)
                echo "#";
            else
echo $root."Services/".$serv_details["serv_id"]."/".$serv_details["serv_name"]; ?>">View Details</a>
      <button
                        <?php
              if($is_available==1)
                  echo "disabled";
              ?>
          id="<?php echo "submit_serv_".$serv_details[0]; ?>" name="serv" type="button" value="<?php echo $serv_id; ?>"  class="btn button red btn-call-4-service">
        Contact Service Provider
      </button>
            </div>
        </div>
            
                        
            
        </div>

</div>
            </div>
          </div>


<div class="service-details d-md-none d-sm-block" id="<?php echo "service_".$serv_name;?>" >
          <div class="card">
            <div class="card-content">
    <div class="row">
      <div class="col  service-img" >
    <a >
        <img class="responsive-img service-img"
             style="height: auto !important; width: auto !important;
             display: block !important; margin-left: auto !important;
             margin-right: auto !important;"
             src="<?php echo $root."uploads/products-services/".$serv_details[2]; ?>"
             onError="this.onerror=null;this.src='http://www.homebiz365.in/uploads/images/small.png';" />
    </a>
      </div>
      
      

    <div class="col-lg-8 col-md-8 service-box" >
                <h5  class="truncate text-left" style="font-size: 16px;">
                                      <b>
                                    <a href="<?php echo $root."Services/".$serv_details[0]."/".$serv_details["serv_name"]; ?>" data-toggle="tooltip" 
                                         title="<?php echo $serv_details["serv_name"]; ?>">
                                        <?php echo $serv_details["serv_name"]; ?>
                                        </a>
                                    </b>
                                  </h5>

                        <p  class="text-left" style="font-size: 14px;">
                by <b><?php echo $serv_details[5]; ?></b><p class="right-align right">
		<?php
                $rating=0;
                if($serv_details[6]!=0 && $serv_details[8]!=0)
                $rating=(int)$serv_details[6]/$serv_details[8];
                ?><span class="badge" style="<?php
                        if($rating==0)
                            echo "display:none";
                        elseif($rating>=1 && $rating<=2.9)
                            echo "background-color:red;  color: white";
                        elseif($rating>=3 && $rating<=3.9)
                            echo "background-color:yellow";
                        elseif($rating>=4 && $rating<=5)
                            echo "background-color:green;  color: white";
                        ?>"><?php echo "$rating &#x2605;"; ?></span></p>
          <p class="row text-left">
              Service Description,<br />
            <?php echo $serv_details[3]; ?>

          </p>
          <?php
            $c=Campaign::getcampcountonservice($serv_id);
            if($c>0) {
                echo "<p class=\"row text-left\"style=\"font-size: 12px;\">".$c." Offer(s) applicable.";
                echo Campaign::getcampnamesbyservid($serv_details[0]);
            }
?>

    
    <div class="row" style="margin-bottom: 5px; ">

<a class="view-file defaultBtn btn btn-link " href="<?php echo $root."Services/".$serv_details[0]."/".$serv_details["serv_name"]; ?>">View Details</a>
      <button id="<?php echo "submit_serv_".$serv_details[0]; ?>" name="serv" type="submit" value="<?php echo $serv_details[0]; ?>"  class="btn btn-primary btn-call-4-service ">
        Contact Service Provider
      </button>
    </div>


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