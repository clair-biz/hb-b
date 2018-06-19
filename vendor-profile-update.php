
<?php
require_once 'data.php';

$errmsg="";
  //  try{
$vend_id=Vendor::getvendidbyuname($user->u_name);

if(isset($_REQUEST["fname"])!="")
    $fname=$_REQUEST['fname'];
else
    $fname="";
/*
if(isset($_REQUEST["lname"])!="")
    $lname=$_REQUEST['lname'];
else
    $lname="";*/
if(isset($_REQUEST["email1"])!="")
    $vend_email=$_REQUEST['email1'];
else
    $vend_email="";

if(!empty($_REQUEST["vendname"]))
    $vendname=$_REQUEST['vendname'];
else
    $vendname="";

if(!empty($_REQUEST["vendname"])) {
    $vendname=$_REQUEST['vendname'];
}
else {
    $vendname="";
    $queryvend="";
}
if(isset($_REQUEST["cntc"])!="")
    $cntc=$_REQUEST['cntc'];
else
    $cntc="";

if(isset($_REQUEST["addr"])!="")
    $addr=$_REQUEST['addr'];
else
    $addr="";

if(isset($_REQUEST["zip"])!="")
    $zip=$_REQUEST['zip'];
else
    $zip="";


    
    if(isset($_REQUEST["dob"])!="") {
        $date = date_create($_REQUEST["dob"]);
        $dob= date_format($date, "Y-m-d");
    }
    else
        $dob="";
        
    

$query.=" where vs_id='".$user->vs_id."';";

$open="";
$close="";  
$sflag="";
$sdate="";
$fd="";
$td="";
$ci=0;
$as="";
$rs="";
//echo $zip;
//($vf,$vl,$vc,$vac,$ve,$va,$lz,$usr)
$m=new Vendor();
    $m->vend_fname=$fname;
    $m->vend_cntc=$vend_cntc;
    $m->vend_email=$vend_email;
    $m->vend_addr=$vend_addr;
        $m->loc_zip=$loc_zip;
    $m->vend_dob=$dob;
    $m->bname=$vendname;
    $m->u_name=$user->u_name;
    $m->vs_id=$user->vs_id;
//echo $c->toString();
if($m->Update($vend_id))
echo "ok";
else
    echo "Update Unsuccessful";
?>