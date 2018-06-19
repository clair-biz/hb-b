<?php
require_once 'data.php';

$sms_otp=$_REQUEST["sms_otp"];
    print_r($_SESSION["regobj"]);
//echo $sms_otp;
$obj= unserialize($_SESSION["regobj"]);
if($obj->is_cntc_validated==$sms_otp) {
    $obj->is_cntc_validated="Y";
if($obj instanceof Vendor){
    $obj->vend_id=Base::getAIValue("vendor");
    if($obj->Insert()){
    $cust_id=NULL;
    $u_type="Vendor";
    $uname=$obj->u_name;
//    echo $vend_id;
    if(Base::addUser($obj->u_name,$obj->pwd,$u_type,$cust_id,$vend_id)) {
        if(Email::newEmailVerification($obj->vend_fname,$obj->vend_email,$obj->u_name,$vend_id,$u_type) /*&& Sms::newCntcVerification($vend_cntc,$is_cntc_validated)*/) 
            echo "ok";
    }
    else
        echo "Unable to add user";
}
else {
    echo "insert error";
}


}
elseif ($obj instanceof Customer) {
    if($obj->insert()){
    $cust_id=Customer::getcustidbyecd($obj->cust_email,$obj->cust_cntc,$obj->cust_dob);
    $vend_id=NULL;
    $u_type="Customer";
    $uname=$obj->u_name;
//    echo $vend_id;
    if(Base::addUser($obj->u_name,$obj->pwd,$u_type,$cust_id,$vend_id)) {
        if(Email::newEmailVerification($obj->u_name,$obj->cust_email,$obj->u_name,$cust_id,$u_type) /*&& Sms::newCntcVerification($vend_cntc,$is_cntc_validated)*/) 
            echo "ok";
    }
    else
        echo "Unable to add user";
}
else {
    echo "insert error";
}
   

}
}
 else {
echo "invalid";    
    echo $sms_otp;
    echo $obj->is_cntc_validated;
}
?>