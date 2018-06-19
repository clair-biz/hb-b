<html>
<head>
        <title> Homebiz365-- Vendor Add new Product </title>

        <?php require_once 'stylesheets.html';?>
    </head>
<body>
<section class="body" >
    <section class="preloader" ></section>
    <section class="content" >
<?php
require_once 'data.php';


$cat=Base::generateResult("select cs_id,cs_name from cat_sub,category,vend_subscription,users where users.u_id=vend_subscription.u_id and category.cat_id=vend_subscription.cat_id and category.cat_id=cat_sub.cat_id and vs_id='".$user->vs_id."' and cs_name<>cat_name and cs_id<>0;");
?>

   <div class="container-fluid" style="margin-top: 40px;">
         <div class="row">
                <div class="col-md-2 col-lg-2 hide-on-small-and-down">
                    <?php
                    require 'vendor-menu.php'; 
                    ?>
                    </div>
           
        
        <div class="card col-lg-10 col-md-offset-1 col-md-10">
    <form class="form-horizontal" id="prod-insert" action="vendor-prod-insert1.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <h5 class="page-header text-center col-sm-12">Add New Product</h5>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
            <p class="col-md-2 col-sm-4 d-flex align-items-center">Sub Category <font style="color:red">*</font>:</p>
            <div class="col-md-5 col-sm-8 form-group">
                <select class="form-control" id="subcat" name="subcat" required>
      <option value="" disabled selected>Choose your option</option>
      <option value="0" >Other</option>

                <?php
            while($row = mysqli_fetch_array($cat)) {
                    ?>
                    <option value="<?php echo $row[0];  ?>"><?php echo $row[1];  ?></option>
                    <?php
                    }
                    ?>
    </select>
  </div>
            <div class="col-md-5 col-sm-8 form-group cat1" style="display: none;">
            <input type="text" class="form-control" placeholder="Mention Other Category" autocomplete="off" id="cat1" name="cat1" required />
        </div>
            </div>

            <div class="row">
              <div class="col-md-6 col-lg-6 col-sm-12">
                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4">Product Name <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="pname" name="pname" required />
        </div>
                </div>

                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4">Product Description:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group">
                 <textarea class="form-control" autocomplete="off" id="pdesc" name="pdesc"  ></textarea>
        </div> 

            </div>

                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4">Lead Time Required:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 input-group form-group">
                    <input type="number" value="1" min="1" class="form-control" autocomplete="off" id="min_time_val" name="min_time_val" />
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
            <p class="col-md-4 col-lg-4 col-sm-4">Min Order Quantity <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 input-group form-group">
                        <input type="text" class="form-control" autocomplete="off" id="qty" name="qty" />
                <div class="input-group-append">
                <select class="form-control" id="unit" name="unit">
                    <option selected="true" disabled value="">-Select-</option>
                    <option value="Kg">Kilograms (kg)</option>
                    <option value="gm">Grams (gm)</option>
                    <option value="mg">Milligrams (mg)</option>
                    <option value="L">Litres (L)</option>
                    <option value="ml">Millilitre (ml)</option>
                    <option value="Piece">Piece(s)</option>
                </select>
                </div>
            <p><em>Note: Product will be available in multiples of Min. Order Quantity</em></p>
            </div>
          </div>  

      </div>
              <div class="col-md-6 col-lg-6 col-sm-12">

                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4">Price &#8377; <span class="base_prc"></span><font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="base_prc" name="base_prc" placeholder="" required />
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
                <input type="text" class="form-control" autocomplete="off" id="hsn" name="hsn" />
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
            <p class="col-sm-12 col-md-4 text-left">Replace / Return :</p>
        <div class="col-md-8 col-sm-12 input-group form-group">
            <div class="input-group-prepend" >
                <label class="checkbox-inline input-group-text"><input type="checkbox" value="replacement" name="check_list[]">Replace</label>
                <label class="checkbox-inline input-group-text"><input type="checkbox" value="return" name="check_list[]">Return</label>
            </div>
            <input type="number" class="form-control" placeholder="Within" autocomplete="off" id="within" name="Within days" />
        </div>
            
            </div>

                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4">Product Image <font style="color:red">*</font>:</p>
                <div class="col-md-8 col-lg-8 col-sm-8 form-group">
                    <input class="form-control" name="file" type="file" id="customfile" accept="image/jpg,image/png,image/jpeg,image/gif" >
<em>Note: The image size should not be more than 1 MB</em>
                </div>
                </div>
                </div>

            </div>

       
                                
            <div class="row">
       
                <button id="submit-prod-insert" type="submit" class="btn waves-effect waves-light" style="margin-bottom: 75px; margin-left: auto; margin-right: auto; display: block">Submit
                <i class="material-icons right">send</i>
                </button>
	
        </div>
    </form> 
</div>
    </div>

        </div>
      </section>    
      <section class="footer" style="margin-top: 10px !important; width: auto !important;" ></section>
      
</section>
<?php
require_once 'scripts.html';
?>        <!-- /#page-wrapper -->
  

    </body>
</html>
