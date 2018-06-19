<html>
    <body>
<?php
include 'data.php';

$flag=$_REQUEST['flag'];

switch($flag) {
    case "mi" :
$cat=$_REQUEST['micat'];
$cattype=$_REQUEST['micattype'];
        $query="insert into category(cat_name,cat_type) values('$cat','$cattype');";
        echo $query;
        if(Base::generateResult( $query)) {
            $cat_id=Crm::getcatidbycatname($cat);
            
    $query="insert into cat_sub(cs_name,cat_id) values('$cat',$cat_id);";
if(Base::generateResult($query)) {
            $result=1;
   if(!empty($_FILES['file']['name']) && isset($_FILES['file']['name'])) {
//This applies the function to our file  
 $ext = Crm::findexts ($_FILES['file']['name']) ; 
  $img_name="cat_".$cat_id.".".$ext;
//echo $img_name;  
$target_dir = "uploads/category-imgs/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
// Check if file already exists
/*if (file_exists($target_file)) {
            unlink($target_file);
} */
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
//    if(file_exists($target_dir.$img_name))
//            unlink($target_dir.$img_name);
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$img_name)) {
        echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
        $query="update category set cat_img='$img_name' where cat_id=$cat_id;";
if(Base::generateResult($query)) {
    $result=1;
 }
else {
    $result=0;
        echo "Sorry, there was an error uploading your file.";
        } // insert cat img
    }
}
    
}
 
    $result=1;
            

 }
else {
    $result=0;
 } // insert sub cat

        }
else {
    $result=0;
 } // insert cat insert
  if($result==1) {
?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Request Processed!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href="<?php echo $root."AddRatePlan?cat_id=$cat_id"; ?>";
                });
                });
    </script>
<?php
      
  }
  else {
?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Request Process Failed!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"Categories";
                });
                });
//        alert("Request Process Failed");
//        window.location.href="admin-category.php";
    </script>
<?php
      
  }
                
        break;
        
        
    case "mu" :
$cat=$_REQUEST['mucat'];
        $res=1;
//$cattype=$_REQUEST['mucattype'];
            $cat_id=$_REQUEST["mucatid"];
            $cat_name=Crm::getcatnamebycatid($cat_id);
        $query="update category set";
        if(!empty($_REQUEST['mucat']) && !empty($_REQUEST['mucattype'])  )
        $query="update category set cat_name='".$_REQUEST['mucat']."', cat_type='".$_REQUEST['mucattype']."' where cat_id=$cat_id;";
        elseif(empty($_REQUEST['mucat']) && !empty($_REQUEST['mucattype']) )
        $query="update category set cat_type='".$_REQUEST['mucattype']."' where cat_id=$cat_id;";
        elseif(!empty($_REQUEST['mucat']) && empty($_REQUEST['mucattype']))
        $query="update category set cat_name='".$_REQUEST['mucat']."' where cat_id=$cat_id;";

        echo $query;
        if(mysqli_multi_query(Crm::con(), $query)) {
            $res=1;
            if(!empty($_REQUEST["mucat"]))
            $query="update cat_sub set cs_name='".$_REQUEST['mucat']."' where cs_name='".$cat_name."' and cat_id=$cat_id";
            echo $query;
        if(Base::generateResult( $query)) {
            $res=1;
        }
 else {
     $res=0;
 }
        }
        else
            $res=0;
            
   if(!empty($_FILES['file1']['name'])) {
//This applies the function to our file  
 $ext = Crm::findexts ($_FILES['file1']['name']) ; 
  $img_name="cat_".$cat_id.".".$ext;
echo $img_name;  
$target_dir = "uploads/category-imgs/";
$target_file = $target_dir . basename($_FILES["file1"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["file1"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
// Check if file already exists
/*if (file_exists($target_file)) {
 //   echo "Sorry, file already exists.";
//    $uploadOk = 0;
            unlink($target_file);
}*/
// Check file size
if ($_FILES["file1"]["size"] > 1000000) {
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
    $res=0;
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file1"]["tmp_name"], $target_dir.$img_name)) {
        echo "The file ". basename( $_FILES["file1"]["name"]). " has been uploaded.";
        $query="update category set cat_img='$img_name' where cat_id=$cat_id;";
        echo $query;
if(Base::generateResult($query)) {
    $res=1;
}
else {
    $res=0;
}
    }
    else
        $res=0;
}
   }
if($res==1) {
?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Request Processed!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"Categories";
                });
                });
//        alert("Request Processed");
//        window.location.href="admin-category.php";
    </script>
<?php
 }
else {
?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Request Process Failed!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"Categories";
                });
                });
//        echo "Sorry, there was an error uploading your file.";
//        alert("Request Process Failed");
//        window.location.href="admin-category.php";
    </script>
<?php
 } // insert img name
        break;
        
        

    case "md" :
$id=$_REQUEST['mdcatid'];
        $query="delete from category where cat_id=$id;";
//echo $query;
if(Base::generateResult($query)) {
?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Request Processed!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href="http://www.homebiz365.in/Categories";
                });
                });
//        alert("Request Processed");
//        window.location.href="admin-category.php";
    </script>
<?php
 }
else {
?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Request Process Failed!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href="http://www.homebiz365.in/Categories";
                });
                });
//        alert("Request Process Failed");
//        window.location.href="admin-category.php";
    </script>
<?php
 }
        break;
        

    case "si" :
$id=$_REQUEST['sicatid'];
$cat=$_REQUEST['sicat'];
        $query="insert into cat_sub(cs_name,cat_id) values('$cat',$id);";
//echo $query;
if(Base::generateResult($query)) {
?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Request Processed!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href="http://www.homebiz365.in/Categories";
                });
                });
//        alert("Request Processed");
//        window.location.href="admin-category.php";
    </script>
<?php
 }
else {
?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Request Process Failed!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href="http://www.homebiz365.in/Categories";
                });
                });
//        alert("Request Process Failed");
//        window.location.href="admin-category.php";
    </script>
<?php
 }
        break;
        
    case "su" :
$id=$_REQUEST['sucatid'];
$cat=$_REQUEST['sucat'];
        $query="update cat_sub set cs_name='$cat' where cs_id=$id ;";
//        break;
//echo $query;
if(Base::generateResult($query)) {
?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Request Processed!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href="http://www.homebiz365.in/Categories";
                });
                });
//        alert("Request Processed");
//        window.location.href="admin-category.php";
    </script>
<?php
 }
else {
?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Request Process Failed!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href="http://www.homebiz365.in/Categories";
                });
                });
//        alert("Request Process Failed");
//        window.location.href="admin-category.php";
    </script>
<?php
 }
 break;
 
case "sd" :
    $id=$_REQUEST['sdcatid'];
    $query="delete from cat_sub where cs_id=$id;";
    //echo $query;
    if(Base::generateResult($query)) {
        ?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Request Processed!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href="http://www.homebiz365.in/Categories";
                });
                });
//        alert("Request Processed");
//        window.location.href="admin-category.php";
    </script>
<?php
 }
else {
?>
    <script type="text/javascript">
        $(document).ready(function() {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Request Process Failed!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href="http://www.homebiz365.in/Categories";
                });
                });
//        alert("Request Process Failed");
//        window.location.href="admin-category.php";
    </script>
<?php
 }
        break;
 
 
}
?>
    </body>
</html>