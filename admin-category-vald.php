<?php
include 'data.php';

function isset_micat($micat){
    $fname1= trim($micat);
    $q="select count(*) as num from category where cat_name='$fname1'";
    echo $q;
    $r=Base::generateResult($q);

    //$r=mysqli_query(Crm::con(),$q);
    $row=mysqli_fetch_array($r);
    if($row['num']>=1){
return true; // true if user exists
}
else{
return false;
}
}

function isset_mucat($mucat,$mucatid){
    $mucat= trim($mucat);
    $q="select count(*) as num from category where cat_name='$mucat' and cat_id<>$mucatid";
//    echo $q;
    $r=Base::generateResult($q);

    //$r=mysqli_query(Crm::con(),$q);
    $row=mysqli_fetch_array($r);
    if($row['num']>=1){
return true; // true if user exists
}
else{
return false;
}
}

function isset_sicat($sicat,$sicatid){
    $sicat= trim($sicat);
    $q="select count(*) as num from cat_sub where cs_name='$sicat' and cat_id=$sicatid";
//    echo $q;
    $r=Base::generateResult($q);
    //$r=mysqli_query(Crm::con(),$q);
    $row=mysqli_fetch_array($r);
    if($row['num']>=1){
return true; // true if user exists
}
else{
return false;
}
}

function isset_sucat($sucat,$sucatid){
    $sucat= trim($sucat);
    $q="select count(*) as num from cat_sub where cs_name='$sucat' and cs_id<>$sucatid";
//    echo $q;
    $r=Base::generateResult($q);
    //$r=mysqli_query(Crm::con(),$q);
    $row=mysqli_fetch_array($r);
    if($row['num']>=1){
return true; // true if user exists
}
else{
return false;
}
}

function isset_mdcatid($mdcatid){
    $mdcatid= trim($mdcatid);
    $q="select count(*) as num from category,vend_subscription where vend_subscription.cat_id=category.cat_id and now() between vs_from and vs_to and category.cat_id=$mdcatid;";
//    echo $q;
    $r=Base::generateResult($q);
    //$r=mysqli_query(Crm::con(),$q);
    $row=mysqli_fetch_array($r);
    if($row['num']>=1){
return true; // true if user exists
}
else{
return false;
}
}

function isset_sdcatid($sdcatid){
    $sdcatid= trim($sdcatid);
    $type=Crm::getcattypebycsid($sdcatid);
    $q="";
    if($type=="Product")
    $q="select count(*) as num from cat_sub,product where product.cs_id=cat_sub.cs_id and cat_sub.cs_id=$sdcatid;";
    if($type=="Service")
    $q="select count(*) as num from cat_sub,service where service.cs_id=cat_sub.cs_id and cat_sub.cs_id=$sdcatid;";
//    echo $q;
    //$r=mysqli_query(Crm::con(),$q);
    $r=Base::generateResult($q);
    $row=mysqli_fetch_array($r);
    if($row['num']>=1){
return true; // true if user exists
}
else{
return false;
}
}



/*function isset_sucat($sucat){
    $email1= trim($sucat);
    $q="select count(*) as num from cat_sub where cs_name='".mysqli_real_escape_string(Crm::con(),$email1)."'";
    $r=mysqli_query(Crm::con(),$q);
    $row=mysqli_fetch_array($r);
    if($row['num']>=1){
return true; // true if user exists
}
else{
return false;
}
}
*/

if(isset($_REQUEST["micat"])) {
    if(!isset_micat($_REQUEST["micat"]))
        echo 'true';
    else
        echo 'false';
}
if(isset($_REQUEST["mucat"])!="" && isset($_REQUEST["mucatid"])!="") {
    if(!isset_mucat($_REQUEST["mucat"],$_REQUEST["mucatid"]))
        echo 'true';
    else
        echo 'false';
}

if(isset($_REQUEST["sucat"])!="" && isset($_REQUEST["sucatid"])!="") {
    if(!isset_sucat($_REQUEST["sucat"],$_REQUEST["sucatid"]))
        echo 'true';
    else
        echo 'false';
}

if(isset($_REQUEST["sicat"])!="" && isset($_REQUEST["sicatid"])!="") {
    if(!isset_sicat($_REQUEST["sicat"],$_REQUEST["sicatid"]))
        echo 'true';
    else
        echo 'false';
}

if(isset($_REQUEST["mdcatid"])!="") {
    if(!isset_mdcatid($_REQUEST["mdcatid"]))
        echo 'true';
    else
        echo 'false';
}

if(isset($_REQUEST["sdcatid"])!="") {
    if(!isset_sdcatid($_REQUEST["sdcatid"]))
        echo 'true';
    else
        echo 'false';
}

/*if(isset($_REQUEST["sicat"])) {
    if(!isset_sicat($_REQUEST["sicat"]))
        echo 'true';
    else
        echo 'false';
}*/

/*if(isset($_REQUEST["sucat"])) {
    if(!isset_sucat($_REQUEST["sucat"]))
        echo 'true';
    else
        echo 'false';
}*/

?>