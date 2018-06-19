<html>
    <body>

<?php
require_once 'data.php';
?>
          <div class="card logo-bg-b darken-1" style="margin-bottom:0 !important;">
              <div class="card-content white-text" style="padding: 5px !important; ">
            <p style="color:white;"><b><?php
            if($type=="prod")
                echo "Product Category";
            elseif($type=="serv")
                echo "Service Category";
            ?><i class="material-icons right">menu</i>
            </b></p>
            </div>
          </div>
        <div class="card white " style="margin-top:0 !important; margin-bottom:0 !important;">
            <div class="card-content white-text" style="padding: 5px !important; ">
                <ul>
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
                $pass=str_replace(" ", "_", $row[0]);
?>
        <li>
            <a class="<?php
            if($type=="prod")
                echo "product-link";
            elseif($type=="serv")
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
            </div>
          </div>
    </body>
</html>