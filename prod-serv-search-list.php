<?php
require_once('data.php');
$type=$_REQUEST["type"];
echo Base::prodServList($type);
?>
