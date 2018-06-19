<html>
<body>
<?php
require_once 'data.php';
    $serv_id=$_REQUEST['serv_id'];
$vs_id=$user->vs_id;

$vend3=Base::generateResult("select serv_name,serv_desc,serv_img,serv_file from service where serv_id=$serv_id;");
$q="select distinct cs_id,cs_name from cat_sub,vend_subscription where vend_subscription.cat_id=cat_sub.cat_id and vs_id=$vs_id ;";

$stmtcat=Base::generateResult($q);

?>

    

        <!-- Navigation -->
        

        
<div class="container-fluid"  >
    
  <div id="prod-upd" class="col-md-10  offset-md-1">
            
<?php
if($row=mysqli_fetch_array($vend3)) {
//    echo $q;
?>
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header text-center">Update <?php echo $row["serv_name"]; ?></h4>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <form class="form-horizontal text-center" id="serv-update" action="vendor-service-update1.php" enctype="multipart/form-data" method="post">
                <div class="row" >
                    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label text-left" for="name">Name:</label>
                <input type="text" class="form-control" placeholder="<?php echo $row["serv_name"];?>" autocomplete="off" id="sname" name="sname" />
            </div>
                    </div>
                    <div class="col-md-6">
            <div class="form-group">
            <label class="control-label text-left" for="desc">Description:</label>
                <textarea class="form-control" autocomplete="off" id="sdesc" name="sdesc" placeholder="<?php echo $row["serv_desc"];?>" ></textarea>
            </div>
                    </div>
                    <div class="col-md-6">
                <div class="form-group">
            <label class="text-left control-label" for="imgs">Display Image:</label>
            <div class="row">
<img height="150" width="320" class="img-fluid img-thumbnail" style="height: 150px !important; width: auto !important; display: block !important; margin-left: auto !important; margin-right: auto !important;" src="<?php echo "assets/products-services/".$row[2]; ?>" onError="this.onerror=null;this.src='/uploads/images/small.png';" />
            </div>

            <div class="form-group">
                <input type="file" class="form-control" autocomplete="off" id="file" name="file" />
            </div>
        </div>
                    </div>
                    <div class="col-md-6">
                <div class="form-group">
            <label class="control-label" for="imgs">Catalog:</label>
            <div class="row">
<img height="150" width="320" class="img-fluid img-thumbnail" style="height: 150px !important; width: auto !important; display: block !important; margin-left: auto !important; margin-right: auto !important;" src="<?php echo "assets/service-file/".$row[3]; ?>" onError="this.onerror=null;this.src='/uploads/images/small.png';" />
            </div>

            <div class="form-group">
                <input type="file" class="form-control" autocomplete="off" id="file1" name="file1" />
            </div>
        </div>
                    </div>

        <div class="form-group col-sm-12">
	<div class="offset-md-2 col-md-3">
            
            <button id="" name="serv" value="<?php echo $serv_id; ?>" class="btn btn-block btn-primary" >Submit</button>
	</div>
    </div>
                </div>
</form>
            <?php
                }
                //mysqli_free_result($vend3);
?>
</div>
            
   </div>
   
    
    
       
        <!-- /#page-wrapper -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
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