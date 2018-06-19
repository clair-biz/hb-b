<?php
require_once('header.php');
if(isset($_REQUEST["from"])!="" && !empty($_REQUEST["to"]))
//$cartcount=Order::getCountCart($_COOKIE["cust"]);
if(isset($_REQUEST["prod"]) ) {
        $prod_id=$_REQUEST["prod"];

//$vs_id=$_COOKIE["vs_id"];
$date = date_create($_REQUEST["from"]);
$na_from= date_format($date, "Y-m-d");

$date = date_create($_REQUEST["to"]);
$na_to= date_format($date, "Y-m-d");

if(Product::setOfflinePeriod($prod_id,$na_from,$na_to)) {
            ?>
    <script>
                    $(document).ready(function() {
                        var from="<?php echo $_REQUEST["from"];?>";
                        var to="<?php echo $_REQUEST["to"];?>";
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Offline Period set from "+from+" to "+to+".</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var loc="<?php
                  if(isset($_SESSION["user"])!="" && $_SESSION["user"]!=null && Crm::getUserType($_SESSION["user"])==1 ) {
                  if(Vendor::countactiveSubscription($_SESSION["user"])>1)
                      echo Crm::root()."VendorDashboard";                  
                  elseif(Vendor::countactiveSubscription($_SESSION["user"])==1) {
		  
                          if(Crm::getcattypebycatid(Vendor::getcatidbyvsid($_COOKIE["vs_id"]))=="Product")
                      echo Crm::root()."ProductsPage";
            
		  elseif(Crm::getcattypebycatid(Vendor::getcatidbyvsid($_COOKIE["vs_id"]))=="Service")
                      echo Crm::root()."ServicesPage";
                  }
                }
            
            ?>";
                    window.location.href=loc;
                });
            });
                    </script>
<?php
    
}
}
elseif(isset($_REQUEST["serv"]) ) {
        $serv_id=$_REQUEST["serv"];

//$vs_id=$_COOKIE["vs_id"];
$date = date_create($_REQUEST["from"]);
$na_from= date_format($date, "Y-m-d");

$date = date_create($_REQUEST["to"]);
$na_to= date_format($date, "Y-m-d");

if(Service::setOfflinePeriod($serv_id,$na_from,$na_to)) {
            ?>
    <script>
                    $(document).ready(function() {
                        var from="<?php echo $_REQUEST["from"];?>";
                        var to="<?php echo $_REQUEST["to"];?>";
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Offline Period set from "+from+" to "+to+".</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var loc="<?php
                  if(isset($_SESSION["user"])!="" && $_SESSION["user"]!=null && Crm::getUserType($_SESSION["user"])==1 ) {
                  if(Vendor::countactiveSubscription($_SESSION["user"])>1)
                      echo Crm::root()."VendorDashboard";                  
                  elseif(Vendor::countactiveSubscription($_SESSION["user"])==1) {
		  
                          if(Crm::getcattypebycatid(Vendor::getcatidbyvsid($_COOKIE["vs_id"]))=="Product")
                      echo Crm::root()."ProductsPage";
            
		  elseif(Crm::getcattypebycatid(Vendor::getcatidbyvsid($_COOKIE["vs_id"]))=="Service")
                      echo Crm::root()."ServicesPage";
                  }
                }
            
            ?>";
                    window.location.href=loc;
                });
            });
                    </script>
<?php
    
}
}
?>
