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
$query="select * from category where cat_id<>0;"; 
$cat=Base::generateResult($query);

$query="select * from cat_sub,category where category.cat_id=cat_sub.cat_id and cs_name<>cat_name and cs_id<>0;"; 
$cat1=Base::generateResult($query);


//Statement stmtvend=packcrm.Crm.con().createStatement();    
//$vend=mysqli_query(Crm::con(),"select vend_id,vend_fname,from_date,to_date,reg_status,category.cat_name,area_served from vendor,category where category.cat_id=vendor.cat_id and vend_id<>0;");  
//Statement stmtcat111=packcrm.Crm.con().createStatement();    
//$cat111=mysqli_query(Crm::con(),"select vend_id,vend_fname,vend_lname,vend_cntc,vend_alt_cntc,vend_email,vend_addr,vendor.loc_zip,vend_open_time,vend_close_time,shutdown_flag,shutdown_date,from_date,to_date,category.cat_main,area_served from vendor,category where category.cat_id=vendor.category and vend_id<>0;");  

?>
    <div class="container-fluid row" style="margin-top: 40px;">
         <div class="row">
                <div class="col-md-2 col-lg-2 d-sm-none d-md-block">
                    <?php
                    require 'admin-menu.php'; 
                    ?>
                    </div>

            <div class="col-lg-10  col-md-10">
        <div class="card ">
        <!-- Navigation -->
<!-- Nav tabs -->
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#home">Categories</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#catinsert">Add Category</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#catupdate">Update Category</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#catdelete">Delete Category</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#scatinsert">Add Sub Category</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#scatupdate">Update Sub Category</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#scatdelete">Delete Sub Category</a>
  </li>
</ul>            

