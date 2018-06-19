<html>
<head>
</head>
<body>
<center>
<?php include('Crypto.php')?>
<?php include('../../data.php')?>
<?php 

	error_reporting(0);

	$working_key="CCF562F216E4B5CA9684ACD27C32E30B";//Shared by CCAVENUES
	$access_code="AVLO75EL03BL95OLLB";//Shared by CCAVENUES
	$merchant_data="";
	
	foreach ($_POST as $key => $value){
		$merchant_data.=$key."=".$value."&";
	}
	
	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.

	$production_url="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction&encRequest=".$encrypted_data."&access_code=".$access_code;
?>
    <iframe src="<?php echo $production_url?>" id="paymentFrame" width="482" height="450" style="margin-top: 40px !important;" frameborder="0" scrolling="No" ></iframe>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script type="text/javascript">
    	$(document).ready(function(){
    		 window.addEventListener('message', function(e) {
		    	 $("#paymentFrame").css("height",e.data['newHeight']+'px'); 	 
		 	 }, false);
	 	 	
		});
</script>
</center>

</body>
</html>

