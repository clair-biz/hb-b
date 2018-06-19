<html>
<body>
<?php
require_once 'data.php';

if(!empty($user->vs_id)) {
$vs_id=$user->vs_id;
$uname=$user->u_name;
$m=Base::getcattypebycatid(Vendor::getcatidbyvsid($vs_id));
?>
    <ul class="list-group" style="list-style-type: none">
                        <li class="list-group-item list-group-item-action disabled">
                            <h5>
                            <?php
                            echo Base::getcatnamebycatid(Vendor::getcatidbyvsid($vs_id));
                            ?>
                            </h5>
                        </li>
                        <li class=""><a class="list-group-item list-group-item-action" href="./">Home</a></li>

                        <li class=""><a class="list-group-item list-group-item-action" href="<?php
                  if(Vendor::countactiveSubscription($uname)>1)
                      echo $root."VendorDashboard";                  
                  if(Vendor::countactiveSubscription($uname)==1) {
		  
                  if(isset($uname)!="" && $uname!=null && Base::getUserType($uname)==1 
                          && Base::getcattypebycatid(Vendor::getcatidbyvsid($vs_id))=="Product")
                      echo $root."ProductsPage";
            
		  elseif(isset($uname)!="" && $uname!=null && Base::getUserType($uname)==1 
                          && Base::getcattypebycatid(Vendor::getcatidbyvsid($vs_id))=="Service")
                      echo $root."ServicesPage";
                  }

                        
                        ?>" >Dashboard</a></li>
                <?php 
                if($m == 'Product'){
                ?>
                <li class=""><a class="list-group-item list-group-item-action" href="<?php echo $root."OrdersPage"; ?>" >Orders</a></li>
                <li class=""><a class="list-group-item list-group-item-action" href="<?php echo $root."ProductsPage"; ?>" >Products</a></li>
                <li class=""><a class="list-group-item list-group-item-action" href="<?php echo $root."AddProduct"; ?>" >Add Product</a></li>
                <li class=""><a class="list-group-item list-group-item-action" href="<?php echo $root."ProductsPage"; ?>" >Update Product</a></li>
                <li class=""><a class="list-group-item list-group-item-action" href="<?php echo $root."MyOffers"; ?>">My Offers</a></li>
                <li class=""><a class="list-group-item list-group-item-action" href="<?php echo $root."MyOffers"; ?>">Add New Offer</a></li>
                <li class=""><a class="list-group-item list-group-item-action" href="<?php echo $root."MyOffers"; ?>">Link Products to Offer</a></li>
                <li class=""><a class="list-group-item list-group-item-action" href="<?php echo $root."MyOffers"; ?>">Update Offer</a></li>
                    <?php 
                }
                else{
                    ?>
                <li class=""><a class="list-group-item list-group-item-action" href="<?php echo $root."ServicesPage"; ?>" >Services</a></li>
                <li class=""><a class="list-group-item list-group-item-action" href="<?php echo $root."AddService"; ?>" >Add Service</a></li>
                <li class=""><a class="list-group-item list-group-item-action" href="<?php echo $root."ServicesPage"; ?>" >Update Service</a></li>
                <li class=""><a class="list-group-item list-group-item-action" href="<?php echo $root."MyOffers"; ?>">My Offers</a></li>
                <li class=""><a class="list-group-item list-group-item-action" href="<?php echo $root."MyOffers"; ?>">Add New Offer</a></li>
                <li class=""><a class="list-group-item list-group-item-action" href="<?php echo $root."MyOffers"; ?>">Link Services to Offer</a></li>
                <li class=""><a class="list-group-item list-group-item-action" href="<?php echo $root."MyOffers"; ?>">Update Offer</a></li>

                    <?php
                    
                }
                    ?>
                </ul>   
    
    <?php 
    }
?>
</body>
</html>