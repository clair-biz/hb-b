<html>
    <body>
<?php
require_once("data.php");
$count=0;
$n=new Order();
//echo Order::newOrdId();
$n->ord_id=Order::newOrdId();
$n->name=$_REQUEST["name"];
$n->cntc=$_REQUEST["ccntc"];
$n->email=$_REQUEST["cemail1"];
$n->addr=$_REQUEST["saddr"];
$n->zip=$_REQUEST["czip"];
$n->subtotal=$_REQUEST["subtotal"];
$n->wallet=$_REQUEST["wallet"];
$_SESSION["ord_data"]= serialize($n);

//Email::generateOrderPO($_SESSION["ord_data"]);
?>
    <script>
                    var root=window.location.origin;
                    window.location.href=root+"/Classes/CCAvenue/dataFrom.php";
    </script>
    </body>
</html>