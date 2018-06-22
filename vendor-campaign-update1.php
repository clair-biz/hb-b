<?php
require_once 'data.php';
       // SimpleDateFormat s=new SimpleDateFormat("yyyy-MM-dd");
       // SimpleDateFormat d=new SimpleDateFormat("dd/MM/yyyy");
    $camp_id=$_REQUEST["camp"];
    
    $camp_name="";
    $camp_start="";
    $camp_end="";

    if(isset($_REQUEST["cname"])!="" && !empty($_REQUEST["cname"]))
       $camp_name= $_REQUEST["cname"];
       if(!empty($_REQUEST["stdt"])!="") {
           $date = date_create($_REQUEST["stdt"]);
           $start_dt= date_format($date, "Y-m-d");
       }
       else
           $start_dt="";
           if(!empty($_REQUEST["endt"])!="") {
               $date = date_create($_REQUEST["endt"]);
               $end_dt= date_format($date, "Y-m-d");
           }
           else
               $end_dt="";
               //$user =$_SESSION["user"];
   $u_id=Base::getuidbyuname($user->u_name);
   $m=new Campaign;
 $m->camp_name=$camp_name;
 $m->camp_start=$start_dt;
 $m->camp_end=$end_dt;
 $m->u_id=$u_id;
 $m->user=$user->u_name;
   if($m->update($camp_id)>0) {       
       echo "success";
}
else {
	 echo "error";
    
}
?> 