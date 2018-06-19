<?php
require_once 'Classes/Classes.php';

if(isset($_REQUEST["serv"])) {
	$serv_id=$_REQUEST["serv"];
$_SESSION["serv"]=$serv_id;
	if(!is_null($_SESSION["cust"]))
	header("location:http://www.homebiz365.in/serviceorder-insert.php");
	else
		header("location:http://www.homebiz365.in/Login");
}
?>