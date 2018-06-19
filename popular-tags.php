<html>
    <body>

<?php
require_once 'header.php';

?>
          <div class="card logo-bg-b darken-1" style="margin-bottom:0 !important;">
              <div class="card-content white-text" style="padding: 5px !important; ">
            <p style="color:white;"><b>Popular Tags &nbsp;
                <i class="material-icons right">menu</i>
            </b></p>
            </div>
          </div>
        <div class="card white " style="margin-top:0 !important; margin-bottom:0 !important;">
            <div class="card-content white-text" style="padding: 5px !important; ">
                <ul>
        <?php
        /*
switch($type) {
    case "prod"  :
                $strQuerytags="select product.prod_id, prod_name, COUNT(product.prod_id) c FROM product,ordertbl WHERE product.prod_id=ordertbl.prod_id and product.is_active='Y' and  product.prod_id<>0  GROUP BY product.prod_id ORDER by c DESC limit 5";
break;
    case "serv"  :
                $strQuerytags="select service.serv_id, serv_name, COUNT(service.serv_id) c FROM service,serviceordertbl WHERE service.serv_id=serviceordertbl.serv_id and service.is_active='Y' and service.serv_id<>0  GROUP BY service.serv_id ORDER by c DESC limit 5";
break;
}
                $restags=mysqli_query(Crm::con(),$strQuerytags);
                    while($tags = mysqli_fetch_array($restags)) {
    $pass= str_replace(" ","_",$tags[1]);
                                 ?>
                    <li>
                        <a href="<?php
                        if($type=="prod")
                        echo Crm::root()."Products/".$pass;
                        elseif($type=="serv")
                        echo Crm::root()."Services/".$pass;
                        ?>">

                                    <?php echo $tags[1]; ?>
                        </a>
                    </li>
<?php
            }
*/
            ?>
                </ul>
            </div>
          </div>
    </body>
</html>
