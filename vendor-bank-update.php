<?php
require_once 'data.php';
       // SimpleDateFormat s=new SimpleDateFormat("yyyy-MM-dd");
       // SimpleDateFormat d=new SimpleDateFormat("dd/MM/yyyy");
$ac_no="";
if($_REQUEST["ac_no"]===$_REQUEST["reac_no"])
    $ac_no=$_REQUEST['ac_no'];
$reac_no=$_REQUEST['reac_no'];
$ac=$_REQUEST['ac'];
$aname=$_REQUEST['aname'];
$ifsc=$_REQUEST['ifsc'];
$pan=$_REQUEST['pan'];
$gst=$_REQUEST['gst'];
$uname=$user->u_name;
$u_id=Base::getuidbyuname($uname);

$q="";
if((Vendor::bankdetailsprovided($uname))){
    if($aname!="")
 $q.="update vend_bank set acc_no='$ac_no',upd_dt=now(), upd_usr='$uname' where vend_bank.u_id=$u_id";   
 $q.="update vend_bank set acc_hold_name='$aname',upd_dt=now(), upd_usr='$uname' where vend_bank.u_id=$u_id";   
 $q.="update vend_bank set acc_type='$ac',upd_dt=now(), upd_usr='$uname' where vend_bank.u_id=$u_id";   
 $q.="update vend_bank set ifsc_code='$ifsc',upd_dt=now(), upd_usr='$uname' where vend_bank.u_id=$u_id";   
 $q.="update vend_bank set pan_no='$pan',upd_dt=now(), upd_usr='$uname' where vend_bank.u_id=$u_id";   
 $q.="update vend_bank set gst_no='$gst',upd_dt=now(), upd_usr='$uname' where vend_bank.u_id=$u_id";   
}
 else{
     $q.="insert into vend_bank(u_id,acc_no,acc_hold_name,acc_type,ifsc_code,pan_no,gst_no,ins_dt,ins_usr) values ($u_id,'$ac_no','$aname','$ac','$ifsc','$pan','$gst',now(),'$uname')";
 }
 echo $q; 
if(Base::generateMultiResult($q)){
    echo "ok";
}
else{
    echo "error";
}
?> 