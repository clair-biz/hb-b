<?php
require_once 'Base.php';
require_once 'Product.php';
require_once 'Sms.php';
require_once 'Customer.php';
require_once 'Vendor.php';
require_once 'PDF.php';
require_once 'FPDF/fpdf.php';
require_once("PHPMailer/PHPMailerAutoload.php");

Class Email {
    

public static function sendEmail($name,$email,$subject,$message) {

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = 'relay-hosting.secureserver.net';
//Whether to use SMTP authentication
//$mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
//$mail->Username = "info@homebiz365.in";
$mail->Username = "mail.oms123@gmail.com";
//Password to use for SMTP authentication
//$mail->Password = "info_homebiz_123";
$mail->Password = "passoms123";



$mail->AddBCC('info@homebiz365.in', 'info@HomeBiz365');
$mail->setFrom('info@homebiz365.in', 'info@HomeBiz365');
//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$mail->addAddress($email, $name);
//Set the subject line
$mail->Subject = $subject;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body

$mail->IsHTML(true);   
$mail->Body= $message;
//Replace the plain text body with one created manually

if (!$mail->send()) {
    return false;
//    echo "Mailer Error: " . $mail->ErrorInfo;
} else
    return true;
}


public static function newEmailVerification($name,$email,$uname,$id,$type) {

$message="
Dear $name,<br />
Thank you for registration.<br />
Your Username : $uname<br />
Please <a href=".$_SERVER['SERVER_NAME']."/validate-email.php?";

if($type=="Customer")
    $message.="cust_id=";
elseif($type=="Vendor")
    $message.="vend_id=";

$message.=urlencode($id)." > click on this link</a> to Verify your email Address.<br />
Thank You!<br />Regards,<br />Team HomeBiz365";
//echo $message;

$subject="HomeBiz365 - Please verify your email ID!";
if(Email::sendEmail($name,$email,$subject,$message))
    return true;
else
    return false;
}

public static function sendSubscriptionDetails($name,$email,$uname,$bname,$cat_id,$city_served,$area_served,$vs_for,$subtotal,$tax,$disc,$total,$status,$prev_cat,$reason) {
$message="Dear $name,<br />";
if($status!="Rejected") {
    $vs_for= explode(" ", $vs_for);
    if($status=="Approved for Renewal") {
        $message.="Your Request for Renewal is approved for ";
    }
    elseif($status=="Renewed")
        $message.="Your Account subscription is renewed successfully for ";
    elseif($status=="New")
    $message.="Congratulations,Your Registration has been<br>
    approved for ";
    if($cat_id==$prev_cat && $cat_id!=0)
    $message.="<b>".Base::getcatnamebyid($cat_id)."</b> category<br>";
     else
    $message.="<b>".Base::getcatnamebyid($cat_id)."</b> instead of $prev_cat category.";

    $message.="Your Subscription details are as follows:<br />
Business Name: <b>$bname</b><br />
Username: <b>$uname</b><br />
Category: <b>".Base::getcatnamebyid($cat_id)."</b><br />";

if(isset($city_served)!="")
    $message.="City Served: <b>$city_served</b>";
if(!empty($area_served))
    $message.=" in <b>$area_served</b> area";

str_replace("Annual", "Year", $vs_for);

$noofmonths=0;
if($vs_for[1]=="Annual")
$noofmonths=$vs_for[0]*12;

elseif($vs_for[1]=="Half")
$noofmonths=$vs_for[0]*6;

if($noofmonths==12)
    $vs_for="1 Year";
elseif($noofmonths==6)
    $vs_for="6 Months";

elseif($noofmonths>12) {
    $y=intval($noofmonths/12);
    $noofmonths=(intval($noofmonths%12));

    if($y==1)
    $vs_for=$y." Year";
    else
    $vs_for=$y." Years";
    
    if($noofmonths>0)
        if($noofmonths==1)
        $vs_for.=" $noofmonths Month";
        else
        $vs_for.=" $noofmonths Months";
}
$message.="
<br />Subscription for: <b>$vs_for</b><br />
Subscription Charges: <b>&#8377; $subtotal/-</b><br />
GST@: <b>&#8377; $tax/-</b><br />";
if(isset($disc)!="" && $disc!="0" && $disc>0)
    $message.="Discount: <b>&#8377; $disc/-</b><br />";


if($status!="Renewed") {    
$message.="
Net Amount: <b>&#8377; $total/-</b><br /><br />
Please pay <b>&#8377; $total/-</b> to<br />
<b>CLAIRVOYANT BIZINFO PVT LTD</b><br />
A/c No: <b>38610200000055</b><br />
<b>Bank of Baroda<br />
Karvenagar, Pune - 411038</b><br />
RTGS / NEFT IFSC CODE: <b>BARB0KARVEN</b><br />
and get benefits from our services.<br /><br />";

if($status="Approved for Renewal")
    $message.="To renew ";
else
$message.="To activate ";

$message.="your account kindly send the<br />
payment acknowledgement mentioning your User Name<br />
to contact@homebiz365.in and/or to 9373512915 and/or 9673006100<br />
Thank You!<br />Regards,<br />HomeBiz365";
}
else
    $message.="Your Subscription has been renewed.<br />Thank You!<br />Regards,<br />HomeBiz365";
}
elseif ($status=="Rejected") {
    $message.="Your Subscription request is $status by www.homebiz365.in due to $reason.<br />Regards,<br />HomeBiz365";

}

$subject="HomeBiz365 - Subscription is $status!";
if(Email::sendEmail($name,$email,$subject,$message))
    return true;
else
    return false;
}

public static function sendSubscriptionDetailsAlternate($name,$email,$uname,$bname,$cat_id,$status,$prev_cat) {
$message="Dear $name,<br />";
        $message.="Your Account subscription is approved for ";
    $message.="<b>".Base::getcatnamebyid($cat_id)."</b> instead of $prev_cat category.";

    $message.="Your Subscription details are as follows:<br />
Business Name: <b>$bname</b><br />
Username: <b>$uname</b><br />
Category: <b>".Base::getcatnamebyid($cat_id)."</b><br />
Please Login www.homebiz365.in and complete Subscription procedure<br />
Thank You!<br />Regards,<br />HomeBiz365";

$subject="HomeBiz365 - Subscription is $status!";
if(Email::sendEmail($name,$email,$subject,$message))
    return true;
else
    return false;
}

   
public static function sendNewSubscriptionDetailsOffline($vend_obj) {
    $objvend= unserialize($vend_obj);
    $name=$objvend->vend_fname;
$message="Dear $name,<br />";

if($objvend->cat_id!=0 && $objvend->cat_id==$objvend->other_cat || $objvend->other_cat==NULL) {
    $message.="Congratulations, your registration has been approved for<br /><b>".Base::getcatnamebyid($objvend->cat_id)."</b> category<br>";

    $message.="Your Subscription details are as follows:<br />
Business Name: <b>".$objvend->bname."</b><br />
Username: <b>".Base::getunamebyuid($objvend->u_id)."</b><br />
Category: <b>".Base::getcatnamebyid($objvend->cat_id)."</b><br />";
if(isset($objvend->city_served)!="")
    $message.="City Served: <b>".$objvend->city_served."</b>";

$vs_for=Base::annualtoyear($objvend->vs_for);
$total=intval($objvend->vs_subtotal+($objvend->vs_subtotal*($objvend->vs_tax/100)));
$message.="
<br />Subscription for: <b>$vs_for</b><br />
Subscription Charges: <b>&#8377; ".$objvend->vs_subtotal."/-</b><br />
GST@: <b>&#8377; ".$objvend->subtotal*($objvend->vs_tax/100)."/-</b><br />
Net Amount: <b>&#8377; $total/-</b><br /><br />
Please pay <b>&#8377; $total/-</b> to<br />
<b>CLAIRVOYANT BIZINFO PVT LTD</b><br />
A/c No: <b>38610200000055</b><br />
<b>Bank of Baroda<br />
Karvenagar, Pune - 411038</b><br />
and get benefits from our services.<br /><br />
Regards,<br />Team HomeBiz365";
    }
    elseif($objvend->cat_id==0){
        $message.="We have received your request for $objvend->other_cat<br />
We would process your request soon<br />Thank You!<br />Regards,<br />Team HomeBiz365";
    }

$subject="HomeBiz365 - Subscription is Approved!";
if(Email::sendEmail($name,$objvend->vend_email,$subject,$message))
    return true;
else
    return false;
}

public static function sendNewSubscriptionDetailsOnline() {
$subsc_data= unserialize($_SESSION["subscription_data"]);
$total=0;
$subsc_name="For ";
foreach ($subsc_data as $value) {
    if($subsc_name!="For ")
    $subsc_name.=", ".Base::getcatnamebycatid ($value->cat_id);
    else 
    $subsc_name.=Base::getcatnamebycatid ($value->cat_id);
    $name=$value->vend_fname;
    $cntc=$value->vend_cntc;
    $email=$value->vend_email;
    $total+=$value->vs_total;
}

    
$message="Dear $name,<br />Congratulations, Your registration has been <b>ENABLED</b> for<br /><b>$subsc_name</b><br />";

    $message.="Your Subscription details are as follows:<br />";
    foreach ($subsc_data as $value) {        
        $message.="Business Name: <b>".$value->bname."</b><br />
Username: <b>".Base::getunamebyuid($value->u_id)."</b><br />
Category: <b>".Base::getcatnamebyid($value->cat_id)."</b><br />";
if(isset($value->city_served)!="")
    $message.="City Served: <b>".$value->city_served."</b>";

$vs_for=Base::annualtoyear($value->vs_for);
$message.="
<br />Subscription for: <b>$vs_for</b><br />
Subscription Charges: <b>&#8377; ".$value->vs_subtotal."/-</b><br />";
if($value->vs_tax!=0)
$message.="GST@: <b>&#8377; ".$value->vs_subtotal*($value->vs_tax/100)."/-</b><br />";

$message.="Net Amount: <b>&#8377; $value->vs_total/-</b><br /><br />";
    }
$message.="Total amount paid <b>&#8377; $total/-</b><br />
You can login and get benefits from our services.<br />Thank You!<br />
Regards,<br />Team HomeBiz365";

$subject="HomeBiz365 - Subscription is Enabled!";
if(Email::sendEmail($name,$email,$subject,$message))
    return true;
else
    return false;
}

    
public static function sendSubscriptionDetails1($name,$email,$uname,$bname,$cat_id,$city_served,$area_served,$vs_for,$subtotal,$tax,$disc,$total,$status,$prev_cat,$reason) {
$message="Dear $name,<br />";

if($status!="Rejected") {
if($status=="approve")
	$message.="Congratulations, ";

switch ($status) {
	case 'approve':
					$message.="Congratulations, your registration has been approved for<br />";
		break;
		case 'renew':
        $message.="Your Account subscription is renewed successfully for ";
        			break;
		case 'approve-renew':
        $message.="Your Request for Renewal is approved for ";
        break;

	default:
		# code...
		break;
}

$vs_for=Base::annualtoyear($vs_for);

    if($cat_id==$prev_cat && $cat_id!=0)
    $message.="<b>".Product::getcatnamebyid($cat_id)."</b> category<br>";
     else
    $message.="<b>".Product::getcatnamebyid($cat_id)."</b> instead of $prev_cat category.";

    $message.="Your Subscription details are as follows:<br />
Business Name: <b>$bname</b><br />
Username: <b>$uname</b><br />
Category: <b>".Product::getcatnamebyid($cat_id)."</b><br />";

if(isset($city_served)!="")
    $message.="City Served: <b>$city_served</b>";
if(!empty($area_served))
    $message.=" in <b>$area_served</b> area";

$message.="
<br />Subscription for: <b>$vs_for</b><br />
Subscription Charges: <b>&#8377; $subtotal/-</b><br />
GST@: <b>&#8377; $tax/-</b><br />";
if(isset($disc)!="" && $disc!="0" && $disc>0)
    $message.="Discount: <b>&#8377; $disc/-</b><br />";



if($status!="Renewed") {    
$message.="
Net Amount: <b>&#8377; $total/-</b><br /><br />
Please pay <b>&#8377; $total/-</b> to<br />
<b>CLAIRVOYANT BIZINFO PVT LTD</b><br />
A/c No: <b>38610200000055</b><br />
<b>Bank of Baroda<br />
Karvenagar, Pune - 411038</b><br />
RTGS / NEFT IFSC CODE: <b>BARB0KARVEN</b><br />
and get benefits from our services.<br /><br />";

if($status="Approved for Renewal")
    $message.="To renew ";
else
$message.="To activate ";

$message.="your account kindly send the<br />
payment acknowledgement mentioning your User Name<br />
to contact@homebiz365.in and/or to 9373512915 and/or 9673006100<br />
Thank You!<br />Regards,<br />HomeBiz365";
}
else
    $message.="Your Subscription has been renewed.<br />Thank You!<br />Regards,<br />HomeBiz365";
}
elseif ($status=="Rejected") {
    $message.="Your Subscription request is $status by www.homebiz365.in due to $reason.<br />Regards,<br />HomeBiz365";
}

$subject="HomeBiz365 - Subscription is $status!";
if(Email::sendEmail($name,$email,$subject,$message))
    return true;
else
    return false;
}

public static function sendDisableMsg($name,$email,$reason) {
    $message="Dear $name,<br />Your account has been disabled due to $reason.<br />Regards,<br />HomeBiz365";
    $subject="HomeBiz365 - Your account is Disabled!";
    if(Email::sendEmail($name,$email,$subject,$message))
        return true;
        else
            return false;
}

public static function sendSubscriptionDetailsAuto($name,$email,$uname,$bname,$cat_id,$city_served,$area_served,$vs_for,$subtotal,$tax,$disc,$total,$status,$prev_cat,$reason) {

//$q="select vend_fname,vend_lname,u_name,disp_name,";
    
    
    
    
$vs_for= explode(" ", $vs_for);


$message="Dear $name,<br />";
if($status!="Rejected") {
$message.="Congratulations,Your Registration has been<br>
    approved for ";
    if($cat_id==$prev_cat)
    $message.="<b>".Product::getcatnamebyid($cat_id)."</b> category<br>";
     else
    $message.="<b>".Product::getcatnamebyid($cat_id)."</b> instead of $prev_cat category.";

    $message.="Your new Subscription details are as follows:<br />
Business Name: <b>$bname</b><br />
Username: <b>$uname</b><br />
Category: <b>".Product::getcatnamebyid($cat_id)."</b><br />";

if(isset($city_served)!="")
    $message.="City Served: <b>$city_served</b>";
if(!empty($area_served))
    $message.=" in <b>$area_served</b> area";

str_replace("Annual", "Year", $vs_for);

$noofmonths=0;
if($vs_for[1]=="Annual")
$noofmonths=$vs_for[0]*12;

elseif($vs_for[1]=="Half")
$noofmonths=$vs_for[0]*6;

if($noofmonths==12)
    $vs_for="1 Year";
elseif($noofmonths==6)
    $vs_for="6 Months";

elseif($noofmonths>12) {
    $y=intval($noofmonths/12);
    $noofmonths=(intval($noofmonths%12));

    if($y==1)
    $vs_for=$y." Year";
    else
    $vs_for=$y." Years";
    
    if($noofmonths>0)
        if($noofmonths==1)
        $vs_for.=" $noofmonths Month";
        else
        $vs_for.=" $noofmonths Months";
}
$message.="
<br />Subscription for: <b>$vs_for</b><br />
Subscription Charges: <b>&#8377; $subtotal/-</b><br />
GST@: <b>$tax</b><br />";
if(isset($disc)!="" && $disc!="0" && $disc>0)
    $message.="Discount: <b>&#8377; $disc/-</b><br />";

$message.="
Net Amount: <b>&#8377; $total/-</b><br /><br />
    
Please pay <b>&#8377; $total/-</b> to<br />
<b>CLAIRVOYANT BIZINFO PVT LTD</b><br />
A/c No: <b>38610200000055</b><br />
<b>Bank of Baroda<br />
Karvenagar, Pune - 411038</b><br />
RTGS / NEFT IFSC CODE: <b>BARB0KARVEN</b><br />
get benefits from our services.<br />
Thank You!<br />Regards,<br />HomeBiz365";
}
elseif ($status=="Rejected") {
    $message.=" is $status by www.homebiz365.in due to $reason. ";

}


$subject="HomeBiz365 - Subscription is $status!";
if(Email::sendEmail($name,$email,$subject,$message))
    return true;
else
    return false;
}

public static function enableVendor($name,$email,$uname,$bname,$cat_id,$vs_for) {
//    echo "Months1 $vs_for<br />";
//    str_replace("Annual", "Year", $vs_for);
    $vs_for= explode(" ", $vs_for);
    
    $noofmonths=0;
    if($vs_for[1]=="Year")
        $noofmonths=$vs_for[0]*12;
        
        elseif($vs_for[1]=="Half")
        $noofmonths=$vs_for[0]*6;
        
        if($noofmonths==12)
            $vs_for="1 Year";
            elseif($noofmonths==6)
            $vs_for="6 Months";
            
            elseif($noofmonths>12) {
                $y=intval($noofmonths/12);
                $noofmonths=(intval($noofmonths%12));
                
                if($y==1)
                    $vs_for=$y." Year";
                    else
                        $vs_for=$y." Years";
                        
                        if($noofmonths>0)
                            if($noofmonths==1)
                                $vs_for.=" $noofmonths Month";
                                else
                                    $vs_for.=" $noofmonths Months";
            }

$date = date_create();

$message="Dear $name,<br />
Thank you for your payment for <b>".Product::getcatnamebyid($cat_id)."</b><br>
    Your account is now enabled.<br>
    You can proceed to upload your <b>".Base::getcattypebyuname($uname)."<b> details.<br />

Business Name: <b>$bname</b><br />
Username: <b>$uname</b><br />
Subscription Period: <b>".date_format($date,"d-m-Y")."</b> to <b> ";

$todate=date_add($date,date_interval_create_from_date_string("$noofmonths months"));

$message.=date_format($todate,"d-m-Y")."</b><br />";


$message.="Category: <b>".Product::getcatnamebyid($cat_id)."</b><br /><br />Regards,<br />HomeBiz365";

//echo $message;
$subject="HomeBiz365 - Service Enabled!";
if(Email::sendEmail($name,$email,$subject,$message))
    return true;
else
    return false;
}

public static function requestFeedback($ord_id) {
$cat_type=Base::getcattypebyuname($user->u_name);

if($cat_type=="Product") {
$q="select prod_name,ord_qty,disp_name,product.vend_id,cust_fname,cust_lname,cust_email,cust_cntc from product,ordertbl,users,customer where customer.cust_id=ordertbl.cust_id and product.prod_id=ordertbl.prod_id and product.vend_id=users.u_id and ord_id=$ord_id";

$res= Base::generateResult($q);
$name="";
$msg="";
while($row= mysqli_fetch_array($res)) {
$name=$row[4]." ".$row[5];
$vendname=$row[2];
$email_id=$row[6];
$cntc=$row[7];
$vend_id=$row[3];
$msg.=$row[0]."<br />
by ".$row[2]."<br />
Quantity: ".$row[1]."<br />";
//echo $message."<br />";
}
$message="<h3>Order Complete!</h3>
Dear $name,<br />
Please give your ratings for<br />".$msg;

$message.="Rate the Vendor by <a href='".$_SERVER['SERVER_NAME']."/rating.php?vendid=".$vend_id."'>clicking here</a> so that we would be serve you better.</div><br />Regards,<br />HomeBiz365";
//echo $message;
$subject="HomeBiz365 - Please rate for ".$vendname."!";
if(Email::sendEmail($name,$email_id,$subject,$message) &&  Sms::sendOrderInfo($name,$cntc,"Order Request","Completed","")) {
                 
    return true;
}
else {
                 
    return false;
}
}
elseif($cat_type=="Service") {
$q="select serv_name,disp_name,service.vend_id,cust_fname,cust_lname,cust_email,cust_cntc from service,serviceordertbl,users,customer where customer.cust_id=serviceordertbl.cust_id and service.serv_id=serviceordertbl.serv_id and service.vend_id=users.u_id and ord_id=$ord_id";
$res= Base::generateResult($q);

$msg="";
while($row= mysqli_fetch_array($res)) {
$name=$row[3]." ".$row[4];
$email_id=$row[5];
$cntc=$row[6];

$msg.=$row[0]."<br />
by ".$row[1]."<br />
Rate the Service Provider by <a href='".$_SERVER['SERVER_NAME']."/rating.php?vendid=".$row[2]."'>clicking here</a> so that we would be serve you better.</div>";
//echo $message."<br />";
$message="<h3>".$row[0]." Provided!</h3>
Dear $name,<br />
Please give your ratings for<br />".$msg."<br />Regards,<br />HomeBiz365";
//echo $message;
$subject="HomeBiz365 - Please rate for ".$row[0]."!";
if(Email::sendEmail($name,$email_id,$subject,$message) &&  Sms::sendOrderInfo($name,$cntc,"Order Request","Completed","")) {
                 
    return true;
}
else {
                 
    return false;
}
}
}

}

public static function forgotPassword($u_name) {
    $a=Base::getUserType($u_name);
  if($a==1)
$q="select disp_name,vend_email from users,vendor where vendor.vend_id=users.vend_id and u_name='$u_name'";
  elseif($a==2)
$q="select disp_name,cust_email from users,customer where customer.cust_id=users.cust_id and u_name='$u_name'";
//echo $q;
$res= Base::generateResult($q);
$msg="";
$subject="HomeBiz365 - Forgot Password?";
while($row= mysqli_fetch_array($res)) {
$name=$row[0];
$email=$row[1];
//$msg.="Account Name: ".$row[2]."<br />Username: ".$row[0]."<br />Password ".md5($row[1])."<br/>";
}
 
$message="We received a request to reset the password,<br>
If you made this request <a href='".$_SERVER['SERVER_NAME']."/new.php?name=$u_name'>Click here!</a><br />Regards,<br />HomeBiz365";
                 
if(Email::sendEmail($name,$email,$subject,$message) )
    return true;
else
    return false;
}


public static function sendMailtoCustomer($id,$status,$reason,$user) {
echo $user;
    
$vend_name=Vendor::getvendnamebyuname($user->u_name);
$cust_id=0;
$cat_type="";
switch ($user->home_url) {
    case "ProductsPage" : $cat_type="Product";
        break;
    case "ServicesPage" : $cat_type="Service";
        break;
}

if($cat_type=="Service")
$cat_type1=$cat_type." Request";
else
    $cat_type1=$cat_type;

echo "cattype-$cat_type-";
if($cat_type=="Product") {

        $q="select product.prod_id,prod_name,ord_qty,ord_rate,req_dt,cust_id from ordertbl,product,product_price where product.prod_id=product_price.prod_id and ordertbl.prod_id=product.prod_id and product.vs_id=".$user->vs_id." and ordertbl.ord_id=$id";
        echo $q;
        $total=0;
        $msg="";
    $res=Base::generateResult($q);
    while ($row= mysqli_fetch_array($res)) {
        $cust_id=$row[5];
 //      $o=new Order($id,$cust_id,$row[1],$row[5],$row[3],$row[4],$user->u_name);
//       if($o->OrderInsert() && Order::removeCartItem($row[0]) ) {
        $total+=$row[3]*$row[2];
        $msg.="<br>Product: ".$row[1];
        $msg.="<br>Qty: ".$row[2];
        $msg.="<br>Price: ".$row[3];
        $msg.="<br>Subtotal: ".($row[2]*$row[3]);
//        }
        $msg.="<br>";
    }
    $name=Customer::getcustnamebyid($cust_id);
    $email=Customer::getcustemailbyid($cust_id);
    $cntc=Customer::getcustcntcbyid($cust_id);
    $msg.="<br>Total Amount: $total";
$message="
Dear $name,<br />
Your $cat_type1 for ";
    $message.=$msg."<br>";
    if($status=="Accepted") {
        $subject="HomeBiz365 - Your $cat_type1 is $status by $vend_name!";
        $message.="<br>is $status by $vend_name";
    }
    if($status=="Rejected" || $status=="Canceled") {
        $subject="HomeBiz365 - Your $cat_type1 is $status by $vend_name, sorry for the inconvenience!";
        $message.="<br>would not be able to complete by $vend_name due to $reason.<br>We regret for the inconvenience.";
    }
    $message.="<br>Vendor Details";
        $q="select disp_name,vend_cntc,vend_email from vendor,users where vendor.vend_id=users.vend_id and u_id=$vend_id;";
//    echo $q;
    $res=Base::generateResult($q);
    while ($row= mysqli_fetch_array($res)) {
        $message.="<br>Vendor Name: ".$row[0];
        $message.="<br>Contact: ".$row[1];
        $message.="<br>Email ID: ".$row[2];
    }
                 
    echo $message;
if(Email::sendEmail($name,$email,$subject,$message) /*&& Sms::sendOrderInfo($name,$cntc,$cat_type1,$status,$reason)*/)
    return true;
else
    return false;
}
elseif($cat_type=="Service") {
    $q="select service.serv_id,serv_name,cust_id from serviceordertbl,service where serviceordertbl.serv_id=service.serv_id and service.vend_id=$vend_id and serviceordertbl.ord_id=$id";
        echo $q;
    $res=Base::generateResult($q);
    while ($row= mysqli_fetch_array($res)) {
            $cust_id=$row[2];
        $msg=" ".$row[1];
    }
    $name=Customer::getcustnamebyid($cust_id);
    $email=Customer::getcustemailbyid($cust_id);
    $cntc=Customer::getcustcntcbyid($cust_id);
    if($status=="Accepted" ) {
        $subject="HomeBiz365 - Your $cat_type1 is $status by $vend_name!";
        $message1="<br>is $status by $vend_name";
    }
    if($status=="Rejected" || $status=="Canceled") {
        $subject="HomeBiz365 - Your $cat_type1 is $status by $vend_name, sorry for the inconvenience!";
        $message1="<br>would not be able to complete by $vend_name due to $reason.<br>We regret for the inconvenience.";
    }
$message="
Dear $name,<br />
Your $cat_type1 for ".$msg.$message1;
    $message.="<br>Service Provider Details";
        $q="select disp_name,vend_cntc,vend_email from vendor,users where vendor.vend_id=users.vend_id and u_id=$vend_id;";
//    echo $q;
    $res=Base::generateResult($q);
    while ($row= mysqli_fetch_array($res)) {
        $message.="<br>Service Provider Name: ".$row[0];
        $message.="<br>Contact: ".$row[1];
        $message.="<br>Email ID: ".$row[2];
    }
//    echo $message;
                 

if(Email::sendEmail($name,$email,$subject,$message) /*&& Sms::sendOrderInfo($name,$cntc,$cat_type1,$status,$reason)*/)
    return true;
else
    return false;
}
}


    public static function generatePO($ord_nos,$wallet) {
        $ord_nos= explode(",", $ord_nos);
        print_r($ord_nos);
        $name= Customer::getcustnamebyuname($user->u_name);
        $email=Customer::getcustemailbyuid(Base::getuidbyuname($user->u_name));
        $message="Dear ".$name.",<br />Order Successfully placed.<br />Thank you for shopping with HomeBiz365<br />Order Details<br /> ";
        $message.="<table style' border:1px solid black'>
            <tr>
            <th>Order #</th>
            <th>Product</th>
            <th>Delivery Date</th>
            <th>Quantity</th>
            <th>Rate</th>
            <th>Subtotal</th>
            </tr>";

$pay=0;        
        foreach ($ord_nos as $ord_id) {
            
        $query="select ordertbl.ord_id,prod_name,date_format(req_dt,'%d-%m-%Y'),ord_qty,ord_rate,sc_cust,bs_from,bs_to from booking_slots,ordertbl,product,order_detail where booking_slots.bs_id=ordertbl.bs_id and order_detail.prod_id=product.prod_id and ordertbl.ord_id=order_detail.ord_id and ordertbl.ord_id=$ord_id order by ord_id; ";
echo $query;
$ship_charge=0;
$total=0;
        $res= Base::generateResult($query);
        while($row= mysqli_fetch_array($res)) {
            $sub=$row[4] *$row[3];
            $total+=$sub;
            $ship_charge=$row[5];
        $message.="
            <tr>
            <td>".$row[0]."</td>
            <td>".$row[1]."</td>
            <td>".$row[2]."<br />Between ".$row[6]."-".$row[7]."</td>
            <td>".$row[3]."</td>
            <td>&#8377; ".$row[4]."/-</td>
            <td>&#8377; $sub/-</td>
            </tr>";
            
        }
        
        $message.="
            <tr>
            <th style='text-align: right;' colspan=5>Delivery Charges</th>
            <th>&#8377; $ship_charge/-</th>
            </tr>
            <tr>
            <th style='text-align: right;' colspan=5>Total</th>
            <th>&#8377; ".($total+$ship_charge)."/-</th>
            </tr>";
$pay+=$total+$ship_charge;
        }
        $message.="</table><br /><br />";
        echo "wallet-$wallet-";
        if($wallet>0)
            $message.="Net Payable &#8377; $pay/-<br />Wallet Amount Redeemed: &#8377; $wallet/-<br>";
        $message.="Amount Received &#8377; ".($pay-$wallet)."/-<br />Regards,<br />Team Homebiz365.";
        echo $message;
        $subject="HomeBiz365-Order Placed";
                 
     if(Email::sendEmail($name,$email,$subject,$message))
    return true;
else
    return false;
   
    
    }

    public static function generatePO4V($ord_id,$vs_id) {
//        $ordobj= unserialize($ordobj);
        $name= Vendor::getvendnamebyuname(Base::getunamebyuid(Vendor::getuidbyvsid($vs_id)));
        $email= Vendor::getvendemailbyuid(Vendor::getuidbyvsid($vs_id));
        $message="Dear ".$name.",<br />Order Successfully  placed order no ".$ord_id.".<br />Order Details<br /> ";
        $query="select prod_name,date_format(req_dt,'%d-%m-%Y'),ord_qty,ord_rate,sc_cust,bs_from,bs_to from ordertbl,product,order_detail,booking_slots where booking_slots.bs_id=ordertbl.bs_id and order_detail.prod_id=product.prod_id and ordertbl.ord_id=order_detail.ord_id and ordertbl.ord_id=".$ord_id;
        echo $query;
        $message.="<table style' border:1px solid black'>
            <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Rate</th>
            <th>Subtotal</th>
            </tr>";

        $res= Base::generateResult($query);
        while($row= mysqli_fetch_array($res)) {
            $slot=$row[5]."-".$row[6];
            $ship=$row[4];
            $dt=$row[1];
            $sub=$row[3];
            $total+=$sub;
        $message.="
            <tr>
            <td>".$row[0]."</td>
            <td>".$row[2]."</td>
            <td>&#8377; ".round($row[3]/$row[2])."/-</td>
            <td>&#8377; $sub/-</td>
            </tr>";
            
        }
        $message.="
            <tr>
            <th style='text-align: right;' colspan=3>Total</th>
            <th>&#8377; $total/-</th>
            </tr>";

        $message.="</table><br /><br />";
        
        
        
        $message.="Delivery Charges: &#8377; ".$ship."/-<br />Amount Received &#8377; ".($total+$ship)."/-<br />To be delivered on $dt between $slot<br />Regards,<br />Team Homebiz365";
        echo $message;
        $subject="HomeBiz365-Order Recieved for $dt";
        
                 
     if(Email::sendEmail($name,$email,$subject,$message))
    return true;
else
    return false;
   
    }
    
    public static function prodRejectionEmail($reason,$prod_name,$ord_id,$email,$name) {

$message="
Dear $name,<br />
Return request for $prod_name(order Id $ord_id) is rejected due to $reason.<br />
<br />Regards,<br />Team HomeBiz365";
//echo $message;

$subject="HomeBiz365 - Product Return Update!";
if(Email::sendEmail($name,$email,$subject,$message))
    return true;
else
    return false;
}
    public static function prodAcceptReplaceEmail($type,$prod_name,$timeslot,$email,$name) {

$message="
Dear $name,<br />
Request for $type $prod_name is accepted and will be picked up tomorrow between $timeslot.<br />
<br />Regards,<br />Team HomeBiz365";
//echo $message;

$subject="HomeBiz365 - Product Return Update!";
if(Email::sendEmail($name,$email,$subject,$message))
    return true;
else
    return false;
}
    public static function prodAcceptReplaceTagoEmail($pr_id) {
        $name="Sameer";
        $email="mail.oms123@gmail.com";
        $subject="HomeBiz365 - Product Return";

 $query="select DISTINCT bname,cust_fname,vend_addr,cust_addr,vendor.loc_zip,customer.loc_zip,sa_name,sa_addr,ship_addr.loc_zip,ordertbl.ord_id,ordertbl.ins_dt,date_format(ordertbl.req_dt,'%d-%m-%Y'),bs_from,bs_to
from users,product,customer,vendor,ship_addr,prod_return,ordertbl,vend_subscription,order_detail,booking_slots
where ordertbl.ord_id=prod_return.ord_id
and customer.cust_id=ship_addr.cust_id
and vendor.vend_id=users.vend_id
and ordertbl.bs_id=booking_slots.bs_id
and ordertbl.sa_id=ship_addr.sa_id 
and vend_subscription.vs_id=product.vs_id
and users.u_id=vend_subscription.u_id
and product.prod_id=order_detail.prod_id 
and order_detail.ord_id=ordertbl.ord_id and product.prod_id=prod_return.prod_id
and pr_id=$pr_id";
            $res= Base::generateResult($query);
            if($row= mysqli_fetch_array($res)) {
                $message.="To be delivered on ".$row[11]."<br>"
                        ."Between ".$row[12]." - ".$row[13]."<br>"
                        . "Pickup from:<br>"
                        . $row[6]."<br>"
                        . $row[7]."<br>"
                        . $row[8]."<br>"
                        . Base::getlocstatebyzip($row[8])."<br>"
                        . "India<br><br>"
                        . "Delivery to<br>"
                        . $row[0]."<br>"
                        . $row[2]."<br>"
                        . $row[4]."<br>"
                        . Base::getlocstatebyzip($row[4])."<br>"
                        . "India<br><br>";
            }
        $message.="<br>Regards,Team HomeBiz365";
       
        
        
//echo $message;

                 
if(Email::sendEmail($name,$email,$subject,$message))
    return true;
else
    return false;
}

    public static function prodReplaceEmail($prod_name,$rp_date,$slot,$email,$name) {

$message="
Dear $name,<br />
Replacement for $prod_name is scheduled for delivery on $rp_date between $slot.<br />
<br />Regards,<br />Team HomeBiz365";
//echo $message;

$subject="HomeBiz365 - Product Replace Update";
if(Email::sendEmail($name,$email,$subject,$message))
    return true;
else
    return false;
}
    public static function prodRefundAmtEmail($prod_name,$amount,$email,$name) {

$message="
Dear $name,<br />
Request for Refund for $prod_name is accepted and &#8377; $amount/- is refunded to wallet.<br />
<br />Regards,<br />Team HomeBiz365";
//echo $message;

$subject="HomeBiz365 - Refund Amount";
if(Email::sendEmail($name,$email,$subject,$message))
    return true;
else
    return false;
}


}
?>