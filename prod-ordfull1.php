<?php
require_once('data.php');
$vs_id=$user->vs_id;


if(isset($_REQUEST["submit"])!="") {
    $case=$_REQUEST["submit"];
    switch($case) {
 case "insert": {
    if(isset($_REQUEST["ofdate"])!="") {
$date = date_create($_REQUEST["ofdate"]);
$na_date= date_format($date, "Y-m-d");
if(!empty($_POST['check_list'])) {
// Counting number of checked checkboxes.
$checked_count = count($_POST['check_list']);
//echo "You have selected following ".$checked_count." option(s): <br/>";
// Loop to store and display values of individual checked checkbox.
$q="";
foreach($_POST['check_list'] as $selected) {
$q.="insert into prod_date(prod_id,ord_full_date) values($selected,cast(N'$na_date' as date) );";
}
//echo $q;
if(Base::generateResult($q)) {
    $msg="Order Full set for ".$_REQUEST["ofdate"];
    }
}
    }
    else
        $msg="Please Select Date to set Order Full!";

}
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
if(Base::generateResult($q)) {
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
if(Base::generateResult($q)) {
    $msg="Order Full Removed!";
        }
    }
}
break;
    }
}
else
    $msg="Improper Input!\nTry Again!";

?>