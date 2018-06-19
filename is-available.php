<?php
require_once 'data.php';

if(isset($_REQUEST["prod"]) && $_REQUEST["prod"]!="") {
$prod=$_REQUEST["prod"];
    if(Product::isAvailable($prod)>0)
        echo "ok";
    else
        echo "error";
}

if(isset($_REQUEST["serv"]) && $_REQUEST["serv"]!="") {
$serv=$_REQUEST["serv"];
    if(Service::isAvailable($serv)>0)
        echo "ok";
    else
        echo "error";
}
?>