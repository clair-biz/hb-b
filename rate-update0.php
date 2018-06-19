<?php
require 'data.php';
//$vend_id=Crm::getuidbyuname($_SESSION["user"]);
$query="select cat_id,cat_name from category where cat_id<>0;";  
$cat2=Base::generateResult($query);
?>
        <div class="row">
            <div class="form-group col-md-12">
                <p class="col-md-2 col-sm-12" for="cat_id">Category Name:</p>
                <div class="col-md-4 col-sm-12">
                    <select class="form-control" col-md-6 id="hy" name="hy"  required>
                      <option value="Half Annual">Half Annual</option>   
                       <option selected="true" value="Annual">Annual</option>
                    </select>
                    </div>
                    
                    <div class="col-md-4 col-sm-12">
                <select class="form-control" col-md-6 id="cat_id" name="cat_id"  required>
                    <option selected="true" value="">-Select-</option>

                <?php
      while($row=mysqli_fetch_array($cat2)){  
                    ?>
                    <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                    <?php
                    }

                    ?>
                </select>
                </div>
            </div>
        </div>
