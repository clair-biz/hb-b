<?php
require_once 'header.php';
       // SimpleDateFormat s=new SimpleDateFormat("yyyy-MM-dd");
       // SimpleDateFormat d=new SimpleDateFormat("dd/MM/yyyy");
    $rp_id=$_REQUEST["rp"];
    
    $rate="";
    $tax="";

    if(isset($_REQUEST["rate"])!="" && !empty($_REQUEST["rate"]))
       $rate= $_REQUEST["rate"];
    if(isset($_REQUEST["tax"])!="" && !empty($_REQUEST["tax"]))
    $tax = $_REQUEST["tax"];
   $user =$_SESSION["user"];
    if($rate!="" && $tax!="")
        $q="update rate_plan set plan_rate=$rate,tax_perc=$tax,upd_dt=now(),upd_usr='$user' where rp_id=$rp_id;";   
    if($rate!="" && $tax=="")
        $q="update rate_plan set plan_rate=$rate,upd_dt=now(),upd_usr='$user' where rp_id=$rp_id;";   
    elseif($rate=="" && $tax!="")
        $q="update rate_plan set tax_perc=$tax,upd_dt=now(),upd_usr='$user' where rp_id=$rp_id;";   
    
  
//        echo $q;
    if(Base::generateResult($q)) {    ?>
   <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Update Successful!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"AdminRateChart";
                });
                });
//        window.location.href="rate-plan.php";
    </script>
    <?php
}
else {
	echo mysqli_error(Crm::con());
   ?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Update Failed!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"AdminRateChart";
                });
                });
//        alert("Update Failed!");
//        window.location.href="rate-plan.php";
    </script>
<?php 
}
?> 