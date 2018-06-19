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
$query="select cat_id,cat_name,cat_type from category where cat_id<>0 order by cat_name;";
$cat=Base::generateResult($query);
//Statement stmtcat111=packcrm.Crm.con().createStatement();    

?>
     <div class="container-fluid" style="margin-top: 40px;">
    
            <div class="row">
                <div class="col-md-2 col-lg-2 d-none d-md-block">
                    <?php
                    require 'vendor-menu.php'; 
                    ?>
                    </div>
        <div class="card col-md-10 col-sm-12 col-lg-10">
                        <h5 class="page-header">&nbsp;&nbsp;Rate Chart</h5>
                            <table width="100%" class="table table-striped table-responsive0 table-bordered table-hover" id="dataTables-category">
                                <thead>
        <tr class="text-center">
            <th>Category Name</th>
            <th>Type</th>
            <th>Half Annual Charge</th>
            <th>Annual Charge</th>
        </tr>
    </thead>
    <tbody>
        <?php
      while($row= mysqli_fetch_assoc($cat)){  
?>
        <tr class="text-center">
        <td><?php echo $row["cat_name"]; ?></td>
        <td><?php echo $row["cat_type"]; ?></td>
        <td><?php echo Base::getrate($row["cat_id"],"Half Annual"); ?></td>
        <td><?php echo Base::getrate($row["cat_id"],"Annual"); ?></td>
        </tr>

<?php }
//mysqli_free_result($cat111);
//stmtcat111.close();
?>
  
    </tbody>

                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
            </div>
                
    </div>
    </section>
    <footer class="footer" ></footer>
    
</section>
    
<?php
require_once 'scripts.html';
?>
    
        <script>
    $(document).ready(function() {
        $('#dataTables-category').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }
        });
        $('#dataTables-example1').DataTable({
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