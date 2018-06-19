<?php
require_once 'data.php';
$ret="false";
 $prod=$_REQUEST['prod'];
 $qty=$_REQUEST['qty'];
 $unit=$_REQUEST['unit'];
  //echo Crm::getDiscount($prod,$qty,$unit);

 $q="select prod_qty,prod_unit from product where prod_id=$prod";
 $pq=Base::generateResult($q);
 if($row=mysqli_fetch_array($pq)){
     $qtyp=$row[0];
     $unitp=$row[1];
      }
      
 if($unit!=$unitp){
     switch($unit){
         case "gm":
             switch($unitp){
                          case "Kg":
                                   if(($qty/=1000) >= $qtyp)
                                       $ret='true';
                                   break;
                          case "mg":
                                   if(($qty*=1000) >= $qtyp)
                                       $ret='true';
                                   break;
                                  
                           }
                           break;
                           
         case "Kg":
             switch($unitp){
                          case "gm":
                              if(($qty*=1000) >= $qtyp) {
                                       $ret='true';
                                       
                                   }
                                   break;
                          case "mg":
                                   if(($qty*=1000000) >= $qtyp)
                                       $ret='true';
                                   break;
                                  
                           }
                           break;
                           
         case "mg":
             switch($unitp){
                          case "Kg":
                                   if(($qty/=1000000) >= $qtyp)
                                       $ret='true';
                                   break;
                          case "gm":
                                   if(($qty/=1000) >= $qtyp)
                                       $ret='true';
                                   break;
                                  
                           }
                           break;
                           
         case "L":
             switch($unitp){
                          case "ml":
                                   if(($qty*=1000) >= $qtyp)
                                       $ret='true';
                                   break;
                           }
                           break;
                           
         case "ml":
             switch($unitp){
                          case "L":
                                   if(($qty/=1000) >= $qtyp)
                                       $ret='true';
                                   break;
                           }
                           break;
                           
     }
 }
      
      
      elseif($qty>=$qtyp && $unit==$unitp)
          $ret='true';
          

      echo $ret;
?>