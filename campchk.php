<?php
require_once 'data.php';
 $prod=$_REQUEST['prod'];
 $qty=$_REQUEST['qty'];
// $unit=$_REQUEST['unit'];
  echo Base::getDiscount($prod,$qty/*,$unit*/);
 
 
?>