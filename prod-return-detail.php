<html>
<body>
<?php
require_once 'data.php';
$pr_id= $_REQUEST['pr_id'];
$cat_type="Product";//Crm::getcattypebyvsid($vs_id);

$status="";
//if($cat_type=="Product")
$query="SELECT distinct cust_fname,cust_cntc,cust_email,cust_addr,ordertbl.ins_dt,req_dt,ord_status,delivery_status,prod_return.prod_return,prod_return.prod_replace,ordertbl.ord_id from customer,users,ordertbl,prod_return WHERE ordertbl.ord_id=prod_return.ord_id and ordertbl.cust_id=customer.cust_id and customer.cust_id=users.cust_id and pr_id=$pr_id";

$cust_info=Base::generateResult($query);
if($row=mysqli_fetch_array($cust_info)){
$date = date_create($row[4]);
$date1 = date_create($row[5]);
$today= date_create();
          $status=$row[7]."<br />Requested for ";
        if($row[8]=="Y")
            $status.="Return ";
        if($row[9]=="Y")
            $status.="Replacement";
      ?>
    <div class="container-fluid row">
    <div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 ">
        <div class="row">
        <p class="container-fluid"><?php
        echo "Order #: <b> ".$row[10]."</b>"; 
        if($status!=null || $status!="")
            echo "<b>($status) </b>";
        ?>
            <span class="float-right"><?php echo "Order Date: <b>".date_format($date,'d-m-Y')."</b>"; ?></span>
        </p>
        <p class="container-fluid"><?php
        echo "Name: <b>".$row[0]."</b>";
        if($cat_type=="Product") {
        ?>
                <span class="float-right"><?php echo "Delivered On: <b>".date_format($date1,'d-m-Y')."</b>"; ?></span>
                <?php
        }
        ?>
        </p>
        <p class="container-fluid"><?php echo "Contact No.: <b>".$row[1]."</b>"; ?>
                <span class="float-right"><?php echo "Email Id: <b>".$row[2]."</b>"; ?></span>
        </p>
        <p class="container-fluid"><?php echo "Address: <b>".$row[3]."</b>";?></p>
        <?php
      }
      ?>
    </div>
            <div class="row">
                            <table width="100%" class="table hover centered z-depth-1 hoverable" id="dataTables-cust-details">
<?php 
if($cat_type=="Product") {
?>                                <thead>
                                    <tr  class="text-center">
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
    <tbody>
            <?php
$q="SELECT prod_name,ord_qty,ord_rate,prod_return.ord_id,pr_status,product.prod_id from customer,ordertbl,product,users,order_detail,prod_return WHERE ordertbl.ord_id=prod_return.ord_id and product.prod_id=prod_return.prod_id and ordertbl.ord_id=order_detail.ord_id and customer.cust_id=ordertbl.cust_id and product.prod_id=order_detail.prod_id and customer.cust_id=users.cust_id and pr_id=$pr_id and ordertbl.req_dt GROUP by prod_name";
//echo $q;
$prod_info=Base::generateResult($q);
      $sum=0;
      $pr_status="";
      $prod_id=0;
      while ($row = mysqli_fetch_array($prod_info)) {
          $prod_name=$row[0];
          $prod_id=$row[5];
          $ord_id=$row[3];
          if(!empty($row[4]) || !is_null($row[4]))
          $pr_status=$row[4];
$sum+=$row[2];          
?>
        <tr class="">
        <td><?php echo $row[0]; ?></td>
        <td><?php echo $row[1]; ?></td>
        <td><?php echo "&#8377; ".$row[2]."/-"; ?></td>
        </tr>
 
     <?php 
     
      }
    ?>
        <tr>
            <th colspan="2" class="text-right"><b>Total</b></th>
            <th class="text-center"><b><?php echo "&#8377; ".$sum."/-"; ?></b></th>
        </tr>
    </tbody>
<?php }
elseif($cat_type=="Service") {
?>                                <thead>
                                    <tr  class="text-center">
                                        <th>Service</th>
                                    </tr>
                                </thead>
    <tbody>
            <?php
$serv_info=Base::generateResult("SELECT serv_name from customer,serviceordertbl,service,users WHERE customer.cust_id=serviceordertbl.cust_id and service.serv_id=serviceordertbl.serv_id and customer.cust_id=users.cust_id and ord_id=$ord_id and service.vend_id=(select u_id from users WHERE u_name='".$_SESSION["user"]."')");
      while ($row = mysqli_fetch_array($serv_info)) {
?>
        <tr class="">
        <td><?php echo $row[0]; ?></td>
        </tr>
 
     <?php 
     
      }
    ?>
    </tbody>
<?php }
?>
    </table>
            </div>
        <form action="prod-return-detail1.php" method="post">
               <div class="row">
                   <div class="col-md-10 col-md-offset-1 form-group">
                 <textarea class="form-control reason" autocomplete="off" id="reason" name="reason" ></textarea>
            <label for="reason">Reason (For Rejection/Cancelation only)<font style="color:red">*</font>:</label>
                   </div>
               </div>

    <div class="row">
        <input type="hidden" name="id" value="<?php echo $pr_id; ?>" />
        <input type="hidden" name="amount" value="<?php echo $sum; ?>" />
        <input type="hidden" name="prodname" value="<?php echo $prod_name; ?>" />
        <input type="hidden" name="prod_id" value="<?php echo $prod_id; ?>" />
        <input type="hidden" name="ord" value="<?php echo $ord_id; ?>" />
        <?php
