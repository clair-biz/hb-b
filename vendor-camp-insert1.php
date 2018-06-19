<?php
require_once 'data.php';

    $camp_name = $_REQUEST["cname"];
    if(isset($_REQUEST["stdt"])!="") {
        $date = date_create($_REQUEST["stdt"]);
        $start_dt= date_format($date, "Y-m-d");
    }
    else
        $start_dt="";
    if(isset($_REQUEST["endt"])!="") {
        $date = date_create($_REQUEST["endt"]);
        $end_dt= date_format($date, "Y-m-d");
    }
    else
        $end_dt="";
    
    $u_id=Base::getuidbyuname($user->u_name);
 $m=new Campaign;
 $m->camp_name=$camp_name;
 $m->camp_start=$start_dt;
 $m->camp_end=$end_dt;
 $m->u_id=$u_id;
 $m->user=$user->u_name;
//echo $m->toString();
//if($m->canInsert())
//    $cc=$m->Insert();
if($m->insert()){
   $camp_id=Campaign::getcampidbyname($camp_name);
//   echo $camp_id;
   $v=Base::getcattypebyuname($user->u_name);
   if($v == 'Product') {
       echo "success";
   }
   else  {
echo 'error';
}
}
else {
echo "error";
}
?> 