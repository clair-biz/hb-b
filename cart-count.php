<?php
require_once('data.php');
$cartcount=0;
if(isset($_SESSION["user"])!="" && !empty($_SESSION["user"])) {
    $user= json_decode($_SESSION["user"]);
    if($user->type=="customer")
$cartcount=Order::getCountCart($user->cust_id);

}
elseif(isset($_SESSION["cart"])!="" && !empty($_SESSION["cart"])) {
    $cart= unserialize($_SESSION["cart"]);
    $cartcount= count($cart);
    
}

    echo $cartcount;
?>
