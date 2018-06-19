<?php
require_once 'data.php';

if(isset($_REQUEST["ord_id"]) && $_REQUEST["ord_id"]!="") {
$ord_id=$_REQUEST["ord_id"];
$ord_amt=$_REQUEST["amt"];
$perc=$_REQUEST["perc"];
    $rst = Order::cancelOrderCustomer($ord_id);
    $amt=$ord_amt*($perc/100);
 //   echo "-$amt-";
    $wallet=Base::getWalletAmt(Base::getuidbyuname($user->u_name));
//    echo "-$wallet-";
    $query="update users set wallet_amt=".($wallet+$amt)." where u_id=".Base::getuidbyuname($user->u_name);
//    echo $query;
    if(Base::generateResult( $query))
            $rst++;
//    out.print(rst);
           if($rst>0) { ?>
            <script>
                    var root="<?php echo Base::root(); ?>";
                    window.location.href=root+"MyOrders";
           </script>
           <?php
    }
    
}

?>