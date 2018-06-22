<!DOCTYPE html>
<html>
<body>
    <div class="slick-slide0 slide0 " style="position: relative;">
            <a  href="#">
                    <img class=" img-fluid"
                         src="<?php
                         switch ($_REQUEST["type"]) {
                             case "Product":
                         echo $root."assets/images/products.png";
                                 break;
                             case "Service":
                         echo $root."assets/images/services.png";
                                 break;
                         }
                                 ?>"  >
            </a>
    </div>
</body>
</html>
