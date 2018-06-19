<?php
require_once 'data.php';

$name=$_REQUEST["name"];
$email=$_REQUEST["emaill"];
$subject=$_REQUEST["sub"];
$type=$_REQUEST["type"];
$message=$type."<br />Name: $name<br />Email Id: $email<br />Message: ".$_REQUEST["msg"];


if(Email::sendEmail("HomeBiz365-$type","enquiry@homebiz365",$subject,$message)) {
    echo "Mail send";
}
else {
    echo "not send";
}
    ?>
