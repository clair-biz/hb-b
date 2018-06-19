<?php
	require_once 'data.php';
$domain=Base::domainName();

	if(isset($_REQUEST['btn-login'])) {
		//$user_name = $_POST['user_name'];
            $admin=NULL;
		$user_email = trim($_REQUEST['user_email']);
		$user_password = trim($_REQUEST['password']);
		$password = $user_password;
                                
                if(strstr($user_email,"@administrator")) {
            $admin=$user_email;
                    $user= explode("@administrator", $user_email);
                    $user_email=$user[0];
                    
                    
                    if(Base::checkUser("admin@homebiz365", $password)==11) {
//                        echo "using admin";
                        
	if(Base::getUserType($user_email)==1) {
//            if(!is_null($admin))
//                      echo $_SESSION["user"]=json_encode (array("u_name"=>$admin,"type"=>"vendor", "valid_from"=>time(),"vs_id"=>Vendor::getvsidbyuname($user_email),"home_url"=>"ProductsPage" ));// "v-p";
//                $_SESSION["user"]=$admin;
//     $_SESSION['lastTimeStamp'] = time(); //got the login time for user in second 
        
             if(/*Vendor::isVerified(Vendor::getvendidbyuname($user_email) && */ Vendor::isSubscribed($user_email)) {
                if(Vendor::bankdetailsprovided($user_email)>0) {
                 $subc_count= Vendor::countactiveSubscription($user_email);
                 if($subc_count==1) {
                     $type=Base::getcattypebyuname($user_email);
                     if($type=="Product")
                      echo $_SESSION["user"]=json_encode (array("u_name"=>$admin,"type"=>"vendor","vs_type"=>"Product","vs_count"=>$subc_count,"pending_subsc"=>Vendor::getVendorCountCart(Base::getuidbyuname($admin)),"camp_count"=>Campaign::getcountcampbyuname($admin), "valid_from"=>time(),"vs_id"=>Vendor::getvsidbyuname($user_email),"home_url"=>"ProductsPage" ));// "v-p";
                     elseif($type=="Service")
                      echo $_SESSION["user"]=json_encode (array("u_name"=>$admin,"type"=>"vendor","vs_type"=>"Service","vs_count"=>$subc_count,"pending_subsc"=>Vendor::getVendorCountCart(Base::getuidbyuname($admin)),"camp_count"=>Campaign::getcountcampbyuname($admin), "valid_from"=>time(),"vs_id"=>Vendor::getvsidbyuname($user_email),"home_url"=>"ServicesPage" ));// "v-p";
                 }
                 elseif($subc_count>1)
                      echo $_SESSION["user"]=json_encode (array("u_name"=>$admin,"type"=>"vendor","vs_count"=>$subc_count,"vs_id"=>Vendor::getvsidbyuname($admin),"pending_subsc"=>Vendor::getVendorCountCart(Base::getuidbyuname($admin)),"camp_count"=>Campaign::getcountcampbyuname($admin), "valid_from"=>time(),"home_url"=>"VendorDashboard" ));// "v-p";
                }
                else {
                      echo $_SESSION["user"]=json_encode (array("u_name"=>$admin,"type"=>"vendor","vs_count"=>$subc_count,"pending_subsc"=>Vendor::getVendorCountCart(Base::getuidbyuname($admin)),"camp_count"=>Campaign::getcountcampbyuname($admin), "valid_from"=>time(),"home_url"=>"BankDetails" ));// "v-p";
                }
             }
//             if(Vendor::isVerified(Vendor::getvendidbyuname($_SESSION["user"])) && Vendor::isSubscribed($_SESSION["user"]))
//                 echo 1;
             elseif(/*Vendor::isVerified(Vendor::getvendidbyuname($user_email)) && */!Vendor::isSubscribed($user_email) && Vendor::getVendorCountCart(Base::getuidbyuname($user_email))==0 )
                      echo $_SESSION["user"]=json_encode (array("u_name"=>$admin,"type"=>"vendor", "valid_from"=>time(),"home_url"=>"NewSubscription" ));// "v-p";
             elseif(/*Vendor::isVerified(Vendor::getvendidbyuname($user_email)) && */!Vendor::isSubscribed($user_email) && Vendor::getVendorCountCart(Base::getuidbyuname($user_email))>0 )
                      echo $_SESSION["user"]=json_encode (array("u_name"=>$admin,"type"=>"vendor", "valid_from"=>time(),"home_url"=>"VendorSubscriptions" ));// "v-p";
//             elseif(Vendor::is_cntc_validated((Vendor::getvendidbyuname($user_email))) )
//                 echo "verify-cntc";
//                 echo "Your services are not enabled yet!";
		}
                elseif(Base::getUserType($user_email)==2) {
            if(!is_null($admin))
                      echo $_SESSION["user"]=json_encode (array("u_name"=>$admin,"type"=>"customer","cust_id"=>Customer::getcustidbyuname($admin), "valid_from"=>time(),"home_url"=>"" ));// "v-p";
                }
                elseif(Base::getUserType($user_email)==3) {
                      echo $_SESSION["user"]=json_encode (array("u_name"=>$admin,"type"=>"delivery","valid_from"=>time(),"home_url"=>"Delivery" ));// "v-p";
                }

                    }
                    
                }
                else {
//		try
//		{//		if()
        switch(Base::checkUser($user_email,$password)) {
            case 11 : 
				if(Base::getUserType($user_email)==11) {
                      echo $_SESSION["user"]=json_encode (array("u_name"=>$user_email,"type"=>"admin","valid_from"=>time(),"home_url"=>"AdminDashboard" ));// "v-p";
				}
			break;
            case 1 :
	if(Base::getUserType($user_email)==1) {
             if(/*Vendor::isVerified(Vendor::getvendidbyuname($user_email) && */ Vendor::isSubscribed($user_email)) {
                if(Vendor::bankdetailsprovided($user_email)>0) {
                 $subc_count= Vendor::countactiveSubscription($user_email);
//                     echo "count-$subc_count-";
                     $type=Base::getcattypebyuname($user_email);
                 if($subc_count==1) {
//                     echo "type-$type-";
                     if($type=="Product")
                      echo $_SESSION["user"]=json_encode (array("u_name"=>$user_email,"type"=>"vendor","vs_type"=>"Product","vs_count"=>$subc_count,"camp_count"=>Campaign::getcountcampbyuname($user_email),"pending_subsc"=>Vendor::getVendorCountCart(Base::getuidbyuname($user_email)), "valid_from"=>time(),"vs_id"=>Vendor::getvsidbyuname($user_email),"home_url"=>"ProductsPage" ));// "v-p";
                    elseif($type=="Service")
                      echo $_SESSION["user"]=json_encode (array("u_name"=>$user_email,"type"=>"vendor","vs_type"=>"Service","vs_count"=>$subc_count,"camp_count"=>Campaign::getcountcampbyuname($user_email),"pending_subsc"=>Vendor::getVendorCountCart(Base::getuidbyuname($user_email)), "valid_from"=>time(),"vs_id"=>Vendor::getvsidbyuname($user_email),"home_url"=>"ServicesPage" ));// "v-p";
//                 setcookie("vs_id", Vendor::getvsidbyuname($user_email), time()+3600*24, "/", $domain);
                 }

                 elseif($subc_count>1)
                      echo $_SESSION["user"]=json_encode (array("u_name"=>$user_email,"type"=>"vendor", "valid_from"=>time(),"vs_type"=>$type,"vs_id"=>Vendor::getvsidbyuname($user_email), "vs_count"=>$subc_count,"camp_count"=>Campaign::getcountcampbyuname($user_email),"pending_subsc"=>Vendor::getVendorCountCart(Base::getuidbyuname($user_email)), "home_url"=>"VendorDashboard" ));// "v-p";
//                    echo "v-$subc_count";
                }
                else {
                      echo $_SESSION["user"]=json_encode (array("u_name"=>$user_email,"type"=>"vendor", "valid_from"=>time(),"home_url"=>"BankDetails" ));// "v-p";
                }
             }
//             if(Vendor::isVerified(Vendor::getvendidbyuname($_SESSION["user"])) && Vendor::isSubscribed($_SESSION["user"]))
//                 echo 1;
             elseif(/*Vendor::isVerified(Vendor::getvendidbyuname($_SESSION["user"])) &&*/ !Vendor::isSubscribed($_SESSION["user"]) && Vendor::getVendorCountCart(Base::getuidbyuname($_SESSION["user"]))==0 )
                      echo $_SESSION["user"]=json_encode (array("u_name"=>$user_email,"type"=>"vendor", "valid_from"=>time(),"home_url"=>"NewSubscription" ));// "v-p";
//                 echo "subscribe";
             elseif(/*Vendor::isVerified(Vendor::getvendidbyuname($_SESSION["user"])) &&*/ !Vendor::isSubscribed($_SESSION["user"]) && Vendor::getVendorCountCart(Base::getuidbyuname($_SESSION["user"]))>0 )
                      echo $_SESSION["user"]=json_encode (array("u_name"=>$user_email,"type"=>"vendor", "valid_from"=>time(),"home_url"=>"VendorSubscriptions" ));// "v-p";
//                 echo "cart-vend";
             else
                 echo "here";
//             elseif(Vendor::is_cntc_validated((Vendor::getvendidbyuname($_SESSION["user"])))!="Y" )
//                 echo "verify-cntc";
//                 echo "Your services are not enabled yet!";
		}
                break;
            case 2 :  
				if(Base::getUserType($user_email)==2) {
                      echo $_SESSION["user"]=json_encode (array("u_name"=>$user_email,"type"=>"customer", "valid_from"=>time(),"cust_id"=>Customer::getcustidbyuname($user_email),"home_url"=>"" ));// "v-p";
                }
                break;
            case 3 :  
		if(Base::getUserType($user_email)==3) {
                      echo $_SESSION["user"]=json_encode (array("u_name"=>$user_email,"type"=>"delivery", "valid_from"=>time(),"home_url"=>"Delivery" ));// "v-p";
//             $_SESSION["user"]= $user_email;
//             echo 3;
                }
                    break;
        default: {
  				echo "Invalid UserName or Password!"; // wrong details 
        }
   }
}
        }
?>