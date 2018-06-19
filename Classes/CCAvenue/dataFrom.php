<html>
<head>
<script>
	window.onload = function() {
		var d = new Date().getTime();
		document.getElementById("tid").value = d;

        document.getElementById("form").submit();  
        };
</script>
</head>
<body>
<?php
require_once '../../data.php';

if(isset($_SESSION["subscription_data"]) && !empty($_SESSION["subscription_data"])) {
    $vst_id=$user->vst_id;
$subsc_data= unserialize($_SESSION["subscription_data"]);
//print_r($subsc_data);
$total=0;
$subsc_name="For ";

$merchant_id="159571";
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
$pincode= Vendor::getloczipbyvendname($name);
$addr= Vendor::getaddrbyvendname($name);
$city=Base::getlocdistbyzip($pincode);
$state=Base::getlocstatebyzip($pincode);
    
?>
	<form method="post" name="customerData" id="form" action="ccavRequestHandler.php">
            <table width="40%" height="100"  align="center" style="display: none;">
				<tr>
					<td>Parameter Name:</td><td>Parameter Value:</td>
				</tr>
				<tr>
					<td colspan="2"> Compulsory information</td>
				</tr>
				<tr>
					<td>TID	:</td><td><input type="hidden" name="tid" id="tid" readonly /></td>
				</tr>
				<tr>
                                    <td>Merchant Id	:</td><td><input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>" readonly /></td>
				</tr>
				<tr>
					<td>Order Id	:</td><td><input type="hidden" name="order_id" value="<?php echo $vst_id;?>"/></td>
				</tr>
				<tr>
					<td>Amount	:</td><td><input type="hidden" name="amount" value="<?php echo $total; ?>"/></td>
				</tr>
				<tr>
					<td>Currency	:</td><td><input type="hidden" name="currency" value="INR"/></td>
				</tr>
				<tr>
					<td>Redirect URL	:</td><td><input type="hidden" name="redirect_url" value="http://www.homebiz365.in/Classes/CCAvenue/ccavResponseHandler.php"/></td>
				</tr>
			 	<tr>
			 		<td>Cancel URL	:</td><td><input type="hidden" name="cancel_url" value="http://www.homebiz365.in/Classes/CCAvenue/ccavResponseHandler.php"/></td>
			 	</tr>
			 	<tr>
					<td>Language	:</td><td><input type="hidden" name="language" value="EN"/></td>
				</tr>
		     	<tr>
		     		<td colspan="2">Billing information(optional):</td>
		     	</tr>
		        <tr>
                            <td>Billing Name	:</td><td><input type="hidden" name="billing_name" value="<?php echo $name;?>"/></td>
		        </tr>
		        <tr>
		        	<td>Billing Address	:</td><td><input type="hidden" name="billing_address" value="<?php echo $addr?>"/></td>
		        </tr>
		        <tr>
		        	<td>Billing City	:</td><td><input type="hidden" name="billing_city" value="<?php echo $city; ?>"/></td>
		        </tr>
		        <tr>
		        	<td>Billing State	:</td><td><input type="hidden" name="billing_state" value="<?php echo $state; ?>"/></td>
		        </tr>
		        <tr>
		        	<td>Billing Zip	:</td><td><input type="hidden" name="billing_zip" value="<?php echo $pincode; ?>"/></td>
		        </tr>
		        <tr>
		        	<td>Billing Country	:</td><td><input type="hidden" name="billing_country" value="India"/></td>
		        </tr>
		        <tr>
		        	<td>Billing Tel	:</td><td><input type="hidden" name="billing_tel" value="<?php echo $cntc; ?>"/></td>
		        </tr>
		        <tr>
		        	<td>Billing Email	:</td><td><input type="hidden" name="billing_email" value="<?php echo $email; ?>"/></td>
		        </tr>
				<tr>
					<td>Promo Code	:</td><td><input type="hidden" name="promo_code" value=""/></td>
				</tr>
				<tr>
					<td>Vault Info.	:</td><td><input type="hidden" name="customer_identifier" value=""/></td>
				</tr>
		        <tr>
		        	<td>Integration Type	:</td><td><input type="hidden" name="integration_type" value="iframe_normal"/></td>
		        </tr>
		        <tr>
		        	<td></td><td><INPUT TYPE="submit" value="CheckOut"></td>
		        </tr>
	      	</table>
	      </form>
<?php
}


