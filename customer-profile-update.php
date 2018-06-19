
<?php 
require_once 'data.php';
$errmsg="";
  //  try{_
$cust_id=$user->cust_id;

$fname="";
//$lname="";
$cntc="";
$email1="";
$addr="";
$dob="";
$gen="";
$zip="";


    if(isset($_REQUEST["fname"]) && !empty($_REQUEST["fname"]))
    $fname=$_REQUEST['fname'];
    if(isset($_REQUEST["cntc"]) && !empty($_REQUEST["cntc"]))
$cntc=$_REQUEST['cntc'];
$alt=0;
    if(isset($_REQUEST["emaill"]) && !empty($_REQUEST["emaill"]))
$email1=$_REQUEST['email1'];
$query="";


//echo $query;
    if(isset($_REQUEST["addr"]) && !empty($_REQUEST["addr"]))
$addr=$_REQUEST['addr'];
    if(isset($_REQUEST["zip"]) && !empty($_REQUEST["zip"]))
$zip=$_REQUEST['zip'];
    if(isset($_REQUEST["dob"]) && !empty($_REQUEST["dob"])) {
    $date = date_create($_REQUEST["dob"]);
    $dob= date_format($date, "Y-m-d");
        }
    if(isset($_REQUEST["gen"]) && !empty($_REQUEST["gen"]))
$gen=$_REQUEST['gen'];

$usr=$user->u_name;
//$uname="";
//$email1="";($cf,$cl,$cc,$cac,$ce,$ca,$lz,$cd,$cg,$usr)
$c=new Customer($fname,$cntc,$alt,$email1,$addr,$zip,$dob,$gen,$usr);
$c->cust_id=$cust_id;
$c->cust_fname=$fname;
$c->cust_cntc=$cntc;
$c->cust_email=$email1;
$c->cust_addr=$addr;
$c->loc_zip=$zip;
$c->cust_dob=$dob;
$c->cust_gen=$gen;
$c->user=$usr;

if($c->Update($cust_id))
echo "ok";
else
    echo "Update Unsuccessful";
    
?>