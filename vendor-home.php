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


$vs_id=$user->vs_id;
$cat_type="";
switch ($user->home_url) {
    case "ProductsPage" : $cat_type="Product";
        break;
    case "ServicesPage" : $cat_type="Service";
        break;
}

if($cat_type=="Product") {

$todayquery="select distinct ordertbl.ord_id,ordertbl.ins_dt,req_dt,cust_fname from ordertbl,customer,product,users,order_detail where order_detail.ord_id=ordertbl.ord_id and users.cust_id=customer.cust_id and customer.cust_id=ordertbl.cust_id and product.prod_id=order_detail.prod_id and ordertbl.ord_id<>0 and req_dt=date_format(now(),'%Y-%m-%d') and ord_status is null and product.vs_id=$vs_id;";
$newquery="select distinct ordertbl.ord_id,ordertbl.ins_dt,req_dt,cust_fname from ordertbl,customer,product,users,order_detail where order_detail.ord_id=ordertbl.ord_id and users.cust_id=customer.cust_id and customer.cust_id=ordertbl.cust_id and product.prod_id=order_detail.prod_id and ordertbl.ord_id<>0 and ord_status is null and product.vs_id=$vs_id ;";
//echo $newquery."<br />";
$acceptedquery="select distinct ordertbl.ord_id,ordertbl.ins_dt,req_dt,cust_fname from ordertbl,customer,product,users,order_detail where order_detail.ord_id=ordertbl.ord_id and users.cust_id=customer.cust_id and customer.cust_id=ordertbl.cust_id and product.prod_id=order_detail.prod_id and ordertbl.ord_id<>0 and ord_status='Accepted' and product.vs_id=$vs_id ;";
$completequery="select distinct ordertbl.ord_id,ordertbl.ins_dt,req_dt,cust_fname from ordertbl,customer,product,users,order_detail where order_detail.ord_id=ordertbl.ord_id and users.cust_id=customer.cust_id and customer.cust_id=ordertbl.cust_id and product.prod_id=order_detail.prod_id and ordertbl.ord_id<>0 and ord_status='Completed' and  product.vs_id=$vs_id ;";
$canceledquery="select distinct ordertbl.ord_id,ordertbl.ins_dt,req_dt,cust_fname from ordertbl,customer,product,users,order_detail where order_detail.ord_id=ordertbl.ord_id and users.cust_id=customer.cust_id and customer.cust_id=ordertbl.cust_id and product.prod_id=order_detail.prod_id and ordertbl.ord_id<>0 and ord_status in ('Canceled','Rejected') and  product.vs_id=$vs_id ;";
$returnquery="select distinct ordertbl.ord_id,date_format(prod_return.ins_dt,'%d-%m-%Y'),order_detail.prod_id,prod_name,ord_qty,ord_rate,prod_return.prod_return,prod_return.prod_replace,cust_fname,pr_id from ordertbl,customer,product,users,order_detail,prod_return where ordertbl.ord_id=prod_return.ord_id and product.prod_id=prod_return.prod_id and  order_detail.ord_id=ordertbl.ord_id and users.cust_id=customer.cust_id and customer.cust_id=ordertbl.cust_id and product.prod_id=order_detail.prod_id and ordertbl.ord_id<>0 and ord_status='Completed' and delivery_status='Delivered' and  product.vs_id=$vs_id ;";
}

if($cat_type=="Service") {

$newquery="select distinct ord_id,serviceordertbl.ins_dt,cust_fname from serviceordertbl,customer,service,users where users.cust_id=customer.cust_id and customer.cust_id=serviceordertbl.cust_id and service.serv_id=serviceordertbl.serv_id and ord_id<>0 and ord_status is null and product.vs_id=$vs_id ;";
$acceptedquery="select distinct ord_id,serviceordertbl.ins_dt,cust_fname from serviceordertbl,customer,service,users where users.cust_id=customer.cust_id and customer.cust_id=serviceordertbl.cust_id and service.serv_id=serviceordertbl.serv_id and ord_id<>0 and ord_status='Accepted' and product.vs_id=$vs_id ;";
$completequery="select distinct ord_id,serviceordertbl.ins_dt,cust_fname from serviceordertbl,customer,service,users where users.cust_id=customer.cust_id and customer.cust_id=serviceordertbl.cust_id and service.serv_id=serviceordertbl.serv_id and ord_id<>0 and ord_status='Completed' and product.vs_id=$vs_id ;";
$canceledquery="select distinct ord_id,serviceordertbl.ins_dt,cust_fname from serviceordertbl,customer,service,users where users.cust_id=customer.cust_id and customer.cust_id=serviceordertbl.cust_id and service.serv_id=serviceordertbl.serv_id and ord_id<>0 and ord_status='Canceled' and product.vs_id=$vs_id ;";
$rejectedquery="select distinct ord_id,serviceordertbl.ins_dt,cust_fname from serviceordertbl,customer,service,users where users.cust_id=customer.cust_id and customer.cust_id=serviceordertbl.cust_id and service.serv_id=serviceordertbl.serv_id and ord_id<>0 and ord_status='Rejected' and product.vs_id=$vs_id ;";
}

