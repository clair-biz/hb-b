<html>
    <head>
        <?php require_once 'stylesheets.html';?>
    </head>
<body>
<section class="body" >
    <section class="preloader" ></section>
    <section class="content" >
<?php
require_once 'data.php';

//$vs_id=$_COOKIE["vs_id"];
//$cat_type=Crm::getcattypebyvsid($_COOKIE["vs_id"]);
$cat_type="Product";
//if($cat_type=="Product") {

$todayquery="select d_id,d_type,date_format(d_date,'%d-%m-%Y'),ord_id,pr_id from delivery where d_date=date_format(now(),'%Y-%m-%d') and d_status is null";

$today= mysqli_query(Crm::con(), $todayquery);
/*$new= mysqli_query(Crm::con(), $newquery);
$accepted= mysqli_query(Crm::con(), $acceptedquery);
$complete= mysqli_query(Crm::con(), $completequery);
$canceled= mysqli_query(Crm::con(), $canceledquery);
$rejected= mysqli_query(Crm::con(), $rejectedquery);
        
        */
        
$cat=mysqli_query(Crm::con(),"select * from category;");
?>
    <div class="container-fluid row" style="margin-top: 40px;">
                <div class="col-lg-2 col-md-2 hide-on-small-and-down">
                    <?php
//                    require 'vendor-menu.php'; 
                    ?>
                    </div>
        <form action="update-delivery.php" method="post">
    <div class="col-lg-10 col-md-10">
<ul class="tabs">
    <?php
    if($cat_type=="Product") {
    ?>
    <li class="tab"><a class="active" href="#home" style="color:blue !important"><b>Today's Orders</b></a></li>
    <?php
    }/*
    else
    ?>
    <li class="tab"><a <?php if($cat_type=="Service") { ?> class="active" href="#home" <?php } else { ?> href="#new" <?php } ?> style="color:blue !important"><b>New Orders</b></a></li>
    <li class="tab"><a href="#accepted" style="color:blue !important;"><b>Accepted Orders</b></a></li>
    <li class="tab"><a href="#completed"  style="color:blue !important;"><b>Completed Orders</b></a></li>
    <li class="tab"><a href="#canceled" style="color:blue !important;"><b>Canceled Orders</b></a></li>
    <li class="tab"><a href="#rejected" style="color:blue !important;"><b>Rejected Orders</b></a></li>
    <?php */?>
</ul>
        <div class="row">
            <div class="vendor-table">
                
            <?php if($cat_type=="Product") { ?>
            <div id="home">
                <div class="card" style="padding: 10px;">
                        <h5 class="text-center">Today's Orders</h5>
                            <table width="100%" class="table hover centered z-depth-1 hoverable" id="dataTables-neworder">
                                <thead>
                                    <tr  class="text-center">
                                        <th></th>
                                        <th>#</th>
                                        <th>Delivery Date</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Between</th>
                                    </tr>
                                </thead>
    <tbody>
        <?php
//        echo mysqli_num_rows($new);
      while($row=mysqli_fetch_array($today)){  
          $from="";
          $to="";
          $slot="";

                  if($row[1]=="Order") {
        $query="select DISTINCT bname,cust_fname,vend_addr,cust_addr,vendor.loc_zip,customer.loc_zip,sa_name,sa_addr,ship_addr.loc_zip,ordertbl.ord_id,ordertbl.ins_dt,invoice.ins_dt,date_format(ordertbl.req_dt,'%d-%m-%Y'),bs_from,bs_to
from users,product,customer,vendor,ship_addr,invoice,ordertbl,vend_subscription,order_detail,booking_slots
where ordertbl.ord_id=invoice.ord_id
and customer.cust_id=ship_addr.cust_id
and vendor.vend_id=users.vend_id
and ordertbl.bs_id=booking_slots.bs_id
and ordertbl.sa_id=ship_addr.sa_id 
and vend_subscription.vs_id=product.vs_id
and users.u_id=vend_subscription.u_id
and product.prod_id=order_detail.prod_id 
and order_detail.ord_id=ordertbl.ord_id 
and ordertbl.ord_id=".$row[3];
            $res= mysqli_query(Crm::con(), $query);
            if($row1= mysqli_fetch_array($res)) {
                        $vendor=$row1[0]."<br>"
                        . $row1[2]."<br>"
                        . $row1[4]."<br>"
                        . Crm::getlocstatebyzip($row1[4])."<br>"
                        . "India<br><br>";
                
                        $customer=$row1[6]."<br>"
                        . $row1[7]."<br>"
                        . $row1[8]."<br>"
                        . Crm::getlocstatebyzip($row1[8])."<br>"
                        . "India<br><br>";
                        $slot=$row1[13]." - ".$row1[14];
            }
                  }

                  if($row[1]=="Return" || $row[1]=="Replace") {
        $query="select DISTINCT bname,cust_fname,vend_addr,cust_addr,vendor.loc_zip,customer.loc_zip,sa_name,sa_addr,ship_addr.loc_zip,ordertbl.ord_id,ordertbl.ins_dt,pick_date,date_format(ordertbl.req_dt,'%d-%m-%Y'),bs_from,bs_to
from users,product,customer,vendor,ship_addr,prod_return,ordertbl,vend_subscription,order_detail,booking_slots
where ordertbl.ord_id=prod_return.ord_id
and prod_return.prod_id=product.prod_id
and customer.cust_id=ship_addr.cust_id
and vendor.vend_id=users.vend_id
and ordertbl.bs_id=booking_slots.bs_id
and ordertbl.sa_id=ship_addr.sa_id 
and vend_subscription.vs_id=product.vs_id
and users.u_id=vend_subscription.u_id
and product.prod_id=order_detail.prod_id 
and order_detail.ord_id=ordertbl.ord_id 
and pr_id=".$row[4];
            $res= mysqli_query(Crm::con(), $query);
            if($row1= mysqli_fetch_array($res)) {
                        $vendor=$row1[0]."<br>"
                        . $row1[2]."<br>"
                        . $row1[4]."<br>"
                        . Crm::getlocstatebyzip($row1[4])."<br>"
                        . "India<br><br>";
                
                        $customer=$row1[6]."<br>"
                        . $row1[7]."<br>"
                        . $row1[8]."<br>"
                        . Crm::getlocstatebyzip($row1[8])."<br>"
                        . "India<br><br>";
                        $slot=$row1[13]." - ".$row1[14];
            }
                  }

          ?>
        <tr class="text-center ">
            <td>
                <p>
                    <label for="<?php echo "cb_".$row[0]; ?>">
                        <input type="checkbox" id="<?php echo "cb_".$row[0]; ?>" value="<?php echo $row[0].",".$row[1].",";
            if($row[1]=="Order")
                echo $row[3];
            
            elseif($row[1]=="Return" || $row[1]=="Replace")
                
                echo $row[4];
            ?>" name="check_list[]"  /> 
                        <span></span>
                        </label>
            </p>
            </td>
        <td><?php echo $row[0]; ?></td>
        <td><?php echo $row[2]; ?></td>
        <td><?php
                  if($row[1]=="Order" || $row[1]=="Replace")
        echo $vendor;
                  else
                      echo $customer;
                  ?></td>
        <td><?php
                  if($row[1]=="Order" || $row[1]=="Replace")
        echo $customer;
                  else
                      echo $vendor;
                  ?></td>
        <td><?php echo $slot; ?></td>
        <?php
                                        }
                                        ?>
        </tr>

<?php }

