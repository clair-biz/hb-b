<?php
require_once 'Classes/Classes.php';
    $serv_id=$_REQUEST['serv_id'];
$vs_id=$_COOKIE["vs_id"];

$vend3=mysqli_query(Crm::con(),"select serv_name,serv_desc,cs_name,serv_img,serv_file from service,cat_sub where service.cs_id=cat_sub.cs_id and serv_id=".$serv_id.";");

$stmtcat=mysqli_query(Crm::con(),"select cs_id,cs_name from cat_sub,vend_subscription where  vend_subscription.cat_id=cat_sub.cat_id and vs_id=$vs_id ;");  

if($row=mysqli_fetch_array($vend3)) {
?>
<form class="form-horizontal text-center serv-update" action="vendor-service-update1.php" enctype="multipart/form-data" method="post">
            <!-- /.row -->
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <p class="text-center"><b>Previous Values</p>
            </div>
            <div class="col-md-4">
                <p class="text-center">New Values</b></p>
            </div>
        </div>
            <div class="row">
            <p class="col-md-2 text-right" >Service Name:</p>
                <p class="text-center col-md-4"><?php echo $row[0]; ?></p>
                <div class="form-group col-md-4">
                        <input type="text" class="form-control" autocomplete="off" id="sname" name="sname" />
                    <label for="sname">Service:</label>
                </div>
            </div>
            
            <div class="row">
            <p class="col-md-2 text-right" >Description:</p>
                <p class="text-center col-md-4"><?php echo $row[1]; ?></p>
                <div class="form-group col-md-4">
                <textarea class="form-control" autocomplete="off" id="sdesc" name="sdesc" ></textarea>
                    <label for="sdesc">Description:</label>
                </div>
            </div>
            
            <div class="row">
            <p class="col-md-2 text-right" >Category:</p>
                <p class="text-center col-md-4"><?php echo $row[2]; ?></p>
                <div class="form-group col-md-4">
                <select class="form-control" id="subcat" name="subcat">
                    <option selected="true" value="">-Select-</option>
                    <option value="0">Other</option>

                <?php
      while($zip=mysqli_fetch_array($stmtcat)){  
                    ?>
                    <option value="<?php echo $zip[0]; ?>"><?php echo $zip[1]; ?></option>
                    <?php
                    }
//                    mysqli_free_result($zip);
                    ?>
                </select>
                    <label for="subcat">Category:</label>
                </div>
            </div>
            
            <div class="row cat1" hidden>
            <p class="col-md-2 text-right" >Other Category:</p>
                <p class="text-center col-md-4"></p>
                <div class="col-md-4 form-group cat1" style="display: none">
                <input type="text" class="form-control" autocomplete="off" id="cat1" name="cat1" />
            <label for="cat1">Mention Other Category <font style="color:red">*</font>:</label>
        </div>
            </div>

            
            <div class="row">
            <p class="col-md-2 text-right" >Image:</p>
            <div class="col-md-4 text-center">
            <img height="150" width="320" class="responsive-img"
                 style="height: 150px !important; width: auto !important;
                 display: block !important; margin-left: auto !important; margin-right: auto !important;"
                 src="<?php echo Crm::root()."uploads/products-services/".$row[3]; ?>"
            onError="this.onerror=null;this.src='http://www.homebiz365.in/uploads/images/small.png';" />
            </div>
                <div class="custom-file col-md-4">
                    <div class="chip">
                      <span>Image</span>
                      <input type="file" class="custom-file-input" name="file" id="file">
                    </div>
                <div class="file-path-wrapper">
                  <input class="file-path validate" type="text">
                </div>
                <div class="row">
                    <em>Note: The image size should not be more than 1 MB</em>
                </div>
                </div>
            </div>

            <div class="row">
            <p class="col-md-2 text-right" >Brochure/Flyer:</p>
            <div class="col-md-4 text-center">
				<button type="button" class="view-file defaultBtn col-md-offset-1  col-md-4" id="<?php echo $serv_id; ?>"><span class="glyphicon  glyphicon-arrow-down"></span> View Catalog</button>
            </div>
                <div class="custom-file col-md-4">
                    <div class="chip">
                      <span>brochure/ Flyer</span>
                      <input type="file" class="custom-file-input" name="file1" id="file1">
                    </div>
                <div class="file-path-wrapper">
                  <input class="file-path validate" type="text">
                </div>
                <div class="row">
                    <em>Note: The PDF,docx,doc or image file size should not be more than 5 MB</em>
                </div>
                </div>
            </div>
            
   
	<div class="row">
            
            <button id="" name="serv" value="<?php echo $serv_id; ?>" class="btn btn-block " style="margin-bottom: 75px; margin-left: auto; margin-right: auto; display: block" >Submit</button>
	</div>
	
   </form>
            <?php
                }
                //mysqli_free_result($vend3);
?>
    <script>
</script>
