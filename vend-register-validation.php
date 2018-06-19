<?php
include 'data.php';

function isset_uname($uname){
    $fname1= trim($uname);
    $q="select count(*) as num from users where is_active='Y' and u_name='".$fname1."'";
//    echo $q;
    $r=Base::generateResult($q);
    $row=mysqli_fetch_array($r);
    if($row['num']>=1){
return true; // true if user exists
}
else{
return false;
}
}

function isset_bname($bname){
    $bname1= trim($bname);
    $q="select count(*) as num from users where is_active='Y' and disp_name='".$bname1."'";
//    echo $q;
    $r=Base::generateResult($q);
    $row=mysqli_fetch_array($r);
    if($row['num']>=1){
return true; // true if user exists
}
else{
return false;
}
}

function isset_cntc($cntc){
    $cntc1= trim($cntc);
    $q="select count(*) as num from vendor where is_active='Y' and vend_cntc=$cntc1 or vend_alt_cntc=$cntc1";
    $r=Base::generateResult($q);
    $row=mysqli_fetch_array($r);
    if($row['num']>=1){
return true; // true if user exists
}
else{
return false;
}
}


function isset_email($email1){
    $email= trim($email1);
    $q="select count(*) as num from vendor where is_active='Y' and vend_email='".$email."'";
    $r=Base::generateResult($q);
    $row=mysqli_fetch_array($r);
    if($row['num']>=1){
return true; // true if user exists
}
else{
return false;
}
}


function isset_dobemailcntc($email1,$cntc,$dob){
    $email= trim($email1);
    $cntc= trim($cntc);
    $date = date_create($dob);
    $dob= date_format($date, "Y-m-d");
    
    $q="select count(*) as num from vendor where is_active='Y' and vend_email='".$email."' and vend_dob=cast(N'$dob' as date) and vend_cntc=$cntc;";
    //    echo $q;
    $r=Base::generateResult($q);
    $row=mysqli_fetch_array($r);
    if($row['num']>=1){
        return true; // true if user exists
    }
    else{
        return false;
    }
}



if(isset($_REQUEST["uname"])) {
    if(!isset_uname($_REQUEST["uname"]))
        echo 'true';
    else
        echo 'false';
}

if(isset($_REQUEST["bname"])) {
    if(!isset_bname($_REQUEST["bname"]))
        echo 'true';
    else
        echo 'false';
}

/*
if(isset($_REQUEST["cntc"])) {
    if(!isset_cntc($_REQUEST["cntc"]))
        echo 'true';
    else
        echo 'false';
}

if(isset($_REQUEST["email1"])) {
    if(!isset_email($_REQUEST["email1"]))
        echo 'true';
    else
        echo 'false';
}
*/
    
    if(isset($_REQUEST["email1"])!="" && isset($_REQUEST["cntc"])!="" && isset($_REQUEST["dob"])!="" && !empty($_REQUEST["email1"]) && !empty($_REQUEST["cntc"]) && !empty($_REQUEST["dob"])) {
        if(!isset_dobemailcntc($_REQUEST["email1"],$_REQUEST["cntc"] , $_REQUEST["dob"]))
            echo 'true';
            else
                echo 'false';
    }
    
?>