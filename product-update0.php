<?php

$vs_id=$_COOKIE["vs_id"];
$prod2=mysqli_query(Crm::con(),"select * from product where prod_id<>0 and vs_id=$vs_id;");  

?>
        <div class="row">
            <div class="form-group col-md-12">
                <p class="col-md-4 col-sm-12" for="prod_id">Product Name:</p>
                <div class="col-md-6 col-sm-12">
                <select class="form-control" id="prod_id" name="prod_id"  required>
                    <option selected="true" value="">-Select-</option>

                <?php
      while($row=mysqli_fetch_array($prod2)){  
                    ?>
                    <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                    <?php
                    }

                    ?>
                </select>
                </div>
            </div>
        </div>
