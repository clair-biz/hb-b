<?php
require_once 'data.php';
$reason=$_REQUEST["reason"];
$cust_id=$_REQUEST["cust_id"];
$name=Customer::getcustnamebyid($cust_id);
$email=Customer::getcustemailbyid($cust_id);
$q=" update customer set is_active='N',reason='$reason',upd_dt=now(),upd_usr='".$user->u_name."' where cust_id=$cust_id;";

$q.=" update users set is_active='N',reason='$reason',upd_dt=now(),upd_usr='".$user->u_name."' where cust_id=$cust_id;";
    
//    echo $q;

    if(Base::generateMultiResult($q) && Email::sendDisableMsg($name,$email,$reason)) {
        echo "ok";
    }
else {
        echo "not done";
        
}
    ?>