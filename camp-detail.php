<html>
<body>
<?php
require_once 'data.php';
$camp_id= $_REQUEST['camp_id'];
//$camp_id= $_REQUEST['cs_id'];

$type=$_REQUEST["type"];
$prod_id=0;
$serv_id=0;
$q="";
switch ($type) {
    case "Product":
                    if(isset($_REQUEST["prod_id"]) && $_REQUEST["prod_id"]!="")
                    $prod_id=$_REQUEST["prod_id"];
                    
                    $q="select prod_id,cs_id,disc_on,camp_prod_map.prod_qty,camp_prod_map.unit,perc_disc from camp_prod_map where camp_id=$camp_id;";
                break;
    case "Service":
                    if(isset($_REQUEST["serv_id"]) && $_REQUEST["serv_id"]!="")
                    $serv_id=$_REQUEST["serv_id"];
                    
                    $q="select serv_id,cs_id,perc_disc from camp_serv_map where camp_id=$camp_id;";
                break;
}
//echo $q;
$camp_prodres=Base::generateResult($q);

?>
    <div class="container-fluid row">
    <div class="col-lg-10 col-md-10 col-sm-12 col-md-offset-1 col-lg-offset-1">
        <div class="row">
        <p><?php /*echo Vendor::getvendfnamelnamebyid($vend_id);*/ ?></p>
    </div>
            <div class="row">
                            <table width="100%" class="table hover table-responsive0 centered z-depth-1 hoverable" id="dataTables-camp-details">
                                <thead>
                                    <?php
switch($type) {
    case "Product":
                                    ?>
      <tr>
    <th class="text-center">Product</th>
    <th class="text-center">Category</th>
    <th class="text-center">Discount On</th>
    <th class="text-center">Quantity</th>
    <th class="text-center">Discount</th>
                                        <th></th>
                                    </tr>
<?php
break;
    case "Service":
                                    ?>
      <tr>
    <th class="text-center">Service</th>
    <th class="text-center">Category</th>
    <th class="text-center">Discount</th>
                                        <th></th>
                                    </tr>
<?php
break;

}
?>
                                </thead>
    <tbody>
            <?php

while($camp_prod= mysqli_fetch_array($camp_prodres)) {
    switch($type) {
    case "Product":
                                    ?>
        
        <tr class="text-center">
        <td><?php if($camp_prod[0]!=0){ echo Product::getprodnamebyid($camp_prod[0]); } else {echo "-";}  ?></td>
        <td><?php if($camp_prod[1]!=0){ echo Base::getcsnamebyid($camp_prod[1]); } else {echo "-";}  ?></td>
        <td><?php echo $camp_prod[2]; ?></td>
        <td><?php echo $camp_prod[3]." ".$camp_prod[4]; ?></td>
        <td><?php echo $camp_prod[5]; ?></td>
        <td><a data-message="<?php echo "delete_type=camp-prod&camp_id=$camp_id&type=Product&prod_id=".$camp_prod[0]."&cs_id=".$camp_prod[1]; ?>" class="camp-delete">Delete</a>
        </td>
        </tr>
 
     <?php
     break;
    case "Service":
                                    ?>
        <tr class="text-center">
        <td><?php if($camp_prod[0]!=0){ echo Service::getservnamebyid($camp_prod[0]); } else {echo "-";}  ?></td>
        <td><?php if($camp_prod[1]!=0){ echo Base::getcsnamebyid($camp_prod[1]); } else {echo "-";}  ?></td>
        <td><?php echo $camp_prod[2]; ?></td>
        <td><a data-message="<?php echo "delete_type=camp-serv&camp_id=$camp_id&type=Service&serv_id=".$camp_prod[0]."&cs_id=".$camp_prod[1]; ?>" class="camp-delete">Delete</a>
        </td>
        </tr>

<?php
        }
      }
    ?>
    </tbody>
</table>
            </div>
    </div>
    </div>
</body>
</html>