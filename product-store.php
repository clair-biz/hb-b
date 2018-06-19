<?php
require_once 'Classes/Classes.php';

if(isset($_REQUEST["prod_id"])) {
//    setcookie("prod_id",$_REQUEST["prod"])
	$prod_id=$_REQUEST["prod_id"];
$_SESSION["prod_id"]=$prod_id;
$q="qty_$prod_id";
//if(isset($_REQUEST["prod_qty"]))
$qty=$_REQUEST[$q];
	$_SESSION["prod_qty"]=$qty;

$d="reqd_".$prod_id;
$req_d=$_REQUEST[$d];
	$_SESSION["req_d"]=$req_d;


	if($_SESSION["cust"]!=null )
	header("location:http://www.homebiz365.in/cart-insert.php");
	else
		header("location:http://www.homebiz365.in/Login");
}
?>