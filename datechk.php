<?php
require_once 'data.php';
$ret="false";
 $prod=$_REQUEST['prod'];
$date = date_create($_REQUEST["req_dt"]);
$req_dt= date_format($date, "Y-m-d");
//print_r($req_dt);
  //echo Crm::getDiscount($prod,$qty,$unit);
$type=$_REQUEST["type"];
switch($type) {
    case "lead": {
$todate="";
 $q="select count(*) from product where cast(N'".$req_dt."' as date)>= date_add(now(), interval prod_min_time day) and prod_id=$prod";
 echo $q;
 $pq=Base::generateResult($q);
 if($row=mysqli_fetch_array($pq)){
     if($row[0]>0)
    $ret="true";
        }
    }
    break;
    case "full" : {
//        echo "in full";
 $q="select count(ord_full_date) from prod_date where prod_id=$prod and ord_full_date=cast(N'".$req_dt."' as date);";
// echo $q;
 $pq=Base::generateResult($q);
 if($row=mysqli_fetch_array($pq)){
        if($row[0]==0)
            $ret="true";
        }
    }
    break;
}
      echo $ret;

?>