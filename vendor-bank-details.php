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

$u_id=Base::getuidbyuname($user->u_name);
$stmtcatprod=Base::generateResult("select cat_id,cat_name from category where cat_type='Product' and cat_id<>0;");
$stmtcatserv=Base::generateResult("select cat_id,cat_name from category where cat_type='Service' and cat_id<>0;");
$stmtcity=Base::generateResult("select distinct city_served from vend_subscription;");
$stmtbank=Base::generateResult("select * from vend_bank where u_id=$u_id;");

?>
    
 <div class="container-fluid" style="margin-top: 40px;">
    <div id="gototop"> </div>
<!-- 
Body Section 
-->
<div class="row">
            <form class="form-horizontal offset-md-1 col-md-6" id="vend-bank" method="post">
    <div class="card container-fluid">
        <div class="row">
            <h5 class="page-header text-center container-fluid" >Enter Bank Details</h5>	
        </div>
                <p class="text-center container-fluid">Update the bank details to receive payments from Homebiz365 for your Products</p>
               <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4 text-right">Account Number <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="ac_no" name="ac_no" />
        </div>  
                </div>  
                  
        <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4 text-right">Re-enter Account Number <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="reac_no" name="reac_no" />
        </div>  
                </div>            
       
                  
                   <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4 text-right">Account Type <font style="color:red">*</font>:</p>
        <div class="col m8 s6 ">
           <select class="form-control" id="ac" name="ac" >
               <option selected value="">-Select your Account type-</option>
                    <option value="Overdraft Account">Overdraft Account</option>
                    <option value="Current Account">Current Account</option>
                    <option value="Saving Account">Saving Account</option>
                </select>
        </div>
                </div>
              </div>
       
             <div class="col-lg-6 col-md-6 col-sm-12">
                   
                  <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4 text-right">Account Holder Name <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="aname" name="aname" />
        </div>  
                </div>
        
        <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4 text-right">IFSC Code<font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="ifsc" name="ifsc" />
        </div>  
                </div>            
          
                  
                </div>
            </div>
                
                <div class="row">
            <h5 class="page-header text-center container-fluid" >Enter Tax Details</h5>	
        </div>
                <p class="text-center container-fluid">Update your Tax Details for MAHARASHTRA :</p>  
                <div class="row">
           <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4 text-right">PAN No. <font style="color:red">*</font>:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="pan" name="pan" />
        </div>  
                </div>
           </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="row">
            <p class="col-md-4 col-lg-4 col-sm-4 text-right">GST No.:</p>
        <div class="col-md-8 col-lg-8 col-sm-8 form-group">
                <input type="text" class="form-control" autocomplete="off" id="gst" name="gst" />
        </div>  
                </div>            
                </div> 
            </div>
                 <div class="row">
       
                <button id="submit-bank" type="submit" class="btn waves-effect waves-light" style="margin-bottom: 75px; margin-left: auto; margin-right: auto; display: block">Submit
                <i class="material-icons right">send</i>
                </button>
	
        </div>
        
            </div>
	</form>
    <div class="col-md-4 card" >
        <?php
        if(mysqli_num_rows($stmtbank) > 0) {
        while($row= mysqli_fetch_array($stmtbank)) {
        ?>
        <div class="row">
            <h5 class="col-md-12 text-center">Bank Details:</h5>
        </div>
        <div class="row">
            <p class="col-md-5">Account No.:</p>
            <p class="col-md-7"><?php echo $row["acc_no"]; ?></p>
        </div>
        <div class="row">
            <p class="col-md-5">Account Type:</p>
            <p class="col-md-7"><?php echo $row["acc_type"]; ?></p>
        </div>
        <div class="row">
            <p class="col-md-5">Account Holder:</p>
            <p class="col-md-7"><?php echo $row["acc_hold_name"]; ?></p>
        </div>
        <div class="row">
            <p class="col-md-5">IFSC Code:</p>
            <p class="col-md-7"><?php echo $row["ifsc_code"]; ?></p>
        </div>
        <div class="row">
            <p class="col-md-5">PAN No.:</p>
            <p class="col-md-7"><?php echo $row["pan_no"]; ?></p>
        </div>
        <div class="row">
            <p class="col-md-5">GST No.:</p>
            <p class="col-md-7"><?php echo $row["gst_no"]; ?></p>
        </div>
        <?php
        }
        }
        ?>
    </div>
</div>
                

<a href="#" class="gotop"><i class="icon-double-angle-up"></i></a>
 </div>
      </section>    
      <section class="footer" style="margin-top: 10px !important; width: auto !important;" ></section>
      
