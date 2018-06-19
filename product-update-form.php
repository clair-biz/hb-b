<?php
require_once 'data.php';
    $prod_id=$_REQUEST['prod_id'];
$vend_id=Base::getuidbyuname($user->u_name);

$vend3=Base::generateResult("select prod_name,prod_desc,cat_sub.cs_name as 'cs_name',prod_img,prod_min_time,prod_unit,prod_qty,`mrp`, `hsn_code`, `sgst`,mrp_for,mrp_unit,prod_replace,prod_return,r_within from product_price,product,cat_sub where product.prod_id=product_price.prod_id and product.cs_id=cat_sub.cs_id and product_price.prod_id=".$prod_id.";");  
$cat=Base::generateResult("select cs_id,cs_name from cat_sub,vend_subscription,users,category where category.cat_id=cat_sub.cat_id and  users.u_id=vend_subscription.u_id and vend_subscription.cat_id=cat_sub.cat_id and cs_name<>cat_name and u_name='".$user->u_name."';");  

if($row=mysqli_fetch_array($vend3)) {
    $img=$root."assets/products-services/$row[3]";
?>
    <form class="form-horizontal text-center prod-update" enctype="multipart/form-data" method="post">
        <div class="row" >
            <h4 class="text-center col" ><?php echo "Update ".$row["prod_name"];?></h4>
        </div>
            
            <div class="row">
            <p class="col-md-2 col-sm-4 d-flex align-items-center">Sub Category :</p>
            <div class="col-md-5 col-sm-8 form-group">
            <select class="form-control" id="subcat" autofocus name="subcat" >
        <option value="0" >Other</option>

                  <?php
              while($rowcat = mysqli_fetch_array($cat)) {
                      ?>
              <option value="<?php echo $rowcat[0];  ?>" <?php if($rowcat[1]==$row["cs_name"]) { echo "selected"; } ?>><?php echo $rowcat[1];  ?></option>
                      <?php
                      }
                      ?>
            </select>
  </div>
            <div class="col-md-5 col-sm-8 form-group cat1" style="display: none;">
            <input type="text" class="form-control" placeholder="Mention Other Category" autocomplete="off" id="cat1" name="cat1"  />
        </div>
            </div>
        
            <div class="row">
              <div class="col-md-6 col-lg-6 col-sm-12">
                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4">Product Name :</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="pname" placeholder="<?php echo $row["prod_name"];?>" name="pname"  />
        </div>
                </div>

                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4">Product Description :</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group">
                 <textarea class="form-control" autocomplete="off" id="pdesc" name="pdesc" placeholder="<?php echo $row["prod_desc"]; ?>"></textarea>
        </div> 

            </div>

                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4">Lead Time Required:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 input-group form-group">
                    <input type="number" placeholder="<?php echo $row["prod_min_time"]; ?>" min="1" class="form-control" autocomplete="off" id="min_time_val" name="min_time_val" />
  <div class="input-group-append">
    <span class="input-group-text">Day(s)</span>
  </div>
           <!--div class="col-sm-6 col-md-6 col-lg-6">
           <select class="form-control" id="min_time" name="min_time" >
                    <option selected="true" value="" disabled="">-Select-</option>
                    <option value="min">Minutes</option>
                    <option value="hr">Hour(s)</option>
                    <option value="day">Day(s)</option>
                </select>
                </div-->
                
        </div>
                
            </div>

            <div class="row form-group">
            <p class="col-md-4 col-lg-4 col-sm-4">Min Order Quantity :</p>
        <div class="col-md-8 col-lg-8 col-sm-8 input-group form-group">
                        <input type="text" class="form-control" placeholder="<?php echo $row["prod_qty"]; ?>" autocomplete="off" id="qty" name="qty" />
                <div class="input-group-append">
                <select class="form-control" id="unit" name="unit">
                    <option selected="true" disabled value="">-Select-</option>
                    <option value="Kg">Kilograms (kg)</option>
                    <option value="gm">Grams (gm)</option>
                    <option value="mg">Milligrams (mg)</option>
                    <option value="L">Litres (L)</option>
                    <option value="ml">Milli liter (ml)</option>
                    <option value="Piece">Pieces</option>
                </select>
                </div>
            <p><em>Note: Product will be available in multiples of Min. Order Quantity</em></p>
            </div>
          </div>  

      </div>
              <div class="col-md-6 col-lg-6 col-sm-12">

                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4">Price &#8377; <span class="base_prc"></span>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="base_prc" name="base_prc" placeholder="<?php echo $row["mrp"];?>" />
        </div>
                </div>

                <!--div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4">Weight <span class="mrp"></span> Package<font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 row ">
                <div class="col-sm-6 col-md-6 col-lg-6 form-group">
                        <input type="text" class="form-control" autocomplete="off" id="weight" name="weight" />
                    <label for="weight">Weight <span class="mrp"></span> Package<font style="color:red">*</font>:</label>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6">
                <select class="form-control" id="weight_unit" name="weight_unit">
                    <option selected value="Kg">Kilograms (kg)</option>
                    <option value="gm">Grams (gm)</option>
                    <option value="mg">Milligrams (mg)</option>
                </select>
                </div>
        </div>
                </div-->

                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4">HSN Code:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group">
                <input type="number" class="form-control" placeholder="<?php echo $row['hsn_code']; ?>" autocomplete="off" id="hsn" name="hsn" />
        </div>
            
                <!--div class="col l6 m6 s6">
            <p class="col-md-4 col-lg-4 col-sm-4">SGST <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group">
                <input type="number" class="form-control" autocomplete="off" id="sgst" min="0" value="0" name="sgst" required />
            <label for="cgst">SGST <font style="color:red">*</font>:</label>
        </div>
      </div-->
                </div>

                <div class="row">
            <p class="col-md-4 col-sm-12 text-left">Replace / Return:</p>
        <div class="col-md-8 col-sm-12 input-group form-group">
            <div class="input-group-prepend" >
                <label class="checkbox-inline input-group-text"><input type="checkbox" <?php if($row["prod_replace"]=="Y") { echo "checked"; }?> value="replacement" name="check_list[]">Replace</label>
                <label class="checkbox-inline input-group-text"><input type="checkbox" <?php if($row["prod_return"]=="Y") { echo "checked"; }?> value="return" name="check_list[]">Return</label>
            </div>
                <input type="number" class="form-control" placeholder="<?php echo $row["r_within"]." Days"; ?>" autocomplete="off" id="within" name="within" />
            <div class="input-group-append" >
            </div>
        </div>
            
            </div>

                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4">Product Image :</p>
                <div class="col-md-8 col-lg-8 col-sm-8 form-group">
                    <input class="form-control" name="file" type="file" id="customFile" accept="image/jpg,image/png,image/jpeg,image/gif" >
<em>Note: The image size should not be more than 1 MB</em>
                </div>
                </div>
                </div>

            </div>

        
            <div class="row">
                <input type="hidden" name="user" value="<?php echo $user->u_name; ?>" />
                <button id="submit-prod-update" type="submit" name="prod" value="<?php echo $prod_id; ?>" class="btn waves-effect waves-light" style="margin-bottom: 75px; margin-left: auto; margin-right: auto; display: block">Submit
                </button>
	
        </div>
	
  
</form>
            <?php
                }
                //mysqli_free_result($vend3);
?>

