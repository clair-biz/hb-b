<?php
require_once 'Classes/Classes.php';

$email_otp=$_REQUEST["email_otp"];
$vend_id=Vendor::getvendidbyuname($_SESSION["user"]);
if($email_otp==Vendor::is_email_validated($vend_id)) {
    if(mysqli_query(Crm::con(),"update vendor set is_email_validated='Y' where vend_id=$vend_id ;"))
        echo "ok";
}
else
    echo "invalid";
?>