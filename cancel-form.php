<?php
require_once 'data.php';
$ord_id=$_REQUEST["ord_id"];
$lead=0;
$rem=0;
$perc=0;
$query="select ordertbl.ord_id,ordertbl.ins_dt,now(),ordertbl.req_dt,DATE_SUB(ordertbl.req_dt, INTERVAL prod_min_time DAY),datediff(DATE_SUB(ordertbl.req_dt, INTERVAL prod_min_time DAY),now()),datediff(ordertbl.req_dt,now()) from product,ordertbl,order_detail where ordertbl.ord_id=order_detail.ord_id and order_detail.prod_id=product.prod_id and  ordertbl.ord_id=$ord_id";
$res= Base::generateResult( $query);
if($row= mysqli_fetch_array($res)) {
    if($row[5]>0)
    $lead=1;
    
    if($row[6]>0)
    $rem=1;
}
$query="select disc_perc from reasons where lead_time_diff=$lead and req_dt_diff=$rem and type='Cancel';";
$res= Base::generateResult( $query);
if($row= mysqli_fetch_array($res)) {
    $perc=$row[0];
}
$ord_amt=Order::getOrdAmt($ord_id);
?>
<div class="modal-content">
        <div class="modal-body" style="margin: 50px; font-size: 18px; color: black">
            <p class="text-center">You are about to cancel Order #<?php echo $ord_id;?></p>
            <p class="text-center"><?php
            if($lead==0 && $rem==0)
                echo "You are cancelling the order on the day of Delivery date or post delivery date, you would be refunded $perc% of Order i.e. &#8377; ".($ord_amt*($perc/100))."/-";
            elseif($lead==0 && $rem==1)
                echo "You are cancelling the order between Lead time period, you would be refunded $perc% of Order i.e. &#8377; ".($ord_amt*($perc/100))."/-";
            elseif($lead==1 && $rem==1)
                echo "You would be refunded $perc% of Order i.e. &#8377; ".($ord_amt*($perc/100))."/-";
            else
                echo "$lead $rem";
            ?></p>
            <p class="text-center">Do You wish to continue?</p>
        </div>
        <div class="modal-footer" >
            <a href="<?php echo $root."cancel-order.php?ord_id=".$ord_id."&amt=".$ord_amt."&perc=".$perc; ?>" class="col l6 m6 s6 text-center modal-action waves-effect waves-green red white-text btn-flat chip" style="margin-right: 0px; font-size: 18px; padding: 0 1rem; ">Yes, Cancel Order</a>
            <a href="#!" class="text-center col l6 m6 s6 modal-action modal-close waves-effect waves-green red white-text btn-flat chip" style="margin-right: 0px; font-size: 18px; padding: 0 1rem; ">No</a>
        </div>
</div>