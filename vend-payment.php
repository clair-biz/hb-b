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


//$cust_id=0;
//if(isset($_COOKIE["cust"])!="")
$u_id=Base::getuidbyuname($user->u_name);
$q="select bname,cat_name,city_served,vs_for,vsc_id,other_cat from vs_cart,category where vs_cart.cat_id=category.cat_id and vs_cart.is_active='Y' and vs_cart.u_id=$u_id;";
//echo $q;
$stmtcart=Base::generateResult($q);
$count=0;
$prod_count=Vendor::getVendorCountCart($u_id);
?>
    <div class="container-fluid" style="margin-top: 40px;">
<div id="gototop"> </div>

<!-- 
Body Section 
-->
    <div class="row">
	<div class="offset-md-1 col-md-10 col-sm-12">
	<div class="row">
            <div class="container-fluid" style="margin-bottom: 10px;">
		<h5>Subscription Summary<small class="pull-right"> </small></h5>
	<hr class="soften"/>	

                  <?php
        if($prod_count>0) {
           $i=1;?>
	<table class="table table-condensed" style="border: none;">
            <thead style="border: none; background: rgba(32, 162, 91, 0.3);">
                <tr>
                  <th style="padding: 2px 5px;">Business Name</th>
                  <th style="padding: 2px 5px;">Category</th>
                  <th style="padding: 2px 5px;">City</th>
                  <th style="padding: 2px 5px;">Subscription Plan</th>
                  <th style="padding: 2px 5px;">Subscription Charges</th>
                  <th style="padding: 2px 5px;">Tax</th>
                  <th style="padding: 2px 5px;">Sub Total</th>
                  <th style="padding: 2px 5px;"></th>
                </tr>
              </thead>
              <tbody>
            <?php
                $subtotal=0;
                while($cart=mysqli_fetch_array($stmtcart)) {//} && $count++<=$prod_count){
//        if(Base.getDiscount(cart.getInt(4),cart.getInt(5))>0)
                   $cat_id=Base::getcatidbycatname($cart[1]);
                   $split= explode(" ", $cart[3]); 
                   $rate=Base::getSubtotal($split[0],$split[1],$cat_id); 
                   $tax=Base::getTax($split[0],$split[1],$cat_id); 
                   
                   
//                    if($cart[11]=="GM" || $cart[11]=="mL")
$subtotal+= intval($rate+($rate*($tax/100)));
?>
                <tr>
                   <td><?php echo $cart[0];  ?></td>
                   <td><?php echo $cart[1];
                                    if($cat_id==0)
                                          echo "<br> ".$cart[5];

                   ?></td>
                   <td><?php echo $cart[2];  ?></td>
                   <td><?php echo Base::getSubscriptionOff($split[0],$split[1],$cat_id);  ?></td>
                   <?php if($rate==0) { ?>
                   <td colspan="3"><p class='red-text'>* Subscription fees for this category to be paid after HomeBiz365's Approval for this category</p></td>
                   <?php 
                   }
                   else {?>
                   <td>&#8377; <?php echo $rate;  ?>/-</td>
                   <td><?php echo "CGST: ". intval($tax/2)."%<br />SGST: ". intval($tax/2)."%";  ?></td>
                   <td>&#8377; <?php echo intval($rate+($rate*($tax/100))); ?>/-</td>
                   <?php 
                   }
                   ?>
                </tr>
<?php } ?>
                <tr>
                  <td style="padding: 10px 5px;"  colspan="5" class="alignR"></td>
                  <td style="padding: 10px 5px;"   class="right-align badge"><b>Net Payable:</b></td>
                  <td  class="badge red" style="padding: 10px 5px;"><b>&#8377; <?php echo  $subtotal; ?>/-</b></td>
                  
                </tr>
				</tbody>
            </table><br/>
            
        <form action="vend-payment1.php" method="post">

                        <input name="options" type="hidden" value="online" />

            <div class="row justify-content-center align-items-center">
            <a href="<?php echo $root."VendorSubscriptions"; ?>" class="shopBtn btn col-md-2"><span class="icon-arrow-left"></span> Go Back</a>
            <button type="submit" class="submit-btn col offset-m1 col-md-2 btn">Submit <span class="icon-arrow-right"></span></button>
            </div>
        </form>

<?php
    }
else {
    ?>
        <div class="row-fluid">
            <h5 class="col-md-12">No categories added!</h5>
        </div>
        <a href="<?php echo $root."NewSubscription"; ?>" class="shopBtn btn-large"><span class="icon-arrow-left"></span> Add Category </a>

    <?php
    }
?>

</div>
</div>
</div>


</div><!-- /container -->


      </section>    
      <section class="footer" style="margin-top: 10px !important; width: auto !important;" ></section>
      
</section>
<?php
require_once 'scripts.html';
?>

<a href="#" class="gotop"><i class="icon-double-angle-up"></i></a>
</div>

<script>
    $("input[name=options]").on("change",function() {
    var val=$("input[name=options]:checked").val();

    switch(val) {
        case "offline" : $(".bank-details").show();
                        $(".submit-btn").html("Submit");
                        break;
                    case "online": $(".submit-btn").html("Pay");
                                    $(".bank-details").hide();
                                    break;
                    default : $(".bank-details").hide();
                        
    }
        
    });
</script>

</body>
</html>
