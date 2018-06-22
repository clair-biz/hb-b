<?php
    require_once 'data.php';
    
                      $type=$_COOKIE["type"];//$_REQUEST["type"];
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
        <div class="card-header p-3">Services</div>
    </div>
    <?php
    if(!empty($list)) {
                    foreach ($list as $item) {
//                        if($item["cat_name"]!="Food Items" && $item["cat_name"]!="Bakery Items") {
//                        echo json_encode($item)."<br/><br />";
                        //$img=$root."assets/images/small.png";
//                        if(!is_null($item->prod_id))

        //$img=$root."assets/category-imgs/".$item["cat_img"];
//          $str="select distinct cs_name from cat_sub,category where cat_sub.cat_id=category.cat_id and cs_name<>'".$item["cat_name"]."' and cat_sub.cat_id='".$item["cat_id"]."';";
         // echo $str;
//          $prodsub=Base::generateResult($str);                      
          $pass= str_replace(" ", "_", $item["cat_name"]);
          ?>

  <div class="card border-0">
    <div class="card-body pt-1 pb-1 pl-2 pr-2">
        <a data-message="<?php echo $root."Services/".$pass; ?>" class="list-group-item text-secondary pb-0 pt-0 pl-2 pr-2
                      <?php
            if($type=="Product")
                echo "product-link";
            elseif($type=="Service")
                echo "service-link";
            ?>
"><?php echo $item["cat_name"]; ?>
        </a>
    </div>
  </div>
<?php
                    }
                    }
                    
                    else
//                        echo "<script>window.location.href=window.location.origin;</script>";
                    ?>
</div>