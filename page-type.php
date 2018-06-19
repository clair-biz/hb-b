<!DOCTYPE html>
<html>
<body>
<div class="row">
    <div class="card" style="margin: 0 !important" >
      <div class="card-content" style="padding: 0px; height: 200px;">
          <?php switch ($type) {
              case "prod"  :
?>
            <a href="<?php echo Crm::root()."Services"; ?>">
              <img class="responsive-img center-block" style="height:200px !important; "
                         src="<?php echo Crm::root()."uploads/images/product.jpg"; ?>" 
                         onError="this.onerror=null;this.src='http://www.homebiz365.in/uploads/images/small.png';" />
            </a>
          <?php 
                break;
              case "serv"  :
?>
            <a href="<?php echo Crm::root(); ?>">
              <img class=" responsive-img center-block" style="height:200px !important; "
                         src="<?php echo Crm::root()."uploads/images/services.jpg"; ?>" 
                         onError="this.onerror=null;this.src='http://www.homebiz365.in/uploads/images/small.png';" />
            </a>
          <?php 
                break;
          }
          ?>
        </div>
    </div>
</div>
</body>
</html>
