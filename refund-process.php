<?php
require_once('header.php');
$vs_id=$_COOKIE["vs_id"];


if(isset($_REQUEST["submit"])!="") {
    $case=$_REQUEST["submit"];
   if(!empty($_POST['check_list'])) {
// Counting number of checked checkboxes.
$checked_count = count($_POST['check_list']);
echo "You have selected following ".$checked_count." option(s): <br/>";
// Loop to store and display values of individual checked checkbox.
$q="";
foreach($_POST['check_list'] as $selected) {
    $query="SELECT wallet_amt,users.u_id,pr_amount,ordertbl.ord_id,prod_name,cust_fname,cust_cntc,cust_email
FROM `prod_return`,users,ordertbl,customer,product
where prod_return.ord_id=ordertbl.ord_id
and customer.cust_id=users.cust_id
and product.prod_id=prod_return.prod_id
and ordertbl.cust_id=customer.cust_id
and users.cust_id=ordertbl.cust_id and pr_id=$selected";
    $res= mysqli_query(Crm::con(), $query);
    $prod_name="";
    $name="";
    $email="";
    $cntc=0;
    if($row= mysqli_fetch_array($res)) {
        $ord_id=$row[3];
        $u_id=$row[1];
        $cntc=$row[6];
        $email=$row[7];
        $name=$row[5];
        $prod_name=$row[4];
        $pr_amount=$row[2];
        $wallet_amt=($row[0])+$pr_amount;
    }
    
$q.="update ordertbl set ord_status='Refunded', upd_dt=now(),upd_usr='".$_SESSION["user"]."' where ord_id=$ord_id;";
$q.="update users set wallet_amt=$wallet_amt, upd_dt=now(),upd_usr='".$_SESSION["user"]."' where u_id=$u_id;";
$q.="update prod_return set pr_returned=$pr_amount,pr_status='Refunded', upd_dt=now(),upd_usr='".$_SESSION["user"]."' where pr_id=$selected;";
Sms::prodRefund($prod_name, $amount, $cntc);
Email::prodRefundAmtEmail($prod_name, $pr_amount, $email, $name);
}
//echo $q;
if(mysqli_multi_query(Crm::con(), $q)) {
    $msg="Selected orders are Refunded!";
    }
}
    }
    else
        $msg="Unable to Refund!";

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
if(mysqli_multi_query(Crm::con(), $q)) {
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
if(mysqli_multi_query(Crm::con(), $q)) {
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
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"Refunds";
                });
                });
//alert("Logging Out");
//window.location.href="logout.php";
</script>

<?php
?>
