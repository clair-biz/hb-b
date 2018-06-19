<html>
    <body>
<?php include('Crypto.php')?>
<?php
require_once '../../data.php';

	error_reporting(0);
	$workingKey="CCF562F216E4B5CA9684ACD27C32E30B";		//Working Key should be provided here.
	
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$tracking_id="";
	$decryptValues=explode("&", $rcvdString);
	$dataSize=sizeof($decryptValues);
//        print_r($decryptValues);
//        echo "<br />";
	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode("=",$decryptValues[$i]);
		if($i==3)	$order_status=$information[1];
		if($i==1)	$tracking_id=$information[1];
		if($i==2)	$bank_ref=$information[1];

                print_r($information);
                echo "<br />";
	}

	echo "<center>";
if(isset($_SESSION["subscription_data"]) && !empty($_SESSION["subscription_data"])) {
    $vst_id=$_REQUEST["vst_id"];
$subsc_data= unserialize($_SESSION["subscription_data"]);
print_r($subsc_data);
//$order_status="Success";

	if($order_status==="Success")
	{
    foreach ($subsc_data as $n) {
        if($n->cat_id==39) {
        if(!is_null($n->fssai_no))
        $n->vs_pay_status="Enabled";
        elseif(empty($n->fssai_no))
        $n->vs_pay_status="Wait4FSSAI";
        }
        else $n->vs_pay_status="Enabled";
                if($n->newVendorSubscription() ) {
                    $vst_id=$user->vst_id;
                    $vs_id=  Vendor::getvsidbyunamencatid($user->u_name, $n->cat_id);
                    if(Vendor::newvstransaction($vst_id,$vs_id,"New",$n->vs_total,$order_status,$tracking_id,$bank_ref,$user->u_name)) {
            ?>
    <script>
        var vs_id="<?php echo $vs_id; ?>";
        document.cookie="vs_id="+vs_id;
        </script>
        <?php
                    }
                    else
                        $order_status="Success1";
                }
            }
            Email::sendNewSubscriptionDetailsOnline();
            Sms::NewEnabledVendorNotification();

        }
}