$today= Base::generateResult( $todayquery);
$new= Base::generateResult( $newquery);
$accepted= Base::generateResult( $acceptedquery);
$complete= Base::generateResult( $completequery);
$canceled= Base::generateResult( $canceledquery);

$rejected="";

if($cat_type=="Service")
$rejected= Base::generateResult( $rejectedquery);
if($cat_type=="Product")
$rejected= Base::generateResult( $returnquery);
        
        
        
$cat=Base::generateResult("select * from category;");
?>
    <div class="container-fluid row" style="margin-top: 40px;">
                <div class="col-md-2 col-lg-2 hide-on-small-and-down">
                    <?php
                    require 'vendor-menu.php'; 
                    ?>
                    </div>
    <div class="col-md-10 col-lg-10">
<ul class="nav-tabs nav">
    <?php
    if($cat_type=="Product") {
    ?>
    <li class="nav-item"><a class="nav-link active text-dark" data-toggle="tab" href="#home" ><b>Today's Orders</b></a></li>
    <?php
    }
    else
    ?>
    <li class="nav-item"><a data-toggle="tab" <?php if($cat_type=="Service") { ?> class="nav-link active text-dark" href="#home" <?php } else { ?> class="nav-link text-dark" href="#new" <?php } ?> ><b>New Orders</b></a></li>
    <li class="nav-item"><a class="nav-link text-dark" data-toggle="tab" href="#accepted" ><b>Accepted Orders</b></a></li>
    <li class="nav-item"><a class="nav-link text-dark" data-toggle="tab" href="#completed"  ><b>Completed Orders</b></a></li>
    <li class="nav-item"><a class="nav-link text-dark" data-toggle="tab" href="#canceled" ><b>Canceled Orders</b></a></li>
    <li class="nav-item"><a class="nav-link text-dark" data-toggle="tab" href="#rejected" ><b>
                                    <?php
if($cat_type=="Service")
echo "Rejected Orders";
elseif($cat_type=="Product")
echo "Returns";
?>
</b></a></li>
</ul>
        <div class="row">
            <div class="vendor-table tab-content">
                
            <?php if($cat_type=="Product") { ?>
                <div id="home" class="tab-pane container active">
                <div class="card" style="padding: 10px;">
                        <h5 class="center-align">Today's Orders</h5>
                            <table width="100%" class="table hover centered z-depth-1 hoverable" id="dataTables-todayorder">
                                <thead>
                                    <tr  class="center-align">
                                        <th>Order #</th>
                                        <th>Request Date</th>
                                        <?php if($cat_type=="Product") {?>
                                        <th>Required On</th>
                                        <?php 
                                        }
                                            ?>
                                        <th>Customer Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
    <tbody>
        <?php
//        echo mysqli_num_rows($new);
      while($row=mysqli_fetch_array($today)){  
$date = date_create($row[1]);
$date1 = date_create($row[2]);
?>
        <tr class="center-align ">
        <td><?php echo $row[0]; ?></td>
        <td><?php echo date_format($date,'d-m-Y'); ?></td>
                                        <?php if($cat_type=="Product") {?>
        <td><?php echo date_format($date1,'d-m-Y'); ?></td>
        <td><?php echo $row[3]; ?></td>
                                        <?php 
                                        }
                                        elseif($cat_type=="Service") {
                                            ?>
        <td><?php echo $row[2]; ?></td>
        <?php
                                        }
                                        ?>
        <td><a href="#"  class="requested-cust  request" id="<?php echo $row[0]; ?>">View Details</a></td>
        </tr>

<?php }

//mysqli_free_result($req);
//req.close();
//stmtreq.close();
?>
  
    </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            
                            
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
            </div>
            <?php } ?>

                <div <?php if($cat_type=="Service") { ?> id="home" class="tab-pane container active" <?php } else { ?> class="tab-pane container fade" id="new" <?php } ?>  >
                <div class="card" style="padding: 10px;">
                        <h5 class="center-align">New Orders</h5>
                            <table width="100%" class="table hover centered z-depth-1 hoverable" id="dataTables-neworder">
                                <thead>
                                    <tr  class="center-align">
                                        <th>Order #</th>
                                        <th>Request Date</th>
                                        <?php if($cat_type=="Product") {?>
                                        <th>Required On</th>
                                        <?php 
                                        }
                                            ?>
                                        <th>Customer Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
    <tbody>
        <?php
