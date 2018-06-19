<?php require_once 'header.php';

if(isset($_REQUEST["cust_id"])!="") {
    if(Customer::validate($_REQUEST["cust_id"])) {
?>
                <script type="text/javascript">
//                    alert("Your Email Id is verified!\nThank You!");
//                window.location.href="./";
                 $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Your Email Id is verified!\nThank you</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root;
                });
                </script>
<?php        
    }
else {
?>
                <script type="text/javascript">
                 $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Unable to verify Your Email ID</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root;
                });
//                    alert("Unable to verify your Email ID!");
//                window.location.href="./";
                </script>
<?php        
}
}

elseif(isset($_REQUEST["vend_id"])!="") {
    if(Vendor::validate($_REQUEST["vend_id"])) {
?>
                <script type="text/javascript">
                 $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Your Email Id is verified!\nThank you</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root;
                });
//                    alert("Your Email Id is verified!\nThank You!");
//                window.location.href="./";
                </script>
<?php        
    }
else {
?>
                <script type="text/javascript">
                 $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Unable to verify Your Email ID</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root;
                });
//                    alert("Unable to verify your Email ID!");
//                window.location.href="./";
                </script>
<?php        
}
}

else {
?>
                <script type="text/javascript">
                 $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Unable to verify Your Email ID</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root;
                });
//                    alert("Unable to verify your Email ID!");
//                window.location.href="./";
                </script>
<?php        
}
?>
