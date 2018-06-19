<?php
    require_once 'data.php';
?>
<div class="row">
    <div class="col-md-10" >
<div class="card0" >
<!--
New Products
-->
<div class="card-body0 row" style="padding: 0px !important;">
    <div class="col-sm-12">
        <h5 class="page-header ml-5"><span style="border-bottom: 2px solid #e31e24;"><b>Products</b></span></h5>
    </div>
      <!--hr style="border-color: #E31E24; color: #E31E24; border-width: 3px; border-top: #E31E24;" /-->
<section class="slider-products col-sm-12" style="margin-top: 3px;" >

                      <?php
                      $products=$productCategoryList;
//                      print_r($products);
                      
                    foreach ($products as $item) {
//                        if($item["cat_name"]!="Food Items" && $item["cat_name"]!="Bakery Items") {
//                        echo json_encode($item)."<br/><br />";

                        $img=$root."assets/images/small.png";
//                        if(!is_null($item->prod_id))

        $img=$root."assets/category-imgs/".$item["cat_img"];
          $pass= str_replace(" ", "_", $item["cat_name"]);
                                 ?>
                <div >   
                <div >   
                            <div class=" card block-card-new" style="margin: 5px !important; ">
                                <div class="card-body" itemscope itemtype="http://schema.org/Product" style="padding: 10px;">
                <h5  class="truncate" style="font-size: 16px;" >
                                      <a href="<?php
                echo $root."Products/$pass";
                                      ?>" data-toggle="tooltip" 
                                      title="<?php echo $item["cat_name"]; ?>" class="text-dark">
                                 <b><span itemprop="name"><?php echo $item["cat_name"]; ?></span></b>
                                      </a>
                </h5>
            </div>
          </div>
                </div>
                </div>
                        <?php 
//                        }   
                    }
                    
                    ?>
      </section>
</div>
</div>
    </div>
      <div class="col-sm-2 advertisement-block" >
      </div>
</div>