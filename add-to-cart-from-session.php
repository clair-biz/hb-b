<?php
require_once 'data.php';

 
 if(isset($_SESSION["user"])!="" && !empty($_SESSION["user"])
 && $user->type=="customer" && !empty($user->cust_id)
 && isset($_SESSION["cart"])!="" && !empty($_SESSION["cart"])) {
     echo "<script>console.log(". json_encode($user).");</script>";
     
     $array= unserialize($_SESSION["cart"]);
     $index=sizeof($array);
//     echo $index;
     $array[$index]=$o;
     $i=0;
     $array2=Array();
     $j=0;
     foreach ($array as $obj) {
         if($obj!="" && $obj instanceof Order) {
             $obj->cust_id=$user->cust_id;
         if($obj->CartInsert()) {
             $i++;
         }
         else {
             $array2[$j]=$obj;
             $j++;
         }
     }
     }
     if($i==$index) {
         unset($_SESSION["cart"]);
         echo "product-success";
     }
     else
     $_SESSION["cart"]= serialize($array2);
 }
 elseif(isset($_SESSION["user"])!="" && !empty($_SESSION["user"])
 && isset($_COOKIE["serv"])!="" && !empty($_COOKIE["serv"])) {
     echo "service";
 }
 else
     echo "nothing";
?>