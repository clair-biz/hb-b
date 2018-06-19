<?php
require_once 'Classes/Classes.php';
    $cat_id=$_REQUEST['cat_id'];
//$vend_id=Crm::getuidbyuname($_SESSION["user"]);
$hy=$_REQUEST['hy'];
$vend3=mysqli_query(Crm::con(),"select rp_id,plan_rate,tax_perc from rate_plan where rate_plan.cat_id=".$cat_id." and plan_name='$hy';");  
//$cat3=mysqli_query(Crm::con(),"select cat_name from category where cat_id<>0 and rate_plan.cat_id=".$cat_id.";");  

//$stmtcat=mysqli_query(Crm::con(),"select cs_id,cs_name from cat_sub,vend_subscription,users,category where category.cat_id=cat_sub.cat_id and  users.u_id=vend_subscription.u_id and vend_subscription.cat_id=cat_sub.cat_id and cs_name<>cat_name and u_name='".$_SESSION["user"]."';");  

if($row=mysqli_fetch_array($vend3)) {
    //$img="uploads/products-services/$row[3]";
?>
    <form class="form-horizontal text-center" id="prod-update" action="admin-rate-update1.php" method="post">
            <!-- /.row -->
                 <div class="row hide-on-small-only">
                     <p class="text-center"><b><?php echo "Update $hy Charge for ".Crm::getcatnamebycatid($cat_id); ?></b></p>
                     <div class="col-md-4 col-md-offset-2">
                         <p class="text-center"><b>Previous Values</b></p>
            </div>
            <div class="col-md-4 ">
                   <p class="text-center">New Values</b></p>
            </div>
        </div>
            <div class="row">
            <p class="col-md-2 text-right" >Charges:</p>
                <p class="text-center col-md-4 "><?php echo "&#8377; ".$row[1]."/-"; ?></p>
                <div class="form-group col-md-4 col-sm-12">
                    <input type="text" class="form-control" autofocus autocomplete="off" id="rate" name="rate" />
                    <label for="rate">charges:</label>
                </div>
            </div>
            
            <div class="row">
            <p class="col-md-2 text-right" >Tax:</p>
                <p class="text-center col-md-4 "><?php echo $row[2]."%"; ?></p>
                <div class="form-group col-md-4 -col-sm-12">
                        <input type="text" class="form-control" autocomplete="off" id="tax" name="tax" />
                    <label for="tax">Tax:</label>
                </div>
            </div>
            
    
	<div class="row">
            
            <button id="" name="rp" value="<?php echo $row[0]; ?>" class="btn btn-block " style="margin-bottom: 75px; margin-left: auto; margin-right: auto; display: block" >Submit</button>
	</div>
	
   
</form>
            <?php
                }
                //mysqli_free_result($vend3);
?>
