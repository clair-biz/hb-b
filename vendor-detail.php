<html>
<body>
<?php
require_once 'data.php';
$vend_id= $_REQUEST['vend_id'];
//$cat_type=Crm::getcattypebyuname($_SESSION["user"]);

$status="";
$query="SELECT bname,cat_name,date_format(vs_from,'%d-%m-%Y'),date_format(vs_to,'%d-%m-%Y'),vs_pay_status,vs_id from vend_subscription,users,category WHERE category.cat_id=vend_subscription.cat_id and vend_subscription.u_id=users.u_id and is_active='Y' and users.vend_id=$vend_id";
$vend_info=Base::generateResult($query);
?>
    <div class="container-fluid row">
    <div class="col-md-offset-1 col-lg-offset-1 col-md-10 col-lg-10 col-sm-12 ">
        <div class="row">
        <h5><?php echo Vendor::getvendnamebyid($vend_id); ?></h5>
    </div>
            <div class="row">
                            <table width="100%" class="table hover table-responsive0 centered z-depth-1 hoverable" id="dataTables-vend-details">
                                <thead>
                                    <tr  class="center-align">
                                        <th>Business Name</th>
                                        <th>Subscription From</th>
                                        <th>Subscription To</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
    <tbody>
            <?php

            while ($row = mysqli_fetch_array($vend_info)) {
?>
        <tr class=" vendor">
        <td><?php echo $row[0]." (".$row[1].")"; ?></td>
        <td><?php echo $row[2]; ?></td>
        <td><?php echo $row[3]; ?></td>
        <td><?php echo $row[4]; ?></td>
        <td><a href="#!" id="<?php echo $row[5]; ?>" class="vendor-disable">Disable</a>
        </td>
        </tr>
 
     <?php 
      } 
    ?>
    </tbody>
</table>
            </div>
    </div>
    </div>
    

</html>