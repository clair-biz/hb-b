<?php
require_once 'data.php';

if(isset($_REQUEST["cart_id"]) && $_REQUEST["cart_id"]!="" ) {
$cart_id=$_REQUEST["cart_id"];
    
    if(isset($user)!="" && $user->cust_id!="") {
    
    $rst = Order::removeCartItem($cart_id);
//    out.print(rst);
           if($rst>0) { ?>
            <script>
                    var root=window.location.origin;
                    window.location.href=root+"/Cart";
           </script>
           <?php
    }
    }
    elseif(isset($_SESSION["cart"])!="") {
        $array= unserialize($_SESSION["cart"]);

        foreach ($array as $cart) {
            
            if($cart->cart_id==$cart_id) {
            $pos= array_search($cart, $array);

            unset($array[$pos]);
            $_SESSION["cart"]= serialize($array);
            ?>
            <script>
                    var root=window.location.origin;
                    window.location.href=root+"/Cart";
           </script>
           <?php
            
        }
    }
}
 }

if(isset($_REQUEST["cart_vend_id"]) && $_REQUEST["cart_vend_id"]!="") {
$cart_id=$_REQUEST["cart_vend_id"];
    $rst = Vendor::removeVendorCartItem($cart_id);
//    out.print(rst);
           if($rst>0) { ?>
            <script>
                    var root=window.location.origin;
                    window.location.href=root+"/VendorSubscriptions";
           </script>
           <?php
    }
    
}
?>