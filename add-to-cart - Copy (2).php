<?php
require_once 'data.php';
if(isset($_REQUEST["prod_id"])!="") {
 $prod_id=$_REQUEST['prod_id'];
 $qty=$_REQUEST['qty'];
 $slot=$_REQUEST['slot'];
 $reqd=$_REQUEST['reqd'];
$date= date_create($req_d);
$req_d= date_format($date, "Y-m-d");
 $check="";
 
 


if(isset($_SESSION["user"])!="" && !empty($_SESSION["user"])) {
    $user= json_decode($_SESSION["user"]);
    if($user->type=="customer") {
$o=new Order();
$o->prod_id=$prod_id;
$o->bs_id=$slot;
$o->qty=$qty;
$o->vs_id=Product::getvendidbyprodid($prod_id);
$o->req_on=$reqd;
	if($o->CartInsert()) {
            echo "success";
        }
        
    }
}

else {
$vs_id=Product::getvendidbyprodid($prod_id);
$o=array();
$o["prod_id"]=$prod_id;
$o["qty"]=$qty;

    if(isset($_SESSION["cart"])!="") {
     $array= json_decode($_SESSION["cart"]);
     print_r($array);
     $arrayvs=$array->vs_id;
     print_r(json_encode($arrayvs));
     $indexvs=0;
     
     foreach ($arrayvs as $vs) {
         $currentvs=$arrayvs[0];
         $indexbs=0;
         $arraybs=$vs->bs_id;
         
         foreach ($arraybs as $cart) {
             $currentbs=$arraybs[$indexbs];
         print_r(json_encode($cart));

         if($cart->prod_id==$prod_id
         && $currentvs==$vs_id
         && $currentreqd==$req_d
         && $currentbs==$slot)
             array_push($arraybs,$o);
             else
                 array_push ($arrayvs, array($slot=>$o));
         }
     }
     
     /*
     if(in_array( $o["prod_id"],$array)) {
     foreach ($array as $cart) {
         $i=array_search($cart, $array,true);
         echo "in array -$i-";
             $array[$i]->qty+=$o["qty"];
         else {
             array_push($array, $o);
             $i++;
         }
     }
     }
*/
//     $array[$i]= json_encode($obj);
//     print_r($array);
//     print_r($_SESSION["cart"]);
    $_SESSION["cart"]= json_encode($array);
//     print_r($_SESSION["cart"]);
      
     echo "success";
//     print_r($_SESSION["cart"]);
 }
 elseif(isset($_SESSION["cart"])=="" || !isset($_SESSION["cart"])) {
     $array=array();
//     array_push($array, $o);
//     print_r($array);
     $bs=$slot;
     $arraybs=array($bs=>$o);
     $arrayvs=array("bs_id"=>$arraybs);
     $array=array("vs_id"=>array($vs_id=>$arrayvs));
     $_SESSION["cart"]= json_encode($array);
     print_r($_SESSION["cart"]);
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