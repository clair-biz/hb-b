<html>
<body>
<?php
require_once 'data.php';
?>
<ul class="list-group">
                        <li class="list-group-item list-group-item-heading">
                            <h5>My Account</h5>
                        </li>
                        <li class="list-group-item">
                            <a href="<?php
                            echo $root;
                            switch ($user->type) {
                                case "vendor": echo "VendorProfile";
                                    break;
                                case "customer": echo "CustomerProfile";
                                    break;
                            }
                        ?>">My Profile</a>
                        </li>
                        <li class="list-group-item">
                            <a href="<?php echo $root."ChangePassword/".$user->u_name; ?>">Change Password</a>
                        </li>
                        <?php
                        if($user->type == "customer") { ?>
                        <li class="list-group-item"><a href="<?php echo $root."MyOrders/"; ?>">My Orders</a>
                            
                        <?php 
                        }
                        ?>
</ul>
</body>
</html>