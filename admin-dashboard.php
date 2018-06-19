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

//Statement stmtcat=packcrm.Crm.con().createStatement();    
$q="select * from category where cat_id<>0;";  
$cat=Base::generateResult($q);
//Statement stmtcat111=packcrm.Crm.con().createStatement();    
$q="select vendor.vend_id,vend_fname,bname,date_format(vs_from,'%d-%m-%Y'),date_format(vs_to,'%d-%m-%Y'),vs_pay_status,category.cat_name from vendor,category,users,vend_subscription where vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=vend_subscription.cat_id and vs_pay_status='Enabled' and vendor.vend_id<>0;";  
$cat111=Base::generateResult($q);
?>
    <div class="container-fluid" style="margin-top: 40px;">
    
            <div class="row">
                <div class="col-lg-2 col-md-2 hide-on-small-and-down">
                    <?php
                    require 'admin-menu.php'; 
                    ?>
                    </div>
        <div class="card col-lg-10 col-md-10 col-sm-12 col-md-offset-1">
            <div class="row">
                         <h5 class="page-header">&nbsp;&nbsp;Admin Dashboard</h5>
            <div >
                <em class="hide-on-med-and-up center-align">Note: Record to view its remaining details on right side.</em>
            </div>
                            <table width="100%" class="table table-striped table-responsive0 table-bordered table-hover" id="dataTables-vendors">
                                <thead>
        <tr class="text-center">
            <th>Name</th>
            <th>Business Name</th>
            <th>Subscription From</th>
            <th>Subscription To</th>
            <th>Category</th>
      </tr>
    </thead>
    <tbody> 
        <?php
      while($row=mysqli_fetch_array($cat111)){  
?>
        <tr class="text-center">
        <td><?php echo $row[1]; ?></td>
        <td><?php echo $row[2]; ?></td>
        <td><?php echo $row[3]; ?></td>
        <td><?php echo $row[4]; ?></td>
        <td><?php if($row[6]!=null){ echo $row[6]; } else {echo "-";}  ?></td>
        </tr>

<?php }
?>
  
    </tbody>

                            </table>
                            <!-- /.table-responsive -->
                </div>
                <!-- /.col-lg-12 -->
                
                <!--div class="col  l4 offset-m1 m4 s12 card-panel hide-on-small-only" style="max-height: 450px;">
          <div class="card logo-bg-b darken-1" style="margin-bottom:0 !important;">
              <div class="card-content container white-text" style="padding: 5px !important; ">
            <p style="color:white;"><b>New Requests &nbsp;
            <i class="material-icons">announcement</i>
                </b></p>
            </div>
          </div>
        <div class="card white " style="margin-top:0 !important; margin-bottom:0 !important;">
            <div class="card-content white-text" style="padding: 5px !important; max-height: 380px; overflow-y: auto">">
                            <?php //require 'admin-notification.php'; ?>
            </div>
          </div>
        </div-->


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
    $(document).ready(function() {
        $('#dataTables-vendors').DataTable({
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