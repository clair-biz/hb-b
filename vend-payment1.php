<html>
    <body>
<?php
require_once 'data.php';
        $u_id=Base::getuidbyuname($user->u_name);
$pay=$_REQUEST['options'];
switch($pay){
    case 'offline':
        $q="select `u_id`, `cat_id`, `other_cat`, `bname`, `gst_no`, `vend_open_time`, `vend_close_time`, `city_served`, `vs_for` from vs_cart where is_active='Y' and u_id=$u_id;";
        $m=Base::generateResult($q);
        $count= mysqli_num_rows($m);
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

    if($n->cat_id>0)
    $n->vs_pay_status="Approved";
    
    $n->vs_for=$row[8];
    $n->vend_fname= Vendor::getvendnamebyid(Vendor::getvendidbyuname($user->u_name));
    $n->vend_email= Vendor::getvendemailbyvendid(Vendor::getvendidbyuname($user->u_name));
    $n->vend_cntc= Vendor::getvendcntcbyvendid(Vendor::getvendidbyuname($user->u_name));
   
    $category="";
    $split= explode(" ", $row[8]);
                   $n->vs_subtotal=Base::getSubtotal($split[0],$split[1],$row[1]); 
                   $n->vs_tax=Base::getTax($split[0],$split[1],$row[1]); 
                   $n->vs_total=$n->vs_subtotal+($n->vs_subtotal*($n->tax/100)); 
    if($n->cat_id>0 && $n->cat_id==$n->other_cat || $n->other_cat==NULL) {
        $category=Base::getcatnamebycatid ($n->cat_id);
                   if($n->newVendorSubscription() && Email::sendNewSubscriptionDetailsOffline(serialize($n)) && Sms::NewApprovedVendorNotification($n->vend_fname, $category, $n->vend_cntc) )
                       $count--;
    }
    else {
        $category=$n->other_cat;
    if($n->newVendorSubscription() && Email::sendNewSubscriptionDetailsOffline(serialize($n)) && Sms::NewVendorNotification($n->vend_fname, $category, $n->vend_cntc) )
        $count--;
    }
    }
    
    if($count==0) {
        ?>
    <script type="text/javascript">
                    var root=window.location.origin;
                    window.location.href=root+"StartSelling";
//        alert("Thank you!\nWe would contact you soon!");
//	        window.location.href="how-it-works-vendor.php";
    </script>
<?php
    }
    else {
        ?>
    <script type="text/javascript">
                    var root=window.location.origin;
                    window.location.href=root+"VendorSubscriptions";
    </script>
<?php
    }
    break;
    case "online":
        $trans=0;
        $q="select `u_id`, `cat_id`, `other_cat`, `bname`, `fssai_no`, `vend_open_time`, `vend_close_time`, `city_served`, `vs_for` from vs_cart where cat_id<>0 and is_active='Y' and u_id=$u_id;";
        $m=Base::generateResult($q);
        $count= mysqli_num_rows($m);
        $vst_id=Base::getAIValue("vend_trans");
        ?>
    <script>
        var id="<?php echo $vst_id; ?>";
    var vstid="vst_id="+id;
    document.cookie=vstid;

    </script>
    <?php
        $i=0;
        $arr= array();
        $total=0;
        while($row= mysqli_fetch_array($m)){
        $n=new Vendor();
        $n->u_id=$row[0];
        $n->cat_id=$row[1];
        $n->bname=$row[3];
        $n->fssai_no=$row[4];
        $n->other_cat=$row[2];
        $n->vend_open_time=$row[5];
        $n->vend_close_time=$row[6];
        $n->city_served=$row[7];

        if($n->cat_id>0)
            $n->vs_pay_status="Processing";

        $n->vs_for=$row[8];
        $n->vend_fname= Vendor::getvendnamebyid(Vendor::getvendidbyuname($user->u_name));
        $n->vend_email= Vendor::getvendemailbyvendid(Vendor::getvendidbyuname($user->u_name));
        $n->vend_cntc= Vendor::getvendcntcbyvendid(Vendor::getvendidbyuname($user->u_name));

        $category="";
    
    $split= explode(" ", $row[8]);
                   $n->vs_subtotal=Base::getSubtotal($split[0],$split[1],$row[1]); 
                   $n->vs_tax=Base::getTax($split[0],$split[1],$row[1]); 
                   $n->vs_total=$n->vs_subtotal+($n->vs_subtotal*($n->vs_tax/100)); 

                   $total+=$n->vs_total;
//                if($n->newVendorSubscription()) {
//                    $vs_id=  Vendor::getvsidbyunamencatid($user->u_name, $n->cat_id);
//                    Vendor::newvstransaction($vst_id,$vs_id,"New",$n->vs_total,"Processing",$user->u_name);
//                }
        $arr[$i++]=$n;
        $trans=1;
        }
        
        $_SESSION["subscription_data"]= serialize($arr);
        
        
                    $q="select `u_id`, `cat_id`, `other_cat`, `bname`, `fssai_no`, `vend_open_time`, `vend_close_time`, `city_served`, `vs_for`,vsc_id from vs_cart where cat_id=0 and is_active='Y' and u_id=$u_id;";
                    echo $q;
        $m=Base::generateResult($q);
        $count0= mysqli_num_rows($m);
        while($row= mysqli_fetch_array($m)){
            $vs_id=Base::getAIValue("vend_subscription");
          $n=new Vendor();
    $n->vs_id=$vs_id;
    $n->u_id=$row[0];
    $n->cat_id=$row[1];
    $n->bname=$row[3];
    $n->fssai_no=$row[4];
    $n->other_cat=$row[2];
    $n->vend_open_time=$row[5];
    $n->vend_close_time=$row[6];
    $n->city_served=$row[7];

    
    $n->vs_for=$row[8];
    $n->vend_fname= Vendor::getvendnamebyid(Vendor::getvendidbyuname($user->u_name));
    $n->vend_email= Vendor::getvendemailbyvendid(Vendor::getvendidbyuname($user->u_name));
    $n->vend_cntc= Vendor::getvendcntcbyvendid(Vendor::getvendidbyuname($user->u_name));
   
    $category="";
 //   $split= explode(" ", $row[8]);
//                   $n->vs_subtotal=Base::getSubtotal($split[0],$split[1],$row[1]); 
//                   $n->vs_tax=Base::getTax($split[0],$split[1],$row[1]); 
//                   $n->vs_total=$n->vs_subtotal+($n->vs_subtotal*($n->tax/100)); 
        $category=$n->other_cat;
        $query="update vs_cart set is_active='N',vs_id=$vs_id where vsc_id=".$row[9];
        echo $query;
    if($n->newVendorSubscription() && Base::generateResult( $query) && Email::sendNewSubscriptionDetailsOffline(serialize($n)) && Sms::NewVendorNotification($n->vend_fname, $category, $n->vend_cntc) )
        $count0--;
    }
if($trans==0) {
        ?>
    <script>
        var msg="success";
        console.log("message -"+msg+"-");
                    window.location.href="http://www.homebiz365.in/TransactionMessage/"+msg;
                    </script>
<?php
}
elseif($trans==1) {
?>
    <script>
                    var root="<?php echo Base::root(); ?>";
                    window.location.href=root+"Classes/CCAvenue/dataFrom.php";
    </script>
<?php    
}
//        exit();
//        $category=Base::getcatnamebycatid ($n->cat_id);
        
//                   if($n->newVendorSubscription() /*&& Email::sendNewSubscriptionDetailsOnline(serialize($n)) && Sms::NewApprovedVendorNotification($n->vend_fname, $category, $n->vend_cntc)*/ )

                  break;  
}
?>
    </body>
</html>