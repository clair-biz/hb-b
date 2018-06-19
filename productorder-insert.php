<?php
require_once("Classes/Classes.php");
$domain=Crm::domainName();

    if(!isset($_SESSION["user"]) || $_SESSION["user"]==null) {
if(isset($_REQUEST["prod_id"])!="") 
    setcookie("prod_id",$_REQUEST["prod_id"], time()+3600*24, "/", $domain);
 echo "login";
}

elseif( (isset($_REQUEST["prod_id"])!="" || isset($_COOKIE["prod_id"])!="") 
        && isset($_COOKIE["cust"])!="" && isset($_SESSION["user"])) {

    if(isset($_REQUEST["prod_id"])!="")
        setcookie("prod_id",$_REQUEST["prod_id"], time()+3600*24, "/", $domain);

    $count=0;
$ord_id=Order::newOrdId();
$cust_id= $_COOKIE["cust"];

if(isset($_COOKIE["prod_id"])!="")
$prod_id= $_COOKIE["prod_id"];

elseif(isset($_REQUEST["prod_id"])!="")
$prod_id= $_REQUEST["prod_id"];
$user= $_SESSION["user"];

        if(Order::RequestOrder($ord_id,$cust_id,$prod_id,$user)) {
            setcookie("prod_id", "", time() - 3600, "/", $domain);
            echo "ok";
        }
else 
	echo mysqli_error(Crm::con()); 
}
else {
	echo mysqli_error(Crm::con());
}
?>
