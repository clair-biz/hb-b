<?php
require_once  'data.php';

if(isset($_REQUEST["for_val"])!="" && isset($_REQUEST["sfor"])!="" && isset($_REQUEST["cat"])!="") {
$sfor=$_REQUEST['sfor'];
$for_val=$_REQUEST['for_val'];
$cat=$_REQUEST['cat'];
echo Base::getTax($for_val,$sfor,$cat);

}

?> 