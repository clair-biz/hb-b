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


//$cust=mysqli_query(Crm::con(),"select prod_name from product,category,users,vend_subscription,cat_sub where vend_subscription.u_id=users.u_id and vend_subscription.cat_id=category.cat_id and category.cat_id=cat_sub.cat_id and product.cs_id=cat_sub.cs_id and vs_pay_status='Enabled' and vend_subscription.vs_id=".$_COOKIE['vs_id'].";");
//            if($row=mysqli_fetch_array($cust)) {
                
?>
    <div class="container-fluid" style="margin-top: 40px;">
         <div class="row">
                <div class="col-md-2 col-lg-2 hide-on-small-and-down">
                    <?php
                    require 'vendor-menu.php'; 
                    ?>
                    </div>
<div id="camp-insert-tab" class="col-lg-10 col-md-offset-1 col-md-10 col-sm-12">
<div id="camp-insert-tab" class="card">
             <form action="prod-ordfull1.php" id="prod-order-full"  method="post">  
            <div class="row">
                <div class="col-lg-12">
                    <h5 class="page-header text-center">Order Full set for following products</h5>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Order Full Date <font style="color:red">*</font>:</p>
                <div class="col-lg-4 col-md-4 col-sm-8 form-group">
                    <input type="text" data-toggle="datepicker" readonly class="form-control" autocomplete="off" id="ofdate" name="ofdate" required />
                </div>
                </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-lg-offset-2 col-md-offset-2">
    <table width="100%" class="table striped responsive-table highlight bordered table-hover" id="dataTables-example">
                                <thead>
      <tr>
    <th class="text-center">Product</th>
    <th class="text-center">Order Full On</th>
    <th class="text-center"></th>
      </tr>
    </thead>
    <tbody>
            <?php
$query="select prod_name,product.prod_id,date_format(ord_full_date,'%d-%m-%Y'),ord_full_date,date_format(ord_full_date,'%d%m%Y') from product,category,users,vend_subscription,cat_sub,prod_date where prod_date.prod_id=product.prod_id and vend_subscription.u_id=users.u_id and vend_subscription.cat_id=category.cat_id and category.cat_id=cat_sub.cat_id and product.cs_id=cat_sub.cs_id and vs_pay_status='Enabled' and vend_subscription.vs_id=".$user->vs_id.";";
$camp_prodres=Base::generateResult($query);
while($camp_prod= mysqli_fetch_array($camp_prodres)) {
?>
        <tr class="text-center">
        <td><?php echo $camp_prod[0]; ?></td>
        <td><?php echo $camp_prod[2]; ?></td>
        <td>
            <p>
            <label for="<?php echo "cb".$camp_prod[1].$camp_prod[4]; ?>">
            <input type="checkbox" id="<?php echo "cb".$camp_prod[1].$camp_prod[4]; ?>" value="<?php echo $camp_prod[1].",".$camp_prod[3];?>" name="check_list[]" /> 
            <span></span>
            </label>
            </p>
        </td>
               </tr>

<?php } ?>
    </tbody>

      </table>
             <div class="row align-items-center justify-content-center d-flex">
            <div class="col-md-3 text-center col-sm-12 submit-btn" style="margin-top: 20px;" >
                <button  type="submit" name="submit" value="update" class="btn waves-effect waves-light" >Update
                <i class="material-icons right">send</i>
                </button>
            </div>
            <div class="offset-md-2 col-md-3 text-center col-sm-12 submit-btn" style="margin-top: 20px;" >
                <button  type="submit" name="submit" formnovalidate value="remove" class="btn waves-effect waves-light" >Remove
                <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
            </div>

             </form>    
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