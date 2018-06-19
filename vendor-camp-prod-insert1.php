<?php
require_once 'data.php';
        
    $camp_id = $_REQUEST["camp_id"];
    $prod_id=0;
    $prod_cat=0;
if(isset($_REQUEST["prod"])!="" && isset($_REQUEST["prod"])!=null)
    $prod_id= $_REQUEST["prod"];
if(isset($_REQUEST["pc"])!="")
    $cs_id= $_REQUEST["pc"];

    $prod_qty= $_REQUEST["qty"];
    $perc_disc= $_REQUEST["disc"];
    $disc_on= $_REQUEST["disc_on"];
    $unit= $_REQUEST["unit"];
$cc=0;
$c=new CampProd();
$c->camp_id=$camp_id;
$c->prod_id=$prod_id;
$c->prod_qty=$prod_qty;
$c->unit=$unit;
$c->disc_on=$disc_on;
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