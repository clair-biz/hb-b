<html>
    <body>


<?php
require_once 'Classes/Classes.php';
 
$camp=$_REQUEST['camp_id'];
$q="select prod_id,cs_id,disc_on,prod_qty,perc_disc from camp_prod_map where camp_id=$camp";
$r=mysqli_query(Crm::con(),$q);
?>
                        <div class="card col-sm-12">
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
while($camp_prod= mysqli_fetch_array($r)) {
?>
        <tr class="text-center">
        <td><?php if($camp_prod[0]!=0){ echo Product::getprodnamebyid($camp_prod[0]); } else {echo "-";}  ?></td>
        <td><?php if($camp_prod[1]!=0){ echo Product::getcsnamebyid($camp_prod[1]); } else {echo "-";}  ?></td>
        <td><?php echo $camp_prod[2]; ?></td>
        <td><?php echo $camp_prod[3]; ?></td>
        <td><?php echo $camp_prod[4]; ?></td>
       </tr>

<?php } ?>
    </tbody>

      </table>

                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
    </body>
</html>