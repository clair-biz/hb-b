<?php
//error_reporting(0);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$root="http://".$_SERVER["SERVER_NAME"]."/";
$city=$_COOKIE["city"];

require_once 'validate_user_server.php';
$is_valid=validate_User($_SERVER["REQUEST_URI"]);
//echo $is_valid;
//echo "<script>console.log('is_valid".$is_valid."');</script>";
if(strstr($is_valid,"false")) {
//echo "<script>console.log('is_valid".$is_valid."');</script>";
//    header("location:".$root."Logout");
//       echo "<script>window.location.href='".$root."Logout';</script>";
//   exit();
   }
//   else {
spl_autoload_register(function ($class) {
    include 'Classes/' . $class . '.php';
});


$user="";   
if(isset($_SESSION["user"])!="")
    $user= json_decode ($_SESSION["user"]);

//echo "<script>console.log(".$_SESSION["user"].");</script>";
$strprodcat="SELECT distinct cat_id,cat_name,cat_img FROM category where cat_type='Product' and category.cat_id<>0 order by cat_name;";

$strservcat="SELECT distinct cat_id,cat_name,cat_img FROM category where cat_type='Service' and category.cat_id<>0 order by cat_name;";

$productCategoryList=Base::generateResult($strprodcat);
$serviceCategoryList=Base::generateResult($strservcat);
//$productCategoryList=$obj->productCategoryList();
//$serviceCategoryList=$obj->serviceCategoryList();
//   }
?>