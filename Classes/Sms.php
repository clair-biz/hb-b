<?php
require_once 'Classes.php';

class Sms{
    private $mobile;
    private $message;
    
    function getMobile($mobile) {
        $this->mobile=$mobile;
    }
    
    function getMessage($message) {
        $this->message=$message;
    }
    
/*    function send(){
	// Authorisation details.
	$username = "info@clairvoyantbizinfo.com";
	$hash = "79956da845dcb3a2da236fbe528defd65ab43107ad215160d73fe0a473e5dc0f";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "1";

	// Data for text message. This is the text message data.
	$sender = "HOMBIZ"; // This is who the message appears to be from.
//	$numbers = "910000000000"; // A single number or a comma-seperated list of numbers
//	$message = "This is a test message from the PHP API script.";
	$numbers = $this->mobile;     //"910000000000"; // A single number or a comma-seperated list of numbers
//	$message = $this->message;   //"This is a test message from the PHP API script.";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
	$message = rawurlencode($this->message);
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
        echo "res ".$result;
    }*/
    
public static function sendSubscriptionDetails($name,$email,$status) {
    $mob=Vendor::getvendcntcbyemail($email);
//    echo "mob-".$mob."-";
	// Authorisation details.
	$username = "info@clairvoyantbizinfo.com";
	$hash = "79956da845dcb3a2da236fbe528defd65ab43107ad215160d73fe0a473e5dc0f";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "1";

	// Data for text message. This is the text message data.
	$sender = "HOMBIZ"; // This is who the message appears to be from.
//	$numbers = "910000000000"; // A single number or a comma-seperated list of numbers
//	$message = "This is a test message from the PHP API script.";
	$numbers = $mob;     //"910000000000"; // A single number or a comma-seperated list of numbers
//	$message = $this->message;   //"This is a test message from the PHP API script.";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers

        $message = rawurlencode("Dear $name,%nYour Subscription is $status%nFor more details check your email.%nRegards,%nTeam HomeBiz365.");
        
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
//        echo "res ".$result;
            return true;
}

public static function NewVendorNotification($vend_name,$category,$vend_cntc) {
//    echo "mob-".$mob."-";
	// Authorisation details.
	$username = "info@clairvoyantbizinfo.com";
	$hash = "79956da845dcb3a2da236fbe528defd65ab43107ad215160d73fe0a473e5dc0f";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "1";

	// Data for text message. This is the text message data.
	$sender = "HOMBIZ"; // This is who the message appears to be from.
//	$numbers = "910000000000"; // A single number or a comma-seperated list of numbers
//	$message = "This is a test message from the PHP API script.";
	$numbers = "919373512915,919673006100";     //"910000000000"; // A single number or a comma-seperated list of numbers
//	$message = $this->message;   //"This is a test message from the PHP API script.";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
	//echo "Dear Admin,%nNew Subscription request from $vend_name for $category.%nPlease login and process the request.%nYou may contact on $vend_cntc.%nRegards,%nHomeBiz365";
        echo "Dear Admin,%nNew request is raised by%n$vend_name%n($vend_cntc)%nfor $category%nRegards,%nHomeBiz365";
        $message = rawurlencode("Dear Admin,%nNew request is raised by%n$vend_name%n($vend_cntc)%nfor $category%nRegards,%nHomeBiz365");
        
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
        echo "res ".$result;
            return true;
}

public static function NewApprovedVendorNotification($vend_name,$category,$vend_cntc) {
//    echo "mob-".$mob."-";
	// Authorisation details.
	$username = "info@clairvoyantbizinfo.com";
	$hash = "79956da845dcb3a2da236fbe528defd65ab43107ad215160d73fe0a473e5dc0f";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "1";
        
	// Data for text message. This is the text message data.
	$sender = "HOMBIZ"; // This is who the message appears to be from.
//	$numbers = "910000000000"; // A single number or a comma-seperated list of numbers
//	$message = "This is a test message from the PHP API script.";
	$numbers = "919765730080";     //"910000000000"; // A single number or a comma-seperated list of numbers
//	$numbers = "919373512915,919673006100";     //"910000000000"; // A single number or a comma-seperated list of numbers
//	$message = $this->message;   //"This is a test message from the PHP API script.";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
	//echo "Dear Admin,%nNew Subscription request from $vend_name for $category.%nPlease login and process the request.%nYou may contact on $vend_cntc.%nRegards,%nHomeBiz365";
//        echo "Dear Admin,%nNew vendor%n$vend_name%n$vend_cntc%nis Approved for $category%nRegards,%nHomeBiz365";
        $message = rawurlencode("Dear Admin,%nNew vendor%n$vend_name%n$vend_cntc%nis Approved for $category%nRegards,%nHomeBiz365");
        
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
        echo "res ".$result;
            return true;
}

public static function NewEnabledVendorNotification() {
$subsc_data= unserialize($_SESSION["subscription_data"]);
$total=0;
$subsc_name="";
foreach ($subsc_data as $value) {
    if($subsc_name!="")
    $subsc_name.=", ".Base::getcatnamebycatid ($value->cat_id);
    else 
    $subsc_name.=Base::getcatnamebycatid ($value->cat_id);
    $name=$value->vend_fname;
    $cntc=$value->vend_cntc;
    $email=$value->vend_email;
    $total+=$value->vs_total;
}
//    echo "mob-".$mob."-";
	// Authorisation details.
	$username = "info@clairvoyantbizinfo.com";
	$hash = "79956da845dcb3a2da236fbe528defd65ab43107ad215160d73fe0a473e5dc0f";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "1";
        
	// Data for text message. This is the text message data.
	$sender = "HOMBIZ"; // This is who the message appears to be from.
//	$numbers = "910000000000"; // A single number or a comma-seperated list of numbers
//	$message = "This is a test message from the PHP API script.";
	$numbers = "919765730080";     //"910000000000"; // A single number or a comma-seperated list of numbers
//	$numbers = "919373512915,919673006100";     //"910000000000"; // A single number or a comma-seperated list of numbers
//	$message = $this->message;   //"This is a test message from the PHP API script.";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
	//echo "Dear Admin,%nNew Subscription request from $vend_name for $category.%nPlease login and process the request.%nYou may contact on $vend_cntc.%nRegards,%nHomeBiz365";
//        echo "Dear Admin,%nNew vendor%n$vend_name%n$vend_cntc%nis Approved for $category%nRegards,%nHomeBiz365";
        $message = rawurlencode("Dear Admin,%nNew vendor%n$name($cntc)%nhas paid Rs. $total/- and is Enabled for $subsc_name%nRegards,%nHomeBiz365");
        
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
        echo "res ".$result;
            return true;
}

public static function sendOrderNotification($vend_cntc,$prod_name,$ord_id,$amount,$date,$slot) {
//    echo "in Send Order Notification";
	// Authorisation details.
	$username = "info@clairvoyantbizinfo.com";
	$hash = "79956da845dcb3a2da236fbe528defd65ab43107ad215160d73fe0a473e5dc0f";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "1";

	// Data for text message. This is the text message data.
	$sender = "HOMBIZ"; // This is who the message appears to be from.
//	$numbers = "910000000000"; // A single number or a comma-seperated list of numbers
//	$message = "This is a test message from the PHP API script.";
	$numbers = $vend_cntc;     //"910000000000"; // A single number or a comma-seperated list of numbers
//	$message = $this->message;   //"This is a test message from the PHP API script.";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
 //       echo "<br>Notification Dear $name,%nYou have received a new $cattype1 .%nPlease check your email or login www.homebiz365.in for details.";

    echo "Order #$ord_id confirmed for $prod_name amounting to INR $amount/- to be delivered on $date between $slot.%nRegards,%nTeam HomeBiz365.";
    $message = rawurlencode("Order #$ord_id confirmed for $prod_name amounting to INR $amount/- to be delivered on $date between $slot.%nRegards,%nTeam HomeBiz365.");
        
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
        echo "res ".$result;
            return true;
}

public static function sendOrderInfo($cust_cntc,$prod_name,$ord_id,$amount,$date,$slot) {
//    echo "in Send Order Info";
	// Authorisation details.
	$username = "info@clairvoyantbizinfo.com";
	$hash = "79956da845dcb3a2da236fbe528defd65ab43107ad215160d73fe0a473e5dc0f";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "1";

	// Data for text message. This is the text message data.
	$sender = "HOMBIZ"; // This is who the message appears to be from.
//	$numbers = "910000000000"; // A single number or a comma-seperated list of numbers
//	$message = "This is a test message from the PHP API script.";
	$numbers = $cust_cntc;     //"910000000000"; // A single number or a comma-seperated list of numbers
//	$message = $this->message;   //"This is a test message from the PHP API script.";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
        $message="";
        
        echo "Order #$ord_id confirmed for $prod_name amounting to INR $amount/- would be delivered on $date between $slot.%nRegards,%nTeam HomeBiz365.";
        $message = rawurlencode("Order #$ord_id confirmed for $prod_name amounting to INR $amount/- would be delivered on $date between $slot.%nRegards,%nTeam HomeBiz365.");
//        if($message!="") {
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
        echo "res ".$result;
            return true;
//        }
}


public static function sendOrderNotificationService($cust_name,$cust_cntc,$prod_name,$vend_name,$vend_cntc) {
//    echo "in Send Order Notification";
	// Authorisation details.
	$username = "info@clairvoyantbizinfo.com";
	$hash = "79956da845dcb3a2da236fbe528defd65ab43107ad215160d73fe0a473e5dc0f";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "1";

	// Data for text message. This is the text message data.
	$sender = "HOMBIZ"; // This is who the message appears to be from.
//	$numbers = "910000000000"; // A single number or a comma-seperated list of numbers
//	$message = "This is a test message from the PHP API script.";
	$numbers = $vend_cntc;     //"910000000000"; // A single number or a comma-seperated list of numbers
//	$message = $this->message;   //"This is a test message from the PHP API script.";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
 //       echo "<br>Notification Dear $name,%nYou have received a new $cattype1 .%nPlease check your email or login www.homebiz365.in for details.";

    $message = rawurlencode("Dear $vend_name,%n$cust_name is interested in $prod_name,%nYou may contact on $cust_cntc to confirm the order.%nRegards,%nTeam HomeBiz365");
        
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
//        echo "res ".$result;
            return true;
}

public static function sendOrderInfoService($cust_name,$cust_cntc,$prod_name,$vend_name,$vend_cntc) {
//    echo "in Send Order Info";
	// Authorisation details.
	$username = "info@clairvoyantbizinfo.com";
	$hash = "79956da845dcb3a2da236fbe528defd65ab43107ad215160d73fe0a473e5dc0f";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "1";

	// Data for text message. This is the text message data.
	$sender = "HOMBIZ"; // This is who the message appears to be from.
//	$numbers = "910000000000"; // A single number or a comma-seperated list of numbers
//	$message = "This is a test message from the PHP API script.";
	$numbers = $cust_cntc;     //"910000000000"; // A single number or a comma-seperated list of numbers
//	$message = $this->message;   //"This is a test message from the PHP API script.";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
        $message="";
        
        $message = rawurlencode("Thank you, for your interest in $prod_name,%nYou may contact $vend_name on $vend_cntc for the same.%nRegards,%nTeam HomeBiz365");
//        if($message!="") {
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
//        echo "res ".$result;
            return true;
//        }
}
    

    
public static function newCntcVerification($cntc,$otp) {
//    echo "in Send Order Info";
	// Authorisation details.
	$username = "info@clairvoyantbizinfo.com";
	$hash = "79956da845dcb3a2da236fbe528defd65ab43107ad215160d73fe0a473e5dc0f";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "1";

	// Data for text message. This is the text message data.
	$sender = "HOMBIZ"; // This is who the message appears to be from.
//	$numbers = "910000000000"; // A single number or a comma-seperated list of numbers
//	$message = "This is a test message from the PHP API script.";
	$numbers = $cntc;     //"910000000000"; // A single number or a comma-seperated list of numbers
//	$message = $this->message;   //"This is a test message from the PHP API script.";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
        $message="";
        
        $message = rawurlencode("Your OTP is $otp.%nPlease use the OTP to proceed.%nRegards,%nTeam HomeBiz365");
//        if($message!="") {
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
//        echo "res ".$result;
            return true;
//        }
}

public static function prodRejection($reason,$prod_name,$ord_id,$cntc) {
//    echo "in Send Order Info";
	// Authorisation details.
	$username = "info@clairvoyantbizinfo.com";
	$hash = "79956da845dcb3a2da236fbe528defd65ab43107ad215160d73fe0a473e5dc0f";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "1";

	// Data for text message. This is the text message data.
	$sender = "HOMBIZ"; // This is who the message appears to be from.
//	$numbers = "910000000000"; // A single number or a comma-seperated list of numbers
//	$message = "This is a test message from the PHP API script.";
	$numbers = $cntc;     //"910000000000"; // A single number or a comma-seperated list of numbers
//	$message = $this->message;   //"This is a test message from the PHP API script.";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
        $message="";
        
        $message = rawurlencode("Return request for $prod_name(Order #$ord_id) is rejected due to $reason%nRegards,%nTeam HomeBiz365.");
//        if($message!="") {
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
        echo "res ".$result;
            return true;
//        }
}
public static function prodAcceptReplace($type,$prod_name,$timeslot,$cntc) {
//    echo "in Send Order Info";
	// Authorisation details.
	$username = "info@clairvoyantbizinfo.com";
	$hash = "79956da845dcb3a2da236fbe528defd65ab43107ad215160d73fe0a473e5dc0f";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "1";

	// Data for text message. This is the text message data.
	$sender = "HOMBIZ"; // This is who the message appears to be from.
//	$numbers = "910000000000"; // A single number or a comma-seperated list of numbers
//	$message = "This is a test message from the PHP API script.";
	$numbers = $cntc;     //"910000000000"; // A single number or a comma-seperated list of numbers
//	$message = $this->message;   //"This is a test message from the PHP API script.";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
        $message="";
        echo "Request for $type $prod_name is accepted and will be picked up tomorrow between $timeslot%nRegards,%nTeam HomeBiz365.";
        $message = rawurlencode("Request for $type $prod_name is accepted and will be picked up tomorrow between $timeslot%nRegards,%nTeam HomeBiz365.");
//        echo $message;
//        if($message!="") {
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
        echo "res ".$result;
            return true;
//        }
}
public static function prodReplace($prod_name,$rp_date,$slot,$cntc) {
//    echo "in Send Order Info";
	// Authorisation details.
	$username = "info@clairvoyantbizinfo.com";
	$hash = "79956da845dcb3a2da236fbe528defd65ab43107ad215160d73fe0a473e5dc0f";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "1";

	// Data for text message. This is the text message data.
	$sender = "HOMBIZ"; // This is who the message appears to be from.
//	$numbers = "910000000000"; // A single number or a comma-seperated list of numbers
//	$message = "This is a test message from the PHP API script.";
	$numbers = $cntc;     //"910000000000"; // A single number or a comma-seperated list of numbers
//	$message = $this->message;   //"This is a test message from the PHP API script.";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
        $message="";
        
        $message = rawurlencode("Replacement for $prod_name is scheduled for delivery on $rp_date between $slot%nRegards,%nTeam HomeBiz365.");
//        if($message!="") {
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
        echo "res ".$result;
            return true;
//        }
}
public static function prodRefund($prod_name,$amount,$cntc) {
//    echo "in Send Order Info";
	// Authorisation details.
	$username = "info@clairvoyantbizinfo.com";
	$hash = "79956da845dcb3a2da236fbe528defd65ab43107ad215160d73fe0a473e5dc0f";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "1";

	// Data for text message. This is the text message data.
	$sender = "HOMBIZ"; // This is who the message appears to be from.
//	$numbers = "910000000000"; // A single number or a comma-seperated list of numbers
//	$message = "This is a test message from the PHP API script.";
	$numbers = $cntc;     //"910000000000"; // A single number or a comma-seperated list of numbers
//	$message = $this->message;   //"This is a test message from the PHP API script.";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
        $message="";
        
        $message = rawurlencode("Request for refund for $prod_name is accepted and INR $amount/- is refunded to wallet.%nRegards,%nTeam HomeBiz365.");
//        if($message!="") {
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
        echo "res ".$result;
            return true;
//        }
}

    
/*    function generateOtp($number,$otp){
       // $string = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
       //$string_shuffled = str_shuffle($string);
       //$otp = substr($string_shuffled, 1, 7);
      $message="
      Your One time Password to access your HomeBiz365 account is $otp";
$this->message=$message;
$this->mobile=$mobile;
   
    }
  */  
    
}

?>