<?php
require_once 'header.php';
        
    $cat_id = $_REQUEST["cat_id"];
    $plan= $_REQUEST["plan"];
    $rate= $_REQUEST["rate"];
    $tax= $_REQUEST["tax"];
    $user= $_SESSION["user"];

    $q="insert into rate_plan(cat_id,plan_name,plan_rate,tax_perc,ins_dt,ins_usr) values (".$cat_id.",'".$plan."',".$rate.",".$tax.",now(),'".$user."')";
//    echo $q;
    if(mysqli_query(Crm::con(), $q)) {
    $sub=$_REQUEST["sub"];
    if($sub=="more") {
                ?>
                <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Rate Added!\nAdd Rate for another Period!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href="<?php     echo Crm::root()."AddRatePlan?cat_id=$cat_id"; ?>";
                });
                });
//                    alert("Insert Unsuccessful");
                </script>
                    <?php
                    
}
    elseif($sub=="submit") {
                ?>
                <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Rate Added!\nAdd Rate for another Period!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"Categories";
                });
                });
//                    alert("Insert Unsuccessful");
                </script>
                    <?php
                    
}
//    $loc="location:admin-category.php";
}
else {
                ?>
                <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Insert Unsuccesful!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href="<?php     echo Crm::root()."AddRatePlan?cat_id=$cat_id"; ?>";
                });
                });
//                    alert("Insert Unsuccessful");
                </script>
                    <?php
                    
}
//echo $loc;
//header($loc);
?>
