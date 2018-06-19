<?php
require_once 'data.php';

$path=$_REQUEST["path"];
echo $path;
$Default=Array("Services","Products","Cart","CustomerRegistration","VendorRegistration","About","FAQ","Contact","HowItWorks","StartSelling","Login","Logout","PrivacyPolicy","Terms","VerifyMobileNumber",);
$Customer=Array("Services","Products","OrderCheckOut","MyOrders","CustomerProfile","CustomerRegistration","ForgotPassword","ChangePassword","Return");
$Delivery=Array("Delivery");  
$Vendor=array("ProductsPage","BankDetails","OrdersPage","VendorSubscriptions","RateChart","ChangePassword","SubscriptionPayment","AddOffer","AddProductToOffer","AddServiceToOffer","UpdateOffer","MyOffers","VendorDashboard","AddProduct","UpdateProduct","VendorProfile","OrderFullChart","OrderFull","ServicesPage","VendorRegistration","AddService","UpdateService","NewSubscription");//Array("RegistrationForm","AdminDashboard","Products","AddProduct","UpdateProduct","Members","ExtendMembership","PrintReceipt","Customers","UpdateCustomer","Campaigns");
$Admin=array("AdminDashboard","Categories","Customers","UpdateRate","Vendors","Refunds","AddRatePlan","AdminRateChart","SubscriptionRequest","Reports");//Array("RegistrationForm","AdminDashboard","Products","AddProduct","UpdateProduct","Members","ExtendMembership","PrintReceipt","Customers","UpdateCustomer","Campaigns");
$path= explode("/", $path);
$path=$path[1];

if(isset($_SESSION["user"])!="" && !empty($user)) {
    echo $type;
    switch ($user->type) {
        case "admin" : {
    if(in_array($path,$Admin,true) || in_array($path, $Default))
        echo  "truea";
    elseif(in_array($path, $Vendor,true) || in_array($path, $Customer,true) || in_array($path, $Delivery,true))
        echo "falsea";
    }
            break;
        case "vendor" : {
    if(in_array($path,$Vendor,true)  || in_array($path, $Default))
        echo  "truev";
    elseif(in_array($path, $Admin) || in_array($path, $Customer) || in_array($path, $Delivery,true))
        echo "falsev";
    }
            break;
            
        case "customer" : {
    if(in_array($path,$Customer)  || in_array($path, $Default)) 
      echo  "truev";
    elseif(in_array($path, $Admin) || in_array($path, $Vendor) || in_array($path, $Delivery,true))
        echo "falsev";
        }
    break;
        
    case "delivery" : {
    if(in_array($path,$Delivery)  || in_array($path, $Default)) 
      echo  "truev";
    elseif(in_array($path, $Admin) || in_array($path, $Vendor) || in_array($path, $Customer,true))
        echo "falsev";
        }
    break;
       
    
    }
}
else {
if(in_array($path, $Admin) || in_array($path, $Vendor) /* || in_array($path, $Customer,true) */|| in_array($path, $Delivery,true)) 
    echo  "falsel";
else
    echo  "trueel";
}
?>