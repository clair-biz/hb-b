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
$o->req_on=$req_d;
$o->cart_id=$cart_id;

//print_r($o);
if(isset($user)!="" && !empty($user)
 && $user->type=="customer") {
        $o->cust_id=$user->cust_id;
	if($o->CartInsert()) {
            echo "success";
        }
        
    }

else {
if(isset($_SESSION["cart"])=="" || !isset($_SESSION["cart"])) {
     $array=array();
     array_push($array,$o);
     $o->type="guest";
     $o->cart_id=count($array);
//     print_r($array);
     $_SESSION["cart"]= serialize($array);
//     print_r($_SESSION["cart"]);
     echo "success";
}

    elseif(isset($_SESSION["cart"])!="") {
     $array= unserialize($_SESSION["cart"]);
     $index=sizeof($array);
     
     print_r($_SESSION["cart"]);
     $k=0;
     foreach ($array as $cart) {
         if($cart->cart_id==$o->cart_id) {
             echo "in same cart";
         $pos= array_search($cart, $array);
//         unset($array[$pos]);
         $array[$pos]=$o;
         //array_push($array, $o,$pos);
         $k=1;
         }
         
     }
     if($k==0) {
         end($array);
         $key= key($array);
//         $pos=sizeof($array);
         $o->cart_id= ($array[$key]->cart_id)+1;
         array_push($array, $o);
     }
         $_SESSION["cart"]= serialize($array);
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