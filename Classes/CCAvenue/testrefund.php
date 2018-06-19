<?php
 include('Crypto.php');
require_once '../Classes.php';

$array->reference_no="107326303734";
    $array->amount="1.0";
    $obj->order_List=$array;
    $array= json_encode($obj);
    print_r($array);
    
	$working_key="CCF562F216E4B5CA9684ACD27C32E30B";//Shared by CCAVENUES
	$encrypted_data=encrypt("107326303734$1.0",$working_key); // Method for encrypting the data.
	$access_code="AVLO75EL03BL95OLLB";//Shared by CCAVENUES
    
	$data = "enc_request=".$encrypted_data."&access_code=".$access_code."&command=confirmOrder&request_type=STRING&version=1.1";
        echo $data;
        echo "<br />";
	$ch = curl_init('https://login.ccavenue.com/apis/servlet/DoWebTrans?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
        echo "res ".$result;
            return true;
?>