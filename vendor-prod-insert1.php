<?php
require_once 'data.php';

    $prod_name = $_REQUEST["pname"];


    $prod_desc = $_REQUEST["pdesc"];
    $subcat = $_REQUEST["subcat"];

    $prod_qty = $_REQUEST["qty"];
    $prod_unit= $_REQUEST["unit"];
    if(isset($_REQUEST["min_time_val"])!="" && !empty($_REQUEST["min_time_val"]) )
    $prod_min_time= $_REQUEST["min_time_val"];//." ".$_REQUEST["min_time"];
    else
        $prod_min_time="";
    
//    echo "-$prod_min_time-";
    $mrp =$_REQUEST["base_prc"];
    $mrpfor =$_REQUEST["qty"];
    $unitfor =$_REQUEST["unit"];
    $replacement="N";
    $return="N";
    $r_within=0;
   // $weight =$_REQUEST["weight"]." ".$_REQUEST["weight_unit"];
  // $mrp =$_REQUEST["base"];
   $sell_prc =0;//$_REQUEST["sp"];
   if(isset($_REQUEST["check_list"])!="") {
   foreach($_REQUEST["check_list"] as $option) {
   if($option=="replacement")
       $replacement="Y";
   if($option=="return")
       $return="Y";
   }
   }
   if(isset($_REQUEST["within"])!="" && !empty($_REQUEST["within"]))
       $r_within=$_REQUEST["within"];
   
   if(isset($_REQUEST["hsn"])!="" && !empty($_REQUEST["hsn"]))
       $hsn_code=$_REQUEST["hsn"];
   else
    $hsn_code = 0;
    //$sgst = $_REQUEST["sgst"];
    
    $delivery=$_REQUEST["deli"];

    $area_served="";
    if($_REQUEST["area"]!="")
        $area_served=$_REQUEST["area"];

    //$other = $_REQUEST["other"];
    $cat_name="";
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
    
//    echo $prod_name;
//    echo $subcat;
    //$cat_name=$_REQUEST["cat1"];
    
    
	$vs_id=$user->vs_id;
	$vend_name=$user->u_name;
    //String vend_cat="";
    $cc=0;
//echo $file;
//$user=$vend_fname+" "+$vend_lname;
 $m=new Product();
$m->prod_name=$prod_name;
$m->prod_desc=$prod_desc;
$m->cs_id=$subcat;
$m->prod_min_time=$prod_min_time;
$m->prod_unit=$prod_unit;
$m->prod_qty=$prod_qty;
//$m->weight=$weight;
$m->is_delivery_provided=$delivery;
$m->area_served=$area_served;
$m->vs_id=$vs_id;
$m->hsn_code=$hsn_code;
$m->prod_replace=$replacement;
$m->prod_return=$return;
$m->r_within=$r_within;
$m->user=$vend_name;
//out.print(m.toString());
//if($m->canInsert())
//    $cc=$m->Insert();
if($m->insert()){
   $prod_id=Product::getprodidbyname($prod_name);
   
   if(isset($_FILES['file']['name'])) {
//This applies the function to our file  
 $ext = Base::findexts ($_FILES['file']['name']) ; 
  $img_name="product_".$prod_id.".".$ext;
  $target_dir = "assets/products-services/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
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
// Check if file already exists
/*if (file_exists($target_file)) {
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
        Base::generateResult( "update product set prod_img='$img_name' where prod_id=$prod_id");
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
    
   }
//echo "mrp-$mrp-";
$formajor= ProductPrice::calformajor($mrp, $mrpfor, $unitfor);
     // $n=new ProductPrice($prod_id,$mrp,$mrpfor,$unitfor,$formajor,$base_prc,$sell_prc,$cgst,$sgst,0,$vend_name);
$n=new ProductPrice();
$n->prod_id=$prod_id;
$n->base_prc=$base_prc;
$n->mrp=$mrp;//$n->calpricewithtax();
$n->mrpfor=$mrpfor;
$n->unitfor=$unitfor;
$n->formajor=$formajor;
$n->sell_prc=$sell_prc;
//$n->cgst=$cgst;
//$n->sgst=$sgst;
$n->user=$vend_name;
      
      if($n->insert())
          echo "success";

      else 
          echo "error";
}
else 
    echo "nothing";
?> 