<html>
<body>
<?php
require_once 'data.php';
//$root=Crm::root();
//$m=Crm::getcattypebyuname($_SESSION["user"]);
?>
 <ul class="list-group">
                <a href="<?php echo $root."AdminDashboard"; ?>" class="list-group-item list-group-item-action" >Home</a>
                <a href="<?php echo $root."AdminRateChart"; ?>" class="list-group-item list-group-item-action" >View Rate Chart</a>
                <a href="<?php echo $root."UpdateRate"; ?>" class="list-group-item list-group-item-action">Update Rate Chart</a>
                <a href="<?php echo $root."Vendors"; ?>" class="list-group-item list-group-item-action">Vendors</a>
                <a href="<?php echo $root."Customers"; ?>" class="list-group-item list-group-item-action">Customers</a>
                <a href="<?php echo $root."Categories"; ?>" class="list-group-item list-group-item-action">Category</a>
                </ul>   
</body>
</html>