/*        if($status=="Accepted" && (date_format($date1, 'd-m-Y')==date_format($today, 'd-m-Y')) ) { ?>
        <div class="col offset-m3 m3 offset-l3 l3">
            <button class="btn" name="status" value="Completed" >Completed</button>
        </div>
        <div class="col offset-m2 m3">
            <button class="btn red rejectbtn" name="status" value="Rejected" disabled >Reject</button>
        </div>
                <?php
        }
        if($status=="Accepted" && (date_format($date1, 'd-m-Y')>date_format($today, 'd-m-Y')) ) { ?>
        <div class="row">
        <div class="col offset-m3 m3 offset-l2 l3">
            <button class="btn" name="status" value="Completed" >Completed</button>
        </div>
        <div class="col offset-m2 m3">
            <button class="btn red rejectbtn" name="status" value="Rejected" disabled >Reject</button>
        </div>
        </div>
        <div class="row">
            <p class="text-center">You cannot Access this Order status till date of requirement</p>
        </div>
                <?php
        }
        elseif(is_null($status)) { */
            if(empty($pr_status) ) {
        
        ?>
        <div class="col-md-2 col-md-offset-1">
            <button class="btn" name="status" style="height: auto!important; padding-bottom: 2px !important;" value="<?php
                echo "Accept";
            ?>" ><?php
                echo "Accept";
            ?></button>
        </div>
        <?php
            }
            elseif($pr_status=="Returned") {?>
        <div class="col-md-2 col-md-offset-1">
            <button class="btn" name="status" style="height: auto!important; padding-bottom: 2px !important;" value="<?php
                echo "Refund";
            ?>" ><?php
                echo "Refund";
            ?></button>
        </div>
        <div class="col-md-2 col-md-offset-1">
            <button class="btn" name="status" style="height: auto!important; padding-bottom: 2px !important;" value="<?php
                echo "Replace";
            ?>" ><?php
                echo "Replace";
            ?></button>
        </div>
        <?php
            }
            ?>
        <div class="col-md-2 col-md-offset-1">
            <button class="btn red rejectbtn" name="status" value="Rejected" disabled >Reject</button>
        </div>
            <?php
//        }
        ?>
    </div>
        </form>
    </div>
    </div>  
    <script>
        $(document).ready(function() {
        $("#reason").on('keyup',function() {
            var len=$(this).val().length;
//            console.log(len);
                if(len>=5)
                    $(".rejectbtn").prop("disabled",false);
                else
                    $(".rejectbtn").prop("disabled",true);
            });
        });

    </script>
</body>
</html>