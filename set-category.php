<?php
require_once('data.php');
$domain=Base::domainName();
$vs_id=$_REQUEST["id"];

$user->vs_id=$vs_id;
$user->vs_type=Vendor::getcattypebyvsid($vs_id);
if($user->vs_type=="Product")
    $user->home_url="ProductsPage";
if($user->vs_type=="Service")
    $user->home_url="ServicesPage";

$_SESSION["user"]=serialize($user);
echo $user->vs_type;
?>
