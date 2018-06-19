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

$camp_id=$_REQUEST["camp"];
$catstr="select cs_id,cs_name from cat_sub,category,users where category.cat_id=cat_sub.cat_id and u_name='".$user->u_name."';";
$catres=Base::generateResult($catstr);
$prodres=Base::generateResult("select product.prod_id,prod_name from product,users,vend_subscription where users.u_id=vend_subscription.u_id and product.vs_id=vend_subscription.vs_id and u_name='".$user->u_name."';");
?>

    <div class="container-fluid row" style="margin-top: 40px;">
         <div class="row">
                <div class="col-md-2 col-lg-2 d-none d-md-block ">
                    <?php
                    require 'vendor-menu.php'; 
                    ?>
                    </div>
    
<div id="camp-insert-tab" class="card col-md-10 col-lg-10 col-sm-12 offset-md-1">
            <div class="row">
                <div class="col-lg-12">
                    <h5 class="page-header">Products in <?php echo Campaign::getcampnamebyid($camp_id)." Offer"; ?></h5>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
    <table width="100%" class="table table-striped table-responsive table-bordered table-hover" id="dataTables-example">
                                <thead>
      <tr>
    <th class="text-center">Product</th>
    <th class="text-center">Category</th>
    <th class="text-center">Discount On</th>
    <th class="text-center">Quantity</th>
    <th class="text-center">Discount</th>
      </tr>
    </thead>
    <tbody>
            <?php
$camp_prodres=Base::generateResult("select prod_id,cs_id,disc_on,camp_prod_map.prod_qty,camp_prod_map.unit,perc_disc from camp_prod_map where camp_id=$camp_id;");
while($camp_prod= mysqli_fetch_array($camp_prodres)) {
?>
        <tr class="text-center">
        <td><?php if($camp_prod[0]!=0){ echo Product::getprodnamebyid($camp_prod[0]); } else {echo "-";}  ?></td>
        <td><?php if($camp_prod[1]!=0){ echo Crm::getcsnamebyid($camp_prod[1]); } else {echo "-";}  ?></td>
        <td><?php echo $camp_prod[2]; ?></td>
        <td><?php echo $camp_prod[3]." ".$camp_prod[4]; ?></td>
        <td><?php echo $camp_prod[5]; ?></td>
       </tr>

<?php } ?>
    </tbody>

      </table>
                            <!-- /.table-responsive -->


<form class="form-horizontal row" id="camp-prod-insert" action="vendor-camp-prod-insert1.php" method="post">
<div class="col-md-10 offset-md-1 col-lg-10 offset-lg-1 col-sm-12 ">
       <div class="row">
            <p class="col-md-4" for="campon">Offer On:</p>
            <div class="col-md-4">
            <label for="campon">Offer On:</label>
                <select class="form-control" id="campon" name="campon" required>
                    <option value="">-select-</option>
                    <option value="1">Product</option>
                    <option value="2">Category</option>
                </select>
                </div>
        </div>
        <div id="displayProduct" style="display:none !important;">
	<div class="form-group" data-parent="#displayProduct">
       <div class="row">
            <p class="col-md-4" >Product:</p>
            <div class="col-md-4">
            <label for="prod">Product:</label>
                <select class="form-control" id="prod" name="prod" >
                    <option selected="true" value="0">-Select-</option>

                <?php
      while($prod= mysqli_fetch_array($prodres)){  
                    ?>
                    <option value="<?php echo $prod[0]; ?>"><?php echo $prod[1]; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
	</div>
	</div>
        </div>
        
        <div id="displayCat" style="display:none !important;">
	<div class="form-group" data-parent="#displayCat">
       <div class="row">
            <p class="col-md-4" >Product Category:</p>
            <div class="col-md-4">
            <label for="prod">Product Category:</label>
                <select class="form-control" id="pc" name="pc" >
                    <option selected="true" value="">-Select-</option>
                <?php
      while($cat= mysqli_fetch_array($catres)){  
                    ?>
                    <option value="<?php echo $cat[0]; ?>"><?php echo $cat[1]; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            </div>
            </div>
	</div>
        
       <div class="row">
            <p class="col-md-4" >Discount On:</p>
            <div class="col-md-4">
            <label for="prod">Discount On:</label>
                <select class="form-control" id="disc_on" name="disc_on" >
                    <option selected="true" value="Atleast">Atleast</option>
                    <option value="Atmost">Atmost</option>
                    <option value="Multiple">Multiple</option>
                </select>
            </div>
        </div>
        
       <div class="row">
            <p class="col-md-4" >Product Qty:</p>
            <div class="col-md-4">
            <label for="prod">Product Qty:</label>
                <input type="text" class="form-control" autocomplete="off" placeholder="This Field is mandatory" value="1" id="qty" name="qty" required />
            </div>
           <div class="col-md-4">        
            <select class="form-control" id="unit" name="unit" >
                    <option selected="true" value="" >-Select-</option>
                    <option value="Kg" >Kilograms (Kg)</option>
                     <option value="gm">Grams (gm)</option>
                    <option value="mg">Milligrams (mg)</option>
                    <option value="L">Litres (L)</option>
                    <option value="ml">Milli liter (ml)</option>
                    <option value="Piece">Pieces</option>
            </select>
        </div>
        </div>
        
       <div class="row">
            <p class="col-md-4" >Discount:</p>
            <div class="col-md-4">
            <label for="prod">Discount:</label>
                <input type="text" class="form-control" autocomplete="off" placeholder="This Field is mandatory" id="disc" name="disc" required />
            </div>
        </div>
    <div class="row">
                <input type="hidden" value="<?php echo $camp_id; ?>" name="camp_id"/>
	<div class="col-md-3 offset-md-1 col-lg-3 offset-lg-1 ">
            <button type="submit" id="" name="sub" value="more" class="btn btn-block btn-primary" >Add More</button>
	</div>
	<div class="col-md-3 offset-md-1 col-lg-3 offset-lg-1 ">
            <button type="submit" id="" name="sub" value="submit" class="btn btn-block btn-primary" >Done</button>
	</div>
    </div>
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
?>

        <script>
/*             $("#campon").change(function() {
          var selected=$(this).val();
console.log(selected);
        switch(selected) {
               case 'Category':
               case 'Product':
                        $("#prod-cat-block").toggle();
          			$.ajax({
				
			type : 'POST',
			url  : 'prod_camp_list.php',
			data : "prod="+selected,
			beforeSend: function()
			{	
				$("#error").fadeOut();
				$(".btn-list").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success :  function(response) {
//                            console.log("alert "+response);
                            $("#prod-cat-block").show();
                            $("#prod-cat-block").html(response);
                            console.log(response);

    }
			});
                               break;
               default:
                        $("#prod-cat-block").hide();
                               break;
          }
          

        });*/

            </script>
    <script>
        $("#campon").change(function() {
           selected=$(this).val();
           switch(selected) {
               case '1': $("#displayProduct").show();
                         $("#displayCat").hide();
                               break;
               case '2': $("#displayCat").show();
                         $("#displayProduct").hide();
                               break;
               default : $("#displayProduct").hide();
                         $("#displayCat").hide();
                        break;
           }
//           alert("selected "+selected);
        });
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