elseif(isset($_SESSION["ord_data"]) && !empty($_SESSION["ord_data"])) {
$value= unserialize($_SESSION["ord_data"]);
//print_r($subsc_data);
$total=0;
//$subsc_name="For ";

$merchant_id="159571";
//    if($subsc_name!="For ")
//    $subsc_name.=", ".Base::getcatnamebycatid ($value->cat_id);
//    else 
//    $subsc_name.=Base::getcatnamebycatid ($value->cat_id);
    $name=$value->name;
    $cntc=$value->cntc;
    $email=$value->email;
    $total= round($value->subtotal);
    $pincode=$value->zip;
    $vst_id=$value->ord_id;
    $addr=$value->addr;

$city=Base::getlocdistbyzip($pincode);
$state=Base::getlocstatebyzip($pincode);
    
?>
	<form method="post" name="customerData" id="form" action="ccavRequestHandler.php">
            <table width="40%" height="100"  align="center" style="display: none">
				<tr>
					<td>Parameter Name:</td><td>Parameter Value:</td>
				</tr>
				<tr>
					<td colspan="2"> Compulsory information</td>
				</tr>
				<tr>
					<td>TID	:</td><td><input type="hidden" name="tid" id="tid" readonly /></td>
				</tr>
				<tr>
                                    <td>Merchant Id	:</td><td><input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>" readonly /></td>
				</tr>
				<tr>
					<td>Order Id	:</td><td><input type="hidden" name="order_id" value="<?php echo $vst_id;?>"/></td>
				</tr>
				<tr>
					<td>Amount	:</td><td><input type="hidden" name="amount" value="<?php echo $total; ?>"/></td>
				</tr>
				<tr>
					<td>Currency	:</td><td><input type="hidden" name="currency" value="INR"/></td>
				</tr>
				<tr>
					<td>Redirect URL	:</td><td><input type="hidden" name="redirect_url" value="http://www.homebiz365.in/Classes/CCAvenue/ccavResponseHandler.php"/></td>
				</tr>
			 	<tr>
			 		<td>Cancel URL	:</td><td><input type="hidden" name="cancel_url" value="http://www.homebiz365.in/Classes/CCAvenue/ccavResponseHandler.php"/></td>
			 	</tr>
			 	<tr>
					<td>Language	:</td><td><input type="hidden" name="language" value="EN"/></td>
				</tr>
		     	<tr>
		     		<td colspan="2">Billing information(optional):</td>
		     	</tr>
		        <tr>
                            <td>Billing Name	:</td><td><input type="hidden" name="billing_name" value="<?php echo $name;?>"/></td>
		        </tr>
		        <tr>
		        	<td>Billing Address	:</td><td><input type="hidden" name="billing_address" value="<?php echo $addr?>"/></td>
		        </tr>
		        <tr>
		        	<td>Billing City	:</td><td><input type="hidden" name="billing_city" value="<?php echo $city; ?>"/></td>
		        </tr>
		        <tr>
		        	<td>Billing State	:</td><td><input type="hidden" name="billing_state" value="<?php echo $state; ?>"/></td>
		        </tr>
		        <tr>
		        	<td>Billing Zip	:</td><td><input type="hidden" name="billing_zip" value="<?php echo $pincode; ?>"/></td>
		        </tr>
		        <tr>
		        	<td>Billing Country	:</td><td><input type="hidden" name="billing_country" value="India"/></td>
		        </tr>
		        <tr>
		        	<td>Billing Tel	:</td><td><input type="hidden" name="billing_tel" value="<?php echo $cntc; ?>"/></td>
		        </tr>
		        <tr>
		        	<td>Billing Email	:</td><td><input type="hidden" name="billing_email" value="<?php echo $email; ?>"/></td>
		        </tr>
					     	<tr>
		     		<td colspan="2">Shipping information(optional):</td>
		     	</tr>
		        <tr>
                            <td>Shipping Name	:</td><td><input type="hidden" name="delivery_name" value="<?php echo $name;?>"/></td>
		        </tr>
		        <tr>
		        	<td>Shipping Address	:</td><td><input type="hidden" name="delivery_address" value="<?php echo $addr?>"/></td>
		        </tr>
		        <tr>
		        	<td>Shipping City	:</td><td><input type="hidden" name="delivery_city" value="<?php echo $city; ?>"/></td>
		        </tr>
		        <tr>
		        	<td>Shipping State	:</td><td><input type="hidden" name="delivery_state" value="<?php echo $state; ?>"/></td>
		        </tr>
		        <tr>
		        	<td>Shipping Zip	:</td><td><input type="hidden" name="delivery_zip" value="<?php echo $pincode; ?>"/></td>
		        </tr>
		        <tr>
		        	<td>Shipping Country	:</td><td><input type="hidden" name="delivery_country" value="India"/></td>
		        </tr>
		        <tr>
		        	<td>Shipping Tel	:</td><td><input type="hidden" name="delivery_tel" value="<?php echo $cntc; ?>"/></td>
		        </tr>
	
                                <tr>
					<td>Promo Code	:</td><td><input type="hidden" name="promo_code" value=""/></td>
				</tr>
				<tr>
					<td>Vault Info.	:</td><td><input type="hidden" name="customer_identifier" value="<?php echo $name." ".$cntc." ".$email; ?>"/></td>
				</tr>
		        <tr>
		        	<td>Integration Type	:</td><td><input type="hidden" name="integration_type" value="iframe_normal"/></td>
		        </tr>
		        <tr>
		        	<td></td><td><INPUT TYPE="submit" value="CheckOut"></td>
		        </tr>
	      	</table>
	      </form>
<?php
}
?>
	</body>
</html>

