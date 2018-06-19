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
$query="select distinct ordertbl.`ord_id`, `req_dt`, `ord_amount`,sc_cust, `ord_status`, `delivery_status`, `delivery_date` from ordertbl,order_detail WHERE order_detail.ord_id=ordertbl.ord_id and cust_id=".$user->cust_id." ORDER by ordertbl.ord_id desc;";
//echo $query;
$stmtcart=Base::generateResult($query);
$count=0;
$prod_count= mysqli_num_rows($stmtcart);
?>
    <div class="container-fluid" style="margin-top: 40px;">
<div id="gototop"> </div>

<!-- 
Body Section 
-->
    <div class="row">
        
    <div class="col-lg-2 col-md-2 hide-on-small-and-down">
                    <?php
                    require 'cust-menu.php'; 
                    ?>
                    </div>
    
    <div class="col-lg-10 col-md-10" style="margin-top: 10px; margin-bottom: 10px;">
	<div class="row">
            <div class="container-fluid" style="margin-bottom: 10px;">
		<h5>My Orders</h5>
	<hr class="soften"/>

                  <?php
        if($prod_count>0) {
           $i=1;?>
            <?php
                $subtotal=0;
                while($ords=mysqli_fetch_array($stmtcart)) {//} && $count++<=$prod_count){ ?>
        <div class="card" style="padding: 5px !important;">
            <p><b>Order #<?php echo $ords[0]; ?></b>
                <?php
                if(!empty($ords[4])) { ?>
                <em class="text-right right">Order Status: <b><?php echo $ords[4]; ?></b></em>
            <?php
                }
                ?>
            </p>
<?php
$cartq="select order_detail.prod_id,prod_name,ord_qty,prod_qty,prod_unit,ord_rate,prod_return,prod_replace,r_within,prod_img from order_detail,product where product.prod_id=order_detail.prod_id and ord_id=".$ords[0];
//echo $cartq;
?>        
	<table class="table table-condensed mb-0" style="border: none;">
            <thead style="border: none; background: rgba(32, 162, 91, 0.3);">
                <tr>
                  <th style="padding: 2px 5px;">Product</th>
                  <th style="padding: 2px 5px;"></th>
                  <th style="padding: 2px 5px;">Qty </th>
                  <th style="padding: 2px 5px;">Rate</th>
                  <th style="padding: 2px 5px;">Total</th>
                  <th style="padding: 2px 5px;"></th>
                </tr>
              </thead>
              <tbody>
            <?php
                $subtotal=0;
                $cartres= Base::generateResult( $cartq);
                while($cart=mysqli_fetch_array($cartres)) {//} && $count++<=$prod_count){
          $img=$root."assets/products-services/".$cart["prod_img"];
?>
                <tr>
                    <td>
				<a  href="<?php  echo "product_details.php?prod=".$cart[3]; ?>">
                                    <img class="img-fluid img-thumbnail"
                                         style="height: 60px !important; width: auto !important; display: block !important;
                                         margin-left: auto !important; margin-right: auto !important;"
                                         src="<?php echo $img; ?>"
                                         onError="this.onerror=null;this.src='uploads/images/small.png';" /></a>
                  </td>
                  <td><a href="<?php echo  "product_details.php?prod=".$cart[0]; ?>"><b><?php echo $cart[1]; ?></b></a></td>
                  <td><?php echo $cart[2]." X ".$cart[3]."".$cart[4] ;  ?></td>
                  <td><?php echo "&#8377; ".($cart[5]/$cart[2])."/-";  ?></td>
                    <td><p><b><?php echo "&#8377; ".$cart[5]."/-"; ?></b></p></td>
                    <td>
                        <?php 
                        if($ords[4]=="Completed" && $ords[5]=="Delivered" && Order::canReturn($ords[0], $cart[0])>0) {
                        ?>
                        <a href="<?php echo $root."Return/".$ords[0]."/".$cart[0]."/$cart[1]"; ?>" class="btn return-btn float-right">Return</a></td>
                    <?php 
                        }
                        ?>
                </tr>
<?php } ?>
				</tbody>    
            </table>
            <p class="text-right mb-1" style="margin-top: 0px !important;"><b>Amount Paid: &#8377; <?php echo $ords[2];?>/-</b></p>
                                <?php 
                                $status=$ords[4];
                                if($status!="Completed" && $status!="Canceled") { ?>
            <div class="container"><a id="<?php echo $ords[0]; ?>" class="btn btn-default cancel-ids float-right ">Cancel</a></div>
  <?php
                                }
                                ?>
        </div>
<?php
        }
    }
else { ?>
        <div class="row-fluid" style="min-height: 60vh;">
            <h3 class="col-md-12">Nothing to Display!</h3>
        </div>
	<a href="./" class="shopBtn btn-large"><span class="icon-arrow-left"></span> Continue Shopping </a>

    <?php
    }
?>

</div>
</div>
</div>


</div><!-- /container -->
</div>
      </section>    
      <section class="footer" style="margin-top: 10px !important; width: auto !important;" ></section>


      
</section>
<?php
require_once 'scripts.html';
?>
<a href="#" class="gotop"><i class="icon-double-angle-up"></i></a>


<script>
    $(".return-btn").on('click',function() {
       var id=$(this).attr("id");
       id=id.split(";");
       var data="ord_id="+id[0]+"&prod_id="+id[1];
       console.log("data-"+data+"-");
		$.ajax({
			
			type : 'POST',
			url  : 'return-form.php',
			data : data,
			beforeSend: function() {
//				$(this).html(preloader());
			},
			success :  function(response) {
                            console.log("alert "+response);
                            $("#modal-ord-cancel").html(response);
                            $("#modal-ord-cancel").modal("open");
    }
			});


    });
   
    $(".cancel-ids").on('click',function() {
       var id=$(this).attr("id");
       console.log("data-"+id+"-");
		$.ajax({
			
			type : 'POST',
			url  : 'cancel-form.php',
			data : "ord_id="+id,
			beforeSend: function() {
//				$(this).html(preloader());
			},
			success :  function(response) {
                            console.log("alert "+response);
                            $("#modal-ord-cancel").html(response);
                            $("#modal-ord-cancel").modal("show");
                            $("#modal-ord-cancel").find(".modal-dialog").html(response);
    }
			});


    });
</script>
</body>
</html>
