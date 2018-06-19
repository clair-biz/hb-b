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


//Statement stmtcat=packcrm.Crm.con().createStatement();    
$cat=mysqli_query(Crm::con(),"select * from category where cat_id<>0;");  
//Statement stmtcat111=packcrm.Crm.con().createStatement();    
$query="select pr_id,ordertbl.ord_id,prod_name,product.prod_id,cust_fname,reasons.reason,pr_amount,users.u_id
from customer,ordertbl,order_detail,users,prod_return,product,reasons
where customer.cust_id=ordertbl.cust_id
and prod_return.r_id=reasons.r_id
and users.cust_id=customer.cust_id
and prod_return.ord_id=ordertbl.ord_id
and order_detail.ord_id=ordertbl.ord_id
and prod_return.prod_id=product.prod_id
and order_detail.prod_id=product.prod_id
and pr_status='Refund'";  
//$cat111=mysqli_query(Crm::con(),$query);
$cat111=Base::generateResult($query);

?>
    <div class="container-fluid" style="margin-top: 40px;">
    
            <div class="row">
                <div class="col-lg-2 col-md-2 hide-on-small-and-down">
                    <?php
                    require 'admin-menu.php'; 
                    ?>
                    </div>
            <div class="row">
        <div class="card col-lg-10 col-md-10 col-sm-12 col-md-offset-1">
                         <h5 class="page-header">&nbsp;&nbsp;Refund</h5>
            <!--div >
                <em class="hide-on-med-and-up center-align">Note: Record to view its remaining details on right side.</em>
            </div-->
            <form action="refund-process.php" method="post">
                            <table width="100%" class="table table-striped table-responsive table-bordered table-hover" id="dataTables-vendors">
                                <thead>
        <tr class="text-center">
            <th></th>
            <th>Order #</th>
            <th>Product</th>
            <th>Vendor</th>
            <th>Customer</th>
            <th>Reason</th>
            <th>Amount</th>
      </tr>
    </thead>
    <tbody> 
        <?php
      while($row=mysqli_fetch_array($cat111)){  
?>
        <tr class="text-center">
        <td>
            <p>
            <input type="checkbox" id="<?php echo "cb_".$row[0]; ?>" value="<?php echo $row[0];?>" name="check_list[]"  /> 
            <label for="<?php echo "cb_".$row[0]; ?>"></label>
            </p>
        </td>
        <td><?php echo $row[1]; ?></td>
        <td><?php echo $row[2]; ?></td>
        <td><?php echo Vendor::getvendnamebyprodid($row[3]); ?></td>
        <td><?php echo $row[4]; ?></td>
        <td><?php echo $row[5]; ?></td>
        <td><?php echo "&#8377; ".$row[6]."/-"; ?></td>
        </tr>

<?php }
?>
  
    </tbody>

                            </table>
                            <!-- /.table-responsive -->
        <div class="row">
            <div class="col-md-offset-4 col-md-4 text-center col-sm-12 submit-btn" style="margin-top: 20px;" >
                <button  type="submit" name="submit" value="refund" class="btn waves-effect waves-light" >Refund
                <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
        </form>
                </div>
                <!-- /.col-lg-12 -->
                
                <!--div class="col  l4 offset-m1 m4 s12 card-panel hide-on-small-only" style="max-height: 450px;">
          <div class="card logo-bg-b darken-1" style="margin-bottom:0 !important;">
              <div class="card-content container white-text" style="padding: 5px !important; ">
            <p style="color:white;"><b>New Requests &nbsp;
            <i class="material-icons">announcement</i>
                </b></p>
            </div>
          </div>
        <div class="card white " style="margin-top:0 !important; margin-bottom:0 !important;">
            <div class="card-content white-text" style="padding: 5px !important; max-height: 380px; overflow-y: auto">">
                            <?php //require 'admin-notification.php'; ?>
            </div>
          </div>
        </div-->


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
        $('#dataTables-vendors').DataTable({
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