<div class="container-fluid">
    <div class="row">
<?php
    $productsList=$productCategoryList;
    $type="Product";
//    print_r($productsList);
//foreach($productsList as $row) {
//    print_r($row);
while($row = mysqli_fetch_assoc($productsList)) {
    $cat_name=str_replace(" ", "_", $row["cat_name"]);
?>
        <div class="col-md-12">
            <a class="dropdown-item
               <?php
                           if($type=="Product")
                        echo "product-link";
                    elseif($type=="Service")
                        echo "service-link";
                    ?>
                " href="#"
                data-message="<?php
                    if($type=="Product")
                    echo $root."Products/".$cat_name;
                    elseif($type=="Service")
                    echo $root."Services/".$cat_name;
                    ?>" >
                        <?php echo $row["cat_name"];?>
            </a>
        </div>
  <?php 
   }
   ?>
    </div>
</div>
    