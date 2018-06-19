<?php
require_once  'header.php';

$status=$_REQUEST["status"];
$vs_id=$_REQUEST["id"];

if(isset($_REQUEST["main"]))
$cat_id=$_REQUEST['main'];
else
    $cat_id="";

$prev_cat="";
//echo $q;
if(isset($_REQUEST["prev_cat"])!="")
$prev_cat=$_REQUEST["prev_cat"];    

if(isset($_REQUEST["sub"])!="")
$subtotal=$_REQUEST['sub'];
else
    $subtotal="";

if(isset($_REQUEST["fssai"])!="")
$fssai=$_REQUEST['fssai'];
else
    $fssai="";

if(isset($_REQUEST["disc"])!="")
$disc=$_REQUEST['disc'];
else
    $disc="";

if(isset($_REQUEST["total"])!="")
$total=$_REQUEST['total'];
else
    $total="";

if(isset($_REQUEST["tax"])!="")
$tax=$_REQUEST['tax'];
else
    $tax="";

if(isset($_REQUEST["city"])!="")
$city_served=$_REQUEST['city'];
else
    $city_served="";

if(isset($_REQUEST["vname"])!="")
$name=$_REQUEST['vname'];
else
    $name="";

if(isset($_REQUEST["bname"])!="")
$bname=$_REQUEST['bname'];
else
    $bname="";

if(isset($_REQUEST["reason"])!="")
$reason=$_REQUEST['reason'];
else
    $reason="";

$u_id= Vendor::getuidbyvsid($vs_id);
$email=Vendor::getvendemailbyuid($u_id);
$uname=Crm::getunamebyuid($u_id);


if(isset($_REQUEST["for_val"])!="" && isset($_REQUEST["for"])!="") {
$vs_for=$_REQUEST['for_val']." ".$_REQUEST['for'];
}
else
    $vs_for="";

$q="update vend_subscription set ";
if(!empty($cat_id))
$q.="cat_id=$cat_id,";

if(!empty($city_served))
$q.="city_served='$city_served',";

if(!empty($vs_for))
$q.="vs_for='$vs_for',";

if(!empty($subtotal))
$q.="vs_subtotal=$subtotal,";

if(!empty($disc))
$q.="vs_disc=$disc,";

if(!empty($fssai))
$q.="fssai_no='$fssai',";

if(!empty($prev_cat) && $prev_cat!=$cat_id)
$q.="other_cat='$prev_cat',";
elseif(empty($prev_cat) || $prev_cat==$cat_id)
$q.="other_cat=NULL,";

if(!empty($total))
$q.="vs_total=$total,";

if(!empty($tax))
$q.="vs_tax=$tax,";

if($status=="Reject" && !empty($reason)) {
    $q.=" remark='$reason',";
}

if($status=="Enabled" || $status=="Renew") {
//    $vs_for1=$vs_for;
    $vs_for=Crm::annualtoyear($vs_for);
    $vs_for= explode(" ", $vs_for);
    $noofmonths=0;
    if($vs_for[1]=="Year" || $vs_for[1]=="Years")
        $noofmonths=$vs_for[0]*12;
    
    elseif($vs_for[1]=="Half")
        $noofmonths=$vs_for[0]*6;

            
if($status=="Enabled") {
            $date = date_create();
    $todate=date_add($date,date_interval_create_from_date_string("$noofmonths months"));
    $todate=date_format($todate,"Y-m-d");
    $q.="vs_pay_status='$status', vs_from=now(),vs_to=cast(N'$todate' as date), vs_for=NULL,";
}
elseif($status=="Renew") {
    $to=Vendor::getvstodate($u_id);
    $date = date_create($to);
    $todate=date_add($date,date_interval_create_from_date_string("$noofmonths months"));
    $todate=date_format($todate,"Y-m-d");
    $q.="vs_to=cast(N'$todate' as date), vs_for=NULL,";
}

}
elseif($status!="Approve Renewal")
$q.="vs_pay_status='$status',";

$q.="upd_dt=now(), upd_usr='".$_SESSION["user"]."' where vs_id=$vs_id;";

//    echo $q;
if($status!="Enabled") {
    if($status=="Approved") {
        if($prev_cat==0)
            $q.="update vs_cart set cat_id=$cat_id, is_active='Y' where vs_id=$vs_id;";
    }

    if($status=="Approve Renewal")
        $status="Approved for Renewal";
    if($status=="Renew")
        $status="Renewed";

    if(Email::sendSubscriptionDetailsAlternate($name,$email,$uname,$bname,$cat_id,$status,$prev_cat)
        &&  mysqli_multi_query(Crm::con(), $q) && Sms::sendSubscriptionDetails($name,$email,$status) ) {
?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Request Processed!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"AdminDashboard";
                });
                });
//        alert("Request Processed!");
//        window.location.href="admin-dashboard.php";
    </script>
    
    <?php
}
else {
?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Unable to process request!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"AdminDashboard";
                });
                });
//        alert("Unable to Process Request!");
//        window.location.href="admin-dashboard.php";
    </script>
    
    <?php
}

}

elseif($status=="Enabled") {

if(/*Email::enableVendor($name,$email,$uname,$bname,$cat_id,$vs_for)
        &&*/ mysqli_query(Crm::con(), $q) /*&& Sms::sendSubscriptionDetails($name,$email,$status)*/ ) {
?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Request Processed!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"AdminDashboard";
                });
                });
//        alert("Request Processed!");
//        window.location.href="admin-dashboard.php";
    </script>
    
    <?php
}
else {
?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Unable to process request!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"AdminDashboard";
                });
                });
//        alert("Unable to Process Request!");
//        window.location.href="admin-dashboard.php";
    </script>
    
    <?php
}

}

?>