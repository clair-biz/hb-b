<?php
require_once 'Classes/Classes.php';
$cart_id=$_REQUEST["cart_id"];
    if(Order::removeCartItem($cart_id))
               echo "ok";
           else
               echo "Unable to remove item from the cart!"
?>