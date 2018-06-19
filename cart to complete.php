<html>
    <body>
<?php
require_once('header.php');
if($_COOKIE["cust"]==null ) {
	header("location:http://www.homebiz365.in/Login");
        exit;
}
$cust_id=0;
if(isset($_COOKIE["cust"])!="")
$cust_id=$_COOKIE["cust"];
$q="SELECT DISTINCT prod_name, cart.prod_id,sum(cart.qty),product_price.sell_prc,sum(cart.qty*product_price.sell_prc),disp_name,cart_id,prod_desc,prod_img,vend_rating,vend_rating_off from cart,customer,product,product_price,users,vendor,vend_subscription WHERE users.u_id=vend_subscription.u_id and product.vend_id=users.u_id and vendor.vend_id=users.vend_id and product_price.prod_id=product.prod_id and product.prod_id=cart.prod_id and customer.cust_id=cart.cust_id and cart.cust_id=".$_COOKIE["cust"]." GROUP by prod_name;";
$stmtcart=mysqli_query(Crm::con(),$q);
$count=0;
$prod_count=Order::getCountCart($cust_id);
?>
    <div class="container-fluid" style="margin-top: 40px;">
<div id="gototop"> </div>
<div class="row">
    <div class="col-lg-2 col-md-4 col-sm-12" >
        <div class="row">
          <div class="card logo-bg-b darken-1" style="margin-bottom:0 !important;">
              <div class="card-content white-text" style="padding: 5px !important; ">
            <p style="color:white;"><b>Shop by &nbsp;
                <i class="material-icons right">menu</i>
            </b></p>
            </div>
          </div>
        <div class="card white " style="margin-top:0 !important; margin-bottom:0 !important;">
            <div class="card-content white-text" style="padding: 5px !important; ">
                <ul>
        <?php
mysqli_data_seek($main_cat, 0);
            while($row = mysqli_fetch_array($main_cat)) {
?>
        <li>
            <a href="<?php  echo "products.php?prod=".$row[0]; ?>">
                <i class="glyphicon glyphicon-chevron-right " style="color : #393185;"></i>
                    <?php echo $row[0]; ?>
            </a>
        </li>
<?php
            }
            ?>
            </ul>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="card logo-bg-b darken-1" style="margin-bottom:0 !important;">
              <div class="card-content white-text" style="padding: 5px !important; ">
            <p style="color:white;"><b>Popular Tags &nbsp;
                <i class="material-icons right">menu</i>
            </b></p>
            </div>
          </div>
        <div class="card white " style="margin-top:0 !important; margin-bottom:0 !important;">
            <div class="card-content white-text" style="padding: 5px !important; ">
                <ul>
        <?php
                $strQuerytags="select product.prod_id, prod_name, COUNT(product.prod_id) c FROM product,ordertbl WHERE product.prod_id=ordertbl.prod_id and product.prod_id<>0  GROUP BY product.prod_id ORDER by c DESC limit 5";
                $restags=mysqli_query(Crm::con(),$strQuerytags);
                    while($tags = mysqli_fetch_array($restags)) {
                                 ?>
                    <li><a href="<?php  echo "products.php?prod=".$tags[1]; ?>"><?php echo $tags[1]; ?></a></li>
<?php
            }
            ?>
                </ul>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="card " style="margin-bottom:0 !important;">
              <div class="card-content grey white-text darken-1" style="height: 300px; padding: 10px !important; ">
                  You can place your Advertisement here!
          </div>
        </div>
        </div>
        <div class="row hide-on-large-only">
          <div class="card " style="margin-bottom:0 !important;">
              <div class="card-content grey white-text darken-1" style="height: 300px; padding: 10px !important; ">
                  You can place your Advertisement here!
          </div>
        </div>
        </div>
</div>
					
    <div class="col m8 l8 s12">

