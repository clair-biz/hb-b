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
       if(!empty($_REQUEST["stdt"])!="") {
           $date = date_create($_REQUEST["stdt"]);
           $start_dt= date_format($date, "Y-m-d");
       }
       else
           $start_dt="";
           if(!empty($_REQUEST["endt"])!="") {
               $date = date_create($_REQUEST["endt"]);
               $end_dt= date_format($date, "Y-m-d");
           }
           else
               $end_dt="";
               $user =$_SESSION["user"];
   $u_id=Crm::getuidbyuname($user);
   $m=new Campaign($camp_name,$start_dt,$end_dt,$u_id,$user);
   if($m->update($camp_id)>0) {    ?>
   <script type="text/javascript">
//        alert("Update Successful!");
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
    </script>
<?php 
}
?> 