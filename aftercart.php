<html>
    <head>
        <?php require_once 'stylesheets.html';?>
    </head>
<body>
<section class="body" >
    <section class="preloader" ></section>
    <section class="content" >
<?php
require_once 'data.php';



$cust_id=0;
if(isset($user->cust_id)!="")
$cust_id=$user->cust_id;
$stmtcart=Base::generateResult("select cust_fname,cust_cntc,cust_addr,cust_email,loc_zip from customer,users where users.cust_id=customer.cust_id and users.cust_id=".$user->cust_id.";");  
$count=0;
                $subtotal=0;
                $shipping=0;
if($row=mysqli_fetch_array($stmtcart)){
$wallet=0;
if(Order::getWalletAmt($user->u_name)>0)
    $wallet=Order::getWalletAmt($user->u_name);
$prod_count=Order::getCountCart($cust_id);
?>
    <div class="container-fluid" style="margin-top: 40px;">
<div id="gototop"> </div>

<!-- 
Body Section 
-->
    <div class="row">
	<div class="offset-md-1 col-lg-offset-1 col-md-10 col-lg-10">
	
                <?php
            $query="select distinct vs_id from cart,product where product.prod_id=cart.prod_id and cust_id=".$user->cust_id;
//            echo $query;
            $res= Base::generateResult( $query);
            while($vs= mysqli_fetch_array($res)) {
                $countdt="select distinct req_dt,date_format(req_dt,'%d-%m-%Y') from cart,product where cart.prod_id=product.prod_id and cust_id=".$user->cust_id." and vs_id=".$vs[0];
//                echo $countdt;
                $resreqdt=Base::generateResult($countdt);
                $countreqdt=mysqli_num_rows($resreqdt);
//                echo $countreqdt;
                if($countreqdt>0) { 
                    while($rowreqdt= mysqli_fetch_array($resreqdt)) { ?>
    <?php
                $countslots="select distinct cart.bs_id,bs_from,bs_to from cart,product,booking_slots where booking_slots.bs_id=cart.bs_id and cart.prod_id=product.prod_id and req_dt=cast(N'".$rowreqdt[0]."' as date) and vs_id=".$vs[0];
  //              echo $countdt;
                $resslots=Base::generateResult($countslots);
                $countslots=mysqli_num_rows($resreqdt);
//                echo $countslots;
                    while($rowslots= mysqli_fetch_array($resslots)) { ?>
            <div class="card border-0 mb-5">
                <div class="card-body p-0">
                    <div class="row mb-2" >
                        <div class="col-md-6" >
                            <?php echo "Required On: ".$rowreqdt[1]; ?>
                        </div>
                        <div class="col-md-6" >
                            <?php echo "Time Slot: ".$rowslots[1]." - ".$rowslots[2]; ?>
                        </div>
                        
                    </div>
<?php 
                        $query="SELECT cust_fname,cust_lname,prod_name,cart.prod_id,cart.qty,mrp+(mrp*(tax_table.cgst/100))+(mrp*(tax_table.sgst/100))+ (mrp*(tax_table.cess/100)) ,bname,cart_id,prod_desc,prod_img,req_dt,product.prod_unit,mrp_for,mrp_unit,weight,prod_qty from tax_table,cart,customer,product,product_price,users,vendor,vend_subscription WHERE tax_table.hsn_code=product.hsn_code and product.vs_id=vend_subscription.vs_id and vendor.vend_id=users.vend_id and vend_subscription.u_id=users.u_id  and product_price.prod_id=product.prod_id and product.prod_id=cart.prod_id and customer.cust_id=cart.cust_id and cart.cust_id=".$user->cust_id." and bs_id=".$rowslots[0]." and req_dt=cast(N'".$rowreqdt[0]."' as date) and product.vs_id=".$vs[0].";";
//                        echo $query;
$stmtcart1=Base::generateResult($query);  
?>
	<table class="table table-borderless table-order-checkout mb-0" style="border: none;">
            <thead>
                <tr style="background: rgba(32, 162, 91, 0.3);">
                  <th class="border-top border-bottom" style="padding: 2px 5px;">Product</th>
                  <th class="border-top border-bottom" style="padding: 2px 5px;">Price</th>
                  <th class="border-top border-bottom" style="padding: 2px 5px;">Qty </th>
                  <th class="border-top border-bottom" style="padding: 2px 5px;">Total</th>
                </tr>
              </thead>
              <tbody>
            <?php
            $sub=0;
                $ship_charge=Order::getShipCharge($user->cust_id, $vs[0], $rowreqdt[0], $rowslots[0],"cust_perc");                    
                $shipping+=$ship_charge;
                while($cart=mysqli_fetch_array($stmtcart1)) {//} && $count++<=$prod_count){
//                echo "qty-$qty-";
                $qty=$cart[4];
//                if(Base::getDiscount($cart[3], $qty/*, $cart[11]*/)>0)
                    $subtotal+=Base::getDiscount($cart[3], $qty/*, $cart[11]*/);
/*                else
                    $subtotal+=$cart[5]*$qty;*/
                $sub+=Base::getDiscount($cart[3], $qty/*, $cart[11]*/);
/*                    if(($cart[14]*$qty)<=3) {
                            $subtotal+=100;
                            $shipping=100;
                    }
                    else {
                        

                    }
                    
//        if(Base.getDiscount(cart.getInt(4),cart.getInt(5))>0)
                /*    if($cart[11]=="GM" || $cart[11]=="mL")*/
/*                    else
    $subtotal+=($cart[4]*$cart[5]);*/
?>
                <tr>
                  <td>
                      <a class="text-dark" href="<?php echo  "product_details.php?prod=".$cart[3]; ?>"><b><?php echo $cart[2]; ?></b></a>
                  </td>
                  <td><?php echo "&#8377;".$cart[5]." per ".$cart[12]." ".$cart[13];  ?></td>
                    <td><p><?php echo $cart[4]; ?></p></td>
                    <td><p>
                           <?php
                    if(Base::getDiscount($cart[3], $qty/*, $cart[11]*/)>0)
                        echo Base::getDiscount($cart[3], $qty/*, $cart[11]*/);
//                    else
//                    echo ($qty);
                    ?>
                        </p>
                    </td>
                </tr>
<?php               }
?>
                <tr>
                    <td colspan="3" class="text-right">
                    </td>
                    <td class="border-top">
                        <?php echo "&#8377; ".round($sub,2)."/-";?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right"></td>
                    <td class="text-right border-bottom">
                        Delivery Charges:
                    </td>
                    <td class="border-bottom">
                        <?php echo "&#8377; ".round($ship_charge,2)."/-";?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right">
                        Subtotal:
                    </td>
                    <td>
                        <b><?php echo "&#8377; ".round(($sub+$ship_charge),2)."/-";?></b>
                    </td>
                </tr>
              </tbody>
        </table>
              
            </div>
        </div>
<?php
                    }
                    ?>
                <?php
                    }
                }
            }

?>
                <hr>
                <p class="text-right container-fluid">
                    <b>Net Payable: &#8377; <?php echo round($subtotal+$shipping); ?>/-</b>
                </p>
                    <?php
                    if($wallet>0){
                        ?>
                <p class="text-right float-right row col-lg-12 col-md-12 col-sm-12">
                      <input type="checkbox" checked id="wallet" name="wallet"  />
                        <label for="wallet">Wallet Amount  &#8377; <?php
                        
                        if($wallet>($subtotal+$shipping))
                            $wallet=($subtotal+$shipping);
                        
                        echo $wallet;
                        ?>/-</label>
                    </p>
                <p class="text-right container-fluid">
                    <b>Net Payable: &#8377; <span id="net-pay"><?php echo round( ($subtotal+$shipping)-$wallet); ?></span>/-</b>
                </p>
                    <?php    
                    }
                    ?>


                
                  
        
            <form id="shipp-details" action="order-insert.php" method="post" >
	<div class="row">
            <h5 class="text-center container-fluid">Shipping Details</h5>
		<div class="col-lg-6 col-md-6 col-sm-12">
                   
                  <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4  text-right">Name <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="name" name="name" value="<?php echo $row[0]; ?>" />
        </div>  
                </div>
                 <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4  text-right">Mobile Number <font style="color:red">*</font>:</p>
                <div class="col-lg-8 col-md-8 col-sm-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="ccntc" name="ccntc" value="<?php echo $row[1]; ?>" required />
                </div>
                </div>

          <div class="row">
                <p class="col-lg-4 col-md-4 col-sm-4  text-right">Email <font style="color:red">*</font>:</p>
                    <div class="col-lg-8 col-md-8 col-sm-8 form-group">
                    <input type="email" class="form-control" autocomplete="off" id="cemail1" name="cemail1" value="<?php echo $row[3]; ?>" required />
                    </div>
                </div>

                    
                </div>
		<div class="col-lg-6 col-md-6 col-sm-12"> 
        <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4  text-right">Shipping Address<font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8 form-group">
                <textarea class="form-control" autocomplete="off" id="saddr" name="saddr" required ><?php echo $row[2]; ?></textarea>
        </div>  
                </div> 
                    
              <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4  text-right">Pincode <font style="color:red">*</font>:</p>
                <div class="col-lg-8 col-md-8 col-sm-8 form-group">
                <input   type="text" class="form-control" autocomplete="off" id="czip" name="czip" value="<?php echo $row[4]; ?>" required />
                </div>
                </div>
                </div>
                <div class="col-md-8 offset-md-2">
<a href="<?php echo $root?>" class=" btn"><span class="icon-arrow-left"></span> Continue Shopping </a>
<a href="<?php echo $root."Cart";?>" class=" btn"><span class="icon-arrow-left"></span> Cart </a>
<input type="hidden" name="wallet" value="<?php 
if($wallet>0)
echo $wallet;
else
    echo 0;
?>" />
<button type="submit" value="<?php echo ($subtotal+$shipping)-$wallet; ?>" id="submit-net-pay" name="subtotal" class=" btn float-right">Proceed to Payment <span class="icon-arrow-right"></span></button>
            </div>
	
</div>
            </form>
</div>


</div><!-- /container -->


<?php
}
?>

    </section>    
      <section class="footer" style="margin-top: 10px !important; width: auto !important;" ></section>
      
</section>
<?php
require_once 'scripts.html';
?>
<script>
    $("#wallet").change(function() {
	var total="<?php echo $subtotal+$shipping;?>";
	var wallet="<?php echo $wallet;?>";
        var rem=0;
        if(total>wallet)
            rem=total-wallet;
        else
            wallet=wallet-total;
    if(this.checked) {
     $("#wallet").val(wallet);   
     $("#net-pay").html(rem);   
     $("#submit-net-pay").val(rem);   
    }
    else {
     $("#wallet").val(0);
     $("#net-pay").html(total);   
     $("#submit-net-pay").val(total);   
    }
        
});
</script>

</body>
</html>