//        echo mysqli_num_rows($new);
      while($row=mysqli_fetch_array($new)){  
$date = date_create($row[1]);
$date1 = date_create($row[2]);
?>
        <tr class="center-align ">
        <td><?php echo $row[0]; ?></td>
        <td><?php echo date_format($date,'d-m-Y'); ?></td>
                                        <?php if($cat_type=="Product") {?>
        <td><?php echo date_format($date1,'d-m-Y'); ?></td>
        <td><?php echo $row[3]; ?></td>
                                        <?php 
                                        }
                                        elseif($cat_type=="Service") {
                                            ?>
        <td><?php echo $row[2]; ?></td>
        <?php
                                        }
                                        ?>
        <td><a href="#"  class="requested-cust  request" id="<?php echo $row[0]; ?>">View Details</a></td>
        </tr>

<?php }

//mysqli_free_result($req);
//req.close();
//stmtreq.close();
?>
  
    </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            
                            
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
            </div>

                <div id="accepted" class="tab-pane container fade">
                <div class="card" style="padding: 10px;">
                        <h5 class="center-align">Accepted Orders</h5>
                            <table width="100%" class="table hover centered z-depth-1 hoverable" id="dataTables-accepted">
                                <thead>
                                    <tr  class="center-align">
                                        <th>Order #</th>
                                        <th>Request Date</th>
                                        <?php if($cat_type=="Product") {?>
                                        <th>Required On</th>
                                        <?php 
                                        }
                                            ?>
                                        <th>Customer Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
    <tbody>
        <?php
      while($row=mysqli_fetch_array($accepted)){  
$date = date_create($row[1]);
$date1 = date_create($row[2]);
?>
        <tr class="center-align ">
        <td><?php echo $row[0]; ?></td>
        <td><?php echo date_format($date,'d-m-Y'); ?></td>
                                        <?php if($cat_type=="Product") {?>
        <td><?php echo date_format($date1,'d-m-Y'); ?></td>
        <td><?php echo $row[3]; ?></td>
                                        <?php 
                                        }
                                        elseif($cat_type=="Service") {
                                            ?>
        <td><?php echo $row[2]; ?></td>
        <?php
                                        }
                                        ?>
        <td><a href="#"  class="requested-cust  request" id="<?php echo $row[0]; ?>">View Details</a></td>
        </tr>

<?php }

//mysqli_free_result($req);
//req.close();
//stmtreq.close();
?>
  
    </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
            </div>
            
                <div id="completed" class="container tab-pane fade">
                <div class="card" style="padding: 10px;">
                        <h5 class="center-align">Completed Orders</h5>
                            <table width="100%" class="table hover centered z-depth-1 hoverable" id="dataTables-completed">
                                <thead>
                                    <tr  class="center-align">
                                        <th>Order #</th>
                                        <th>Request Date</th>
                                        <?php if($cat_type=="Product") {?>
                                        <th>Required On</th>
                                        <?php 
                                        }
                                            ?>
                                        <th>Customer Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
    <tbody>
        <?php
      while($row=mysqli_fetch_array($complete)){  
$date = date_create($row[1]);
$date1 = date_create($row[2]);
?>
        <tr class="center-align">
        <td><?php echo $row[0]; ?></td>
        <td><?php echo date_format($date,'d-m-Y'); ?></td>
                                        <?php if($cat_type=="Product") {?>
        <td><?php echo date_format($date1,'d-m-Y'); ?></td>
        <td><?php echo $row[3]; ?></td>
                                        <?php 
                                        }
                                        elseif($cat_type=="Service") {
                                            ?>
        <td><?php echo $row[2]; ?></td>
        <?php
                                        }
                                        ?>
        <td><a href="#"  class="requested-cust  request" id="<?php echo $row[0]; ?>">View Details</a></td>
        </tr>

<?php }

