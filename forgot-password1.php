<?php
require_once 'data.php';

$res=Email::forgotPassword($_REQUEST["user_name"]);
if($res==1)
    echo "ok";
else
    echo $res;
?>