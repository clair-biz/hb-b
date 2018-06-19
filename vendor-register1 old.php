<?php
require_once 'Classes/Classes.php';
       // SimpleDateFormat s=new SimpleDateFormat("yyyy-MM-dd");
       // SimpleDateFormat d=new SimpleDateFormat("dd/MM/yyyy");

    $vend_fname = $_REQUEST["fname"];
    
$user=$vend_fname;

    
    $uname = $_REQUEST["uname"];
    $vend_cntc =$_REQUEST["cntc"];

    $vend_email=$_REQUEST["email1"];
    $pwd="";
    if($_REQUEST["pwd"]===$_REQUEST["cpwd"])
        $pwd=$_REQUEST["pwd"];
    $vend_addr= $_REQUEST["addr"];
    $loc_zip= $_REQUEST["zip"];

    
    if(isset($_REQUEST["dob"])!="") {
        $date = date_create($_REQUEST["dob"]);
        $dob= date_format($date, "Y-m-d");
    }
    else
        $dob="";
        
    $is_cntc_validated=Crm::generateRandomString();
    $is_email_validated=Crm::generateRandomString();
    

    $m=new Vendor();
    $m->vend_fname=$vend_fname;
    $m->vend_cntc=$vend_cntc;
    $m->is_cntc_validated=$is_cntc_validated;
    $m->vend_email=$vend_email;
    $m->is_email_validated=$is_email_validated;
    $m->vend_addr=$vend_addr;
    $m->loc_zip=$loc_zip;
    $m->vend_dob=$dob;
    
//echo $m->toString();
//if($m->canInsert())
//    $cc=$m->Insert();
if($m->insert()){
    $vend_id=Vendor::getvendidbyecd($vend_email,$vend_cntc,$dob);
    $cust_id=NULL;
    $u_type="Vendor";
//    echo $vend_id;
    if(Crm::addUser($uname,$pwd,$u_type,$cust_id,$vend_id)) {
        if(Email::newEmailVerification($user,$vend_email,$uname,$vend_id,"Vendor") /*&& Sms::newCntcVerification($vend_cntc,$is_cntc_validated)*/) 
            echo "ok";
    }
    else
        echo "Unable to add user";
}
else {
    echo "insert error";
	echo mysqli_error(Crm::con());
}
?> 