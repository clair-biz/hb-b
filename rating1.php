<?php
include 'Classes/Classes.php';
$id=$_REQUEST['vendid']; //Integer.parseInt(request.getParameter("id"));
$rating=$_REQUEST['star']; //Integer.parseInt(request.getParameter("id"));
//String remark= request.getParameter("status");
        $q="select vend_rating,vend_rating_off from vend_subscription where u_id=$id;";
$res=mysqli_query(Crm::con(),$q);
if($row= mysqli_fetch_array($res)) {
        $rating+=$row[0];
        $rating_off=$row[1]+1;
}
$q="update vend_subscription set vend_rating=$rating,vend_rating_off=$rating_off where u_id=$id;";
if(mysqli_query(Crm::con(),$q)) {
?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Thank You!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root;
                });
                });
//        alert("Thank You!");
//        window.location.href="./";
    </script>
    <?php
}
else {
   ?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>something went wrong!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
        window.location.href="<?php echo Crm::root()."rating.php?vendid=$id";?>";
    });
    });
    </script>
    <?php
}


//}
?>