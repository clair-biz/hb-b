<html>
<body>
<?php
require_once 'data.php';
$ord_id= $_REQUEST['ord'];
$vs_id= $user->vs_id;
$cat_type="";
switch ($user->home_url) {
    case "ProductsPage" : $cat_type="Product";
        break;
    case "ServicesPage" : $cat_type="Service";
        break;
}

$status="";
if($cat_type=="Product")
$query="SELECT distinct cust_fname,cust_cntc,cust_email,cust_addr,ordertbl.ins_dt,req_dt,ord_status from customer,users,ordertbl WHERE ordertbl.cust_id=customer.cust_id and customer.cust_id=users.cust_id and ord_id=$ord_id";
if($cat_type=="Service")
$query="SELECT distinct cust_fname,cust_cntc,cust_email,cust_addr,serviceordertbl.ins_dt,req_dt,ord_status from customer,users,serviceordertbl WHERE serviceordertbl.cust_id=customer.cust_id and customer.cust_id=users.cust_id and ord_id=$ord_id";

$cust_info=Base::generateResult($query);
if($row=mysqli_fetch_array($cust_info)){
$date = date_create($row[4]);
$date1 = date_create($row[5]);
$today= date_create();
          $status=$row[6];
      ?>
    <div class="container-fluid row">
    <div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 ">
        <div class="row">
            <p class="container-fluid"><?php echo "Order #: <b>".$ord_id."</b>"; 
        if($status!=null || $status!="")
            echo "<b>($status) </b>"; ?>
            <span class="float-right"><?php echo "Order Date: <b>".date_format($date,'d-m-Y')."</b>"; ?></span></p>
            <p class="container-fluid"><?php echo "Name: <b>".$row[0]."</b>";
        if($cat_type=="Product") {
        ?>
                <span class="float-right"><?php echo "Required On: <b>".date_format($date1,'d-m-Y')."</b>"; ?></span>
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
                                    <tr  >
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
    <tbody>
            <?php
$q="SELECT prod_name,ord_qty,ord_rate,ord_unit subtotal from customer,ordertbl,product,users,order_detail WHERE ordertbl.ord_id=order_detail.ord_id and customer.cust_id=ordertbl.cust_id and product.prod_id=order_detail.prod_id and customer.cust_id=users.cust_id and ordertbl.ord_id=$ord_id and product.vs_id=$vs_id and ordertbl.req_dt GROUP by prod_name";
$prod_info=Base::generateResult($q);
      $sum=0;
      while ($row = mysqli_fetch_array($prod_info)) {
$sum+=$row[2];          
?>
        <tr class="">
        <td><?php echo $row[0]; ?></td>
        <td><?php echo $row[1]." ".$row[3]; ?></td>
        <td><?php echo $row[2]; ?></td>
        </tr>
 
     <?php 
     
      }
    ?>
        <tr>
            <th colspan="2" class="text-right"><b>Total</b></th>
            <th class="text-left"><b><?php echo $sum; ?></b></th>
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
        <form id="upd-order" action="update-order.php" method="post">
               <div class="row">
                   <div class="col-md-10 col-md-offset-1 form-group">
                 <textarea class="form-control reason" autocomplete="off" id="reason" name="reason" ></textarea>
            <label for="reason">Reason (For Rejection/Cancelation only)<font style="color:red">*</font>:</label>
                   </div>
               </div>

    <div class="row">
        <input type="hidden" name="id" value="<?php echo $ord_id; ?>" />
        <?php
        if($status=="Accepted" && (date_format($date1, 'd-m-Y')==date_format($today, 'd-m-Y')) ) { ?>
        <div class="col-md-3 col-lg-3 col-md-offset-3 col-lg-offset-3">
            <button class="btn" name="status" value="Completed" >Completed</button>
        </div>
        <div class="col-md-3 col-md-offset-2">
            <button class="btn red rejectbtn" name="status" value="Rejected" disabled >Reject</button>
        </div>
                <?php
        }
        if($status=="Accepted" && (date_format($date1, 'd-m-Y')>date_format($today, 'd-m-Y')) ) { ?>
        <div class="row">
        <div class="col-md-3 col-lg-3 col-md-offset-3 col-lg-offset-2">
            <button class="btn" name="status" value="Completed" >Completed</button>
        </div>
        <div class="col-md-3 col-md-offset-2">
            <button class="btn red rejectbtn" name="status" value="Rejected" disabled >Reject</button>
        </div>
        </div>
        <div class="row">
            <p class="text-center">You cannot Access this Order status till date of requirement</p>
        </div>
                <?php
        }
        elseif(is_null($status)) { ?>
        <div class="col offset-m3 m3">
            <button class="btn" name="status" value="Accepted" >Accept</button>
        </div>
        <div class="col-md-3 col-md-offset-2">
            <button class="btn red rejectbtn" name="status" value="Rejected" disabled >Reject</button>
        </div>
            <?php
        }
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