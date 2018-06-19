<html>
    <head>
        <?php require_once 'stylesheets.html';?>
    </head>
<body>
<section class="body" >
    <section class="preloader" ></section>
    <section class="content" >
<?php
require_once 'data.php';
    
//Statement stmtcat=packcrm.Crm.con().createStatement();    
$cat=Base::generateResult("select * from category where cat_id<>0;");  
$cat1=Base::generateResult("select * from cat_sub,category where category.cat_id=cat_sub.cat_id and cs_name<>cat_name and cs_id<>0;");  
//Statement stmtvend=packcrm.Crm.con().createStatement();    
//$vend=Base::generateResult("select vend_id,vend_fname,from_date,to_date,reg_status,category.cat_name,area_served from vendor,category where category.cat_id=vendor.cat_id and vend_id<>0;");  
//Statement stmtcat111=packcrm.Crm.con().createStatement();    
//$cat111=Base::generateResult("select vend_id,vend_fname,vend_lname,vend_cntc,vend_alt_cntc,vend_email,vend_addr,vendor.loc_zip,vend_open_time,vend_close_time,shutdown_flag,shutdown_date,from_date,to_date,category.cat_main,area_served from vendor,category where category.cat_id=vendor.category and vend_id<>0;");  

?>
    <div class="container-fluid" style="margin-top: 40px;">
         <div class="row">
                <div class="col-md-2 col-lg-2 d-none d-md-block">
                    <?php
                    require 'admin-menu.php'; 
                    ?>
                    </div>

        <div class="card-panel col-lg-10  col-md-10">
        <!-- Navigation -->
        <div class="row">
        <div class="col-lg-8 col-md-8">
    <h5 id="title" class="page-header text-center">Category Add/Update/Delete</h5>
    <div class="row" >  
            <p class="col-md-4 col-lg-4 col-sm-4  text-right">Select <font style="color:red">*</font>:</p>
        <div class="col-md-6 col-lg-6 col-sm-6 form-group">
                <select class="form-control" id="selid" name="selid" >
                    <option selected="true" value="" disabled="">-Select-</option>
                    <option value="1">Add/Insert Category</option>
                    <option value="2">Update Category</option>
                    <option value="5">Delete Category</option>
                    <option value="3">Add/Insert Sub Category</option>
                    <option value="4">Update Sub Category</option>
                    <option value="6">Delete Sub Category</option>

                </select>
        </div>
  </div>

    <div id="catinsert" class="container-fluid cats">
    <div class="row col-md-10 col-lg-10 col-sm-12 offset-md-1 ">
        <h5 class="text-center container-fluid" style="font-size: 16px;">New Category</h5>
        <form class="form-horizontal" id="main-insert" action="category-process.php" method="post" enctype="multipart/form-data">
        
                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4  text-right">Category Name <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group">
            <input type="text" class="form-control" autocomplete="off" autofocus id="micat" name="micat" required />
        </div>
      </div>
 
                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4  text-right">Category Type <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group">
                <select class="form-control" id="micattype" name="micattype" >
                    <option selected value="" >-Select-</option>
                    <option value="Product" >Product</option>
                    <option value="Service" >Service</option>
                </select>
        </div>
      </div>

                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4  text-right">Category Image <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8  form-group">
            <input type="file" id="file" name="file" class="form-control">
      </div>
      </div>
           
        <div class="row text-center justify-content-center container-fluid">
                <button type="submit" name="flag" value="mi" id="mi" class="btn waves-effect waves-light col-md-4 text-center container-fluid ">Next
                </button>
        </div>
      </form>
    </div>
  </div>
    
    <div id="catupdate" class="container-fluid cats" >
    <div class="row col-md-10 col-lg-10 col-sm-12 offset-md-1 ">
        <h5 class="text-center container-fluid" style="font-size: 16px;">Update Category</h5>
    <form action="category-process.php" id="main-update" method="post" class="form-horizontal" enctype="multipart/form-data">


                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4  text-right">Category Type <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 ">
            <select class="form-control" id="mucatid" autofocus name="mucatid" required>
      <option value="" disabled selected>Choose your option</option>

                <?php
            while($row = mysqli_fetch_array($cat)) {
                    ?>
                    <option value="<?php echo $row[0];  ?>"><?php echo $row[1];  ?></option>
                    <?php
                    }
//zip.close();
//stmtzip.close();
                    ?>
    </select>
    </div>
    </div>
        <div id="displayCustom" style="display:none !important;">
                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4  text-right">Category Name:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group">
            <input type="text" class="form-control" autofocus="" autocomplete="off" id="mucat" name="mucat" />
        </div>
      </div>
   
                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4  text-right">Category Type <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 ">
                <select class="form-control" id="mucattype" name="mucattype" >
                    <option selected="true" value="" disabled="">-Select-</option>
                    <option value="Product" >Product</option>
                    <option value="Service" >Service</option>
                </select>
        </div>
      </div>


                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4  text-right">Category Image <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8  form-group">
            <input type="file" id="file1" name="file1" class="form-control">
      </div>
      </div>
    
     <div class="row text-center container-fluid">
                <button type="submit" name="flag" value="mu" class="btn waves-effect waves-light text-center container-fluid"  style="margin-bottom: 75px; margin-left: auto; margin-right: auto; display: block; margin-bottom: 75px;">Submit
                <i class="material-icons right">send</i>
                </button>
    
        </div>       
        </div>
    </form>
      </div>
  </div>

    <div id="catdelete" class="container-fluid cats " >
    <div class="row col-md-10 col-lg-10 col-sm-12 offset-md-1 ">
        <h5 class="text-center container-fluid" style="font-size: 16px;">Delete Category</h5>
    <form action="category-process.php" id="main-delete" method="post" class="form-horizontal" >

                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4  text-right">Select Category <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 ">
        <select class="form-control" autofocus id="mdcatid" name="mdcatid" required>
      <option value="" disabled selected>Choose your option</option>

                <?php
                mysqli_data_seek($cat, 0);
            while($row = mysqli_fetch_array($cat)) {
                    ?>
                    <option value="<?php echo $row[0];  ?>"><?php echo $row[1];  ?></option>
                    <?php
                    }
