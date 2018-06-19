<div class="container-fluid">
    <div class="row">
<?php
    $serviceList=$serviceCategoryList;
    $type="Service";
//    print_r($productsList);
//foreach($productsList as $row) {
//    print_r($row);
while($row = mysqli_fetch_assoc($serviceList)) {
    $cat_name=str_replace(" ", "_", $row["cat_name"]);
?>
        <div class="">
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
