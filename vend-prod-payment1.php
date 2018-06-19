<?php
require_once 'header.php';
$cust_id=0;
if(isset($_COOKIE["cust"])!="")
$cust_id=$_COOKIE["cust"];
//$u_id=Crm::getuidbyuname($_SESSION['user']);
$name=$_REQUEST['name'];
$saddr=$_REQUEST['saddr'];
$czip=$_REQUEST['czip'];
$ccntc=$_REQUEST['ccntc'];
$cemail1=$_REQUEST['cemail1'];
$pay=$_REQUEST['options'];

switch($pay){
    case 'offline':
$q=mysqli_query(Crm::con(),"SELECT cust_fname,cust_lname,prod_name,cart.prod_id,cart.qty,mrp,bname,cart_id,prod_desc,prod_img,req_dt,cart.unit,for_major from cart,customer,product,product_price,users,vendor,vend_subscription WHERE product.vs_id=vend_subscription.vs_id and vendor.vend_id=users.vend_id and vend_subscription.u_id=users.u_id and product_price.prod_id=product.prod_id and product.prod_id=cart.prod_id and customer.cust_id=cart.cust_id and cart.cust_id=".$_COOKIE["cust"].";");  
        $m=mysqli_query(Crm::con(),$q);
        $count= mysqli_num_rows($m);
        $subtotal=0;
        $arr=array();
        while($row= mysqli_fetch_array($m)){
          $n=new Customer();
    $arr["cust_fname"]=$row[0];
    $arr["cust_cntc"]=$row[1];
    $arr["cust_email"]=$row[2];
    $arr["cust_addr"]=$row[3];
    $arr["loc_zip"]=$row[4];
                    $qty=Crm::convertToMajor($row[4], $row[11]);
                if(Crm::getDiscount($row[3], $row[4], $row[11])>0)
                    $subtotal+=Crm::getDiscount($row[3], $row[4], $row[11]);
                else
                    $subtotal+=$row[12]*$qty;
        }
        $arr["subtotal"]=$subtotal;
        $arr["city"]=Crm::getlocdistbyzip($arr["loc_zip"]);
        $arr["state"]=Crm::getlocstatebyzip($arr["loc_zip"]);
        $_SESSION["cust_data"]= serialize($arr);

?>
    
    <script type="text/javascript">
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-ali   gn'>Thank You!\nWe would contact you soon!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href="./start-selling";
                });
//        alert("Thank you!\nWe would contact you soon!");
//	        window.location.href="how-it-works-vendor.php";
    </script>
<?php
    }
    else {
        ?>
    <script type="text/javascript">
	        window.location.href="cart-vend.php";
    </script>
<?php
    }
    break;
    case "online":
        $q="select `u_id`, `cat_id`, `other_cat`, `bname`, `gst_no`, `vend_open_time`, `vend_close_time`, `city_served`, `vs_for` from vs_cart where cat_id<>0 and u_id=$u_id;";
        $m=mysqli_query(Crm::con(),$q) or die("error ". mysqli_error(Crm::con()));
        $count= mysqli_num_rows($m);
        $vst_id=Vendor::newVstId();
        $i=0;
        $arr= array();
        $total=0;
        while($row= mysqli_fetch_array($m)){
        $n=new Vendor();
        $n->u_id=$row[0];
        $n->cat_id=$row[1];
        $n->bname=$row[3];
        $n->gst_no=$row[4];
        $n->other_cat=$row[2];
        $n->vend_open_time=$row[5];
        $n->vend_close_time=$row[6];
        $n->city_served=$row[7];

        if($n->cat_id!=0)
            $n->vs_pay_status="Processing";

        $n->vs_for=$row[8];
        $n->vend_fname= Vendor::getvendfnamelnamebyid(Vendor::getvendidbyuname($_SESSION["user"]));
        $n->vend_email= Vendor::getvendemailbyvendid(Vendor::getvendidbyuname($_SESSION["user"]));
        $n->vend_cntc= Vendor::getvendcntcbyvendid(Vendor::getvendidbyuname($_SESSION["user"]));

        $category="";
    
    $split= explode(" ", $row[8]);
                   $n->vs_subtotal=Crm::getSubtotal($split[0],$split[1],$row[1]); 
                   $n->vs_tax=Crm::getTax($split[0],$split[1],$row[1]); 
                   $n->vs_total=$n->vs_subtotal+($n->vs_subtotal*($n->vs_tax/100)); 

                   $total+=$n->vs_total;
                if($n->newVendorSubscription()) {
                    $vs_id=  Vendor::getvsidbyunamencatid($_SESSION["user"], $n->cat_id);
                    Vendor::newvstransaction($vst_id,$vs_id,"New",$n->vs_total,"Processing",$_SESSION["user"]);
                }
        $arr[$i++]=$n;
        }
        setcookie("vst_id",$vst_id);
        $_SESSION["subscription_data"]= serialize($arr);
        header("location:Classes/razorpay/pay.php?checkout=automatic");
        exit();
//        $category=Crm::getcatnamebycatid ($n->cat_id);
        
//                   if($n->newVendorSubscription() /*&& Email::sendNewSubscriptionDetailsOnline(serialize($n)) && Sms::NewApprovedVendorNotification($n->vend_fname, $category, $n->vend_cntc)*/ )

                  break;  
}
?>