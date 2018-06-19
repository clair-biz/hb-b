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

    $queryvs="select vs_id,bname from vend_subscription where vs_pay_status='Enabled';";
            $resvs=mysqli_query(Crm::con(), $queryvs);
?>
    <div class="container-fluid" style="margin-top: 40px;">
    
            <div class="row">
                <div class="col-lg-2 col-md-2 hide-on-small-and-down">
                    <?php
                    require 'admin-menu.php'; 
                    ?>
                    </div>
            <div class="row">
        <div class="card col-lg-10 col-md-10 col-sm-12 col-md-offset-1">
                         <h5 class="page-header">&nbsp;&nbsp;Reports</h5>
                         
                         <div class="container col-md-4 col-sm-12" >
                             <form id="reports-form" method="post" action="admin-reports-process.php" >
                                 
                                 <div class="form-group" >
                                     <select class="form-control" id="type" name="type" >
                                         <option value="" selected >-Select-</option>
                                         <option value="transaction" >Transaction</option>
                                         <option value="delivery" >Delivery</option>
                                         <!--option value="tax" >Tax</option-->
                                     </select>
                                     <label for="vs_id" >Vendor</label>
                                 </div>
                                 <div class="form-group types transaction" style="display:none;" >
                                     <select class="form-control" name="vs_id" >
                                         <option value="0" selected >All Vendors</option>
                                         <?php
                                         while($rowvs= mysqli_fetch_array($resvs)) {
                                          ?>
                                         <option value="<?php echo $rowvs[0]; ?>" ><?php echo $rowvs[1]; ?></option>
                                         <?php
                                         }
                                         ?>
                                     </select>
                                     <label for="vs_id" >Vendor</label>
                                 </div>
                                 
                                 <div class="form-group types delivery" style="display:none;" >
                                     <select class="form-control" name="case" >
                                         <option value="" selected >All Deliveries</option>
                                         <option value="Delivered" >Delivered</option>
                                         <option value="Not Delivered"  >Not Delivered</option>
                                     </select>
                                     <label for="case" >Case</label>
                                 </div>
                                 <div class="form-group" >
                                     <input type="date" class="form-control" id="from_dt" name="from_dt" />
                                     <label for="from_dt">From</label>
                                 </div>
                                 <div class="form-group" >
                                     <input type="date" class="form-control" id="to_dt" name="to_dt" />
                                     <label for="to_dt">To</label>
                                 </div>
            <div class="row">
       
                <button id="submit-register" type="submit" class="btn waves-effect waves-light" style="margin-bottom: 75px; margin-left: auto; margin-right: auto; display: block">Submit
                <i class="material-icons right">send</i>
                </button>
            </div>
                             </form>
                         </div>
                </div>
                <!-- /.col-lg-12 -->
                

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
    $(document).ready(function() {
        $("#type").on('change',function() {
           switch($(this).val()) {
               case 'transaction' :
                                    $(".types").hide();
                                    $(".transaction").show();
                                    break;
               case 'delivery' :
                                    $(".types").hide();
                                    $(".delivery").show();
                                    break;
           } 
        });
        
        $('#dataTables-vendors').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }
        });
        /*
        $("#reports-form").validate({
            rules: {
                
            },
            messages: {
                
            },
                                            errorElement : 'em',
        errorPlacement: function(error, element) {
          var placement = $(element).data('error');
          if(element.attr("type")=="radio" || element.attr("type")=="checkbox") {
              console.log("in radio or checkbox");
              error.insertAfter(element.parents("p"));
          }
          else {
          if (placement) {
            $(placement).append(error);
          } else {
            error.insertAfter(element);
          }
      }
        },
	   submitHandler: submitRegistrationForm	
       });  
	   /* validation */
	   
	   /* login submit *
	   function submitRegistrationForm() {		
			var data = $("#reports-form").serialize();
                        console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : 'admin-reports-process.php',
			data : data,
			beforeSend: function() {
                                $("#submit-reports").prop('disabled', true);
				$("#submit-reports").html(preloader());
			},
			success :  function(response) {
                         console.log("response="+response+"=");   
                        }
                    });
                }*/
    });
    </script>
    </body>
</html>