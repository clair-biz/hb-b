<?php
require_once("data.php");
$domain=Base::domainName();

    if(!isset($_SESSION["user"]) || $_SESSION["user"]==null) {
if(isset($_REQUEST["serv"])!="") 
    setcookie("serv",$_REQUEST["serv"], time()+3600*24, "/", $domain);
 echo "login";
}

elseif( (isset($_REQUEST["serv"])!="" || isset($_COOKIE["serv"])!="") 
        && $user->cust_id!="" && isset($_SESSION["user"])) {
    echo 'here';
    if(isset($_REQUEST["serv"])!="")
        setcookie("serv",$_REQUEST["serv"], time()+3600*24, "/", $domain);

    $count=0;
$ord_id=Order::newServiceOrdId();
$cust_id= $user->cust_id;

if(isset($_COOKIE["serv"])!="")
$serv_id= $_COOKIE["serv"];

elseif(isset($_REQUEST["serv"])!="")
$serv_id= $_REQUEST["serv"];
$user= $user->u_name;

        if(Order::ServiceRequestOrder($ord_id,$cust_id,$serv_id,$user)) {
            setcookie("serv", "", time() - 3600, "/", $domain);
            echo "success-service";
        }
else 
	echo "error 1"; 
}
else {
	echo "error 0";
}
?>
