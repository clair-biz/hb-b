<?php
require_once 'Classes/Classes.php';
    $camp_id=$_REQUEST['camp_id'];
    $q="select perc_disc from camp_serv_map where camp_id=$camp_id";
    if(isset($_REQUEST["serv"])!=0)
        $q.=" and serv_id=".$_REQUEST["serv"];
    elseif(isset($_REQUEST["cs_id"])!=0)
        $q.=" and cs_id=".$_REQUEST["cs_id"];
    
$vend_id=Crm::getuidbyuname($_SESSION["user"]);

$vend3=mysqli_query(Crm::con(),$q);  

//$stmtcat=mysqli_query(Crm::con(),"select cs_id,cs_name from cat_sub,vend_subscription,users,category where category.cat_id=cat_sub.cat_id and  users.u_id=vend_subscription.u_id and vend_subscription.cat_id=cat_sub.cat_id and cs_name<>cat_name and u_name='".$_SESSION["user"]."';");  
//$stmtprodcamp=mysqli_query(Crm::con(),"select prod_name from product,camp_prod_map where product.prod_id=camp_prod_map.prod_id and camp_id=$camp_id;");  

if($row=mysqli_fetch_array($vend3)) {
    //$img="uploads/products-services/$row[3]";
?>
    <form class="form-horizontal text-center" id="prod-update" action="vendor-camp-serv-update1.php" method="post">
            <!-- /.row -->
            <div class="row">
            <p class="col-md-2 text-right" >Disc Percentage:</p>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" autocomplete="off" id="disc" name="disc" placeholder="<?php echo $row[0]."%"; ?>" value="<?php echo $row[0]; ?>"/>
                    <label for="disc">Disc Percentage:</label>
                </div>
            </div>
            
            
    <div class="row">
	<div class="col-md-3 col-lg-3 col-md-offset-3 col-lg-offset-3">
            
            <button id="" name="camp" value="<?php echo $camp_id; ?>" class="btn btn-block " >Submit</button>
	</div>
    </div>
</form>
            <?php
                }
                //mysqli_free_result($vend3);
?>