//mysqli_free_result($req);
//req.close();
//stmtreq.close();
?>
  
    </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            
                            <div class="row">
            <div class="col-md-4 col-md-offset-4 text-center col-sm-12 submit-btn" style="margin-top: 20px;" >
                <button  type="submit" name="submit" value="delivered" class="btn waves-effect waves-light" >Delivered
                <i class="material-icons right">send</i>
                </button>
            </div>
        </div> 
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
            </div>
            <?php 
        ?>
                    </div>
        </div>
    </div>
        </form>
</div>
         </section>    
      <section class="footer" style="margin-top: 10px !important; width: auto !important;" ></section>
      
</section>
<?php
require_once 'scripts.html';
?>
        <!-- /#page-wrapper -->
    <script>
    $("#dataTables-vendors").on('click','.requested-cust',function() {
       var id= $(this).attr("id");
//       console.log("console -"+id+"-");
			$.ajax({
				
			type : 'POST',
			url  : 'vendor-detail.php',
			data : "vend_id="+id,
			beforeSend: function() {
				$(this).html(preloader());
			},
			success :  function(response) {
//                            console.log("alert "+response);
                            $(".vend-details-block").html(response);
                            $(".vend-details-block").focus();
    $(".vend-details-block").ready(function() {
    $('#dataTables-vend-details').DataTable({
        responsive: true
    });
    });
                            
        $(".vend-details").show("slow");
        $(".vend-details-btns").show("slow");
        $(".vendor-table").hide("slow");
//        $('#dataTables-vend-details').DataTable({
//            responsive: true
//        });
    }
			});


    });
   
    
    $(".requested-cust").on('click',function() {
       var id= $(this).attr("id");
//        console.log(cust);
    var vs="<?php echo $vs_id; ?>";
    var data="ord="+id+"&vs_id="+vs;
			$.ajax({
				
			type : 'POST',
			url  : '<?php echo Crm::root()."customer-detail.php"; ?>',
			data : data,
			beforeSend: function()
			{	
				$(this).html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
				$(this).html(preloader());
			},
			success :  function(response) {
//                            console.log("alert "+response);
                            $(".cust-details-block").html(response);
        $(".cust-details").toggle("slow");
        $(".cust-details-btns").toggle("slow");
        $(".vendor-table").toggle("slow");
    $(".cust-details-block").ready(function() {
    $('#dataTables-cust-details').DataTable({
            responsive: true
        });
    });
        $("#reason").on('keyup',function() {
            var len=$(this).val().length;
                if(len>=5) {
            console.log(len);
                    $(".rejectbtn").prop("disabled",false);
                    $(".rejectbtn").prop("disabled",false);
                }
                else
                    $(".rejectbtn").prop("disabled",true);
            });

    }
			});


    });
    
    $("#btn_close").on('click',function() {
        $(".vendor-table").toggle("slow");
        $(".cust-details").toggle("slow");
        $(".cust-details-btns").toggle("slow");
        
    });
    

    </script>
    <script>
    $(document).ready(function() {
    $('#dataTables-neworder').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }
        });
    });
    </script>
</body>

</html>