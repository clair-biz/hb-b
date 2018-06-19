<?php
require_once 'header.php';
       // SimpleDateFormat s=new SimpleDateFormat("yyyy-MM-dd");
       // SimpleDateFormat d=new SimpleDateFormat("dd/MM/yyyy");
    $camp_id=$_REQUEST["camp"];
    $prod_id=0;
    $cs_id=0;
    
    $cpm="";
    if(isset($_COOKIE["cpm"])!="") {
        $cpm=$_COOKIE["cpm"];
    
        $cpm=explode("-",$cpm);
     $prod_id=$cpm[1];
     $cs_id=$cpm[2];
    }
    
    $prod_qty=0;
    if(isset($_REQUEST["qty"])!="")
        $prod_qty=$_REQUEST["qty"];
    
    $perc_disc=0;
    if(isset($_REQUEST["disc"])!="" && !empty($_REQUEST["disc"]))
        $perc_disc=$_REQUEST["disc"];
    
    $disc_on="";
    if(isset($_REQUEST["disc_on"])!="" && !empty($_REQUEST["disc_on"]))
        $disc_on=$_REQUEST["disc_on"];
    
    $unit="";
    if(isset($_REQUEST["unit"])!="" && !empty($_REQUEST["unit"]))
        $_REQUEST["unit"];
    $user= $_SESSION["user"];
    
//echo $perc_disc;
    $c=new CampProd($camp_id,$prod_id,$prod_qty,$unit,$disc_on,$perc_disc,$cs_id,$user);
//    echo $c->toString();
    if($c->update()>0) {
        unset($_COOKIE["cpm"]);
        ?>
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
//       window.location.href="vendor-campaign-update.php";
    </script>
<?php 
}
?> 