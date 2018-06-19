<?php
require_once 'Classes/Classes.php';
$text=$_REQUEST["searchText"];
$type=$_REQUEST["group1"];
$location=Crm::root();
if($type=="product")
  $location.="Products/$text";  
elseif($type=="service")
  $location.="Services/$text";  

header("location:$location");
exit;
?>