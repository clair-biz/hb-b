<?php
require_once('Classes/Classes.php');
   mysqli_data_seek($serv_cat,0);
   $cat_count=1;
   $type="serv";
?>
<div class="category-service-block"  style="display: none" >
    <div class="row">
<div class="col l2">
<?php
while($row = mysqli_fetch_array($serv_cat)) {
    $cat_name=str_replace(" ", "_", $row[0]);
?>
          <ul>
              <li>
                  <a class="<?php
            if($type=="prod")
                echo "product-link";
            if($type=="serv")
                echo "service-link";
            ?>" href="#" data-message="<?php
            if($type=="prod")
            echo Crm::root()."Products/".$cat_name;
            elseif($type=="serv")
            echo Crm::root()."Services/".$cat_name;
            ?>">
<b style="color: blue"><?php echo $row[0]; ?></b></a></li>
        <?php
        $sub_menu_query="select cs_name from cat_sub,category where cat_sub.cat_id=category.cat_id and cs_name<>'".$row[0]."' and cat_name='".$row[0]."' order by cs_name;";
        $sub_menu_res= mysqli_query(Crm::con(), $sub_menu_query);
            while($sub_menu = mysqli_fetch_array($sub_menu_res)) {
                $pass=str_replace(" ", "_", $row[0]);

?>
        <li >
            <a class="<?php
            if($type=="prod")
                echo "product-link-from-top";
            if($type=="serv")
                echo "service-link-from-top";
            ?>" href="#" data-message="<?php
            if($type=="prod")
            echo Crm::root()."Products/".$pass;
            elseif($type=="serv")
            echo Crm::root()."Services/".$pass;
            ?>" style="color: black;" id="<?php echo "sub_cat_".$cat_name."_.$sub_cat_name"; ?>">
                <?php echo $sub_menu[0]; ?>
            </a>
        </li>
       <?php
            }
            ?>
          </ul>
    <?php
    if($cat_count==2) {
        $cat_count=1;
        ?>
</div>
<div class="col l2">
<?php    }
else
       $cat_count++;
   }
   ?>
</div>

</div>
</div>