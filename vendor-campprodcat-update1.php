<?php
require_once 'header.php';
       // SimpleDateFormat s=new SimpleDateFormat("yyyy-MM-dd");
       // SimpleDateFormat d=new SimpleDateFormat("dd/MM/yyyy");
    $camp_id=$_REQUEST["camp"];
    
    $camp_name="";
    $camp_start="";
    $camp_end="";

    if(isset($_REQUEST["cname"])!="" && !empty($_REQUEST["cname"]))
       $camp_name= $_REQUEST["cname"];
    if(isset($_REQUEST["stdt"])!="" && !empty($_REQUEST["stdt"]))
    $start_dt = $_REQUEST["stdt"];
    if(isset($_REQUEST["endt"])!="" && !empty($_REQUEST["endt"]))
    $end_dt = $_REQUEST["endt"];
   $user =$_SESSION["user"];
 $m=new Campaign($camp_name,$start_dt,$end_dt,$user);
   if($m->update($camp_id)>0) {    ?>
   <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Update Successful!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"UpdateOffer";
                });
                });
//        alert("Update Successful!");
//        window.location.href="vendor-campaign-update.php";
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
                    window.location.href=root+"UpdateOffer";
                });
                });
//        alert("Update Failed!");
//        window.location.href="vendor-campaign-update.php";
    </script>
<?php 
}
?> 