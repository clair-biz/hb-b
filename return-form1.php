<?php
require_once 'data.php';

$ord_id=$_REQUEST["ord_id"];
$prod_id=$_REQUEST["prod_id"];
$reason=$_REQUEST["reason"];
$pr_amount=0;
$replacement="N";
$return="N";
foreach($_REQUEST["check_list"] as $option) {
   if($option=="replacement")
       $replacement="Y";
   if($option=="return"){
   $return="Y";
   $pr_amount=Order::getReturnProdAmt($ord_id,$prod_id);
   }
   }
   
   $pr_id=Base::getAIValue("prod_return");
        $q="insert into prod_return(pr_id,ord_id,prod_id,r_id,prod_return,prod_replace,pr_amount,ins_dt,ins_usr) values ($pr_id,".$ord_id.",".$prod_id.",".$reason.",'".$return."','".$replacement."',".$pr_amount.",now(),'".$user->u_name."');";   
//        echo $q;
    if(Base::generateResult($q)){
        //foreach($
    
//    echo $prod_name;
//    echo $subcat;
    //$cat_name=$_REQUEST["cat1"];
    
    $count=0;
   if(isset($_FILES['file']['name'])) {
       $total=count($_FILES['file']['name']);
       $count=$total;
echo $count;
// Loop through each file
for($i=0; $i<$total; $i++) {
  //Get the temp file path
//  $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

//This applies the function to our file  
 $ext = Base::findexts ($_FILES['file']['name'][$i]) ; 
  $img_name=$pr_id."_".$i."_".$prod_id.".".$ext;
  $target_dir = "assets/products-return/";
$target_file = $target_dir . basename($_FILES["file"]["name"][$i]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"][$i]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
/*if (file_exists($target_file)) {
    unlink($target_file);
//    echo "Sorry, file already exists.";
//    $uploadOk = 0;
}*/
// Check file size
if ($_FILES["file"]["size"][$i] > 1000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"][$i], $target_dir.$img_name)) {
        
        echo "The file ". basename( $_FILES["file"]["name"][$i]). " has been uploaded.";
        $q="insert into pr_images(pr_id,pr_img,ins_dt,ins_usr) values ($pr_id,'$img_name',now(),'".$user->u_name."') ;";
//        echo $q;
        if(Base::generateResult( $q))
        $count--;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
    
    }
   }
   
    }
   
      
      if($count==0){
    echo "success";
}
else {
echo "error";
    
}

?> 