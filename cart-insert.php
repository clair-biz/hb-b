<?php
require_once('Classes/Classes.php');
$domain=Crm::domainName();
if(isset($_SESSION["user"])=="" ) {
    if(isset($_REQUEST["prod_id"])!="" && !is_null($_REQUEST["prod_id"]))
    setcookie("prod_id",$_REQUEST["prod_id"], time()+3600*24, "/", $domain);
    if(isset($_REQUEST["qty"])!="" && !is_null($_REQUEST["qty"]))
    setcookie("qty",$_REQUEST["qty"], time()+3600*24, "/", $domain);
    if(isset($_REQUEST["slot"])!="" && !is_null($_REQUEST["slot"]))
    setcookie("slot",$_REQUEST["slot"], time()+3600*24, "/", $domain);

/*    if(isset($_REQUEST["unit"])!="" && !is_null($_REQUEST["unit"]))
    setcookie("unit",$_REQUEST["unit"]);
    */
//    if(Product::getcatnamebyid($_REQUEST["prod_id"])=="Food Items") {
    if(isset($_REQUEST["reqd"])!="" && !is_null($_REQUEST["reqd"])) {
    setcookie("reqd",$_REQUEST["reqd"], time()+3600*24, "/", $domain);
    }
/*    }
    else {
        
    }*/
    echo "login";

}
elseif(isset($_REQUEST["serv"])!="" || isset($_COOKIE["serv"])!="") {
    if(isset($_REQUEST["serv"])!="")
    setcookie("serv",$_REQUEST["serv"], time()+3600*24, "/", $domain);

    echo "service";
}

elseif( (isset($_REQUEST["prod_id"])!="" || isset($_COOKIE["prod_id"])!="") 
    && (isset($_REQUEST["qty"])!="" || isset($_COOKIE["qty"])!="")
    && (isset($_REQUEST["slot"])!="" || isset($_COOKIE["slot"])!="")
    && (isset($_REQUEST["reqd"])!="" || isset($_COOKIE["reqd"])!="")
        && isset($_COOKIE["cust"])!="" && isset($_SESSION["user"])) {

if(isset($_REQUEST["prod_id"])!="") {
    setcookie("prod_id",$_REQUEST["prod_id"], time()+3600*24, "/", $domain);
    $prod_id=$_REQUEST["prod_id"];
}
elseif(isset($_COOKIE["prod_id"])!="")
    $prod_id=$_COOKIE["prod_id"];


if(isset($_REQUEST["qty"])!="") {
    setcookie("qty",$_REQUEST["qty"], time()+3600*24, "/", $domain);
    $qty=$_REQUEST["qty"];
}
elseif(isset($_COOKIE["qty"])!="")
    $qty=$_COOKIE["qty"];

if(isset($_REQUEST["slot"])!="") {
    setcookie("slot",$_REQUEST["slot"]);
    $slot=$_REQUEST["slot"];
}
elseif(isset($_COOKIE["slot"])!="")
    $slot=$_COOKIE["slot"];

if(isset($_REQUEST["reqd"])!="") {
    setcookie("reqd",$_REQUEST["reqd"], time()+3600*24, "/", $domain);
    $req_d=$_REQUEST["reqd"];
}
elseif(isset($_COOKIE["reqd"])!="")
    $req_d=$_COOKIE["reqd"];

$date= date_create($req_d);
$req_d= date_format($date, "Y-m-d");
$rate=0;
$ord_id=0;
$cust_id=$_COOKIE["cust"];//$_REQUEST["prod_id"];
$user=$_SESSION["user"];//$_REQUEST["prod_qty"];


/*
echo "<br />c-".$cust_id;
echo "<br />p-".$prod_id;
echo "<br />q-".$qty;
echo "<br />r-".$rate;
echo "<br />o-".$ord_id;
echo "<br />d-".$req_d;
echo "<br />u-".$user;*/
       $o=new Order();
       $o->cust_id=$cust_id;
       $o->prod_id=$prod_id;
       $o->req_on=$req_d;
       $o->bs_id=$slot;
       $o->qty=$qty;
       $o->rate=$rate;
       $o->user=$user;
	if($o->CartInsert()) {
            setcookie("prod_id", "", time() - 3600, "/", $domain);
            setcookie("qty", "", time() - 3600, "/", $domain);
            setcookie("slot", "", time() - 3600, "/", $domain);
            setcookie("reqd", "", time() - 3600, "/", $domain);
            echo "ok";
        }
else 
	echo "insert error".mysqli_error(Crm::con()); 
}
else {
	echo mysqli_error(Crm::con());
}
?>
