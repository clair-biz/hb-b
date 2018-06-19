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


$stmtcatprod=Base::generateResult("select cat_id,cat_name from category where cat_type='Product' and cat_id not in (select distinct category.cat_id from category,vend_subscription,users where users.u_id=vend_subscription.u_id and category.cat_id=vend_subscription.cat_id and u_name='".$user->u_name."');");  
$stmtcatserv=Base::generateResult("select cat_id,cat_name from category where cat_type='Service' and cat_id not in (select distinct category.cat_id from category,vend_subscription,users where users.u_id=vend_subscription.u_id and category.cat_id=vend_subscription.cat_id and u_name='".$user->u_name."');");  
$stmtcity=Base::generateResult("select distinct city_served from vend_subscription;");  

?>
    
 <div class="container-fluid" style="margin-top: 40px;">
    <div id="gototop"> </div>
<!-- 
Body Section 
-->
<div class="row">
            <form class="form-horizontal offset-md-1 col-md-10" id="vend-subsc" method="post">
                <div class="card container-fluid">
        <div class="row">
            <h5 class="page-header container-fluid text-center" >New Subscription Form</h5>	
        </div>
        <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12  ">
            <div class="row mb-3">
            <p class=" col-md-4  text-center" >Subscription For<font style="color:red">*</font>:</p>
                <select class="form-control col-md-4 col-lg-4 " id="cat_type" name="cat_type" required>
      <option value="" disabled selected>Choose your option</option>
      <option value="Product" >Products</option>
      <option value="Service" >Services</option>
                </select>
        </div>
        </div>
    </div>
                    <div class="row category-block-product" style="display: none;">
           <div class="col-lg-6 col-md-6 col-sm-12  ">
               <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Product Category <font style="color:red">*</font>:</p>
            <div class="col-lg-8 col-md-8 col-sm-8 form-group">
                <select class="form-control cat_p" id="catp" name="catp" required>
      <option value="" disabled selected>Choose your option</option>
      <option value="0" >Other</option>

                <?php
            while($cat = mysqli_fetch_array($stmtcatprod)) {
                    ?>
                    <option value="<?php echo $cat[0];  ?>"><?php echo $cat[1];  ?></option>
                    <?php
                    }
                    ?>
    </select>
    </div>
    </div>
           </div>

          <div class="col-lg-6 col-md-6 col-sm-12  cat1p" style="display: none">
              <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Mention Other Product Category (if not in the List)<font style="color:red">*</font>:</p>
            <div class="col-lg-8 col-md-8 col-sm-8  form-group ">
                <input type="text" class="form-control" placeholder="Category" autocomplete="off" id="cat_p" name="cat_p" required />
        </div>
        </div>
          </div>
    </div>

                    <div class="row category-block-service" style="display: none;">
          <div class="col-lg-6 col-md-6 col-sm-12  ">
              <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Service Category <font style="color:red">*</font>:</p>
            <div class="col-lg-8 col-md-8 col-sm-8 ">
                <select class="form-control cat_s" id="cats" name="cats" required>
      <option value="" disabled selected>Choose your option</option>
      <option value="0" >Other</option>

                <?php
            while($cat = mysqli_fetch_array($stmtcatserv)) {
                    ?>
                    <option value="<?php echo $cat[0];  ?>"><?php echo $cat[1];  ?></option>
                    <?php
                    }
//zip.close();
//stmtzip.close();
                    ?>
    </select>
    </div>
    </div>
          </div>       
          <div class="col-lg-6 col-md-6 col-sm-12  cat1s" style="display: none">
              <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Mention Other Service Category (if not in the List)<font style="color:red">*</font>:</p>
            <div class="col-lg-8 col-md-8 col-sm-8  form-group ">
                <input type="text" class="form-control" placeholder="Category" autocomplete="off" id="cat_s" name="cat_s" required />
        </div>
        </div>
          </div>
    </div>



            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12 ">
            <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Business Name <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8  form-group">
                <input type="text" class="form-control" autocomplete="off" id="bname" name="bname" />
        </div>  
                </div>
                  
            <!--div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">GST No:</p>
        <div class="col-lg-8 col-md-8 col-sm-8  form-group">
                <input type="text" class="form-control" autocomplete="off" id="gst_no" name="gst_no" />
            <label for="bname">GST No:</label>
        </div>  
                </div-->
                
            <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Preferred Time to contact</p>
        <div class="col-md-4 col-sm-6 form-group">
                <input type="text" class="form-control" autocomplete="off" id="otime" name="otime" placeholder="From"  />
        </div>
        <div class="col-md-4 col-sm-6 form-group">
                <input type="text" class="form-control" autocomplete="off" id="ctime" name="ctime" placeholder="To" />
        </div>
                </div>
             
        </div>
              <div class="col-lg-6 col-md-6 col-sm-12 ">

            <div class="row mb-3">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Subscription Plan <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8  input-group">
            <div class="row">
           <input type="text" class="form-control col-md-5 col-sm-5 col-lg-5" autocomplete="off" id="for_val" name="for_val" value="1" />
        <div class="col-md-7 col-sm-7 col-lg-7 input-group-append">
            <select class="form-control" id="for" name="for" >
                <option selected value="Annual">Year</option>
                <option value="Half Annual">Half Year</option>
            </select>
        </div>
            </div>
            </div>
            </div>
                  
            <div class="row">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">City <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8 ">
                <select class="form-control" id="city" name="city" required>
      <option value="" disabled selected>Choose your option</option>

                <?php
            while($city = mysqli_fetch_array($stmtcity)) {
                    ?>
                    <option value="<?php echo $city[0];  ?>"><?php echo $city[0];  ?></option>
                    <?php
                    }
