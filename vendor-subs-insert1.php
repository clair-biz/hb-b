<?php
require_once 'data.php';

    if(isset($_REQUEST["bname"])!="" )
    $bname = $_REQUEST["bname"];
    else
        $bname=Vendor::getvendnamebyunamebyvendor($_SESSION["user"]);
    
    if(isset($_REQUEST["fssai"])!="" )
    $fssai_no = $_REQUEST["fssai"];
    else
        $fssai_no="";
    
    $vend_open_time="";
    $vend_close_time="";
    if(!empty($_REQUEST["otime"]) && !empty($_REQUEST["ctime"]))
    if(!empty($_REQUEST["otime"])) {
$var= substr($_REQUEST["otime"], -2);
$vend_open_time= str_replace($var," $var",$_REQUEST["otime"]);
$vend_open_time= date('H:i:s',strtotime($vend_open_time));
}

if(!empty($_REQUEST["ctime"])) {
    $var= substr($_REQUEST["ctime"], -2);
$vend_close_time= str_replace($var," $var",$_REQUEST["ctime"]);
$vend_close_time= date('H:i:s',strtotime($vend_close_time));
}

    $cat_name="";
    $cat_id=0;
    $cat_type=$_REQUEST["cat_type"];
    switch ($cat_type) {
        case "Product":
                        if(isset($_REQUEST["catp"]) && $_REQUEST["catp"]!=0)
                        $cat_id=$_REQUEST["catp"];
                        elseif(isset($_REQUEST["catp"]) && $_REQUEST["catp"]==0 && isset($_REQUEST["cat_p"])!="")
                        $cat_name=$_REQUEST["cat_p"]." in $cat_type";
                        break;
        case "Service":
                        if(isset($_REQUEST["cats"]) && $_REQUEST["cats"]!=0)
                        $cat_id=$_REQUEST["cats"];
                        elseif(isset($_REQUEST["cats"]) && $_REQUEST["cats"]==0  && isset($_REQUEST["cat_s"])!="")
                        $cat_name=$_REQUEST["cat_s"]." in $cat_type";
                        break;
    }

    $city_served="";
    if(isset($_REQUEST["city"]) && $_REQUEST["city"]!="0")
    $city_served=$_REQUEST["city"];
    elseif(isset($_REQUEST["city"]) && $_REQUEST["city"]=="0" && isset($_REQUEST["city_c"])!="") {
      $city_served=$_REQUEST["city_c"];
      }

//      echo $city_served;
//echo "cat ".$cat_name;
    $vs_for=$_REQUEST["for_val"]." ".$_REQUEST["for"];


   // $deli=$_REQUEST["deli"];
//    $cat1=$_REQUEST["cat1"];
$user=$user->u_name;
$u_id=Base::getuidbyuname($user);
/*$vend_id=Vendor::getvendidbyuname($user);
$vend_cntc=Vendor::getvendcntcbyuname($user);
    $cust_id=NULL;
    $u_type="Vendor";
//    echo $vend_id;*/
    $m=new Vendor();
    $m->u_id=$u_id;
    $m->cat_id=$cat_id;
    $m->bname=$bname;
    $m->fssai_no=$fssai_no;
    $m->other_cat=$cat_name;
    $m->vend_open_time=$vend_open_time;
    $m->vend_close_time=$vend_close_time;
    $m->city_served=$city_served;
    $m->vs_for=$vs_for;
    
    if($m->vendorCart()){
        
    $n=$_REQUEST['btn'];
if($n == 'submit')    
    echo "ok";
elseif($n == 'more')    
    echo "more";
}
else
    echo "Unable to add subscription";
?> 