<?php
require_once 'data.php';
if($_REQUEST['pwd']==$_REQUEST['cpwd'])
$password=$_REQUEST['pwd'];

$uname=$_REQUEST['uname'];

$q="update users set pwd='".md5($password)."',upd_dt=now(),upd_usr='$uname' where u_name='$uname';";
        $loc=$root;

if(Base::generateResult($q)) {
    echo "ok";
}
else {
    echo "error";
}    
//echo "<script>window.location.href=$loc; </script>";


    ?>