//mysqli_free_result($req);
//req.close();
//stmtreq.close();
?>
  
    </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            
                            
                            
                    </div>
                    <!-- /.panel -->
            </div>
            
                <div id="canceled" class="tab-pane container fade">
                <div class="card" style="padding: 10px;">
                        <h5 class="center-align">Canceled Orders</h5>
                            <table width="100%" class="table hover centered z-depth-1 hoverable" id="dataTables-canceled">
                                <thead>
                                    <tr  class="center-align">
                                        <th>Order #</th>
                                        <th>Request Date</th>
                                        <?php if($cat_type=="Product") {?>
                                        <th>Required On</th>
                                        <?php 
                                        }
                                            ?>
                                        <th>Customer Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
    <tbody>
        <?php
      while($row=mysqli_fetch_array($canceled)){  
$date = date_create($row[1]);
$date1 = date_create($row[2]);
?>
        <tr class="center-align ">
        <td><?php echo $row[0]; ?></td>
        <td><?php echo date_format($date,'d-m-Y'); ?></td>
                                        <?php if($cat_type=="Product") {?>
        <td><?php echo date_format($date1,'d-m-Y'); ?></td>
        <td><?php echo $row[3]; ?></td>
                                        <?php 
                                        }
                                        elseif($cat_type=="Service") {
                                            ?>
        <td><?php echo $row[2]; ?></td>
        <?php
                                        }
                                        ?>
        <td><a href="#"  class="requested-cust  request" id="<?php echo $row[0]; ?>">View Details</a></td>
        </tr>

<?php }

//mysqli_free_result($req);
//req.close();
//stmtreq.close();
?>
  
    </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            
                    </div>
                    <!-- /.panel -->
            </div>
<?php            
if($cat_type=="Service") { ?>
                <div id="rejected" class="tab-pane container fade">
                <div class="card" style="padding: 10px;">
                        <h5 class="center-align">Rejected Orders</h5>
                            <table width="100%" class="table hover centered z-depth-1 hoverable" id="dataTables-rejected">
                                <thead>
                                    <tr  class="center-align">
                                        <th>Order #</th>
                                        <th>Request Date</th>
                                        <?php if($cat_type=="Product") {?>
                                        <th>Required On</th>
                                        <?php 
                                        }
                                            ?>
                                        <th>Customer Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
    <tbody>
        <?php
      while($row=mysqli_fetch_array($rejected)){  
$date = date_create($row[1]);
$date1 = date_create($row[2]);
?>
        <tr class="center-align">
        <td><?php echo $row[0]; ?></td>
        <td><?php echo date_format($date,'d-m-Y'); ?></td>
                                        <?php if($cat_type=="Product") {?>
        <td><?php echo date_format($date1,'d-m-Y'); ?></td>
        <td><?php echo $row[3]; ?></td>
                                        <?php 
                                        }
                                        elseif($cat_type=="Service") {
                                            ?>
        <td><?php echo $row[2]; ?></td>
        <?php
                                        }
                                        ?>
        <td><a href="#"  class="requested-cust  request" id="<?php echo $row[0]; ?>">View Details</a></td>
        </tr>

<?php }

//mysqli_free_result($req);
//req.close();
//stmtreq.close();
?>
  
    </tbody>
                            </table>
                            <!-- /.table-responsive -->

                    </div>
                    <!-- /.panel -->
            </div>
                    <?php
}
elseif($cat_type=="Product") {
?>
            
                <div id="rejected" class="tab-pane container fade">
                <div class="card" style="padding: 10px;">
                        <h5 class="center-align">Returns</h5>
                            <table width="100%" class="table hover centered z-depth-1 hoverable" id="dataTables-rejected">
                                <thead>
                                    <tr  class="center-align">
                                        <th>Order #</th>
                                        <th>Request Date</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Amount</th>
                                        <th>Return / Replace</th>
                                        <th>Customer Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
    <tbody>
        <?php
      while($row=mysqli_fetch_array($rejected)){  
?>
        <tr class="center-align">
        <td><?php echo $row[0]; ?></td>
        <td><?php echo $row[1]; ?></td>
        <td><?php echo $row[3]; ?></td>
        <td><?php echo $row[4]; ?></td>
        <td><?php echo "&#8377; ".$row[5]."/-"; ?></td>
        <td><?php
        if($row[6]=="Y")
            echo "Return ";
        if($row[7]=="Y")
            echo "Replace";
         ?></td>
        <td><?php echo $row[8]; ?></td>
        <td><a href="#"  class="requested-return" id="<?php echo $row[9]; ?>">View Details</a></td>
        </tr>

<?php }

//mysqli_free_result($req);
//req.close();
//stmtreq.close();
?>
  
    </tbody>
                            </table>
                            <!-- /.table-responsive -->

                    </div>
                    <!-- /.panel -->
            </div>
                <?php
}
?>
        </div>
            
                    <div class="cust-details card" style="display:none" >
                    <div class="cust-details-btns row  col-lg-2 col-md-2 right" style="display:none" >
                        <a class="btn red" id="btn_close">X</a>
                    </div>
                        <div class="cust-details-block">
                            
                        </div>    
                    </div>
        </div>
    </div>
