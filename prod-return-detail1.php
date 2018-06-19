<?php
require_once('data.php');
$vs_id=$user->vs_id;
$q="";
$status=$_REQUEST['status'];
$prod_name=$_REQUEST['prodname'];
$pr_id=$_REQUEST['id'];
$bs_id= Order::getBSdatabyprid($pr_id, "bs_id");
$bs_from= Order::getBSdatabyprid($pr_id, "bs_from");
$bs_to= Order::getBSdatabyprid($pr_id, "bs_to");

            $prod_id=$_REQUEST['prod_id'];
            $ord_id=$_REQUEST['ord'];
            $cntc=Customer::getCntcforRejection($pr_id,"cust_cntc");
            $email=Customer::getCntcforRejection($pr_id,"cust_email");
            $name=Customer::getCntcforRejection($pr_id,"cust_fname");
//echo $cntc;
echo Customer::getCntcforRejection($pr_id,"cust_email");
if(isset($status)!=""){
    switch($status){
        case 'Refund':
            $amount=$_REQUEST['amount'];
            $q="update prod_return set pr_status='Refund', pr_amount=$amount, upd_dt=now(),upd_usr='".$_SESSION["user"]."' where pr_id=$pr_id ";
            //echo $q;
           if(Base::generateResult($q) )//&& Email::prodRefundAmtEmail($prod_name,$amount,$email,$name) && Sms::prodRefund($prod_name, $amount, $cntc))
             $msg="Request for Refund Received ";  
           
           break;
           
        case 'Rejected':
            $reason=$_REQUEST['reason'];
           // $prod_name=$_REQUEST['prodname'];
            $ord_id=$_REQUEST['ord'];
            $q="update prod_return set pr_status='Rejected', reason='$reason', upd_dt=now(),upd_usr='".$_SESSION["user"]."' where pr_id=$pr_id";
             if(Base::generateResult($q) && Sms::prodRejection($reason,$prod_name,$ord_id,$cntc) && Email::prodRejectionEmail($reason,$prod_name,$ord_id,$email,$name))
             $msg="Request for Return Rejected ";  
           
           break;
          
        case 'Accept':
            $prod_name=$_REQUEST['prodname'];
            $ord_id=$_REQUEST['ord'];
            $q.="update prod_return set bs_id=$bs_id, pr_status='Return',pick_date=date_add(now(), interval 1 day), upd_dt=now(),upd_usr='".$_SESSION["user"]."' where pr_id=$pr_id;";
            $q.="insert into delivery(pr_id,d_type,d_date,ins_dt,ins_usr) values ($pr_id,'Return',date_add(now(), interval 1 day),now(),'".$_SESSION["user"]."' );";
            echo $q;
            $slot=$bs_from." - ".$bs_to;
             if(Base::generateMultiResult($q) && Sms::prodAcceptReplace("Return", $prod_name, $slot, $cntc) && Email::prodAcceptReplaceEmail("Return", $prod_name, $slot, $email, $name) && Email::prodAcceptReplaceTagoEmail($pr_id) )
             $msg="Request for Return Accepted";  
           
           break;
          
        case 'Replace':
            $days=Product::getleadtime($prod_id);
            $q.="update prod_return set pr_status='$status',pr_date=date_add(now(), interval $days day), upd_dt=now(),upd_usr='".$_SESSION["user"]."' where pr_id=$pr_id;";
            $q.="insert into delivery(pr_id,d_type,d_date,ins_dt,ins_usr) values ($pr_id,'$status',date_add(now(), interval $days day),now(),'".$_SESSION["user"]."' );";
            echo $q;
            $date=Base::AddDaysinDatedmy($days);
            $slot=$bs_from." - ".$bs_to;
             if(Base::generateMultiResult($q) && Sms::prodReplace($prod_name, $date, $slot, $cntc) && Email::prodReplaceEmail($prod_name, $date, $slot, $email, $name)) // && Sms::prodRejection($reason,$prod_name,$ord_id,$cntc) && Email::prodRejectionEmail($reason,$prod_name,$ord_id,$email,$name))
             $msg="Product accepted for replace";  
           
           break;
          
            
            
    }
    
}


/*if(isset($_REQUEST["submit"])!="") {
    $case=$_REQUEST["submit"];
   if(!empty($_POST['check_list'])) {
// Counting number of checked checkboxes.
$checked_count = count($_POST['check_list']);
echo "You have selected following ".$checked_count." option(s): <br/>";
// Loop to store and display values of individual checked checkbox.
$q="";
foreach($_POST['check_list'] as $selected) {
$q.="update ordertbl set ord_status='Completed',delivery_status='Delivered', delivery_date=now(), upd_dt=now(),upd_usr='".$_SESSION["user"]."' where ord_id=$selected;";
}
echo $q;
if(Base::generateMultiResult( $q)) {
    $msg="Selected orders are delivered";
    }
}
    }
    else
        $msg="Please Select Date to set Order Full!";

/*}
break;

 case "update": {
    if(isset($_REQUEST["ofdate"])!="") {
$date = date_create($_REQUEST["ofdate"]);
$na_date= date_format($date, "Y-m-d");
    }
if(!empty($_POST['check_list'])) {
// Counting number of checked checkboxes.
$checked_count = count($_POST['check_list']);
echo "You have selected following ".$checked_count." option(s): <br/>";
// Loop to store and display values of individual checked checkbox.
$q="";
foreach($_POST['check_list'] as $selected) {
    $selected= explode(",", $selected);
$q.="update prod_date set ord_full_date=cast(N'$na_date' as date) where prod_id=".$selected[0]." and ord_full_date=cast(N'".$selected[1]."' as date);";
}
//echo $q;
if(Base::generateMultiResult( $q)) {
    $msg="Order Full updated to ".$_REQUEST["ofdate"];
    }
}

}
break;

 case "remove" :  {
if(!empty($_POST['check_list'])) {
// Counting number of checked checkboxes.
$checked_count = count($_POST['check_list']);
echo "You have selected following ".$checked_count." option(s): <br/>";
// Loop to store and display values of individual checked checkbox.
$q="";
foreach($_POST['check_list'] as $selected) {
    $selected= explode(",", $selected);
$q.="delete from prod_date where prod_id=".$selected[0]." and ord_full_date=cast(N'".$selected[1]."' as date);";
}
echo $q;
if(Base::generateMultiResult( $q)) {
    $msg="Order Full Removed!";
        }
    }
}
break;
    }
}
else
    $msg="Improper Input!\nTry Again!";*/
        ?>
<script>
        $(document).ready(function() {
            var msg="<?php echo $msg; ?>";
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>"+msg+"</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Base::root(); ?>";
                    window.location.href=root+"OrdersPage";
                });
                });
//alert("Logging Out");
//window.location.href="logout.php";
</script>

<?php
?>
