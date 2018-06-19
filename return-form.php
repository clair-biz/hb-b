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

$ord_id=$_REQUEST["ord_id"];
$prod_id=$_REQUEST["prod_id"];
$cat=Base::generateResult("select r_id,reason from reasons where type='Return';");
?>
    <div class="container-fluid" style="margin-top: 40px;">
         <div class="row">
                <div class="col-lg-2 col-md-2 hide-on-small-and-down">
                    <?php
                    require 'cust-menu.php'; 
                    ?>
                </div>
           
<!-- 
Body Section 
-->
    	<div class="card col-md-10 col-lg-10 col-md-offset-1">
            <form class="form-horizontal" id="return-form" action="return-form1.php" method="post"  enctype="multipart/form-data">
        <div class="row justify-content-center">
            <h5 class="text-center" >Return Form</h5>	
        </div>

<?php                
        $query="select prod_name,date_format(req_dt,'%d-%m-%Y'),ord_qty,ord_rate,sc_cust,bs_from,bs_to,product.prod_id from ordertbl,product,order_detail,booking_slots where booking_slots.bs_id=ordertbl.bs_id and order_detail.prod_id=product.prod_id and ordertbl.ord_id=order_detail.ord_id and ordertbl.ord_id=".$ord_id;
//        echo $query;
//        $replace=Product::canReturn($prod_id, "prod_replace");
//        $return=Product::canReturn($prod_id, "prod_return");
        ?>

                    <?php
                    if(Product::canReturn($prod_id, "prod_replace")) {
                    ?>
                <div class="row">
                    <p class="offset-sm-4 col-md-4 col-lg-4 col-sm-4">
                                <input type="checkbox" id="replacement" value="replacement" name="check_list[]" required  /> 
            <label for="replacement">Replacement</label>
            </p>
                </div>
                    <?php
                    }
                    if(Product::canReturn($prod_id, "prod_return")) {
                    ?>
                <div class="row">
                    <p class="offset-sm-4 col-md-4 col-lg-4 col-sm-4">
                                <input type="checkbox" id="return" value="return" name="check_list[]" required  /> 
            <label for="return">Return</label>
            </p>
                </div>
            <?php 
                    }
                    ?>
                
                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Reason for Return <font style="color:red">*</font>:</p>
            <div class="col-lg-6 col-md-6 col-sm-8">
                <select class="form-control" id="reason" name="reason" required>
      <option value="" disabled selected>Choose your option</option>
          <?php
            while($row = mysqli_fetch_array($cat)) {
                    ?>
                    <option value="<?php echo $row[0];  ?>"><?php echo $row[1];  ?></option>
                    <?php
                    }
                    ?>
    </select>
  </div>
          </div>
               
          
                  <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Product Image <font style="color:red">*</font>:</p>
        <div class="col-lg-6 col-md-6 col-sm-8 form-group">
                      <input type="file" class="form-control" name="file[]" id="file" multiple accept="image/jpg,image/png,image/jpeg,image/gif" >
                <div class="row">
                    <em>Note: The image size should not be more than 1 MB</em>
                </div>
                </div>

            </div>

        
         <div class="row justify-content-center">
             <input type="hidden" name="ord_id" value="<?php echo $ord_id;?>" />
             <input type="hidden" name="prod_id" value="<?php echo $prod_id;?>" />
                    <div class="col-md-4 text-center col-sm-12 submit-btn" style="">
                <button id="submit-return" type="submit" class="btn waves-effect waves-light" style="margin-bottom: 75px;">Submit
                <i class="material-icons right">send</i>
                </button>
	</div>
        </div>
	</form>
               </div>
                

</div>

</div><!-- /container -->

      </section>    
      <section class="footer" style="margin-top: 10px !important; width: auto !important;" ></section>
      
</section>
<?php
require_once 'scripts.html';
?>

<script>
    $(document).ready(function() {
  $('#dataTables-example').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }
    });
    

    
});

</script>


    </body>
</html>