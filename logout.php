<?php
require_once("data.php");
unset($_SESSION["user"]);
unset($_SESSION["session_time"]);
            ?>
            <script>
                    var root="<?php echo $root; ?>";
                    window.location.href=root+"Login";
           </script>
           <?php
//			   header("location:./");
//    response.sendRedirect("login.jsp");
?>