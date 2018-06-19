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
$vs_id=$_REQUEST['vs_id'];
//Statement stmtcat=packcrm.Crm.con().createStatement();    
$cat=mysqli_query(Crm::con(),"select cat_id,cat_name from category where cat_id<>0;");  
//Statement stmtvend=packcrm.Crm.con().createStatement();    
$query="select users.u_id,vend_fname,bname,vs_for,vs_pay_status,category.cat_name,vs_disc,category.cat_id,city_served,other_cat,fssai_no from vendor,category,users,vend_subscription where vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=vend_subscription.cat_id and vs_for is not NULL and vs_id=$vs_id;";
echo "<script>console.log('".$query."');</script>";
$vend1=mysqli_query(Crm::con(),$query);

?>
        <div class="container-fluid" style="margin-top: 40px;">
        <div class="row">
                <div class="col-lg-2 col-md-2 hide-on-small-and-down">
                    <?php
                    require 'admin-menu.php'; 
                    ?>
                    </div>
            <div class="row">
        <div class="col-lg-10 col-md-offset-1 col-md-10 col-sm-12">
                    <div class="panel panel-default">
                    <div class="card">
                    <h5 class="page-header text-center">Vendor Subscription Form</h5>
  <?php
  $prev_cat="";
      if($row=mysqli_fetch_array($vend1)){
if($row[7]==0)
$prev_cat=$row[9];
else
    $prev_cat=$row[7];

$vs_for= Crm::annualtoyear($row[3]);
?>
                            
    <form class="form-horizontal" id="disp-po-desc" action="request-process.php" method="post">
               <div class="row">
                   <div class="col-md-offset-1 col-md-10">
        <p><?php echo "Vendor: <b>".$row[2]." (".$row[1].")</b>"; ?></p>

        <p><?php echo "Subscription Plan: <b>$vs_for</b>"; ?></p>
        <p><?php echo "Category: <b>".$row[5]."</b>";
        if($row[7]==0)
            echo " (<b>".$row[9]."</b>)";
            echo " would be served in <b>".$row[8]."</b>"; ?></p>
                    </div>
               </div>
        <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <label for="main">Category <font style="color:red">*</font>:</label>
                <select class="form-control" id="main" name="main" required>
      <option selected="true" value="<?php echo $row[7]; ?>" ><?php echo $row[5]; ?></option>

                <?php
           while($row1=mysqli_fetch_array($cat)){  
          if($row1[0]!=$row[7]) {
                    ?>
                    <option value="<?php echo $row1[0]; ?>"><?php echo $row1[1]; ?></option>
                    <?php
                    }
      }
?>
    </select>
    </div>
        </div>
        
        <?php 
        if($row[7]==39) {
        ?>
        <div class="row">

        <div class="col-md-5 col-md-offset-1">
            <div class="form-group">
                    <input type="text" class="form-control" autocomplete="off"  id="fssai" name="fssai" value="<?php echo $row[10]; ?>" />
                <label for="city">FSSAI No:</label>
            </div>
            </div>
        </div>
        <?php
      }
      ?>
        <div class="row">

        <div class="col-md-5 col-md-offset-1 col-sm-12 form-group">
                <input type="text" class="form-control" autocomplete="off"  id="city" name="city" value="<?php echo $row[8]; ?>"required />
            <label for="city">City <font style="color:red">*</font>:</label>
        </div>
        
        <!--div class="col m5 form-group">
                <input type="text" class="form-control" autocomplete="off"  id="area" name="area" value="<!?php echo $row[7]; ?>"required />
            <label for="area">Delivery Provided in:</label>
        </div-->
        </div>
        
        <div class="row">
        <div class="col-md-5 col-lg-5 col-sm-8 col-md-offset-1 col-lg-offset-1 form-group">
           <input type="number" min="1" class="form-control col-lg-5 col-md-5 col-sm-5" autocomplete="off" id="for_val" name="for_val" value="<?php $v= explode(" ",$row[3]);
                echo $v[0];?>" />
            <label for="for_val">Subscription Plan<font style="color:red">*</font>:</label>
           <select class="form-control col-lg-7 col-md-7 col-sm-7" id="for" name="for" >
               <?php
               if($v[1]=="Annual") { ?>
               <option selected value="Annual">Year</option>
                    <option value="Half Annual">Half Year</option>
                   <?php
               }
               
               elseif($v[1]=="Half") {
               ?>
               <option selected value="Half Annual">Half Year</option>
               <option value="Annual">Year</option>
               <?php
               }
               ?>
                </select>
        </div>
                <div class="col-lg-2 col-md-2 col-sm-4 card grey white-text">
                    <p class="text-center "><em>&#8377; <span id="disp_sub"><?php echo $row[6];?></span>/-</em></p>
                </div>
        </div>
               
            <div class="row">
        <div class="col-md-5 col-sm-8 col-md-offset-1 form-group">
            <label for="disc_val">Discount: </label>
            <input type="number" min="0" class="form-control col-sm-5 col-md-6" autocomplete="off" id="disc_val" name="disc_val" value="<?php
            if(!empty($row[6]))
                echo $row[6];
                else
                    echo "0";
                ?>"/>

                <select class="form-control col-sm-7 col-md-6" id="disc_type" name="disc_type">
                    <option selected value="Amount">Amount</option>
                    <option value="Percent">Percentage</option>
                </select>
        </div>
                <div class="col-md-2 col-sm-4 card grey white-text">
                    <p class="text-center "><em>&#8377; <span id="disp_disc"><?php echo $row[6];?></span>/-</p>
                </div>
    <input type="hidden" id="disc" name="disc" value="<?php echo $row[6];   ?>" />
	</div>

        
        
        <div class="row">
            <div class="col-md-offset-3 col-md-6 col-sm-12 row">
                            <table width="30%" class="table hover z-depth-1 hoverable" >
				<tbody>
                                    <tr>
                                        <th>Subtotal</th><td><em>&#8377; <span id="disp_sub1"></span>/-</em>    </td>
                                    </tr>
                                    <tr>
                                        <th>Tax</th><td><em>&#8377; <span id="disp_tax"></span>/-</em>    </td>
                                    </tr>
                                    <tr>
                                        <th>Net Total</th><td><em>&#8377; <span id="net"></span>/-</em>    </td>
                                    </tr>
                                </tbody>
                            </table>
	</div>
        </div>
            <?php
            if($row[4]!="Enabled") {
            ?>
               
               <div class="row">
                   <div class="col-md-10 col-md-offset-1 form-group">
                 <textarea class="form-control reason" autocomplete="off" id="reason" name="reason" ></textarea>
            <label for="reason">Reason (For Rejection only)<font style="color:red">*</font>:</label>
                   </div>
               </div>
			<?php
            }
            ?>
        

        
    <div class="row">
    <input type="hidden" id="total" name="total" />
    <input type="hidden" id="sub" name="sub" />
                <input type="hidden" id="tax" name="tax"  />
            <input type="hidden" name="id" value="<?php echo $vs_id; ?>" />
            <input type="hidden" name="vname" value="<?php echo $row[1]; ?>" />
            <input type="hidden" name="bname" value="<?php echo $row[2]; ?>" />
            <input type="hidden" name="prev_cat" value="<?php echo $prev_cat; ?>" />
            <?php
            if($row[4]!="Enabled") {
            ?>
	<div class="col-md-offset-1 col-md-3">
            <button type="submit" name="status" id="<?php echo $row[10]; ?>" value="Rejected" class="btn btn-block red rejectbtn" disabled  >Reject</button>
        </div>
        <?php 
      }
        if($row[4]=="New") {
        ?>
	<div class="col-md-offset-1 col-md-3">
            <button type="submit" name="status" value="Approved" class="btn btn-block btn-primary" >Approve</button>
	</div>
<?php
      }
elseif($row[4]=="Approved" || $row[4]=="Updated" || $row[4]=="Wait4FSSAI") { ?>
	<div class="col-md-offset-1 col-md-3">
            <button type="submit" name="status" value="Updated" class="btn btn-block btn-primary" >Update</button>
	</div>
	<div class="col-md-offset-1 col-md-3">
            <button type="submit"  name="status" value="Enabled" class="btn btn-block green" >Enable</button>
	</div>
<?php
}
elseif($row[4]=="Enabled") { ?>
	<div class="col-md-offset-1 col-md-5">
            <button type="submit" name="status" value="Approve Renewal" class="btn btn-block btn-primary" >Approve Renewal</button>
	</div>
	<div class="col-md-offset-1 col-md-3">
            <button type="submit"  name="status" value="Renew" class="btn btn-block green" >Renew</button>
	</div>
<?php
}
?>
    </div>
               
           </form>
            <?php 
      }
