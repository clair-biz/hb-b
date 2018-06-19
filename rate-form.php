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

$cat_id=$_REQUEST["cat_id"];
$catstr="select cs_id,cs_name from cat_sub,category,vend_subscription,users where category.cat_id=cat_sub.cat_id and vend_subscription.cat_id=category.cat_id and users.u_id=vend_subscription.u_id and u_name='".$_SESSION["user"]."';";
$catres=mysqli_query(Crm::con(),$catstr);
$prodres=mysqli_query(Crm::con(),"select product.prod_id,prod_name from product,users where product.vend_id=users.u_id and u_name='".$_SESSION["user"]."';");
?>

    <div class="container-fluid" style="margin-top: 40px;">
        <div class="row">
<div id="camp-insert-tab" class="col-lg-10 col-sm-12 col-lg-offset-1">
            <div class="row">
                    <h5 class="page-header">Rate Chart for <?php echo Crm::getcatnamebycatid($cat_id); ?></h5>
            </div>
            <!-- /.row -->
                            <table width="100%" class="table hover centered z-depth-1 hoverable" id="dataTables-example">
                                <thead>
      <tr>
    <th class="text-center">Plan Name</th>
    <th class="text-center">Rate </th>
    <th class="text-center">Tax Percentage</th>
      </tr>
    </thead>
    <tbody>
            <?php
$camp_prodres=mysqli_query(Crm::con(),"select plan_name,plan_rate,tax_perc from category,rate_plan where category.cat_id=rate_plan.cat_id and category.cat_id=$cat_id;");
while($camp_prod= mysqli_fetch_array($camp_prodres)) {
?>
        <tr class="text-center">
        <td><?php echo $camp_prod[0]; ?></td>
        <td><?php echo $camp_prod[1]; ?></td>
        <td><?php echo $camp_prod[2]; ?></td>
       </tr>

<?php } ?>
    </tbody>

      </table>
                            <!-- /.table-responsive -->


<form class="form-horizontal" id="rate-insert" action="rate-form1.php" method="post">

                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Plan Name <font style="color:red">*</font>:</p>
        <div class="col-lg-4 col-md-4 col-sm-4">
                <select class="form-control" id="plan" name="plan" required>
                    <option value="">-select-</option>
                    <option value="Half Annual">Half Year</option>
                    <option value="Annual">Year</option>
                </select>
            <label class="col-md-4" for="plan">Plan Name:</label>
        </div>
      </div>
                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Rate <font style="color:red">*</font>:</p>
        <div class="col-lg-4 col-md-4 col-sm-4 form-group">
                <input type="number" class="form-control" autocomplete="off" value="" id="rate" name="rate" required />
            <label for="rate">Rate:</label>
        </div>
      </div>
                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Tax Percentage <font style="color:red">*</font>:</p>
        <div class="col-lg-4 col-md-4 col-sm-4 form-group">
                <input type="number" class="form-control" autocomplete="off" id="tax" value="0" name="tax" required />
            <label for="tax">Tax Percentage:</label>
        </div>
      </div>
    <div class="row">
                <input type="hidden" value="<?php echo $cat_id; ?>" name="cat_id"/>
	<div class="col-md-offset-2 col-md-3">
            <button type="submit" id="" name="sub" value="more" class="btn btn-block " >Add More</button>
	</div>
	<div class="col-md-offset-1 col-md-3">
            <button type="submit" id="" name="sub" value="submit" class="btn btn-block green" >Submit</button>
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
            responsive: true
        });
    });
    </script>
    </body>
</html>