<html>
    <body>

<?php
$prod_name= urldecode($_REQUEST['prod']);
$prod_name=str_replace("_"," ",$prod_name);
require_once 'Classes/Classes.php';
?>
<?php
$count=1;
$strQuery1="select product.prod_id, `prod_name`,prod_desc,cs_name,cat_name, disp_name,vend_rating,mrp,vend_rating_off,prod_unit,prod_qty,prod_unit,delivery,city_served,area_served from  product,cat_sub,vendor,category,product_price,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and product_price.prod_id=product.prod_id and users.u_id=product.vend_id and city_served='".$_COOKIE["city"]."' and prod_name like '%".$prod_name."%'";
	$proddetailsres=mysqli_query(Crm::con(), $strQuery1);
            while($prod_details = mysqli_fetch_array($proddetailsres)) {
                $n= explode(" ", $prod_details[0]);
                $prod_name= implode("_", $n);
          $img="uploads/products-services/".Product::getprodimgbyname($prod_details[1]);
                ?>
<div class="product-details" id="<?php echo "product_".$prod_name;?>" >
          <div class="card row">
            <div class="card-content">
                <div class="row">
                <div class="col l4 m4 s4">
        <img class="responsive-img product-img"
             style="height: auto !important; width: auto !important;
             display: block !important; margin-left: auto !important;
             margin-right: auto !important;"
             src="<?php echo $img; ?>"
             onError="this.onerror=null;this.src='uploads/images/small.png';" />
                </div>
        <div class="product-box col l8 m8 s8" >
                <h5  class="truncate left-align" style="font-size: 16px;">
                                      <b>
                                    <a href="<?php echo "product_details.php?prod=".$prod_details[0]; ?>" data-toggle="tooltip" 
                                         title="<?php echo $prod_details[1]; ?>">
                                        <?php echo $prod_details[1]; ?>
                                        </a>
                                    </b>
	<span id="<?php echo "prc_".$prod_details["0"]; ?>" class="right right-align text-danger prc">@ Rs. <?php echo $prod_details[7]."<font style='font-size: 14px !important;'> per ";
	if($prod_details[9]=="Kg" || $prod_details[9]=="gm" || $prod_details["mg"])
	echo "Kg</font>"; ?></span>
                                  </h5>
        <div class="row">
                        <p  class="left-align" style="font-size: 14px;">
                by <b><?php echo $prod_details[5]." (".$prod_details[13].")"; ?></b>
		<?php
                $rating=0;
                if($prod_details[6]!=0 && $prod_details[8]!=0)
                $rating=(int)$prod_details[6]/$prod_details[8];
                ?> <span class="" style="<?php
                        if($rating==0)
                            echo "display:none";
                        elseif($rating>=1 && $rating<=2.9)
                            echo "background-color:red;  color: white";
                        elseif($rating>=3 && $rating<=3.9)
                            echo "background-color:yellow";
                        elseif($rating>=4 && $rating<=5)
                            echo "background-color:green;  color: white";
                        ?>">&nbsp;&nbsp;<?php echo intval($rating)." &#x2605;"; ?>&nbsp;&nbsp;</span>
                        </p>
    </div>
      
          <p class="row left-align">
              Product Description,<br />
            <?php echo $prod_details[2]; ?>
          </p>
                        


    </div>
            </div>
            </div>
            <div class="card-action">
                <div class="row">
          <p class="left">
            <?php
            if($prod_details[12]=="Yes")
            echo "Delivery available in ".$prod_details[14]; ?>
          </p>
      <button id="<?php echo "submit_prod_".$prod_details[0]; ?>" name="prod_id" type="submit" value="<?php echo $prod_details[0]; ?>"  class="btn button red btn-call-4-product right">
        Contact Vendor
      </button>
                </div>
            </div>
            </div>



</div>
    <?php
    }
    ?>

<script>
    $(".product-details").ready(function() {
    $(".btn-call-4-product").on('click', function() {
        console.log("btn clicked add to cart");
        var prod_id=$(this).val();
//        var form_id="#form_"+serv_id;
        console.log("prod "+prod_id);
//        console.log("form "+form_id);
    var data="prod_id="+prod_id;
			$.ajax({
				
			type : 'POST',
			url  : 'productorder-insert.php',
			data : data,
			beforeSend: function() {	
//				$("#error").fadeOut();
                                $("#submit_prod_"+prod_id).prop('disabled', true);
				$("#submit_prod_"+prod_id).html(preloader());
			},
			success :  function(response) {
                            console.log("data "+data);
                            console.log("resp "+response);
					if(response=="ok"){
                                                $("#submit_prod_"+prod_id).prop('disabled', false);
                                                $("#submit_prod_"+prod_id).html('Contact Vendor');
                                                alert('You would receive Vendor Details soon!');
                                                updatecart();
                                    }
                                    else if(response=="login") {
                				$("#submit_prod_"+prod_id).html(preloader());
						setTimeout(' window.location.href = "login.php"; ',2000);
                                    }
					else{
                                                $("#submit_prod_"+prod_id).prop('disabled', false);
                                                $("#submit_prod_"+prod_id).html('Contact Vendor');
                                                alert(response);
					}
			  }
			});

    });

        
    });
</script>
    </body>
</html>