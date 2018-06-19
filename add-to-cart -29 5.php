<?php
require_once 'data.php';
if(isset($_REQUEST["prod_id"])!="") {
 $prod_id=$_REQUEST['prod_id'];
 $qty=$_REQUEST['qty'];
 $slot=$_REQUEST['slot'];
 $reqd=$_REQUEST['reqd'];
 $cart_id="";
 
 if(isset($_REQUEST["cart_id"]))
     $cart_id=$_REQUEST["cart_id"];
 
$date= date_create($req_d);
$req_d= date_format($date, "Y-m-d");
 $check="";
 
 
$o=new Order();
$o->prod_id=$prod_id;
$o->bs_id=$slot;
$o->qty=$qty;
$o->req_on=$reqd;
$o->cart_id=$cart_id;

print_r($o);
if(isset($user)!="" && !empty($user)
 && $user->type=="customer") {
        $o->cust_id=$user->cust_id;
	if($o->CartInsert()) {
            echo "success";
        }
        
    }

else {
    if(isset($_SESSION["cart"])!="") {
     $array= unserialize($_SESSION["cart"]);
     $index=sizeof($array);
     $i=0;
     foreach ($array as $cart) {
         echo $cart->prod_id;
         echo $cart->req_on;
         echo $cart->bs_id;
         echo $cart->qty;
//         print_r($cart);
//         if($i<$index) {
         $k=1;
         if($cart->prod_id==$o->prod_id && $cart->req_on==$o->req_on && $cart->bs_id==$o->bs_id ) {
             echo "in same";
             unset($array[i]);
     $array[$i]=$o;
             $k=0;
             continue;
         }
         else {
             $i++;
             $k=1;
         }
     }
     echo $i;
     $o->type="guest";
     $o->cart_id=$i;
     if($k==1)
     $array[$i]=$o;
//     print_r($array);
//     print_r($_SESSION["cart"]);
    unset($_SESSION["cart"]);
//    print_r($array);
    echo "<br />";
    $_SESSION["cart"]= serialize($array);
//     print_r($_SESSION["cart"]);
      
     echo "success";
     print_r($_SESSION["cart"]);
 }
 elseif(isset($_SESSION["cart"])=="" || !isset($_SESSION["cart"])) {
     $array=array();
     $array[0]=$o;
     $o->type="guest";
     $o->cart_id=0;
//     print_r($array);
     $_SESSION["cart"]= serialize($array);
//     print_r($_SESSION["cart"]);
     echo "success";
}
else
    echo "nothing";
}    
}

elseif(isset($_REQUEST["serv"])!="" || isset($_COOKIE["serv"])!="") {
    if(isset($_REQUEST["serv"])!="")
    setcookie("serv",$_REQUEST["serv"], time()+3600*24, "/", $domain);

    echo "service";
}
 
?>