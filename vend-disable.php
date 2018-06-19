<?php
require_once 'data.php';
$reason=$_REQUEST["reason"];
$vs_id=$_REQUEST["vs_id"];
$vend_id=Vendor::getvendidbyvsid($vs_id);
$name=Vendor::getvendnamebyid($vend_id);
$email=Vendor::getvendemailbyvendid($vend_id);
$q="";
if(Vendor::getcountofaccounts($vend_id)==1)
    $q.=" update vendor set is_active='N',reason='$reason',upd_dt=now(),upd_usr='".$user->u_name."' where vend_id=$vend_id;";
if(Vendor::getcountofaccounts($vend_id)>=1)
    $q.=" update users set is_active='N',reason='$reason',upd_dt=now(),upd_usr='".$user->u_name."' where vend_id=$vend_id;";
    
//    echo $q;

    if(Base::generateMultiResult($q) && Email::sendDisableMsg($name,$email,$reason)) {
        echo "ok";
    }
else {
    echo "not done";
}
    ?>