elseif(isset($_SESSION["ord_data"]) && !empty($_SESSION["ord_data"])) {
$ord_data= unserialize($_SESSION["ord_data"]);
$order_status="Success";
print_r($ord_data);
	if($order_status==="Success")
	{
            $ot=Base::getAIValue("ord_trans");
            $query="insert into ord_trans(ot_id,ot_amount,track_id,bank_ref,ot_status,ins_dt,ins_usr) values($ot,$ord_data->subtotal,'$tracking_id','$bank_ref','$order_status',now(),'".$user->u_name."');";
            echo $query;
            if(Base::generateResult( $query)){
            
            $value=new Customer();
    $value->cust_id=$user->cust_id;
    $value->cust_fname=$ord_data->name;
    $value->cust_cntc=$ord_data->cntc;
    $value->cust_email=$ord_data->email;
    $value->loc_zip=$ord_data->zip;
    $value->cust_addr=$ord_data->addr;
    
    if(!$value->checkShipAddr()>0) {
    $value->sa_id=Base::getAIValue("ship_addr");
        $value->InsertShipAddr();
    }
    else
        $value->sa_id=$value->getSAID ();
    
    $sa_id=$value->sa_id;
            echo "said -$sa_id-<br><br><br><br>";
            $ords="";
            $query="select distinct vs_id from cart,product where product.prod_id=cart.prod_id and cust_id=".$user->cust_id;
            echo $query;
            $res= Base::generateResult( $query);
            while($vs= mysqli_fetch_array($res)) {
                $countdt="select distinct req_dt,date_format(req_dt,'%d-%m-%Y') from cart,product where cart.prod_id=product.prod_id and cust_id=".$user->cust_id." and  vs_id=".$vs[0];
                echo $countdt;
                $resreqdt=Base::generateResult($countdt);
                $countreqdt=mysqli_num_rows($resreqdt);
                echo $countreqdt;
                if($countreqdt>0) {
                    while($rowreqdt= mysqli_fetch_array($resreqdt)) {
                $countslots="select distinct cart.bs_id,bs_from,bs_to from cart,product,booking_slots where booking_slots.bs_id=cart.bs_id and cart.prod_id=product.prod_id and req_dt=cast(N'".$rowreqdt[0]."' as date) and cust_id=".$user->cust_id." and vs_id=".$vs[0];
                echo $countdt;
                $resslots=Base::generateResult($countslots);
//                $countslots=mysqli_num_rows($resreqdt);
                echo $countslots;
                    while($rowslots= mysqli_fetch_array($resslots)) {
                $ship_charge=0;//100;//Product::getShippingCharge($ord->qty*($row[5]/1000));
                echo "here";
                $ord_amt=Order::getOrdCost($user->cust_id, $vs[0], $rowreqdt[0], $rowslots[0]);
                echo $ord_amt;
                $sc_cust=Order::getShipCharge($user->cust_id, $vs[0], $rowreqdt[0], $rowslots[0],"cust_perc");
                $sc_vend=0;//Order::getShipCharge($user->cust_id, $vs[0], $rowreqdt[0], $rowslots[0],"vend_perc");
                $sc_hb=0;//Order::getShipCharge($user->cust_id, $vs[0], $rowreqdt[0], $rowslots[0],"hb_perc");
                $sc_off=0;//Order::getShipCharge($user->cust_id, $vs[0], $rowreqdt[0], $rowslots[0],"sc_off");
                $ord_id=Base::getAIValue("ordertbl");
                    $query="insert into ordertbl(ord_id,cust_id,sa_id,req_dt,bs_id,ord_amount,sc_cust,sc_vend,sc_hb,sc_off,ot_id,ins_dt,ins_usr) values($ord_id,".$user->cust_id.",$sa_id,cast(N'".$rowreqdt[0]."' as date),".$rowslots[0].",".$ord_amt.",$sc_cust,$sc_vend,$sc_hb,$sc_off,$ot,now(),'".$user->u_name."' );";
                    $query.="insert into delivery(ord_id,d_type,d_date,ins_dt,ins_usr) values($ord_id,'Order',cast(N'".$rowreqdt[0]."' as date),now(),'".$user->u_name."' );";
                    echo $query;
                    if(Base::generateMultiResult($query)) {
                               
                    $query="select product.prod_id,qty,cart_id from cart,product,product_price where product.prod_id=product_price.prod_id and product.prod_id=cart.prod_id and req_dt='".$rowreqdt[0]."' and bs_id=".$rowslots[0]." and cust_id=".$user->cust_id."  and vs_id=".$vs[0];
                echo $query;
                $invc_amt=0;
            $res= Base::generateResult( $query);
            while($row= mysqli_fetch_array($res)) {
                $ord=new Order();
                $ord->ord_id=$ord_id;
                $ord->prod_id=$row[0];
                $ord->qty=$row[1];
                $ord->user=$user->u_name;
//                $qty=Base::convertToMajor($ord->qty*$row[3],$row[4]);
//                print_r($ord);
//                echo "-".$row[3]."-";
//                echo "-".$row[3]*$ord->qty."-";
                $ord->rate=(Base::getDiscount($ord->prod_id,$ord->qty));
//                $ord->unit=NULL;
                $amount+=$ord->rate;
                $ord->cgst=((Order::getTax($ord->prod_id,"cgst"))*($ord->qty));
                $ord->sgst=((Order::getTax($ord->prod_id,"sgst"))*($ord->qty));
                $ord->cess=($ord->cgst+$ord->sgst)*(Order::getTax($ord->prod_id,"cess")/100);
//                echo $amount;
                $invc_amt+=$ord->rate;
                
                $cust_cntc= Customer::getcustcntcbyid($user->cust_id);
                $vend_cntc= Vendor::getvendcntcbyprodid($ord->prod_id);
                $prod_name= Product::getprodnamebyid($ord->prod_id);
                if( $ord->OrderInsert())// && Sms::sendOrderInfo($cust_cntc,$prod_name,$ord_id,$amount,$rowreqdt[1],$rowslots[1]."-".$rowslots[2]) && Sms::sendOrderNotification($vend_cntc,$prod_name,$ord_id,$amount,$rowreqdt[1],$rowslots[1]."-".$rowslots[2]) /*&& Order::removeCartItem($row[2])*/)
                    continue;
            }
            $invc_amt+=$sc_cust;
            $invc_id=Base::getAIValue("invoice");
                    $query="insert into invoice(invc_id,ord_id,invc_amt,ins_dt,ins_usr) values($invc_id,$ord_id,$invc_amt,now(),'".$user->u_name."');";
                    echo $query;
                    Base::generateResult( $query);
//                        continue;
                if($ords=="")
                    $ords.=$ord_id;
                else
                    $ords.=",".$ord_id;
                
                echo "<br>-ords--$invc_id-<br>";
            Email::generatePO4V($ord_id,$vs[0]);
            PDF::generateInvoiceTago($invc_id);
            echo "$invc_id<br><br><br><br>";
//            $ord_data 
                            }
                        }
                        $r_within=Product::getMaxRWithin($ord_id);
                    $query="update ordertbl set r_within=$r_within where ord_id=$ord_id;";
                    Base::generateResult( $query);
                    }
            Email::generatePO($ords,$ord_data->wallet);
                    if($ord_data->wallet>0) {
                        $u_id=Base::getuidbyuname($user->u_name);
                        $wallet_avail=Base::getWalletAmt($u_id);
                        $redeemed=Base::getWalletRedeemed($u_id);
                        $q="update users set wallet_amt=$wallet_avail-".$ord_data->wallet.",redeemed=$redeemed+".$ord_data->wallet.",upd_dt=now(), upd_usr='".$user->u_name."' where u_id=$u_id";
                        echo $q;
                        if(Base::generateResult( $q))
                        continue;
                    }

                    }
            }
        }
    }
}

?>
    <script>
        var msg="<?php echo $order_status; ?>";
        console.log("message -"+msg+"-");
//                    window.location.href="http://www.homebiz365.in/TransactionMessage/"+msg;
                    </script>
<?php
	echo "</center>";
?>
    </body>
    </html>