<?php
    require_once 'data.php';
?>
<div class="row">
    <div class="col-md-10" >
<div class="card" >
<!--
New Products
-->
<div class="card-body row" style="padding: 0px !important;">
    <div class="col-sm-12">
        <h5 class="page-header mx-5">
            <span style="border-bottom: 2px solid #e31e24;"><b>Food Items</b></span>
            <span class="float-right">
            <a href="<?php echo $root."Products/Food_Items"?>" style="font-size: 12px; " class="text-right" >View All</a>
            </span>
        
        </h5>
    </div>
      <!--hr style="border-color: #E31E24; color: #E31E24; border-width: 3px; border-top: #E31E24;" /-->
<section class="slider-food-items col-sm-12" style="margin-top: 3px;" >

                      <?php
                      $foodItems= $obj->foodSubCategories($city);
//                      print_r($foodItems);
                      
                    foreach ($foodItems as $item) {
//                        echo json_encode($item)."<br/><br />";

                        $img=$root."assets/images/small.png";
//                        if(!is_null($item->prod_id))

        $img=$root."assets/products-services/".$item["prod_img"];
          $pass= str_replace(" ", "_", $item["cs_name"]);
                                 ?>
                   
                            <div class=" card block-card-new" style="margin: 5px !important; ">
            <div class="card-img-top">
                <a class="" href="<?php
                echo $root."Products/$pass";
                ?>"
                >
                    <img height="150" width="320" class="img-fluid image-zoom slick-img"
             data-lazy="<?php echo $img; ?>"
             onError="this.onerror=null;this.src='http://www.homebiz365.in/uploads/images/small.png';" />
                </a>
            </div>
                                <div class="card-body" itemscope itemtype="http://schema.org/Product" style="padding: 10px;">
                <h6  class="truncate" style="font-size: 16px;" >
                                      <a href="<?php
                echo $root."Products/$pass";
                                      ?>" data-toggle="tooltip" 
                                         title="<?php echo $item["cs_name"]; ?>">
                                 <b><span itemprop="name"><?php echo $item["cs_name"]; ?></span></b>
                                      </a></h6>
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
</div>