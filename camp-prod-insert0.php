<?php
require 'Classes/Classes.php';
$q="select camp_id,camp_name from campaign,users where campaign.u_id=users.u_id and camp_id<>0 and u_name='".$_SESSION["user"]."';";
$cat2=mysqli_query(Crm::con(),$q);  

?>
<form action="vendor-camp-prod-insert.php" method="post">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3 card">
            <h5>Select Offer to which you want to link the products</h5>
                <div class="row col-md-12">
                <p class="col-md-4 col-sm-12 text-right" for="cat_id">Select Offer:</p>
                <div class="col-md-4 col-sm-12">
                   <select class="form-control col-md-6" id="camp" name="camp"  required>
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
    <div class="row">
            <button id="" style="margin-bottom: 75px; margin-left: auto; margin-right: auto; display: block"" class="btn btn-block " >Submit</button>
    </div>

        </div>
        </div>
</form>
