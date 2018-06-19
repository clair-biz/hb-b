<?php
require_once 'data.php';
$query="select serv_file from service where serv_id=".$_REQUEST["id"];
$res=Base::generateResult($query);
$file1="";
if($row=mysqli_fetch_array($res)) {
    if(!is_null($row[0]))
$file1 = $root.'assets/service-pdf/'.$row[0];
}
echo $file1;
?>