?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->

                <!--div class="col  l4 offset-m1 m4 card-panel" style="max-height: 450px;">
          <div class="card logo-bg-b darken-1" style="margin-bottom:0 !important;">
              <div class="card-content container white-text" style="padding: 5px !important; ">
            <p style="color:white;"><b>New Requests &nbsp;
            <i class="material-icons">announcement</i>
                </b></p>
            </div>
          </div>
        <div class="card white " style="margin-top:0 !important; margin-bottom:0 !important;">
            <div class="card-content white-text" style="padding: 5px !important; max-height: 380px; overflow-y: auto">">
                            <?php //require_once 'admin-notification.php'; ?>
            </div>
          </div>
        </div-->
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
    
    function calc_disc(){
            var sub= $("#disp_sub").text();
            var disc_val=$("#disc_val").val();
            var disc_type=$("#disc_type" ).val();
            var tax= null;
            var for_val=$("#for_val").val();
            var sfor=$("#for").val();
            var cat=$("#main").val();
//            alert("cat "+cat);
         if (for_val != '' && sfor != '') {
   var dataString = 'sfor='+ sfor+'&for_val='+for_val+'&cat='+cat;

                $.ajax({ 
                    type: "POST",
                    url: "gettotaltax.php",
                    data: dataString,
                    async: false, // <- this turns it into synchronous
                    cache: false,
                    success: function(response) {
                        console.log("response tax"+response);
                            tax=response;
                            console.log("response tax1"+tax);
                            
                    }
                
                  });              //  alert(tax);

            console.log("tax perc "+tax);
//            alert(disc_type);
            switch(disc_type) {
                case 'Amount': 
                    var sub_total=sub-disc_val;
                    var tax=sub_total*(tax/100);
                    $("#disp_disc").text(Math.round(disc_val));
                    $("#disp_sub1").text(Math.round(sub_total));
                $("#tax").val(Math.round(tax));
                $("#disp_tax").text(Math.round(tax));
                    $("#net").text(Math.round(sub_total+tax));
                    $("#total").val(Math.round(sub_total+tax));
            $("#disc").val(parseFloat(disc_val));
                                break;
                case 'Percent':
                    var disc_amt=sub*(disc_val/100);
                    var sub_total=sub-disc_amt;
                    var tax=sub_total*(tax/100);

                     $("#disp_disc").text(Math.round(disc_amt));
                $("#disp_sub1").text(Math.round(sub_total));
                $("#tax").val(Math.round(tax));
                $("#disp_tax").text(Math.round(tax));
                    $("#net").text(Math.round(sub_total+tax));
                    $("#total").val(Math.round(sub_total+tax));
            $("#disc").val(Math.round(sub*(disc_val/100)));
                                break;
                                
            }
//            alert(sub);
        }
    }
        
           function calc_sub() {
               var for_val=$("#for_val").val();
               var sfor=$("#for").val();
               var cat=$("#main").val();
//               alert("cat "+cat);
            if (for_val != '' && sfor != '') {
      var dataString = 'sfor='+ sfor+'&for_val='+for_val+'&cat='+cat;
        $.ajax({ 
          type: "POST",
          url: "getsubtotal.php",
          data: dataString,
          cache: false,
          success: function(html) {
//              alert(html);
        $.ajax({ 
          type: "POST",
          url: "gettotaltax.php",
          data: dataString,
          cache: false,
          success: function(tax) {
//              alert(parseFloat(parseFloat(tax)+parseFloat(html)));
            $("#disp_sub").text(html);
            $("#disp_sub1").text(Math.round(parseFloat(html)));
            $("#disp_tax").text(html*tax/100);
            $("#tax").val(html*tax/100);
        
            $("#sub").val(Math.round(html));
            $("#net").text(Math.round(parseFloat(tax)+parseFloat(html)));
            $("#total").val(Math.round(parseFloat(tax)+parseFloat(html)));
//            alert($("#sub").val() );
    calc_disc();
          }
        });              //  alert(tax);
//            $("#net").val(parseFloat(html+tax) );
//            alert($("#sub").val() );
          }
        });
      }

//        }
        }
                
    $(document).ready(function() {
        calc_sub();
        calc_disc();
        $("#for_val").keyup(calc_sub);
        $("#main").change(calc_sub);
        $("#for").change(calc_sub);
        $("#disc_val").keyup(calc_disc);
        $("#disc_type").change(calc_disc);
        
        
        $("#reason").on('keyup',function() {
            var len=$(this).val().length;
            console.log(len);
                if(len>=5)
                    $(".rejectbtn").prop("disabled",false);
                else
                    $(".rejectbtn").prop("disabled",true);
            });
                
//            alert("->"+($("#sub").val()) );
    });
    </script>
    </body>
</html>