//zip.close();
//stmtzip.close();
                    ?>
    </select>
    </div>
                </div>
     <div class="row text-center container-fluid">
                <button type="submit" name="flag" value="md" class="btn waves-effect waves-light text-center container-fluid" style="margin-bottom: 75px;">Submit
                <i class="material-icons right">send</i>
                </button>
    
        </div>
    </form>
      </div>
  </div>

    <div id="scatinsert" class="container-fluid cats" >
    <div class="row col-md-10 col-lg-10 col-sm-12 offset-md-1 ">
        <h5 class="text-center container-fluid" style="font-size: 16px;">New Sub Category</h5>
    <form action="category-process.php" id="sub-insert" method="post" class="form-horizontal">


                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4  text-right">Select Main Category <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 ">
        <select class="form-control" id="sicatid" autofocus name="sicatid" required>
      <option value="" disabled selected>Choose your option</option>

                <?php
             mysqli_data_seek($cat, 0);
                while($row = mysqli_fetch_array($cat)) {
                    ?>
                    <option value="<?php echo $row[0];  ?>"><?php echo $row[1];  ?></option>
                    <?php
                    }
//zip.close();
//stmtzip.close();
                    ?>
    </select>
        </div>
    </div>
        <div id="displayCustom2" style="display:none !important;">
                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4  text-right">Select Main Category <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group">
            <input type="text" class="form-control" autofocus autocomplete="off" id="sicat" name="sicat" required />
        </div>
                </div>
   
        <div class="row text-center container-fluid">
       
                <button type="submit" name="flag" value="si" class="btn waves-effect waves-light" style="margin-bottom: 75px;">Submit
                <i class="material-icons right">send</i>
                </button>
        </div>    
            
        </div>
    </form>
    </div>
        </div>
    
    <div id="scatupdate" class="container-fluid cats" >
    <div class="row col-md-10 col-lg-10 col-sm-12 offset-md-1 ">
        <h5 class="text-center container-fluid" style="font-size: 16px;">Update Sub-Category</h5>
    <form action="category-process.php" id="sub-update" method="post" class="form-horizontal">

                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4  text-right">Select Sub Category <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 ">
            <select class="form-control" autofocus id="sucatid" name="sucatid" required>
      <option value="" disabled selected>Choose your option</option>

                <?php
             //mysqli_data_seek($cat, 0);
                while($row = mysqli_fetch_array($cat1)) {
                    ?>
                    <option value="<?php echo $row[0];  ?>"><?php echo $row[1];  ?></option>
                    <?php
                    }
//zip.close();
//stmtzip.close();
                    ?>
    </select>
        </div>
    </div>
        <div id="displayCustom1" style="display:none !important;">

                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4  text-right">Sub Category Name <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group" data-parent="#displayCustom1"> 
            <input type="text" class="form-control" autofocus autocomplete="off" id="sucat" name="sucat" required />
        </div>
                </div>
            
           <div class="row text-center container-fluid">
                <button type="submit" name="flag" value="su" class="btn waves-effect waves-light" style="margin-bottom: 75px;">Submit
                <i class="material-icons right">send</i>
                </button>
        </div>  
     </div>
    </form>
    </div>
      </div>
  
  
  
    <div id="scatdelete" class="container-fluid cats" >
    <div class="row col-md-10 col-lg-10 col-sm-12 offset-md-1 ">
        <h5 class="text-center container-fluid" style="font-size: 16px;">Delete Sub-Category</h5>
    <form action="category-process.php" id="sub-delete" method="post" class="form-horizontal" >

                <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4  text-right">Select Sub Category <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 ">
        <select class="form-control" autofocus id="sdcatid" name="sdcatid" required>
      <option value="" disabled selected>Choose your option</option>

                <?php
                mysqli_data_seek($cat1, 0);
                while($row = mysqli_fetch_array($cat1)) {
                    ?>
                    <option value="<?php echo $row[0];  ?>"><?php echo $row[1];  ?></option>
                    <?php
                    }
                    ?>
    </select>
    </div>
                </div>
     <div class="row text-center container-fluid">
                <button type="submit" name="flag" value="sd" class="btn waves-effect waves-light text-center container-fluid" style="margin-bottom: 75px;">Submit
                <i class="material-icons right">send</i>
                </button>
    
        </div>
    </form>
      </div>
  </div>
    
        </div>
        </div>
</div>
    </div>
    </div>
      </section>    
      <section class="footer" style="margin-top: 10px !important; width: auto !important;" ></section>
      
</section>
<?php
require_once 'scripts.html';
?>
    
    </body>
</html>