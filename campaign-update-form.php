<?php
require_once 'data.php';
    $camp_id=$_REQUEST['camp_id'];
$vend_id=Base::getuidbyuname($user->u_name);

$vend3=Base::generateResult("select camp_name,date_format(camp_start,'%d-%m-%Y') as 'camp_start',date_format(camp_end,'%d-%m-%Y') as 'camp_end' from campaign where camp_id=".$camp_id.";");  

//$stmtcat=Base::generateResult("select cs_id,cs_name from cat_sub,vend_subscription,users,category where category.cat_id=cat_sub.cat_id and  users.u_id=vend_subscription.u_id and vend_subscription.cat_id=cat_sub.cat_id and cs_name<>cat_name and u_name='".$_SESSION["user"]."';");  
//$stmtprodcamp=Base::generateResult("select prod_name from product,camp_prod_map where product.prod_id=camp_prod_map.prod_id and camp_id=$camp_id;");  

if($row=mysqli_fetch_array($vend3)) {
    //$img="uploads/products-services/$row[3]";
?>

    <form class="form-horizontal text-center" id="camp-update" method="post">
        <div class="row justify-content-center mb-2" >
            <h4 class="text-center col" ><?php echo "Update ".$row["camp_name"];?></h4>
        </div>
            <!-- /.row -->
            <div class="row">
            <p class="col text-right" >Offer Name:</p>
                <p class="text-center col"><?php echo $row["camp_name"]; ?></p>
                <div class="form-group col">
                    <input type="text" class="form-control" autocomplete="off" autofocus id="cname" name="cname" />
                </div>
            </div>
            
            <div class="row">
            <p class="col text-right" >Start Date:</p>
                <p class="text-center col"><?php echo $row['camp_start']; ?></p>
                <div class="form-group col">
                    <input type="text" data-toggle="datepicker" class="form-control" readonly autocomplete="off" id="stdt" name="stdt" />
                </div>
            </div>
            <div class="row">
            <p class="col text-right" >End Date:</p>
                <p class="text-center col"><?php echo $row["camp_end"]; ?></p>
                <div class="form-group col">
                    <input type="text" data-toggle="datepicker" class="form-control" readonly autocomplete="off" id="endt" name="endt" />
                </div>
            </div>
            
            
    <div class="row justify-content-center">
            <button id="submit-camp-update" name="camp" value="<?php echo $camp_id; ?>" class="btn " >Submit</button>
    </div>
</form>
            <?php
                }
                //mysqli_free_result($vend3);
?>
