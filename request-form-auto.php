<html>
    <body>
<?php
//include 'Classes/index.php';
require_once 'header.php';
$vend_id=$_REQUEST['vend'];
//Statement stmtcat=packcrm.Crm.con().createStatement();    
$cat=mysqli_query(Crm::con(),"select cat_id,cat_name from category where cat_id<>0;");  
//Statement stmtvend=packcrm.Crm.con().createStatement();    
$vend1=mysqli_query(Crm::con(),"select users.u_id,vend_fname,vend_lname,disp_name,vs_for,vs_pay_status,category.cat_name,area_served,vs_disc,category.cat_id,city_served,other_cat from vendor,category,users,vend_subscription where vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=vend_subscription.cat_id and vs_pay_status<>'Enabled' and users.u_id=$vend_id;");  

?>
    <div class="container-fluid" style="margin-top: 40px;">
            <div class="row">
                <div class="col-lg-8 card">
                    <div class="panel panel-default">
                        <div class="card-body">
                    <h5 class="page-header">&nbsp;&nbsp;Vendor Subscription Form</h5>
  <?php
  $prev_cat="";
      if($row=mysqli_fetch_array($vend1)){
if($row[9]==0)
$prev_cat=$row[11];
else
    $prev_cat=$row[9];



$vs_for= explode(" ", $row[4]);
$vs_f=$vs_for[1];

if($vs_for[1]=="Annual")
$noofmonths=$vs_for[0]*12;

elseif($vs_for[1]=="Half")
$noofmonths=$vs_for[0]*6;

if($noofmonths==12)
    $vs_for="1 Year";
elseif($noofmonths==6)
    $vs_for="6 Months";

elseif($noofmonths>12) {
    $y=intval($noofmonths/12);
    $noofmonths=(intval($noofmonths%12));

    if($y==1)
    $vs_for=$y." Year";
    else
    $vs_for=$y." Years";
    
    if($noofmonths>0)
        if($noofmonths==1)
        $vs_for.=" $noofmonths Month";
        else
        $vs_for.=" $noofmonths Months";
}
    


      ?>
               <div class="row">
                   <div class="col-md-offset-1 col-md-10">
        <p><?php echo "Vendor: <b>".$row[3]." (".$row[1]." ".$row[2].")</b>"; ?></p>
        
        <p><?php echo "Subscription Plan: <b>".$vs_for."</b>"; ?></p>
        <p><?php echo "Category: <b>".$row[6]."</b>";
        if($row[9]==0)
            echo " (<b>".$row[11]."</b>)";
            echo " would be served in <b>".$row[10]."</b>";
        if(!empty($row[7]))
            echo " (".$row[7]." area)</b>"; ?></p>
                    </div>
               </div>
                            
                    <form class="form-horizontal" id="disp-po-desc" action="request-process.php" method="post">
        <div class="row">
        <div class="col-md-5 col-md-offset-1 form-group">
                <select class="form-control" id="main" name="main" required>
      <option selected="true" value="<?php echo $row[9]; ?>" ><?php echo $row[6]; ?></option>

                <?php
           while($row1=mysqli_fetch_array($cat)){  
          if($row1[0]!=$row[9]) {
                    ?>
                    <option value="<?php echo $row1[0]; ?>"><?php echo $row1[1]; ?></option>
                    <?php
                    }
      }

//zip.close();
//stmtzip.close();
                    ?>
    </select>
            <label for="main">Category <font style="color:red">*</font>:</label>
    </div>
        </div>
        
        <div class="row">

        <div class="col-md-5 col-md-offset-1 form-group">
                <input type="text" class="form-control" autocomplete="off"  id="city" name="city" value="<?php echo $row[10]; ?>"required />
            <label for="city">City <font style="color:red">*</font>:</label>
        </div>
        
        </div>
               <div class="row">
        <div class="col-md-5 col-md-offset-1" >
            <label for="to">Is Delivery Provided?<font style="color:red">*</font>:</label>
                <select class="form-control" id="deli" name="deli" >
                    <option selected value="">-Select-</option>
                    <option value="Yes">Provided</option>
                    <option value="No">Not Provided</option>
                </select>
        </div>
       
                 <div class="col-md-5 form-group area" hidden>
                <input type="text" class="form-control" autocomplete="off" id="area" name="area" value="" />
            <label for="area">Delivered in Areas:</label>
            <p>Note: leave Delivered in Areas Field blank if serving anywhere in the City</p>
                </div>
                    
               </div>
        
        <div class="row">
       <div class="col-md-8 col-md-offset-1 form-group"  style="z-index: 1000 !important;">
           <input type="number" min="1" class="form-control col-md-6" autocomplete="off" id="for_val" name="for_val" value="<?php $v= explode(" ",$row[4]);
                echo $v[0];?>" />
            <label for="for_val">Subscription Plan <font style="color:red">*</font>:</label>
           <select class="form-control col-md-6" id="for" name="for" >
               <?php
               if($vs_f=="Annual") { ?>
               <option selected value="Annual">Year</option>
                    <option value="Half Annual">Half Year</option>
                   <?php
               }
               elseif($vs_f=="Half") {
               ?>
               <option selected value="Half Annual">Half Year</option>
               <option value="Annual">Year</option>
               <?php
               }
               ?>
                </select>
        </div>
                <div class="col-md-2 card grey white-text">
                    <p class="text-center "><em>&#8377; <span id="disp_sub"><?php echo $row[8];?></span>/-</p>
                </div>
        </div>
               
            <div class="row">
        <div class="col-md-8 col-md-offset-1">
        <div class="col-md-8 form-group">
            <label for="disc_val">Discount: </label>
            <input type="number" min="0" class="form-control" autocomplete="off" id="disc_val" name="disc_val" value="0"/>
        </div>

                <div class="form-group col-md-4">
                <select class="form-control" id="disc_type" name="disc_type">
                    <option selected value="Amount">Amount</option>
                    <option value="Percent">Percentage</option>
                </select>
                </div>
        </div>
                <div class="col-md-2 card grey white-text">
                    <p class="text-center "><em>&#8377; <span id="disp_disc"><?php echo $row[8];?></span>/-</p>
                </div>
    <input type="hidden" id="disc" name="disc" value="<?php echo $row[8];?>" />
	</div>

        
        
        <div class="row">
            <div class="col-md-6 col-md-offset-3 row">
                            <table width="30%" class="table hover z-depth-1 hoverable" >
				<tbody>
                                    <tr>
                                        <th>Tax</th><td><em>&#8377; <span id="disp_tax"></span>/-</em>    </td>
                                    </tr>
                                    <tr>
                                        <th>Subtotal (including tax)</th><td><em>&#8377; <span id="disp_sub1"></span>/-</em>    </td>
                                    </tr>
                                    <tr>
                                        <th>Net Total</th><td><em>&#8377; <span id="net"></span>/-</em>    </td>
                                    </tr>
                                </tbody>
                            </table>
	</div>
        </div>
               
        
    <div class="row">
    <input type="hidden" id="total" name="total" />
    <input type="hidden" id="sub" name="sub" />
                <input type="hidden" id="tax" name="tax"  />
            <input type="hidden" name="id" value="<?php echo $row[0]; ?>" />
            <input type="hidden" name="vname" value="<?php echo $row[1]." ".$row[2]; ?>" />
            <input type="hidden" name="bname" value="<?php echo $row[3]; ?>" />
            <input type="hidden" name="prev_cat" value="<?php echo $prev_cat; ?>" />
<?php
if($row[9]==0) { ?>
	<div class="col-md-3 col-md-offset-1">
            <button type="submit" name="status" value="Approved" class="btn btn-block btn-primary" >Approve</button>
	</div>
<script>
    $("disp-po-desc").submit();
    alert("auto-submitted");
</script>
<?php
}
?>
    </div>
               
           </form>
            <?php 
      }
