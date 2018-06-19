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
    <?php
                    foreach ($list as $item) {
//                        if($item["cat_name"]!="Food Items" && $item["cat_name"]!="Bakery Items") {
//                        echo json_encode($item)."<br/><br />";
                        //$img=$root."assets/images/small.png";
//                        if(!is_null($item->prod_id))

        //$img=$root."assets/category-imgs/".$item["cat_img"];
          $str="select distinct cs_name from cat_sub,category where cat_sub.cat_id=category.cat_id and cs_name<>'".$item["cat_name"]."' and cat_sub.cat_id='".$item["cat_id"]."';";
         // echo $str;
          $prodsub=Base::generateResult($str);                      
          ?>

  <div class="card">
    <div class="card-header pt-1 pb-1 pl-2 pr-2">
        <a class="card-link text-dark" style="font-weight: 500;" data-toggle="collapse" href="<?php echo "#collapse".$item["cat_id"]; ?>" > <?php echo $item["cat_name"]; ?>  </a>
      <!--a class="card-link" data-toggle="collapse" href="<?php //echo "#collapse".$item["cat_id"]; ?>" > <?php //echo $item["cat_name"]; ?>  </a>--
    </div>
    <!--div id="<?php// echo "collapse".$item["cat_id"]; ?>" class="collapse" data-parent="#accordion">
      <div class="card-body">
      <ul class="list-group list-group-flush" style="max-height: 20vh; overflow-y: auto; overflow-x: hidden">
    <?php
    /*
    while($row=mysqli_fetch_array($prodsub)){
          $pass= str_replace(" ", "_", $row["cs_name"]);
        ?>
        <a href="<?php echo $root."Products/".$pass; ?>" class="list-group-item"><?php echo $row[0]; ?></a>

    <?php    
    }*/
    ?>
        </ul>
      </div-->
    </div>
  </div>
<?php
                    }
                    ?>
</div>