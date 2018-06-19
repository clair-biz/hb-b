<?php
require_once 'data.php';

function validate_User($path) {
//    echo "path--".$path;
    $path= explode("/", $path);
    $path=$path[1];
$Default=Array("Services","Products","Cart","CustomerRegistration","VendorRegistration","About","FAQ","Contact","HowItWorks","StartSelling","Login","Logout","PrivacyPolicy","Terms","VerifyMobileNumber",);
$Customer=Array("Services","Products","OrderCheckOut","MyOrders","CustomerProfile","CustomerRegistration","ForgotPassword","ChangePassword","Return");
$Delivery=Array("Delivery");  
$Vendor=array("ProductsPage","BankDetails","OrdersPage","VendorSubscriptions","RateChart","ChangePassword","SubscriptionPayment","AddOffer","AddProductToOffer","AddServiceToOffer","UpdateOffer","MyOffers","VendorDashboard","AddProduct","UpdateProduct","VendorProfile","OrderFullChart","OrderFull","ServicesPage","VendorRegistration","AddService","UpdateService","NewSubscription");//Array("RegistrationForm","AdminDashboard","Products","AddProduct","UpdateProduct","Members","ExtendMembership","PrintReceipt","Customers","UpdateCustomer","Campaigns");
$Admin=array("AdminDashboard","Categories","Customers","UpdateRate","Vendors","Refunds","AddRatePlan","AdminRateChart","SubscriptionRequest","Reports");//Array("RegistrationForm","AdminDashboard","Products","AddProduct","UpdateProduct","Members","ExtendMembership","PrintReceipt","Customers","UpdateCustomer","Campaigns");
//echo "path on server-$path-";

    if($path!="Login") {

if(isset($_SESSION["user"])!="" && !empty($user)) {
//    echo $type;
    switch ($user->type) {
        case "admin" : {
    if(in_array($path,$Admin,true) || in_array($path, $Default))
        return  "truea";
    elseif(in_array($path, $Vendor,true) || in_array($path, $Customer,true) || in_array($path, $Delivery,true))
        return "falsea";
    }
            break;
        case "vendor" : {
    if(in_array($path,$Vendor,true)  || in_array($path, $Default))
        return  "truev";
    elseif(in_array($path, $Admin) || in_array($path, $Customer) || in_array($path, $Delivery,true))
        return "falsev";
    }
            break;
            
        case "customer" : {
    if(in_array($path,$Customer)  || in_array($path, $Default)) 
      return  "truev";
    elseif(in_array($path, $Admin) || in_array($path, $Vendor) || in_array($path, $Delivery,true))
        return "falsev";
        }
    break;
        
    case "delivery" : {
    if(in_array($path,$Delivery)  || in_array($path, $Default)) 
      return  "truev";
    elseif(in_array($path, $Admin) || in_array($path, $Vendor) || in_array($path, $Customer,true))
        return "falsev";
        }
    break;
       
    
    }
}
else {
    if(in_array($path, $Admin) || in_array($path, $Vendor) || in_array($path, $Customer,true) || in_array($path, $Delivery,true))
        return "falsev";
    else
    return  "true";
    }
    }
}
/*elseif(!isset($_SESSION["user"])) {
if(in_array($path, $Admin) || in_array($path, $Vendor) || in_array($path, $Customer,true) || in_array($path, $Delivery,true)) 
    return  "trueel";
}
}*/
?>