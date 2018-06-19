    <?php 
    require_once 'Classes/Classes.php';
    $id=$_REQUEST["serv_id"];
    $q="select count(*) from serviceordertbl where serv_id=$id";
   // $q="delete from product where prod_id=$id";
    $pq=mysqli_query(Crm::con(),$q);
    if($row=mysqli_fetch_array($pq)){
     $count=$row[0];
     if($count == 0)
     {
        $m="delete from service where serv_id=$id";
        
     }
    
     else{
         $m="update service set is_active='N' where serv_id=$id"; 
     }
    if($mn=mysqli_query(Crm::con(),$m))
            echo 'ok';

    else
        echo 'error';
     }
    ?>
