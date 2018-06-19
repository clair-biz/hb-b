<?php
require_once("Classes/Classes.php");
        $email = $_REQUEST["email"];   
        $password = $_REQUEST["password"];
//echo $email."<br />".$password."<br/>".Crm::checkUser($email,$password)."<br/>".Crm::getUserType($email);
        switch(Crm::checkUser($email,$password)) {
            case 11 : 
				if(Crm::getUserType($email)==11) {
             $_SESSION["user"]= $email;
            ?>
            <script>
//				alert("stuck here11");
                window.location.href="admin-dashboard.php";
           </script>            
            <?php 
				}
			break;
            case 1 :
				if(Crm::getUserType($email)==1) {
             $_SESSION["user"]= $email;
            ?>
            <script>
//				alert("stuck here1");
                window.location.href="vendor-home.php";
           </script>            
            <?php 
				}
                break;
            case 2 :  
				if(Crm::getUserType($email)==2) {
             $_SESSION["user"]= $email;
             $_SESSION["cust"]= Customer::getcustidbyuname($email);
            ?>
            <script>
//				alert("stuck here2");
                window.location.href="cart-insert.php";
           </script>            
            <?php 
                }
                    break;
        default: {
            ?>
            <script>
           alert("Invalid login credentials");
           window.location.href="login.php";
           </script>
           <?php 
   }
}

?>