<?php
require_once 'data.php';

$delete_type=$_REQUEST["delete_type"];
switch ($delete_type) {
 case "camp" :
    $camp_id=$_REQUEST["camp_id"];
             if(Campaign::removeCampaign($camp_id)) {
                 echo "success";
        }
        else
            echo "error";

     break;
 case "camp-prod" :
if(isset($_REQUEST["camp_id"])!="" && isset($_REQUEST["type"])!="") {
    $camp_id=$_REQUEST["camp_id"];
    
    if(isset($_REQUEST["prod_id"])!="" && isset($_REQUEST["cs_id"])!="") {
        if(CampProd::removeCampProd($camp_id,$_REQUEST["prod_id"],$_REQUEST["cs_id"])) {
            echo "success";
        }
        else
            echo "error";
    }
        else
            echo "error";
}
        else
            echo "error";
     
     break;
 case "camp-serv" :
if(isset($_REQUEST["camp_id"])!="" && isset($_REQUEST["type"])!="") {
    $camp_id=$_REQUEST["camp_id"];
    
if(isset($_REQUEST["serv_id"])!="" && isset($_REQUEST["cs_id"])!="") {
        if(CampServ::removeCampServ($camp_id,$_REQUEST["serv_id"],$_REQUEST["cs_id"])) {
            echo "success";
            }    
        else
            echo "error";
        }
        else
            echo "error";
    }     
        else
            echo "error";
     break;
}
?>