<?php
require_once 'data.php';
       // SimpleDateFormat s=new SimpleDateFormat("yyyy-MM-dd");
       // SimpleDateFormat d=new SimpleDateFormat("dd/MM/yyyy");

    $serv_id = $_REQUEST["serv"];
$count=0;

   if(!empty($_FILES['file']['name'])) {
//This applies the function to our file  
 $ext = Base::findexts ($_FILES['file']['name']) ; 
  $img_name="service_".$serv_id.".".$ext;
  $target_dir = "assets/products-services/";
$target_file = basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
/*
// Check if file already exists
if (file_exists($target_file)) {
    unlink($target_file);
//    echo "Sorry, file already exists.";
//    $uploadOk = 0;
}*/
// Check file size
if ($_FILES["file"]["size"] > 1000000) {
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
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$img_name)) {
        
        echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
        $q="update service set serv_img='$img_name' where serv_id=$serv_id";
//        echo $q;
        if(Base::generateResult( $q))
                $count++;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
    
   }

   if(!empty($_FILES['file1']['name'])) {
//This applies the function to our file  
 $ext = Base::findexts ($_FILES['file1']['name']) ; 
  $img_name="service_".$serv_id.".".$ext;
  $target_dir = "assets/service-pdf/";
$target_file = basename($_FILES["file1"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file1"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
/*
// Check if file already exists
if (file_exists($target_file)) {
    unlink($target_file);
//    echo "Sorry, file already exists.";
//    $uploadOk = 0;
}*/
// Check file size
if ($_FILES["file1"]["size"] > 50000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "doc" && $imageFileType != "docx" && $imageFileType != "pdf"
&& $imageFileType != "gif" && $imageFileType != "txt") {
    echo "Sorry, only DOC, DOCX, PDF, JPG, JPEG, PNG, TXT & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file1"]["tmp_name"], $target_dir.$img_name)) {
        
        echo "The file ". basename( $_FILES["file1"]["name"]). " has been uploaded.";
        $q="update service set serv_file='$img_name' where serv_id=$serv_id";
//        echo $q;
        if(Base::generateResult( $q))
                $count++;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
    
}
    $serv_name= $_REQUEST["sname"];
    $serv_desc = $_REQUEST["sdesc"];
//    $user =$_SESSION["user"];
    $subcat=0;
    if(isset($_REQUEST["subcat"]) && $_REQUEST["subcat"]!="0")
    $subcat=$_REQUEST["subcat"];
    elseif(isset($_REQUEST["subcat"]) && $_REQUEST["subcat"]=="0" && isset($_REQUEST["cat1"])){
     $cat_name=$_REQUEST["cat1"];

        $q="insert into cat_sub(cs_name,cat_id) values ('$cat_name',". Vendor::getcatidbyvsid($user->vs_id).");";   
//        echo $q;
    if(Base::generateResult($q)){
        $subcat=Base::getcsidbycsname($cat_name);
    }
        
    }
    $cc=0;
 $m=new Service();
 $m->serv_name=$serv_name;
 $m->serv_desc=$serv_desc;
 $m->cs_id=$subcat;
 $m->area=$area;
 $m->user=$user->u_name;
//$user=$vend_fname+" "+$vend_lname;

    //$n=new ProductPrice($prod_id,$mrp,$base_prc,$sell_prc,$cgst,$sgst,$other,$user);
//out.print(m.toString());
//if($m->canInsert())
//    $cc=$m->Insert();
//    echo $n->update();
$count+=$m->update($serv_id);
//echo $count;
if($count>=1){
    echo "success";
}
else {
echo "error";

}
?> 