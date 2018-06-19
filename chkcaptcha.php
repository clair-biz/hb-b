<?php
require_once 'Classes/securimage/securimage.php';

if(isset($_COOKIE["captcha"])!="" && strlen($_COOKIE["captcha"])==6) {
    if($_COOKIE["captcha"]==$_REQUEST["captcha_code"])
        echo "true";
    else
        echo "false";
}
else {
$securimage = new Securimage();
if ($securimage->check($_REQUEST['captcha_code']) == false)
    echo "false";
else {
    echo "true";
    setcookie("captcha", $_REQUEST["captcha_code"], time()+3600*24, "/", $domain);
}
}
?>