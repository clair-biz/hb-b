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


$cart="";
if(!empty($user) && $user->type="customer" && !empty($user->cust_id) ) {
$cust_id=$user->cust_id;

$cartquery.="select prod_id,req_dt,qty,bs_id,cart_id from cart where cust_id=".$cust_id;

//echo $cartquery;
$rescart= Base::generateResult($cartquery);
$i=0;
while ($rowcart= mysqli_fetch_array($rescart)) {
    $obj=new Order();
    $obj->prod_id=$rowcart["prod_id"];
    $obj->cart_id=$rowcart["cart_id"];
    
    $obj->req_on=$rowcart["req_dt"];
    $obj->qty=$rowcart["qty"];
    $obj->bs_id=$rowcart["bs_id"];
    $cart[$i]=$obj;
    $i++;
    }

}
elseif(isset($_SESSION["cart"])!="")
    $cart= unserialize($_SESSION["cart"]);

echo "<script>console.log('cart-". serialize($cart)."-');</script>";
?>

        
    <div class="container-fluid mx-5" style="margin-top: 40px;">
        <div class="card border-0" >
            <div class="card-body" >
            <h4>My Cart (<span class="cartdata"></span>)</h4>
            <div class="cart-items" style="min-height: 60vh;" >
            <?php
                $countcart=0;

                if(sizeof($cart)>0 && $cart!="") {
                            foreach ($cart as $item) {

                                $query="SELECT distinct product.prod_id as 'prod_id', prod_name,".$item->qty.",'".Base::getDiscount($item->prod_id, $item->qty)."' as 'mrp',bname,prod_desc,prod_img,product.prod_unit,prod_qty from tax_table,customer,product,product_price,users,vendor,vend_subscription WHERE tax_table.hsn_code=product.hsn_code and product.vs_id=vend_subscription.vs_id and vendor.vend_id=users.vend_id and vend_subscription.u_id=users.u_id  and product_price.prod_id=product.prod_id and product.prod_id=".$item->prod_id.";";
//                echo $query;
                $resprod= Base::generateResult( $query);
                if($rowprod= mysqli_fetch_array($resprod)) {
                    
                ?>
            <div class="card product border-top-0 border-left-0 border-right-0" id="<?php echo "product_".$item->prod_id; ?>" data-cart="<?php echo $item->cart_id; ?>" data-prod='<?php echo $item->prod_id; ?>' >
                <div class="card-body py-2">
                    <div class="row" >
                        <div class="col-sm-2" >
                            <img src="<?php echo $root."assets/products-services/".$rowprod["prod_img"]; ?>" class="img-fluid" />
                        </div>
                        <div class="col-md-10">
                            <div class="row " >
                                
                                <div class="col-md-4" >
                                    <p class="mb-1" style="font-weight: 600"><?php echo $rowprod["prod_name"]?></p>
                                     <p class="mb-1"><?php echo $rowprod["prod_qty"]." ".$rowprod["prod_unit"]."- &#8377; ".$rowprod["mrp"]."/-";?></p>
                                      <p  class="mb-1"><?php echo $rowprod["prod_desc"];?></p>
                                </div>
                                <div class="col-md-4">
                                <?php
//                                $date= date_create($req);
//                                $req_d= date_format($date, "m/d/Y"); 

                                    ?>
                  
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" for="cat">Required On:</span>
                                    </div>
                                    <input type="text" data-toggle="datepicker" class="form-control can-change can-change-req" data-value="<?php echo $item->req_on; ?>" value="<?php echo $item->req_on; ?>" name="req" id="req" />
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" for="cat">Time slot:</span>
                                    </div>
                                    <select class="form-control can-change can-change-slot" name="slot" id="slot">
                                        <?php 
                                        $queryslots="select bs_id,bs_from,bs_to from booking_slots order by bs_id;";
                                        $resslots= Base::generateResult($queryslots);
                                        while ($rowslots= mysqli_fetch_array($resslots)) {
                                            if($item->bs_id==$rowslots[0]) {
                                        ?>
                                        <option value="<?php echo $rowslots[0]; ?>" selected ><?php echo $rowslots[1]." - ".$rowslots[2]; ?></option>
                                        <?php 
                                            }
                                            ?>
                                        <option value="<?php echo $rowslots[0]; ?>"  ><?php echo $rowslots[1]." - ".$rowslots[2]; ?></option>
                                        
                                        <?php
                                        }
                                        ?>
                                     </select>
                                </div>
                                </div>
                                <div class="col-md-2">
  <div class="input-group">
      <div class="input-group-prepend">
        <div class="input-group-text p-0">
            <button class="btn btn-secondary btn-neg" type="button" >-</button> 
        </div>
      </div>
    <input id="qty" type="text" class="form-control can-change can-change-qty" name="qty" min="1" value="<?php echo $item->qty;?>" data-val="<?php echo $rowprod["mrp"]; ?>" placeholder="Quantity">
      <div class="input-group-append">
        <div class="input-group-text bg-secondary p-0">
            <button class="btn btn-secondary btn-pos" type="button" >+</button> 
        </div>
      </div>
  </div>
                  

                                    <p class="text-right">Subtotal &#8377; <span class="subtotal"><?php echo $rowprod["mrp"]; ?></span>/-
                  </p>
                                </div>
                                <div class="col-sm-2">
                                    <a class="remove-prod text-center" href="<?php echo "http://".$_SERVER["SERVER_NAME"]."/cart-remove.php?cart_id=";
                                        echo $item->cart_id;
                                    ?>" >Remove</a>
                                </div>
                            
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
                    <?php
                    }
                    
                        }
                    }
/*                }

            }
*/            
 ?>
            </div>
            <div class="container-fluid mx-5 card order-content" style="display: none">
<a href="<?php
if($user!="" && !empty($user->cust_id))
echo $root."OrderCheckOut";
else
    echo $root."Login";
?>" class="checkout-link btn btn-primary float-right text-right mr-5" >Checkout</a>
                    	<a href="<?php echo $root;?>" class=" ml-5" >Continue Shopping</a>
            </div>
<?php
//            }
 ?>
            <div class="container-fluid mx-5 card nothing-content" style="display: none; min-height: 60vh;" >
                <h5 class="text-center"><span class="msg">You do not have anything in Cart!</span><br /><br /><a href="<?php echo $root;?>" >Continue Shopping</a></h5>
            </div>
            
            </div>
        </div>
    </div>

        
      </section>    
      <section class="footer" style="margin-top: 10px !important; width: auto !important;" ></section>
      
</section>
<?php
require_once 'scripts.html';
?>


</body>
</html>
