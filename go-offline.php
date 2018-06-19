<?php
require_once('data.php');
if(isset($_REQUEST["from"])!="" && !empty($_REQUEST["to"]))
//$cartcount=Order::getCountCart($_COOKIE["cust"]);
$vs_id=$user->vs_id;


if(isset($_REQUEST["ofdate"])!="") {
$date = date_create($_REQUEST["ofdate"]);
$na_date= date_format($date, "Y-m-d");
if(Vendor::setOrderFullDate($user->vs_id,$na_date)) {
    echo "Orders Full set for ".$_REQUEST["of_date"]."";
}
}

if(isset($_REQUEST["from"])!="" && isset($_REQUEST["to"])!="") {
$date = date_create($_REQUEST["from"]);
$na_from= date_format($date, "Y-m-d");

$date = date_create($_REQUEST["to"]);
$na_to= date_format($date, "Y-m-d");

if(Vendor::setOfflinePeriod($user->vs_id,$na_from,$na_to)) {
echo "Offline Period set from ".$_REQUEST["from"]." to ".$_REQUEST["to"].".</p>";
    
}

}
?>
