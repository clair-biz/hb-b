<?php
require_once 'Classes/Classes.php';
$camp_id=$_REQUEST["camp_id"];
$cat=mysqli_query(Crm::con(),"select prod_id,cs_id from camp_prod_map where camp_id=$camp_id;");  

?>
	<div class="row">
	<p class="col-md-2 col-md-offset-1">Product / Category</p>
	<select class="form-control col-md-4" id="cpm" name="cpm"  required>
                    <option selected="true" value="">-Select-</option>

                <?php
      while($row=mysqli_fetch_array($cat)){
          $cpm="";
          if(!empty($row[0]))
              $cpm=$camp_id."-".$row[0]."-0";
              else
                $cpm=$camp_id."-0-".$row[1];
                  ?>
                    <option value="<?php echo $cpm; ?>"><?php
                    if(!empty($row[0]))
                        echo Product::getprodnamebyid($row[0]);
                        else
                            echo Crm::getcsnamebyid($row[1]);
                            
                     ?></option>
                    <?php
                    }

                    ?>
    </select>
	</div>
    