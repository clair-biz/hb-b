<?php
require_once 'header.php';
$user=$_REQUEST["user"];
$vs_for=$_REQUEST["for_val"]." ".$_REQUEST["for"];
$u_id=Crm::getuidbyuname($user);
$q="update vend_subscription set vs_for='$vs_for',upd_usr='$user',upd_dt=now() where u_id=$u_id";

if(mysqli_query(Crm::con(),$q)) {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Requested for Extension!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href="vendor-subs.php";
                });
                });
//        alert("Requested for Extension!");
//        window.location.href="vendor-subs.php";
    </script>
<?php 
}
else {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Request for Extension Failed!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href="admin-category.php";
                });
                });
//        alert("Request for Extension Failed!");
//        window.location.href="vendor-subs.php";
    </script>
<?php 
}
?>