<div class="tab-content" >
    <div id="catinsert" class="container tab-pane fade">
    <div class="row col-md-10 col-sm-12 offset-md-1">
        <h5 class="text-center" style="font-size: 16px;">New Category</h5>
        <form class="form-horizontal" id="main-insert" action="category-process.php" method="post" enctype="multipart/form-data">
        
                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Category Name <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8 form-group">
            <input type="text" class="form-control" autocomplete="off" autofocus id="micat" name="micat" required />
            <label for="micat">Category Name <font style="color:red">*</font>:</label>
        </div>
      </div>
 
                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Category Type <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8">
            <label for="cat">Category Type <font style="color:red">*</font>: </label>
                <select class="form-control" id="micattype" name="micattype" >
                    <option selected value="" >-Select-</option>
                    <option value="Product" >Product</option>
                    <option value="Service" >Service</option>
                </select>
        </div>
      </div>

                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Category Image <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8 custom-file">
            <div class="chip">
        <span>Image</span>
        <input type="file" class="custom-file-input" id="file" name="file">
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate" type="text" placeholder="Upload Image" >
      </div>
    </div>
      </div>
           
        <div class="row text-center">
                <button type="submit" name="flag" value="mi" id="mi" class="btn waves-effect waves-light text-center" style="margin-bottom: 75px; margin-left: auto; margin-right: auto; display: block; margin-bottom: 75px;">Next
                <i class="material-icons right">send</i>
                </button>
        </div>
      </form>
    </div>
  </div>
    
    <div id="catupdate" class="container-fluid" hidden>
    <div class="row col-lg-10 col-md-10 col-sm-12 col-lg-offset-1 col-md-offset-1">
        <h5 class="text-center" style="font-size: 16px;">Update Category</h5>
    <form action="category-process.php" id="main-update" method="post" class="form-horizontal" enctype="multipart/form-data">


                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Category Type <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8">
            <label for="mucatid">Select Category <font style="color:red">*</font>:</label>
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
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Category Name:</p>
        <div class="col-lg-8 col-md-8 col-sm-8 form-group">
            <input type="text" class="form-control" autofocus="" autocomplete="off" id="mucat" name="mucat" />
            <label for="mucat">Category Name<font style="color:red">*</font>:</label>
        </div>
      </div>
   
                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Category Type <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8">
            <label for="cat">Category Type:</label>
                <select class="form-control" id="mucattype" name="mucattype" >
                    <option selected="true" value="" disabled="">-Select-</option>
                    <option value="Product" >Product</option>
                    <option value="Service" >Service</option>
                </select>
        </div>
      </div>

                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Category Type <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8 custom-file">
            <div class="chip">
        <span>Image</span>
        <input type="file" class="custom-file-input" id="file1" name="file1">
      </div>
      <div class="file-path-wrapper">
          <input class="file-path validate" type="text" placeholder="Upload file" >
      </div>
    </div>
  </div>
    
     <div class="row text-center">
                <button type="submit" name="flag" value="mu" class="btn waves-effect waves-light text-center"  style="margin-bottom: 75px; margin-left: auto; margin-right: auto; display: block; margin-bottom: 75px;">Submit
                <i class="material-icons right">send</i>
                </button>
    
        </div>       
        </div>
    </form>
      </div>
  </div>

    <div id="catdelete" class="container-fluid" hidden>
    <div class="row col-lg-10 col-md-10 col-sm-12 col-lg-offset-1 col-md-offset-1">
        <h5 class="text-center" style="font-size: 16px;">Delete Category</h5>
    <form action="category-process.php" id="main-delete" method="post" class="form-horizontal" >

                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Select Category <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8">
        <label for="mucatid">Select Category <font style="color:red">*</font>:</label>
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
     <div class="row text-center">
                <button type="submit" name="flag" value="md" class="btn waves-effect waves-light text-center" style="margin-bottom: 75px;">Submit
                <i class="material-icons right">send</i>
                </button>
    
        </div>
    </form>
      </div>
  </div>

    <div id="scatinsert" class="container-fluid" hidden>
    <div class="row col-lg-10 col-md-10 col-sm-12 col-lg-offset-1 col-md-offset-1">
        <h5 class="text-center" style="font-size: 16px;">New Sub Category</h5>
    <form action="category-process.php" id="sub-insert" method="post" class="form-horizontal">


                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Select Main Category <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8">
        <label for="sicatid">Select Main Category <font style="color:red">*</font>:</label>
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
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Select Main Category <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8 form-group">
            <input type="text" class="form-control" autofocus autocomplete="off" id="sicat" name="sicat" required />
            <label for="cat">Sub-Category Name <font style="color:red">*</font>:</label>
        </div>
                </div>
   
        <div class="row text-center">
       
                <button type="submit" name="flag" value="si" class="btn waves-effect waves-light" style="margin-bottom: 75px;">Submit
                <i class="material-icons right">send</i>
                </button>
        </div>    
            
        </div>
    </form>
    </div>
        </div>
    
    <div id="scatupdate" class="container-fluid" hidden>
    <div class="row col-lg-10 col-md-10 col-sm-12 col-lg-offset-1 col-md-offset-1">
        <h5 class="text-center" style="font-size: 16px;">Update Sub-Category</h5>
    <form action="category-process.php" id="sub-update" method="post" class="form-horizontal">

                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Select Sub Category <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8">
            <label for="sucat">Select Sub-Category <font style="color:red">*</font>:</label>
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
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Sub Category Name <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8 form-group" data-parent="#displayCustom1"> 
            <input type="text" class="form-control" autofocus autocomplete="off" id="sucat" name="sucat" required />
            <label for="sucat">Sub-Category Name<font style="color:red">*</font>:</label>
        </div>
                </div>
            
           <div class="row text-center">
                <button type="submit" name="flag" value="su" class="btn waves-effect waves-light" style="margin-bottom: 75px;">Submit
                <i class="material-icons right">send</i>
                </button>
        </div>  
     </div>
    </form>
    </div>
      </div>
  
  
  
    <div id="scatdelete" class="container-fluid" hidden>
    <div class="row col-lg-10 col-md-10 col-sm-12 col-lg-offset-1 col-md-offset-1">
        <h5 class="text-center" style="font-size: 16px;">Delete Sub-Category</h5>
    <form action="category-process.php" id="sub-delete" method="post" class="form-horizontal" >

                <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Select Sub Category <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8">
        <label for="sdcatid">Select sub-Category <font style="color:red">*</font>:</label>
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
     <div class="row text-center">
                <button type="submit" name="flag" value="sd" class="btn waves-effect waves-light text-center" style="margin-bottom: 75px;">Submit
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
    
    <script>
        
        $("#selid").change(function() {
           selected=$(this).val();

        switch(selected) {
               case '1':
                        $("#title").html("Add Category");
                        $("#catinsert").show();
                        $("#micat").focus();
                        $("#catupdate").hide();
                        $("#scatinsert").hide();
                        $("#scatupdate").hide();
                        $("#catdelete").hide();
                        $("#scatdelete").hide();
                               break;
               case '2':
                        $("#title").html("Update Category");
                        $("#catinsert").hide();
                        $("#catupdate").show();
                        $("#mucatid").focus();
                        $("#scatinsert").hide();
                        $("#scatupdate").hide();
                        $("#catdelete").hide();
                        $("#scatdelete").hide();
                               break;
               case '3':
                        $("#title").html("Add Sub-Category");
                        $("#catinsert").hide();
                        $("#catupdate").hide();
                        $("#scatinsert").show();
                         $("#sicatid").focus();
                       $("#scatupdate").hide();
                        $("#catdelete").hide();
                        $("#scatdelete").hide();
                               break;
               case '4':
                        $("#title").html("Update Sub-Category");
                        $("#catinsert").hide();
                        $("#catupdate").hide();
                        $("#scatinsert").hide();
                        $("#scatupdate").show();
                        $("#sucatid").focus();
                        $("#catdelete").hide();
                        $("#scatdelete").hide();
                               break;
               case '5':
                        $("#title").html("Delete Category");
                        $("#catinsert").hide();
                        $("#catupdate").hide();
                        $("#scatinsert").hide();
                        $("#scatupdate").hide();
                        $("#catdelete").show();
                        $("#mdcatid").focus();
                        $("#scatdelete").hide();
                               break;
               case '6':
                        $("#title").html("Delete Sub-Category");
                        $("#catinsert").hide();
                        $("#catupdate").hide();
                        $("#scatinsert").hide();
                        $("#scatupdate").hide();
                        $("#catdelete").hide();
                        $("#scatdelete").show();
                        $("#sdcatid").focus();
                               break;
               default:
                        $("#title").html("Category Add/Update/Delete");
                        $("#catinsert").hide();
                        $("#catupdate").hide();
                        $("#scatinsert").hide();
                        $("#scatupdate").hide();
                        $("#catdelete").hide();
                        $("#scatdelete").hide();
                               break;
           }
        });
        $("#mucatid").change(function() {
           selected=$(this).val();
           switch(selected) {
               case '': $("#displayCustom").hide();
                               break;
               default : $("#displayCustom").show();
                            $("#mucat").focus();
                   break;
           }
        });
        $("#sucatid").change(function() {
           selected=$(this).val();
           switch(selected) {
               case '': $("#displayCustom1").hide();
                               break;
               default : $("#displayCustom1").show();
                        $("#sucat").focus();
                   break;
           }
        });
        $("#sicatid").change(function() {
           selected=$(this).val();
           switch(selected) {
               case '': $("#displayCustom2").hide();
                               break;
               default : $("#displayCustom2").show();
                        $("#sicat").focus();
                   break;
           }
        });


        $.validator.addMethod("mucatchk", function(value, element) {
        	var ret=true;
          // allow any non-whitespace characters as the host part
         if($("#mucatid").val().length>0 && value.length>0) {
              var mucatid=$("#mucatid").val();
              var data="mucatid="+mucatid+"&mucat="+value;
//              console.log("data "+data);

              ret=function() {
                  var tmp=null;
        			$.ajax({
        			async: false,
        			type : 'POST',
        			url  : 'admin-category-vald.php',
        			data : data,
        			success : function(response) {
//                                     console.log("response-"+response+"-");
                                     if(response.search("true")!==-1)
                                        tmp=true;
                                     else
                                        tmp=false;
                            		}
          					});
        				return tmp;
                    }();
        	 }
//         		console.log("return "+ret);
        	 return ret;
        }, 'Please enter a Valid Email Address.');

        $.validator.addMethod("sicatchk", function(value, element) {
        	var ret=true;
          // allow any non-whitespace characters as the host part
         if($("#sicatid").val().length>0 && value.length>0) {
              var sicatid=$("#sicatid").val();
              var data="sicatid="+sicatid+"&sicat="+value;
//              console.log("data "+data);

              ret=function() {
                  var tmp=null;
        			$.ajax({
        			async: false,
        			type : 'POST',
        			url  : 'admin-category-vald.php',
        			data : data,
        			success : function(response) {
//                                     console.log("response-"+response+"-");
                                     if(response.search("true")!==-1)
                                        tmp=true;
                                     else
                                        tmp=false;
                            		}
          					});
        				return tmp;
                    }();
        	 }
//         		console.log("return "+ret);
        	 return ret;
        }, 'Please enter a Valid Email Address.');

        $.validator.addMethod("sucatchk", function(value, element) {
        	var ret=true;
          // allow any non-whitespace characters as the host part
         if($("#sucatid").val().length>0 && value.length>0) {
              var sucatid=$("#sucatid").val();
              var data="sucatid="+sucatid+"&sucat="+value;
//              console.log("data "+data);

              ret=function() {
                  var tmp=null;
        			$.ajax({
        			async: false,
        			type : 'POST',
        			url  : 'admin-category-vald.php',
        			data : data,
        			success : function(response) {
//                                     console.log("response-"+response+"-");
                                     if(response.search("true")!==-1)
                                        tmp=true;
                                     else
                                        tmp=false;
                            		}
          					});
        				return tmp;
                    }();
        	 }
//         		console.log("return "+ret);
        	 return ret;
        }, 'Please enter a Valid Email Address.');

        
        $( document ).ready( function () {

    		$( "#main-insert" ).validate( {
				rules: {
					micattype : "required",
					micat: {
                           required: true,
                           namechkw: true,
                           remote:{
                           			url:"admin-category-vald.php",
                                    type:"post"
                                    }
                          }
				},
				messages: {
					micattype: "Please select Category Type!",
					micat: {
                                           required: "Please enter Category",
                                           namechkw: "Please enter Alphabets Only",
                                           remote: "The category already exist!"
                                        }
					
				},
		         errorElement : 'em',
		         errorPlacement: function(error, element) {
		           var placement = $(element).data('error');
		           if (placement) {
		             $(placement).append(error);
		           } else {
		             error.insertAfter(element);
		           }
		         }
    });


    		$( "#main-update" ).validate( {
				rules: {
					mucat: {
						mucatchk: true
					}
				},
				messages: {
					mucat: {
                                           mucatchk: "The category already exist!"
                                        }
					
				},
		         errorElement : 'em',
		         errorPlacement: function(error, element) {
		           var placement = $(element).data('error');
		           if (placement) {
		             $(placement).append(error);
		           } else {
		             error.insertAfter(element);
		           }
		         }
    });

    		$( "#main-delete" ).validate( {
				rules: {
					mdcatid: {
                        remote:{
                   			url:"admin-category-vald.php",
                            type:"post"
                            }
					}
				},
				messages: {
					mdcatid: {
                                           remote: "The Vendors are subscribed to this category!"
                                        }
					
				},
		         errorElement : 'em',
		         errorPlacement: function(error, element) {
		           var placement = $(element).data('error');
		           if (placement) {
		             $(placement).append(error);
		           } else {
		             error.insertAfter(element);
		           }
		         }
    });

    		$( "#sub-delete" ).validate( {
				rules: {
					sdcatid: {
                        remote:{
                   			url:"admin-category-vald.php",
                            type:"post"
                            }
					}
				},
				messages: {
					sdcatid: {
                                           remote: "The Products/Services are added to this category!"
                                        }
					
				},
		         errorElement : 'em',
		         errorPlacement: function(error, element) {
		           var placement = $(element).data('error');
		           if (placement) {
		             $(placement).append(error);
		           } else {
		             error.insertAfter(element);
		           }
		         }
    });


		$( "#sub-insert" ).validate( {
				rules: {
					sicatid:"required",
                    sicat: {
                    sicatchk:true
							}
					
				},
				messages: {
                                        sicatid:"Please select Main category",
					sicat: {
                                           sicatchk: "The Sub Category already Exists!"
                                        }
					
				},
		         errorElement : 'em',
		         errorPlacement: function(error, element) {
		           var placement = $(element).data('error');
		           if (placement) {
		             $(placement).append(error);
		           } else {
		             error.insertAfter(element);
		           }
		         }
			} );

		$( "#sub-update" ).validate( {
				rules: {
					sucatid:"required",
                                        sucat: {
                                            sucatchk: true
                                            }
					
				},
				messages: {
                                        sucatid:"Please select category",
					sucat: {
                                           sucatchk: "The Sub Category already Exists!"
					}
					},
			         errorElement : 'em',
			         errorPlacement: function(error, element) {
			           var placement = $(element).data('error');
			           if (placement) {
			             $(placement).append(error);
			           } else {
			             error.insertAfter(element);
			           }
			         }
				} );


		
		} );


    </script>
    </body>
</html>