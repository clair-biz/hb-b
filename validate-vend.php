<?php require_once 'Classes/Classes.php';

if(isset($_REQUEST["email"])!="") {
    if(Customer::validate($_REQUEST["email"])) {
?>
                <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Your Email ID is verifyed!\nThank You!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root;
                });
                });
//                    alert("Your Email Id is verified!\nThank You!");
//                window.location.href="http://www.homebiz365.in/";
                </script>
<?php        
}
else {
?>
                <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Unable to verify Email!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root;
                });
                });
//                    alert("Unable to verify your Email ID!");
//                window.location.href="http://www.homebiz365.in/";
                </script>
<?php        
}
}
else {
?>
                <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Unable to verify Email ID!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root;
                });
                });
//                    alert("Unable to verify your Email ID!");
//                window.location.href="http://www.homebiz365.in/";
                </script>
<?php        
}
?>
