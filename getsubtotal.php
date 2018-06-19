<?php
require_once  'data.php';

if(isset($_REQUEST["for_val"])!="" && isset($_REQUEST["sfor"])!="" && isset($_REQUEST["cat"])!="" && $_REQUEST["type"]=="sub") {
$sfor=$_REQUEST['sfor'];
$for_val=$_REQUEST['for_val'];
$cat=$_REQUEST['cat'];
echo Base::getSubtotal($for_val,$sfor,$cat);
}

if(isset($_REQUEST["for_val"])!="" && isset($_REQUEST["sfor"])!="" && isset($_REQUEST["cat"])!="" && $_REQUEST["type"]=="disp") {
$sfor=$_REQUEST['sfor'];
$for_val=$_REQUEST['for_val'];
$cat=$_REQUEST['cat'];
echo Base::getSubscriptionOff($for_val,$sfor,$cat);
}

?> 