</section>
<?php
require_once 'scripts.html';
?>
<script>
    $("input[name=options]").on("change",function() {
    var val=$("input[name=options]:checked").val();

    switch(val) {
        case "no" : $(".fssai-n").show();
                        $(".fssai-y").hide();
                        break;
                    case "yes": $(".fssai-y").show();
                                    $(".fssai-n").hide();
                                    break;
                    default : $(".fssai-n").hide();
                              $(".fssai-y").hide();
                        
    }
        
    });
</script>
<script>
    $("#catp").on('change',function() {
       var val=$(this).val();
       switch(val) {
           case "39" :
                        $(".fssai").show();
                        break;
           default :
                        $(".fssai").hide();
                        break;
                        
       }
    });
    $("#deli").on('change',function() {
       var val=$(this).val();
       switch(val) {
           case "Yes" :
                        $(".area").show();
                        break;
           default :
                        $(".area").hide();
                        break;
                        
       }
    });
    $("#cat_type").on('change', function() {
        var type=$(this).val();
        switch(type) {
            case "Product" : 
                            $(".category-block-product").show();
                            $(".category-block-service").hide();
                            break;
            case "Service" : 
                            $(".category-block-product").hide();
                            $(".category-block-service").show();
                            break;
            default : 
                            $(".category-block-product").hide();
                            $(".category-block-service").hide();
                            break;
                            
        }
    });
    
    function showothercat(val,id) {
        console.log("cat val "+val);
        console.log("cat class "+id);
        switch(val) {
            case "0": 
                	if(id=="cat_p")
                		$(".cat1p").show();
                	if(id=="cat_s")
                		$(".cat1s").show();
                break;
            default: 
                $(".cat1p").hide();
                $(".cat1s").hide();
        }
    }
    $(".cat_p , .cat_s").on('click', function() {
        var id=$(this).attr("class");
        var val=$(this).val();
        id=id.split("browser-default ");
        id=id[1];
        console.log("id "+id);
        showothercat(val,id);
        console.log("cat clicked");
    });
    $(".cat_p , .cat_s").on('change', function() {
        var id=$(this).attr("class");
        var val=$(this).val();
        id=id.split("browser-default ");
        id=id[1];
        console.log("id "+id);
        showothercat(val,id);
        console.log("cat changed");
    });
    $(".cat_p , .cat_s").on('select', function() {
        var id=$(this).attr("class");
        var val=$(this).val();
        id=id.split("browser-default ");
        id=id[1];
        console.log("id "+id);
        showothercat(val,id);
        console.log("cat selected");
    });
    
     function showothercity() {
        var val=$("#city").val();
        console.log("city val "+val);
        switch(val) {
            case "0": $(".city1").show();
                break;
            default: $(".city1").hide();
        }
    }
    $("#city").on('click', function() {
        showothercity();
        console.log("city clicked");
    });
    $("#city").on('change', function() {
        showothercity();
        console.log("city changed");
    });
    $("#city").on('select', function() {
        showothercity();
        console.log("city selected");
    });
    
               function calc_sub() {
               var for_val=$("#for_val").val();
               var sfor=$("#for").val();
               var cat=0;
               
               if($("#cat_type").val()=="Product")
                   cat=$("#catp").val();
               else if($("#cat_type").val()=="Service")
                   cat=$("#cats").val();
               
//               alert("cat "+cat);
            if (for_val != '' && sfor != '') {
      var dataString = 'sfor='+ sfor+'&for_val='+for_val+'&cat='+cat;
        $.ajax({ 
          type: "POST",
          url: "<?php echo $root."getsubtotal.php"; ?>",
          data: dataString,
          cache: false,
          success: function(html) {
//              alert(html);
        $.ajax({ 
          type: "POST",
          url: "<?php echo $root."gettotaltax.php"; ?>",
          data: dataString,
          cache: false,
          success: function(tax) {
//              alert(parseFloat(parseFloat(tax)+parseFloat(html)));
            $("#disp_sub").html(Math.round(parseFloat(html)));
            $("#disp_tax").html(tax+"%");
        
            $("#net").html(Math.round(parseFloat(html)+parseFloat(html*(tax/100))));
            $("#sub").show();
          }
        });              //  alert(tax);
          }
        });
      }

//        }
        }
            $(document).ready(function() {
//                calc_sub();
        $("#for_val").keyup(calc_sub);
        $("#catp, #cats").select(calc_sub);
        $("#catp, #cats").change(calc_sub);
        $("#for").change(calc_sub);

            });

</script>
    </body>
</html>       
   