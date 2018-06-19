<html>
    <body>
<?php
require_once 'Classes/Classes.php';
//Statement stmtcat=packcrm.Crm.con().createStatement();    
$q="select * from category where cat_id<>0;";
$cat=Base::generateResult($q);
//Statement stmtvend=packcrm.Crm.con().createStatement();
$q="select users.u_id,vend_fname,cat_name,vs_for,vs_pay_status,vs_id from vendor,category,users,vend_subscription where vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=vend_subscription.cat_id and vs_for is not NULL and vendor.vend_id<>0";  
$vend=Base::generateResult($q);
?>
                                <?php
                                    while($row=mysqli_fetch_array($vend)) {
                                       $vs_for=Crm::annualtoyear($row[3]);
                                ?>
                                    <li class="list-group">
                                <a href="<?php echo Crm::root()."SubscriptionRequest?vs_id=".$row[5]; ?>" style="<?php 
                                       if($row[4]=="New")
                                           echo "color: red !important;";
                                       elseif($row[4]=="Approved")
                                           echo "color: green !important;";
                                       
                                       ?>">
                                           <?php echo "Vendor:&nbsp".$row[1]." (".$row[2].")"; ?>
                                    &nbsp;<em><?php echo "For: ".$vs_for; ?></em>
                                </a>
                                    </li>
                                <?php }
//                                mysqli_free_result($vend);
                                //stmtvend.close();
?>
                            <!-- /.list-group -->
        
    </body>
</html>