//zip.close();
//stmtzip.close();
                    ?>
      <option value="0" >Other</option>
    </select>
        </div>
    </div>

            <div class="row city1"  style="display: none">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">Mention Other City (if not in the List)<font style="color:red">*</font>:</label></p>
        <div class="col-lg-8 col-md-8 col-sm-8  form-group">
                <input type="text" class="form-control" placeholder="City" autocomplete="off" id="city_c" name="city_c" required />
            </div>
        </div>

`
                
                  <div class="row fssai" style="display: none">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">FSSAI Registered <font style="color:red">*</font>:</p>
        <div class="col-lg-8 col-md-8 col-sm-8 ">
                    <p>
                        <input class="with-gap" name="options" type="radio" id="yes" required value="yes" />
                        <label for="yes">Yes</label>
                    </p>
                    <p>
                        <input class="with-gap" name="options" type="radio" id="no" value="no" />
                        <label for="no">No</label>
                    </p>
        </div>
                
        <div class="row fssai-y"  style="display: none">
            <p class="col-lg-4 col-md-4 col-sm-4 text-right">FSSAI No.<font style="color:red">*</font>:</label></p>
        <div class="col-lg-8 col-md-8 col-sm-8  form-group">
                <input type="text" class="form-control" placeholder="fssai no." autocomplete="off" id="fssai" name="fssai" required />
            <label for="fssai">FSSAI No.<font style="color:red">*</font>:</label>
        </div>
        </div> 
       
          <div class="row fssai-n"  style="display: none; margin: 0 10px 0 30px; text-justify: inter-word;">
              <ul style="list-style-type: disc !important;" >
                  <li style="list-style-type: disc">Homemade food or each and every Food Business Operator (FBO) is required as per Food Safety and  Security act, 2006. <a href="https://www.fssaifoodlicense.com/food-license-for-homemade-food/">Click here</a> for registration.</li>
                  <li style="list-style-type: disc">However, you can continue as a vendor on Homebiz365 we will advertise for your products one month free of charge and selling your products starts immediately after your FSSAI done. Also your billing cycle for subscription start from that date.</li>
              </ul>
          </div> 
              </div>
            </div>
            </div>
                <div class="row" id="sub" style="display: none;">
                <div class="col-lg-6 col-md-6 col-sm-12  offset-md-3">
            <div class="row ">
                <p class="col-lg-12 col-md-12 col-sm-12  text-center">Subscription for <span id="disp"></span></p>
                <p class="col-lg-6 col-md-6 col-sm-8 text-right">Subscription Charge</p><p class="col-lg-6 col-md-6 col-sm-4">&#8377; <span id="disp_sub"></span>/-</p>
                <p class="col-lg-6 col-md-6 col-sm-6 text-right">Tax</p><p class="col-lg-6 col-md-6 col-sm-6" id="disp_tax"></p>
                <p class="col-lg-6 col-md-6 col-sm-6 text-right">Total</p><p class="col-lg-6 col-md-6 col-sm-6">&#8377; <span id="net"></span>/-</p>
            </div>
                </div>
                </div>
        <div class="row justify-content-center align-items-center">
            <div class="text-center submit-btn">
                <button id="more-vendor-subscription" type="submit" name="btn" value="more" class="btn waves-effect waves-light" style="margin-bottom: 75px;">Add Category
                    <i class="material-icons right">add</i>
                </button>
                <button id="submit-vendor-subscription" type="submit" name="btn" value="submit" class="btn waves-effect waves-light" style="margin-bottom: 75px;">Submit
                <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
                </div>       
	</form>
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
    console.log(val);

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
                	if(id.search("cat_p")>-1)
                		$(".cat1p").show();
                	if(id.search("cat_s")>-1)
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
        id=id.split("form-control ");
        id=id[1];
        console.log("id "+id);
        showothercat(val,id);
        console.log("cat clicked");
    });
    $(".cat_p , .cat_s").on('change', function() {
        var id=$(this).attr("class");
        var val=$(this).val();
        id=id.split("form-control ");
        id=id[1];
        console.log("id "+id);
        showothercat(val,id);
        console.log("cat changed");
    });
    $(".cat_p , .cat_s").on('select', function() {
        var id=$(this).attr("class");
        var val=$(this).val();
        id=id.split("form-control ");
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
          data: dataString+"&type=sub",
          cache: false,
          success: function(html) {
              console.log(html);
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
        $.ajax({ 
          type: "POST",
          url: "<?php echo $root."getsubtotal.php"; ?>",
          data: dataString+"&type=disp",
          cache: false,
          success: function(disp) {
//              alert(parseFloat(parseFloat(tax)+parseFloat(html)));
            $("#disp").html(disp);
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
   
