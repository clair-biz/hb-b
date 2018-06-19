<html>
    <body>
<?php require_once 'header.php';?>
<div class="container-fluid row" style="margin-top: 40px; min-height: 75vh; margin-bottom: 30px;">
<?php
$order_status=$_REQUEST["ord_status"];
          if($order_status=="Success") {  
        ?>
    <script type="text/javascript">
        $(document).ready(function() {
            var msg="<?php
            if(isset($_SESSION["subscription_data"])!="")
            echo "Thank You!\\nYou can now add your Product/Services and get benefits from our Services.";
            if(isset($_SESSION["ord_data"])!="")
            echo "Thank You!\\nWe have received your Order!";
            ?>";
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>"+msg+"</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var loc="<?php
                  if(isset($_SESSION["user"])!="" && $_SESSION["user"]!=null && Crm::getUserType($_SESSION["user"])==1 ) {
                  if(Vendor::countactiveSubscription($_SESSION["user"])>1)
                      echo Crm::root()."VendorDashboard";                  
                  elseif(Vendor::countactiveSubscription($_SESSION["user"])==1) {
                      echo Crm::root()."Login";
                  }
                }
                  if(isset($_SESSION["user"])!="" && $_SESSION["user"]!=null && Crm::getUserType($_SESSION["user"])==2 ) {
                      echo Crm::root();
                  }
                
            if(isset($_SESSION["subscription_data"])!="")
                unset($_SESSION["subscription_data"]);
            if(isset($_SESSION["ord_data"])!="")
                unset($_SESSION["ord_data"]);
            ?>";
                        console.log("loc-"+loc+"-");
                    window.location.href=loc;
                });
                });
//        alert("Thank you!\nWe would contact you soon!");
//	        window.location.href="how-it-works-vendor.php";
    </script>
<?php
          }
	else if($order_status==="Aborted")
	{
            ?>
    <script>
                    $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Transaction Aborted.</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var loc="<?php
            if(isset($_SESSION["subscription_data"])!="")
                echo Crm::root()."VendorSubscriptions";
            if(isset($_SESSION["ord_data"])!="")
                echo Crm::root()."Cart";
                ?>";
                    window.location.href=loc;
                });
            });
                    </script>
<?php
//		echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
	
	}
	else if($order_status==="Failure" || $order_status=="Success1")
	{
            ?>
    <script>
                    $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Transaction Failure.</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var loc="<?php
            if(isset($_SESSION["subscription_data"])!="")
                echo Crm::root()."VendorSubscriptions";
            if(isset($_SESSION["ord_data"])!="")
                echo Crm::root()."Cart";
                ?>";
                    window.location.href=loc;
                });
            });
                    </script>
<?php
//		echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
	}
	elseif($order_status=="success") {
            ?>
    <script>
                    $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Subscription Request Received!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var loc="<?php
                echo Crm::root();
                ?>";
                    window.location.href=loc;
                });
            });
                    </script>
<?php
//		echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
		echo "<br>Security Error. Illegal access detected";
	
	}
	else {
            ?>
    <script>
                    $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Transaction Failure.</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var loc="<?php
            if(isset($_SESSION["subscription_data"])!="")
                echo Crm::root()."VendorSubscriptions";
            if(isset($_SESSION["ord_data"])!="")
                echo Crm::root()."Cart";
                ?>";
                    window.location.href=loc;
                });
            });
                    </script>
<?php
//		echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
		echo "<br>Security Error. Illegal access detected";
	
	}

?>    
    
</div>
    <?php require_once 'footer.php';?>
    </body>
</html>