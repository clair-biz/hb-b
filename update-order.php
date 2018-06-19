<?php
include 'data.php';        

$id=$_REQUEST['id']; //Integer.parseInt(request.getParameter("id"));
$status=$_REQUEST['status']; //Integer.parseInt(request.getParameter("id"));
$reason="";
if(isset($_REQUEST["reason"])!="")
    $reason=$_REQUEST["reason"];

$cat_type="";
switch ($user->home_url) {
    case "ProductsPage" : $cat_type="Product";
        break;
    case "ServicesPage" : $cat_type="Service";
        break;
}

if($cat_type=="Product") {
        $q="update ordertbl set ord_status='".$status."',upd_dt=now(), upd_usr='".$user->u_name."'";
        if($status=="Rejected" || $status=="Canceled")
        $q.=", remark='$reason'";
        
        $q.=" where ord_id=$id;";
        
}
elseif($cat_type=="Service") {
        $q="update serviceordertbl set ord_status='".$status."',upd_dt=now(), upd_usr='".$user->u_name."'";
        if($status=="Rejected" || $status=="Canceled")
        $q.=", remark='$reason'";
        
        $q.=" where ord_id=$id;";
        
}


if(Base::generateResult($q) ) {
    if($status=="Completed")
        if(Email::requestFeedback($id)) {
            echo "ok";
}
else {
    echo "errorc";
}
    elseif($status!="Completed") {
        
if(Email::sendMailtoCustomer($id,$status,$reason,$user->u_name)) {
    
    echo "ok";
}
else {
    echo "errornc";
}
    }
}
else {
    echo "errore";
}

//            echo "<script>window.location.href=window.location.origin+'/OrdersPage'; </script>";
?>