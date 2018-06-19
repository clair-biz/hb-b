<?php
    require_once 'data.php';
?>
<div class="row">
    <div class="col-md-12" >
<div class="card0" >
<!--
New Products
-->
<div class="card-body0 row" style="padding: 0px !important;">
    <div class="col-sm-12">
        <h5 class="page-header ml-5"><span style="border-bottom: 2px solid #e31e24;">
            <?php
                $type=$_REQUEST["type"];
                if($type== 'Product'){
                    ?>
                 <b>Our Product Categories</b>   
                <?php
                 }
                elseif($type== 'Service'){
                ?>
                 <b>Our Service Categories</b>
                 <?php
                }
                ?>
</span>
        </h5>
    </div>
      <!--hr style="border-color: #E31E24; color: #E31E24; border-width: 3px; border-top: #E31E24;" /-->
<section class="product-category col-sm-12" style="margin-top: 3px;" >
    <div class="row">
                      <?php
                      //$type=$_REQUEST["type"];
                      switch($type){
                          case 'Product':
                                          $list=$productCategoryList;
                                            break;
                          case 'Service':
                                          $list=$serviceCategoryList;
                                            break;
                              }
//                      print_r($products);
                      
                    foreach ($list as $item) {
//                        if($item["cat_name"]!="Food Items" && $item["cat_name"]!="Bakery Items") {
//                        echo json_encode($item)."<br/><br />";
                        $img=$root."assets/images/small.png";
//                        if(!is_null($item->prod_id))

        $img=$root."assets/category-imgs/".$item["cat_img"];
          $str="select distinct cs_name from cat_sub,category where cat_sub.cat_id=category.cat_id and cs_name<>'".$item["cat_name"]."' and cat_sub.cat_id='".$item["cat_id"]."';";
//         echo $str;
          $prodsub=Base::generateResult($str);                      
          $pass= str_replace(" ", "_", $item["cat_name"]);
          ?>
    
        <div class="col-md-3 mb-5" style="min-height: 340px; max-height: 340px;">
    <div class="card" >
        <img class="card-img-top" src="<?php echo $img; ?>" alt="Card image">
        <div class="card-body p-0">
        <a class="logo-color-b p-3 <?php
            if($type=="Product")
                echo "product-link";
            elseif($type=="Service")
                echo "service-link";
            echo " list-group-item "; 
            ?>" style="border: none; font-weight: 600;" href="#" data-message="<?php
            if($type=="Product")
            echo $root."Products/".$pass;
            elseif($type=="Service")
            echo $root."Services/".$pass;
            ?>" >
            <?php echo $item["cat_name"]; ?>
        </a>
        <ul class="list-group list-group-flush" style="max-height: 20vh; overflow-y: auto; overflow-x: hidden">
    <?php
    while($row=mysqli_fetch_array($prodsub)){
          $pass= str_replace(" ", "_", $row["cs_name"]);
        ?>
        <a class="text-dark p-1 <?php
            if($type=="Product")
                echo "product-link";
            elseif($type=="Service")
                echo "service-link";
            echo " list-group-item";
            ?>" href="#" data-message="<?php
            if($type=="Product")
            echo $root."Products/".$pass;
            elseif($type=="Service")
            echo $root."Services/".$pass;
            ?>"  >
<?php echo $row[0]; ?></a>

    <?php    
    }
    ?>
        </ul>
  </div>
</div>
    </div>

                        <?php 
//                        }   
                    }
                    
                    ?>
</div>
      </section>
</div>
</div>
    </div>
      <div class="col-sm-2 advertisement-block" >
      </div>
</div>