<!-- 
Body Section 
-->
    <h5>Check Out  (<?php echo Customer::getcustnamebyid($cust_id); ?>)<small class="pull-right"> <?php echo $prod_count; ?> Items are in the cart </small></h5>

            <?php
        if($prod_count>0) {
           $i=1;
                $subtotal=0;
                while($cart=mysqli_fetch_array($stmtcart)) {//} && $count++<=$prod_count){
//        if(Crm.getDiscount(cart.getInt(4),cart.getInt(5))>0)
    $subtotal+=$cart[4];
?>

      <div class="row">
          <div class="card " style="padding">
            <div class="card-content ">
<div class="product-details" id="<?php echo "product_".$cart[0];?>" >
    <div class="row">
      <div class="col l3 product-img" >
      <div class="row" >
    <a >
        <img class="responsive-img product-img"
             style="height: auto !important; width: auto !important;
             display: block !important; margin-left: auto !important;
             margin-right: auto !important;"
             src="<?php echo "uploads/products-services/".$cart[8]; ?>"
             onError="this.onerror=null;this.src='uploads/images/small.png';" />
    </a>
      </div>
      
      <div class="row" >
          <p class="">
            <?php echo $cart[7]; ?>

          </p>
      </div>
      
</div>

    <div class="col l9 product-box" >
                <h5  class="truncate" style="font-size: 16px;">
                                      <b>
                                    <a href="<?php echo "products.php?prod=".$cart[1]; ?>" data-toggle="tooltip" 
                                         title="<?php echo $cart[0]; ?>">
                                        <?php echo $cart[0]; ?>
                                        </a>
                                    </b>
	<span id="<?php echo "prc_".$cart[1]; ?>" class="right right-align text-danger prc">@ Rs. <?php echo $cart[3]; ?></span>
                                  </h5>

                        <h6  class="truncate" style="font-size: 12px;">
                by <b><?php echo $cart[5]; ?></b><p class="right-align right">
		<?php
                $rating=0;
                if($cart[9]!=0 && $cart[10]!=0)
                $rating=(int)$cart[9]/$cart[10];
                ?><span class="badge" style="<?php
                        if($rating==0)
                            echo "display:none";
                        elseif($rating>=1 && $rating<=2.9)
                            echo "background-color:red;  color: white";
                        elseif($rating>=3 && $rating<=3.9)
                            echo "background-color:yellow";
                        elseif($rating>=4 && $rating<=5)
                            echo "background-color:green;  color: white";
                        ?>"><?php echo "$rating &#x2605;"; ?></span></p></h6>
        
<form id="<?php echo "form_".$cart[1];?>" class="form-cart" method="post">
    <div class="col l6 m6 s12 padding-small">
    <label class="left">Required on</label>
    <input id="<?php echo "reqd_".$cart[1]; ?>" name="reqd" type="date" class="input dt"   required />
    </div>
    
    <div class="col l6 m6 s12 padding-small">
    <label class="left">Quantity</label>
    <input id="<?php echo "qty_".$cart[1]; ?>" name="qty" type="number" min="1" class="input qty" value="1" required />
    <label id="<?php echo "subtotal_".$cart[1]; ?>"
           class="right">@ <span class="subtotal"><?php echo $subtotal;?></span>
    </label>
    </div>
    
    <div class="row right" style="margin-bottom: 5px; ">

      <button id="<?php echo "submit_prod_".$cart[0]; ?>" name="prod_id" type="submit" value="<?php echo $cart[0]; ?>"  class="btn button btn-add-to-cart">
        Update
      </button>
      <button id="<?php echo "submit_prod_".$cart[0]; ?>" name="prod_id" type="submit" value="<?php echo $cart[0]; ?>"  class="btn button red btn-add-to-cart">
        Remove
      </button>
    </div>
</form>


</div>
</div>

</div>
            </div>
          </div>
      </div>
    <?php
                }
                ?>
    <div class="row">
	<a href="./" class="btn"><span class="icon-arrow-left"></span> Continue Shopping </a>
	<a href="order-insert.php" class="shopBtn btn right">Proceed to Order <span class="icon-arrow-right"></span></a>
    </div>

<?php
}
else { ?>
        <div class="row">
            <h3 class="col m12">Cart is Empty!</h3>
        </div>
	<a href="./" class="shopBtn btn"><span class="icon-arrow-left"></span> Continue Shopping </a>

    <?php
    }
?>
    </div>
</div>
<?php require_once 'footer.php'; ?>

<a href="#" class="gotop"><i class="icon-double-angle-up"></i></a>
</div>
<script>
        $(".btn-remove-from-cart").on('click', function() {
        var cart_id=$("#btn-rem_prod").val();
        var data="cart_id="+cart_id;
        console.log("btn clicked add to cart");
                        console.log(data);
        
			$.ajax({
				
			type : 'POST',
			url  : 'cart-remove.php',
			data : data,
			beforeSend: function() {	
//				$("#error").fadeOut();
                                $(".btn-remove-from-cart").prop('disabled', true);
                                $(".btn-remove-from-cart").removeClass('btn');
				$(".btn-remove-from-cart").html(preloader());
			},
			success :  function(response) {
                            console.log("resp "+response);
					if(response=="ok"){
                                                $(".btn-remove-from-cart").prop('disabled', false);
                                                $(".btn-remove-from-cart").addClass('btn');
                                                $(".btn-remove-from-cart").html('<i class="material-icons">remove_shopping_cart</i> Remove');
                                                Materialize.toast('Product removed from cart!', 4000);
                                                updatecart();
                                    }
					else{
                                                $(".btn-remove-from-cart").prop('disabled', false);
                                                $(".btn-remove-from-cart").addClass('btn');
                                                $(".btn-remove-from-cart").html('<i class="material-icons">remove_shopping_cart</i> Remove');
                                                Materialize.toast(response, 20000);
					}
			  }
			});
    });

</script>

</body>
</html>
