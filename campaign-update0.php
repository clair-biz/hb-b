<?php
require 'Classes/Classes.php';
$vend_id=Crm::getuidbyuname($_SESSION["user"]);
$cat2=mysqli_query(Crm::con(),"select camp_id,camp_name from campaign where camp_id<>0 and u_id=$vend_id;");  

?>
        <div class="row">
            <div class="container">
                <div class="row col-md-6 col-md-offset-2">
                <p>
                        <label class="question" for="campaign">
                        <input class="form-control" name="options" type="radio" checked id="campaign" value="campaign" />
                        <span>Update Offer Details</span>
                        </label>
            </p>
                   <?php
                   $a=Crm::getcattypebycatid(Vendor::getcatidbyvsid($_COOKIE["vs_id"]));
                   if($a == 'Product'){
                   ?>
                <p>
                        <label class="question" for="campprodcat">
                        <input class="form-control" name="options" type="radio" id="campprodcat" value="campprodcat" />
                        <span>Update Product/Category linked to Offer</span>
                        </label>
            </p>
                    <?php
                        }
                        else {
                   ?>
                <p>
                        <label class="question" for="campservcat">
                        <input class="form-control" name="options" type="radio" id="campservcat" value="campservcat" />
                        <span>Update Service/Category linked to Offer</span>
                        </label>
            </p>
                    <?php
                        }
                    ?>
                    </div> 
                <div class="row col-md-12">
                <p class="col col-md-offset-1 col-md-2 col-sm-12" for="cat_id">Offer Name:</p>
                <div class="col-sm-12 col-md-4">
                   <select class="form-control col-md-6" id="camp_id" name="camp_id"  required>
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
        </div>