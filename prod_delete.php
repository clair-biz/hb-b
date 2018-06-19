    <?php 
    require_once 'data.php';
    $id=$_REQUEST["prod_id"];
    $q="select count(*) from order_detail where prod_id=$id";
   // $q="delete from product where prod_id=$id";
    $pq=Base::generateResult($q);
    if($row=mysqli_fetch_array($pq)){
     $count=$row[0];
     if($count == 0)
     {
        $m="delete from product where prod_id=$id";
        
     }
    
     else{
         $m="update product set is_active='N' where prod_id=$id"; 
     }

     if($mn=Base::generateResult($m))
        echo 'ok';

    else
        echo 'error';
     }
    ?>
