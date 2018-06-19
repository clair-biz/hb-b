<?php
require_once 'Classes/Classes.php';
    $camp_id=$_REQUEST['camp_id'];
    $q="select disc_on,prod_qty,unit,perc_disc from camp_prod_map where camp_id=$camp_id";
    if(isset($_REQUEST["prod"])!=0)
        $q.=" and prod_id=".$_REQUEST["prod"];
    elseif(isset($_REQUEST["cs_id"])!=0)
        $q.=" and cs_id=".$_REQUEST["cs_id"];
    
$vend_id=Crm::getuidbyuname($_SESSION["user"]);

$vend3=mysqli_query(Crm::con(),$q);  

//$stmtcat=mysqli_query(Crm::con(),"select cs_id,cs_name from cat_sub,vend_subscription,users,category where category.cat_id=cat_sub.cat_id and  users.u_id=vend_subscription.u_id and vend_subscription.cat_id=cat_sub.cat_id and cs_name<>cat_name and u_name='".$_SESSION["user"]."';");  
//$stmtprodcamp=mysqli_query(Crm::con(),"select prod_name from product,camp_prod_map where product.prod_id=camp_prod_map.prod_id and camp_id=$camp_id;");  

if($row=mysqli_fetch_array($vend3)) {
    //$img="uploads/products-services/$row[3]";
?>
    <form class="form-horizontal text-center" id="prod-update" action="vendor-camp-prod-update1.php" method="post">
            <!-- /.row -->
            <div class="row">
              <p class="col-md-2 text-right" >Discount On:</p>
                <div class="col-md-4 ">
                    <label for="disc_on">Discount On:</label>
                            <select class="form-control" id="disc_on" name="disc_on" >
                    <option selected="true" value="<?php echo $row[0]; ?>" ><?php echo $row[0]; ?></option>
                   <?php 
                   if($row[0]=="Atleast"){
                       ?>
                    <option value="Atmost">Atmost</option>
                    <option value="Multiple">Multiple</option>  
                    <?php
                   }
                   elseif($row[0]=="Atmost"){
                       ?>
                    <option value="Atleast">Atleast</option>
                    <option value="Multiple">Multiple</option>
                   <?php
                    }
                   else{
                       ?>
                    <option value="Atleast">Atleast</option>
                    <option value="Atmost">Atmost</option>
                   <?php
                    }
                    ?>
                    </select>
        </div>
            </div>
            
            <div class="row">
            <p class="col-md-2 text-right" >Quantity:</p>
                <div class="form-group  col-md-4 ">
                    <input type="text" class="form-control" autocomplete="off" id="qty" name="qty" placeholder="<?php echo $row[1]." ".$row[2]; ?>"  value="<?php echo $row[1]; ?>"/>
                    <label for="qty">Quantity:</label>
                </div>
            <div class="col-md-4">        
            <select class="form-control" id="unit" name="unit" >
                    <option selected="true" value="<?php echo $row[2]; ?>" ><?php echo $row[2]; ?></option>
                    <?php
                    if($row[2]=="Kg"){
                        ?>
                     <option value="gm">Grams (gm)</option>
                    <option value="mg">Milligrams (mg)</option>
                    <option value="L">Litres (L)</option>
                    <option value="ml">Milli liter (ml)</option>
                    <option value="Piece">Pieces</option>
                    <?php
                    }
                    elseif ($row[2]=="gm") {
                        ?>
                    <option value="Kg">Kilograms (kg)</option>
                    <option value="mg">Milligrams (mg)</option>
                    <option value="L">Litres (L)</option>
                    <option value="ml">Milli liter (ml)</option>
                    <option value="Piece">Pieces</option>
                    <?php
                }elseif ($row[2]=="mg") {
                    ?>
                      <option value="Kg">Kilograms (kg)</option>
                    <option value="gm">Grams (gm)</option>
                    <option value="L">Litres (L)</option>
                    <option value="ml">Milli liter (ml)</option>
                    <option value="Piece">Pieces</option>
                        <?php      
                        }
                        elseif ($row[2]=="L") {
                            ?>
                    <option value="Kg">Kilograms (kg)</option>
                    <option value="gm">Grams (gm)</option>
                    <option value="mg">Milligrams (mg)</option>
                    <option value="ml">Milli liter (ml)</option>
                    <option value="Piece">Pieces</option>
                     <?php   
                    }
                    elseif ($row[2]=="ml") {
                    ?>
                     <option value="Kg">Kilograms (kg)</option>
                    <option value="gm">Grams (gm)</option>
                    <option value="mg">Milligrams (mg)</option>
                    <option value="L">Litres (L)</option>
                    <option value="Piece">Pieces</option>
                        <?php
                }
                else {
                    ?>
                <option value="Kg">Kilograms (kg)</option>
                    <option value="gm">Grams (gm)</option>
                    <option value="mg">Milligrams (mg)</option>
                    <option value="L">Litres (L)</option>
                    <option value="ml">Milli liter (ml)</option>
                        <?php    
                }
                ?>
                    </select>
            </div>  
            </div>
            <div class="row">
            <p class="col-md-2 text-right" >Disc Percentage:</p>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" autocomplete="off" id="disc" name="disc" placeholder="<?php echo $row[3]."%"; ?>" value="<?php echo $row[3]; ?>"/>
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
