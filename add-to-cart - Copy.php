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
     $arrayvs=$array["vs_id"];
     $indexvs=0;
         if(in_array($vs_id,$array["vs_id"])) {
     foreach ($arrayvs as $vs) {
         $arraybs=$vs["bs_id"];
         $currentvs=$arrayvs[$indexvs++];
         $indexbs=0;
         if($array["vs_id"][$currentvs]["bs_id"][$currentbs]==$slot) {
         foreach ($arraybs as $cart) {
             $currentbs=$arraybs[$indexbs++];
             if($prod_id==$cart["prod_id"]
                     && $currentbs==$slot
                     && $currentvs==$vs_id)
                 $array["vs_id"][$currentvs]["bs_id"][$currentbs]["qty"]+=$qty;
             else
                 array_push($array["vs_id"][$currentvs]["bs_id"][$currentbs],$o);
                 
                }
            }
             else
                 array_push($array["vs_id"][$currentvs]["bs_id"],array($currentbs=>$o));
        }
     }
             else
                 array_push($array["vs_id"],array($vs_id=>array("bs_id"=>array(["bs_id"]=>$o)) ) );
     /*
     if(in_array( $o["prod_id"],$array)) {
     foreach ($array as $cart) {
         $i=array_search($cart, $array,true);
         echo "in array -$i-";
         if($cart->prod_id==$o["prod_id"]
         && $cart->req_on==$o["req_on"]
         && $cart->bs_id==$o["bs_id"])
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
     $vs=$o["vs_id"];
     $bs=$o["bs_id"];
     $arrayobj=array("prod_id"=>$o["prod_id"],"qty"=>$o["qty"]);
     $arraybs=array($bs=>$arrayobj);
     $arrayvs=array("bs_id"=>$arraybs);
     $array=array("vs_id"=>$arrayvs);
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