</div>
         </section>    
      <section class="footer" style="margin-top: 10px !important; width: auto !important;" ></section>
      
</section>
<?php
require_once 'scripts.html';
?>
    <script>
    $(".requested-cust").on('click',function() {
       var id= $(this).attr("id");
//        console.log(cust);
    var vs="<?php echo $vs_id; ?>";
    var data="ord="+id+"&vs_id="+vs;
			$.ajax({
				
			type : 'POST',
			url  : '<?php echo Base::root()."customer-detail.php"; ?>',
			data : data,
			beforeSend: function()
			{	
				$(this).html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
//				$(this).html(preloader());
			},
			success :  function(response) {
                            console.log("alert "+response);
                            $(".cust-details-block").html(response);
        $(".cust-details").toggle("slow");
        $(".cust-details-btns").toggle("slow");
        $(".vendor-table").toggle("slow");
    $(".cust-details-block").add("#upd-order").ready(function() {
    $('#dataTables-cust-details').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }
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
    
                        $("#upd-order").validate({
				rules: {
                                reason: "required"
				},
				messages: {
				},
                                errorElement : 'em',
        errorPlacement: function(error, element) {
          var placement = $(element).data('error');
          if (placement) {
            $(placement).append(error);
          } else {
            error.insertAfter(element);
          }
        },
	   submitHandler: submitUpdateOrderForm	
       });  

	   function submitUpdateOrderForm() {
			var data = $("#upd-order").serialize();
               
			$.ajax({
				
			type : 'POST',
			url  : window.location.origin+'/update-order.php',
                        data : data,
			beforeSend: function() {	
			},
			success :  function(response) {
                            console.log("resp "+response);
                            if(response.search("success")>-1) {
                                $(".content").prepend("<p style='vertical-align:central;' class='text-center bg-success text-white'><i class='fa fa-exclamation' ></i> Update Successful!</p>").fadeIn();
//                                setTimeout( displayProductTable(),5000);
                                    window.location.href=origin+"OrdersPage";
                            }
                            else {
                                $(".content").prepend("<p style='vertical-align:central;' class='text-center bg-danger text-white'><i class='fa fa-exclamation' ></i> Unable to Process!</p>").fadeIn();
                            }
                                
			  }
			});
				return false;
		}
                

    
    
    $(".requested-return").on('click',function() {
       var id= $(this).attr("id");
//        console.log(cust);
    var data="pr_id="+id;
			$.ajax({
				
			type : 'POST',
			url  : '<?php echo Base::root()."prod-return-detail.php"; ?>',
			data : data,
			beforeSend: function()
			{	
				$(this).html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
//				$(this).html(preloader());
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
    $('#dataTables-todayorder').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }
        });
    $('#dataTables-neworder').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
    console.log("page-len-"+this.api().page.info().pages+"-");
  }
        });
    $('#dataTables-accepted').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }
        });
        $('#dataTables-completed').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }
        });
        $('#dataTables-canceled').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }
        });
        $('#dataTables-rejected').DataTable({
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