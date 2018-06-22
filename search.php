<?php
require_once 'data.php';
$text=$_REQUEST["searchText"];
//$type=$_REQUEST["group1"];
$location=$root;
$type=Base::prodServRedirect($text);
$text= str_replace(" ", "_", $text);
$location.=$type."/".$text;
//echo $location;
echo json_encode(array("location"=>$location,"type"=>$type) );

?>
