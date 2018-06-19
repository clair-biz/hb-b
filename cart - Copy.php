<html>
    <body>
<?php
require_once('header.php');

if($_SESSION["user"]==null || $_SESSION["user"]=="" || Crm::getUserType($_SESSION["user"])!=2 || $_COOKIE["cust"]==null) {
    if(time()- $_SESSION["session_time"]> 60) {
        ?>
<script>
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Logging Out!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"Logout";
                });
//alert("Please Log In");
//window.location.href="logout.php";
</script>
<?php
    }
    else {
        $_SESSION["session_time"]=time();
    }
}


$cust_id=0;
if(isset($_COOKIE["cust"])!="")
$cust_id=$_COOKIE["cust"];
$stmtcart=mysqli_query(Crm::con(),"select cust_fname,cust_cntc,cust_addr,cust_email,loc_zip from customer,users where users.cust_id=customer.cust_id and users.cust_id=".$_COOKIE["cust"].";");  
$count=0;
$prod_count=Order::getCountCart($cust_id);
                $subtotal=0;
                $shipping=0;
if($row=mysqli_fetch_array($stmtcart)){
$wallet=0;
if(Order::getWalletAmt($_SESSION['user'])>0)
    $wallet=Order::getWalletAmt($_SESSION['user']);
$prod_count=Order::getCountCart($cust_id);
?>
    <div class="container-fluid" style="margin-top: 40px;">
<div id="gototop"> </div>

<!-- 
Body Section 
-->
    <div class="row">
	<div class="col offset-m1 offset-l1 m10 l10 card-panel">
		<h5>Check Out  (<?php echo Customer::getcustnamebyid($cust_id); ?>)<small class="pull-right"> <?php echo $prod_count; ?> Items are in the cart </small></h5>
	<div class="row">
                <?php
            $query="select distinct vs_id from cart,product where product.prod_id=cart.prod_id and cust_id=".$_COOKIE["cust"];
//            echo $query;
            $res= mysqli_query(Crm::con(), $query);
            while($vs= mysqli_fetch_array($res)) {
                $countdt="select distinct req_dt,date_format(req_dt,'%d-%m-%Y') from cart,product where cart.prod_id=product.prod_id and cust_id=".$_COOKIE["cust"]." and vs_id=".$vs[0];
//                echo $countdt;
                $resreqdt=mysqli_query(Crm::con(),$countdt);
                $countreqdt=mysqli_num_rows($resreqdt);
//                echo $countreqdt;
                if($countreqdt>0) { 
                    while($rowreqdt= mysqli_fetch_array($resreqdt)) { ?>
    <?php
                $countslots="select distinct cart.bs_id,bs_from,bs_to from cart,product,booking_slots where booking_slots.bs_id=cart.bs_id and cart.prod_id=product.prod_id and req_dt=cast(N'".$rowreqdt[0]."' as date) and vs_id=".$vs[0];
  //              echo $countdt;
                $resslots=mysqli_query(Crm::con(),$countslots);
                $countslots=mysqli_num_rows($resreqdt);
//                echo $countslots;
                    while($rowslots= mysqli_fetch_array($resslots)) { ?>
	<table class="table table-condensed" style="border: none; background-color: #f89406">
            <thead style="border: none;">
                <tr>
                  <th style="padding: 2px 5px;"><?php echo "Required On: ".$rowreqdt[1]; ?></th>
                  <th style="padding: 2px 5px;"><?php echo "Time Slot: ".$rowslots[1]." - ".$rowslots[2]; ?></th>
                </tr>
              </thead>
              <tbody>
<?php 
                        $query="SELECT cust_fname,cust_lname,prod_name,cart.prod_id,cart.qty,mrp+(mrp*(tax_table.cgst/100))+(mrp*(tax_table.sgst/100))+ (mrp*(tax_table.cess/100)) ,bname,cart_id,prod_desc,prod_img,req_dt,product.prod_unit,mrp_for,mrp_unit,weight,prod_qty from tax_table,cart,customer,product,product_price,users,vendor,vend_subscription WHERE tax_table.hsn_code=product.hsn_code and product.vs_id=vend_subscription.vs_id and vendor.vend_id=users.vend_id and vend_subscription.u_id=users.u_id  and product_price.prod_id=product.prod_id and product.prod_id=cart.prod_id and customer.cust_id=cart.cust_id and cart.cust_id=".$_COOKIE["cust"]." and bs_id=".$rowslots[0]." and req_dt=cast(N'".$rowreqdt[0]."' as date) and product.vs_id=".$vs[0].";";
//                        echo $query;
$stmtcart1=mysqli_query(Crm::con(),$query);  
?>
	<table class="table table-condensed" style="border: none;">
            <thead style="border: none; background-color: #f89406">
                <tr>
                  <th style="padding: 2px 5px;">Product</th>
                  <th style="padding: 2px 5px;">Price</th>
                  <th style="padding: 2px 5px;">Qty </th>
                  <th style="padding: 2px 5px;">Total</th>
                  <th style="padding: 2px 5px;"></th>
                </tr>
              </thead>
              <tbody>
            <?php
            $sub=0;
                $ship_charge=Order::getShipCharge($_COOKIE["cust"], $vs[0], $rowreqdt[0], $rowslots[0],"cust_perc");                    
                $shipping+=$ship_charge;
                while($cart=mysqli_fetch_array($stmtcart1)) {//} && $count++<=$prod_count){
//                echo "qty-$qty-";
                $qty=$cart[4];
//                if(Crm::getDiscount($cart[3], $qty/*, $cart[11]*/)>0)
                    $subtotal+=Crm::getDiscount($cart[3], $qty/*, $cart[11]*/);
/*                else
                    $subtotal+=$cart[5]*$qty;*/
                $sub+=Crm::getDiscount($cart[3], $qty/*, $cart[11]*/);
/*                    if(($cart[14]*$qty)<=3) {
                            $subtotal+=100;
                            $shipping=100;
                    }
                    else {
                        

                    }
                    
//        if(Crm.getDiscount(cart.getInt(4),cart.getInt(5))>0)
                /*    if($cart[11]=="GM" || $cart[11]=="mL")*/
/*                    else
    $subtotal+=($cart[4]*$cart[5]);*/
?>
                <tr>
                  <td>
                      <p><a href="<?php echo  Crm::root()."Products/".$cart[3]."/".$cart[2]; ?>"><b><?php echo $cart[2]; ?></b></a></p>
                  </td>
                  <td><?php echo "&#8377;".$cart[5]." per ".$cart[12]." ".$cart[13];  ?></td>
                    <td><p><b><?php echo $cart[4]; ?></b></p></td>                    
                    <td><p><b><?php
                    if(Crm::getDiscount($cart[3], $qty/*, $cart[11]*/)>0)
                        echo Crm::getDiscount($cart[3], $qty/*, $cart[11]*/);
//                    else
//                    echo ($qty);
                    ?></b></p></td>
                    <td><a href="<?php echo "cart-remove.php?cart_id=".$cart[7]; ?>" class="btn  chip">Remove</a></td>
                </tr>
<?php               }
?>
                <tr>
                    <td>
                        Delivery Charges: <?php echo "&#8377; $ship_charge/-";?>
                    </td>
                    <td>
                        Subtotal: <?php echo "&#8377; ".($sub+$ship_charge)."/-";?>
                    </td>
                </tr>
              </tbody>
        </table>
<?php
                    }
                    ?>
                <?php
                    }
                }
            }

?>
	<a href="./" class=" btn col offset-m4 offset-l4"><span class="icon-arrow-left"></span> Continue Shopping </a>
        <a href="<?php echo Crm::root()."OrderCheckOut";?>" class=" btn col offset-l1 offset-m1">Proceed to Order <span class="icon-arrow-right"></span></a>

<?php  }
else { ?>
        <div class="row-fluid">
            <h3 class="col-md-12">Cart is Empty!</h3>
	<a href="./" class="shopBtn btn-large"><span class="icon-arrow-left"></span> Continue Shopping </a>
        </div>

    <?php
    }
?>

</div>


</div><!-- /container -->
    </div>


<a href="#" class="gotop"><i class="icon-double-angle-up"></i></a>
</div>
<?php require_once 'footer.php'; ?>

</body>
</html>
