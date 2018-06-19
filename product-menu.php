<?php
    require_once 'data.php';
    
                      $type=$_COOKIE["type"];//$_REQUEST["type"];
                      $search_val=$_REQUEST["val"];//$_REQUEST["type"];


$cat_id=array();
$cat_name=array();



$strQuery1="select  distinct category.cat_id,cat_name from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='$city' and users.is_active='Y' and product.is_active='Y' and prod_name like '%".$search_val."%'";
$strQuery1.=" union select distinct category.cat_id,cat_name from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='$city' and users.is_active='Y' and product.is_active='Y' and  product.area_served like '%".$search_val."%'";
$strQuery1.=" union select distinct category.cat_id,cat_name from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='$city' and users.is_active='Y' and product.is_active='Y' and  bname like '%".$search_val."%'";
$strQuery1.=" union select distinct category.cat_id,cat_name from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='$city' and users.is_active='Y' and product.is_active='Y' and  cs_name like '%".$search_val."%'";
$strQuery1.=" union select distinct category.cat_id,cat_name from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='$city' and users.is_active='Y' and product.is_active='Y' and  cat_name like '%".$search_val."%'";
$strQuery1.=" union select distinct category.cat_id,cat_name from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='$city' and users.is_active='Y' and product.is_active='Y' and  vend_addr like '%".$search_val."%'";
$strQuery1.=" union select distinct category.cat_id,cat_name from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='$city' and users.is_active='Y' and product.is_active='Y' and  loc_zip like '%".$search_val."%'";

//echo $strQuery1; 
$res=Base::generateResult($strQuery1);

while($row= mysqli_fetch_array($res)) {
    array_push($cat_id,$row[0]);
    array_push($cat_name,$row[1]);
    }

                      switch($type){
                          case 'Product':
                                          $list=$productCategoryList;
                                            break;
                          case 'Service':
                                          $list=$serviceCategoryList;
                                            break;
                              }
//                      print_r($products);
                              
      ?>                
<div id="accordion">
    <div class="card" >
        <div class="card-header p-3">Products</div>
    </div>
    <?php
                    foreach ($list as $item) {
//                        if($item["cat_name"]!="Food Items" && $item["cat_name"]!="Bakery Items") {
//                        echo json_encode($item)."<br/><br />";
                        //$img=$root."assets/images/small.png";
//                        if(!is_null($item->prod_id))
        //$img=$root."assets/category-imgs/".$item["cat_img"];
          $str="select distinct cs_name from cat_sub,category where cat_sub.cat_id=category.cat_id and cs_name<>'".$item["cat_name"]."' and cat_sub.cat_id='".$item["cat_id"]."';";
         // echo $str;
          $link_cat= str_replace(" ", "_", $item["cat_name"]);
          $prodsub=Base::generateResult($str);                      
          ?>

  <div class="card">
    <div class="card-header pt-1 pb-1 pl-2 pr-2">
        <a class="card-link text-dark
           <?php
            if($type=="Product")
                echo "product-link";
            elseif($type=="Service")
                echo "service-link";
            ?>" style="font-weight: 500;" href="#" data-message="<?php echo $root."Products/".$link_cat; ?>" > <?php echo $item["cat_name"]; ?>  </a>
        <a class="card-link text-dark float-right" style="font-weight: 500;" data-toggle="collapse" href="<?php echo "#collapse".$item["cat_id"]; ?>" ><i class="material-icons">arrow_drop_down</i></a>
    </div>
    <div id="<?php echo "collapse".$item["cat_id"]; ?>" class="collapse 
         <?php
if(array_search($item["cat_name"],$cat_name)>-1)
         echo "show";
         ?>
         " data-parent="#accordion">
      <div class="card-body p-0">
      <ul class="list-group list-group-flush" style="max-height: 50vh; overflow-y: auto; overflow-x: hidden">
    <?php
    while($row=mysqli_fetch_array($prodsub)){
          $pass= str_replace(" ", "_", $row["cs_name"]);
        ?>
        <a data-message="<?php echo $root."Products/".$pass; ?>" class="list-group-item text-secondary pb-0 pt-0 pl-2 pr-2
                      <?php
            if($type=="Product")
                echo "product-link";
            elseif($type=="Service")
                echo "service-link";
            ?>
"><?php echo $row[0]; ?></a>

    <?php    
    }
    ?>
        </ul>
      </div>
    </div>
  </div>
<?php
    }
                    ?>
</div>