//mysqli_free_result($vend1);
//stmtreord.close();
?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->

                <div class="col-lg-4 col-md-offset-1 col-md-4 card" style="max-height: 450px;">
          <div class="card logo-bg-b darken-1" style="margin-bottom:0 !important;">
              <div class="card-content container white-text" style="padding: 5px !important; ">
            <p style="color:white;"><b>New Requests &nbsp;
            <i class="material-icons">announcement</i>
                </b></p>
            </div>
          </div>
        <div class="card white " style="margin-top:0 !important; margin-bottom:0 !important;">
            <div class="card-content white-text" style="padding: 5px !important; max-height: 380px; overflow-y: auto">">
                            <?php require_once 'admin-notification.php'; ?>
            </div>
          </div>
        </div>
                </div>
          </div>
    <?php
require_once 'footer.php';
    ?>
    <script>
        
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
    
    function calc_disc(){
            var sub= $("#disp_sub").text();
            var disc_val=$("#disc_val").val();
            var disc_type=$("#disc_type" ).val();
//            alert(disc_type);
            switch(disc_type) {
                case 'Amount': $("#disp_disc").text(parseFloat(disc_val));
                    $("#net").text(parseFloat(sub-disc_val));
                    $("#total").val(parseFloat(sub-disc_val));
            $("#disc").val(parseFloat(disc_val));
                                break;
                case 'Percent': $("#disp_disc").text(parseFloat(sub*(disc_val/100)));
                    $("#net").text(parseFloat(parseFloat(sub- sub*(disc_val/100) )) );
                    $("#total").val(parseFloat(parseFloat(sub- sub*(disc_val/100) )) );
            $("#disc").val(parseFloat(sub*(disc_val/100)));
                                break;
                                
            }
//            alert(sub);
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
            $("#disp_sub1").text(parseFloat(parseFloat(tax)+parseFloat(html)));
            $("#disp_tax").text(tax);
            $("#tax").val(tax);
        
            $("#sub").val(parseFloat(html));
            $("#net").text(parseFloat(parseFloat(tax)+parseFloat(html)));
            $("#total").val(parseFloat(parseFloat(tax)+parseFloat(html)));
//            alert($("#sub").val() );
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