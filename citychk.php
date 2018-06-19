<?php
require_once 'data.php';
$type=$_REQUEST["type"];
 $city=$_REQUEST['city'];
switch ($type) {
    case "check" : {
$strcities="SELECT count(city_served) from vend_subscription where city_served like '%$city%'; ";
$res=Base::generateResult($strcities);
if($row= mysqli_fetch_array($res)) {
    if($row[0]>0)
       echo $city;
    else
        echo "Pune";
}
else
    echo "Pune";
}
break;
    case "list": {
$strcities="SELECT distinct city_served FROM vend_subscription where vs_pay_status='Enabled' and city_served<>'$city'; ";
            $cities=Base::generateResult($strcities);
        

      if(mysqli_num_rows($cities)>0) { ?>
          <?php
      while($row= mysqli_fetch_array($cities)) {
          if($_COOKIE["city"]!=$row[0]) { ?>
    <a class="dropdown-item city" data-city="<?php echo $row[0];?>" href="#"><?php echo $row[0]; ?></a>

    <?php
                }
            }
      }
      
    }
    break;
}
?>