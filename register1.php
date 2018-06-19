<?php
require_once 'data.php';

$fname=$_REQUEST['fname'];
$uname=$_REQUEST['uname'];
$cntc=$_REQUEST['cntc'];
$alt=0;//$_REQUEST['alt'];
$email=$_REQUEST['email1'];
$pwd="";
if($_REQUEST['pwd']==$_REQUEST['cpwd'])
$pwd=$_REQUEST['pwd'];

$addr=$_REQUEST['addr'];
$zip=$_REQUEST['zip'];

if(isset($_REQUEST["dob"])!="") {
$date = date_create($_REQUEST["dob"]);
$dob= date_format($date, "Y-m-d");
}
else
    $dob="";

if(isset($_REQUEST["gen"])!="")
$gen=$_REQUEST['gen'];
else
    $gen="";

$usr=$fname;

$is_email_validated=Base::generateRandomString();

$m=new Customer();
    $m->cust_fname=$fname;
    $m->cust_cntc=$cntc;
    $m->is_cntc_validated=$is_cntc_validated;
    $m->cust_alt_cntc=$is_cntc_validated;
    $m->cust_email=$email;
    $m->is_email_validated=$is_email_validated;
    $m->cust_addr=$addr;
    $m->loc_zip=$zip;
    $m->cust_dob=$dob;
    $m->cust_gen=$gen;
    $m->u_name=$uname;
    $m->pwd=$pwd;
    
    $_SESSION["regobj"]= serialize($m);
//    if($_SESSION["vendor"]==$m)
            setcookie("captcha", "", time() - 3600, "/", $domain);
    echo "ok";

/*$c=new Customer($fname,$lname,$cntc,$alt,$email,$addr,$zip,$dob,$gen,$usr);
if($c->Insert()){
    $cust_id=Customer::getcustidbyemail($email);
    $vend_id=NULL;
    $u_type="Customer";
    if(Base::addUser($uname,$pwd,$u_type,$cust_id,$vend_id,$usr)) {
        if(Email::newUserVerification($usr,$email,$cust_id,"Customer")) {
    echo "ok";
        }
    else 
	echo "mail error ".mysqli_error(Base::con());
}
else {
	echo "user error ".mysqli_error(Base::con());
}
}
else {
	echo "customer error ".mysqli_error(Base::con());
}*/
?> 