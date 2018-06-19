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


    $cat111=mysqli_query(Crm::con(),"select users.u_id,vend_fname,bname,vs_for,vs_pay_status,category.cat_name,vs_disc,category.cat_id,city_served,other_cat from vendor,category,users,vend_subscription where vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=vend_subscription.cat_id and  vs_for is not null");
    ?>
   <div class="container-fluid row" style="margin-top: 40px;">
         <div class="row">
                <div class="col-lg-2 col-md-2 hide-on-small-and-down">
                    <?php
                    require 'admin-menu.php'; 
                    ?>
                    </div>   
         <div class="col-lg-10 col-md-10 col-sm-12 col-md-offset-1">         
             <div class="vendor-table">
                    <div class="card">
                    <h5 class="page-header">&nbsp;&nbsp;Customers</h5>
                            <table width="100%" class="table table-striped table-responsive table-bordered table-hover" id="dataTables-customers">
                                <thead>
        <tr class="text-center">
            <th>Name</th>
            <th>Subscription for</th>
            <th>Status</th>
            <th>Category</th>
            <th>City</th>
            <th></th>
      </tr>
    </thead>
    <tbody>
        <?php
      while($row=mysqli_fetch_array($cat111)) {
?>
        <tr class="text-center ">
        <td  ><?php echo $row[1]."(".$row[2].")"; ?></td>
        <td  ><?php echo $row[3]; ?></td>
        <td  ><?php echo $row[4]; ?></td>
        <td  ><?php echo $row[8]; ?></td>
        <td><a href="#!" id="<?php echo $row[0]; ?>" class="customer-disable">Approve</a>
        <td><a href="#!" id="<?php echo $row[0]; ?>" class="customer-disable">Approve</a>
        </tr>

<?php }
//mysqli_free_result($cat111);
//stmtcat111.close();
?>
  
    </tbody>

                            </table>
                            <!-- /.table-responsive -->
                            
                            
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
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
?>?>           <!-- /#page-wrapper -->
    <script>
    $(".customer-disable").on('click',function() {
        var id= $(this).attr("id");
		$.ajax({
			
			type : 'POST',
			url  : 'cust-disable-form.php',
			data : "cust_id="+id,
			beforeSend: function() {
				$(this).html(preloader());
			},
			success :  function(response) {
                            console.log("alert "+response);
                            $("#modal-disable-customer").html(response);
                            $("#modal-disable-customer").modal("open");
    }
			});


    });
    
    $("#dataTables-customers").on('click','.customer-disable',function() {
        var id= $(this).attr("id");
		$.ajax({
			
			type : 'POST',
			url  : 'cust-disable-form.php',
			data : "cust_id="+id,
			beforeSend: function() {
				$(this).html(preloader());
			},
			success :  function(response) {
                            console.log("alert "+response);
                            $("#modal-disable-customer").html(response);
                            $("#modal-disable-customer").modal("open");
    }
			});


    });
    
    

    </script>
    <script>
    $(document).ready(function() {
    $('#dataTables-customers').DataTable({
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