<?php
require_once 'data.php';
        
    $camp_id = $_REQUEST["camp_id"];
    $serv_id=0;
    $serv_cat=0;
if(isset($_REQUEST["serv"])!="" && isset($_REQUEST["serv"])!=null)
    $serv_id= $_REQUEST["serv"];
if(isset($_REQUEST["pc"])!="")
    $cs_id= $_REQUEST["pc"];

    $perc_disc= $_REQUEST["disc"];
    $user= $_SESSION["user"];
$cc=0;
$c=new CampServ();
$c->camp_id=$camp_id;
$c->serv_id=$serv_id;
$c->perc_disc=$perc_disc;
$c->cs_id=$cs_id;
$c->user=$user->u_name;


//echo $c->toString()."<br />";
if($c->Insert()) {
    $sub=$_REQUEST["sub"];
    echo $sub;

    }
else {
    echo "error";
}

?>