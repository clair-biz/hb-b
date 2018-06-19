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
    echo $selected;
    $selected= explode(",", $selected);
    $q.="update delivery set d_status='Delivered',d_on=now(),upd_dt=now(),upd_usr='".$_SESSION["user"]."'  where d_id=$selected[0]; ";
    if($selected[1]=="Order")
$q.="update ordertbl set ord_status='Completed',delivery_status='Delivered', delivery_date=now(), upd_dt=now(),upd_usr='".$_SESSION["user"]."' where ord_id=$selected[2];";
    elseif($selected[1]=="Return")
$q.="update prod_return set pr_status='Returned',ds_status='Delivered', upd_dt=now(),upd_usr='".$_SESSION["user"]."' where pr_id=$selected[2];";
}
echo $q;
if(mysqli_multi_query(Crm::con(), $q)) {
    $msg="Selected orders are delivered";
    }
}
    }
    else
        $msg="Unable to Update Delivery Status!";

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
                    window.location.href=root+"Delivery";
                });
                });
//alert("Logging Out");
//window.location.href="logout.php";
</script>

<?php
?>
