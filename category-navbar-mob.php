<html>
    <body>
<!-- Dropdown Structure -->
<ul id="dropdown_shopby" class="dropdown-content">
  <?php
switch($type) {
    case "prod"  :
mysqli_data_seek($main_cat, 0);
$cat=$main_cat;
break;
    case "serv"  :
mysqli_data_seek($serv_cat, 0);
$cat=$serv_cat;
break;
}
            while($row = mysqli_fetch_array($cat)) {
    $pass= str_replace(" ","_",$row[0]);
?>
        <li>
            <a class="<?php
            if($type=="prod")
                echo "product-link";
            if($type=="serv")
                echo "service-link";
            ?>" href="#" data-message="<?php
            if($type=="prod")
            echo Crm::root()."Products/".$pass;
            elseif($type=="serv")
            echo Crm::root()."Services/".$pass;
            ?>">
                    <?php echo $row[0]; ?>
            </a>
        </li>
<?php
            }
            ?>
        
</ul>
<ul id="dropdown_popular" class="dropdown-content">
  <?php
  /*
switch($type) {
    case "prod"  :
                $strQuerytags="select product.prod_id, prod_name, COUNT(product.prod_id) c FROM product,ordertbl WHERE product.prod_id=ordertbl.prod_id and product.prod_id<>0  GROUP BY product.prod_id ORDER by c DESC limit 5";
break;
    case "serv"  :
                $strQuerytags="select service.serv_id, serv_name, COUNT(service.serv_id) c FROM service,serviceordertbl WHERE service.serv_id=serviceordertbl.serv_id and service.serv_id<>0  GROUP BY service.serv_id ORDER by c DESC limit 5";
break;
}
  
                $restags=mysqli_query(Crm::con(),$strQuerytags);
                    while($tags = mysqli_fetch_array($restags)) {
    $pass= str_replace(" ","_",$tags[1]);
                                 ?>
                    <li><a href="<?php
                if($type=="prod")
                    echo Crm::root()."Products/".$pass;
                if($type=="serv")
                    echo Crm::root()."Services/".$pass;
                    ?>"><?php echo $tags[1]; ?></a></li>
<?php
            }
            */
            ?>

</ul>
<nav class="nav-wrapper hide-on-large-only" style="line-height: 30px !important; height: 30px; " >
    <ul class=" " style="margin-top: 1px;">
      <!-- Dropdown Trigger -->
      <li class="left h-30"><a class="dropdown-button" href="#!" data-activates="dropdown_shopby">
              <?php
                if($type=="prod")
                    echo "Product";
                if($type=="serv")
                    echo "Service";
              ?> Category
              <i class="material-icons h-30 right">arrow_drop_down</i></a></li>
      <!-- Dropdown Trigger -->
      <li class="right h-30"><a class="dropdown-button" href="#!" data-activates="dropdown_popular">Popular Tag<i class="material-icons h-30 right">arrow_drop_down</i></a></li>
    </ul>
</nav>
    </body>
</html>