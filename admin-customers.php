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

    $q="select distinct customer.cust_id,cust_fname,cust_cntc,cust_email,u_name from customer,users where customer.cust_id=users.cust_id and customer.is_active='Y' and customer.cust_id<>0";
    $cat111=Base::generateResult($q);
    ?>
   <div class="container-fluid row" style="margin-top: 40px;">
         <div class="row">
                <div class="col-lg-2 col-md-2 d-none d-md-block">
                    <?php
                    require 'admin-menu.php'; 
                    ?>
                    </div>   
         <div class="col-lg-10 col-md-10 col-sm-12">         
             <div class="vendor-table">
                    <div class="card">
                    <h5 class="page-header">&nbsp;&nbsp;Customers</h5>
                            <table width="100%" class="table table-striped table-responsive table-bordered table-hover" id="dataTables-customers">
                                <thead>
        <tr class="text-center">
            <th>Name</th>
            <th>Mobile Number</th>
            <th>Email ID</th>
            <th>User Name</th>
            <th></th>
      </tr>
    </thead>
    <tbody>
        <?php
      while($row=mysqli_fetch_array($cat111)) {
?>
        <tr class="text-center ">
        <td  ><?php echo $row[1]; ?></td>
        <td  ><?php echo $row[2]; ?></td>
        <td  ><?php echo $row[3]; ?></td>
        <td  ><?php echo $row[4]; ?></td>
        <td><a href="#!" id="<?php echo $row[0]; ?>" class="customer-disable">Disable</a>
        </tr>

<?php }
//mysqli_free_result($cat111);
//stmtcat111.close();
?>
  
    </tbody>

                            </table>
                            <!-- /.table-responsive -->
                            
                            
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    </div>
                    <div class="cust-details card" style="display:none" >
                    <div class="cust-details-btns row  col-lg-2 col-md-2 right" style="display:none" >
                        <a class="btn red" id="btn_close">X</a>
                    </div>
                        <div class="cust-details-block">
                            
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
?>      <!-- /#page-wrapper -->
    <script>
    $(".customer-disable").on('click',function() {
        var id= $(this).attr("id");
		$.ajax({
			
			type : 'POST',
			url  : 'cust-disable-form.php',
			data : "cust_id="+id,
			beforeSend: function() {
				//$(this).html(preloader());
			},
			success :  function(response) {
//                            console.log("alert "+response);
                            console.log("in disable");
                            $("#modal-disable-customer").find(".modal-dialog").html(response);
                            $("#modal-disable-customer").modal("show");
                            
                            $("#modal-disable-customer.show").ready(function () {
    var origin=window.location.origin+"/";
		var form_status = $('<div class="form_status"></div>');
            
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
                                
                                
	 $("#disable-cust").validate({
      rules: {
			reason: {
                            required: true,
                            minlength: 5
                        }
	   },
       messages: {
       },
        errorElement : 'em',
        errorPlacement: function(error, element) {
          var placement = $(element).data('error');
          if (placement) {
            $(placement).append(error);
          } else {
            error.insertAfter(element);
          }
        },
	   submitHandler: submitDisableCustForm	
       });

        /* login submit */
	   function submitDisableCustForm() {
			var data = $("disable-cust").serialize();
                        //console.log("data disable-cust "+data);
                        console.log("data disable-cust-chacha");
			$.ajax({
				
			type : 'POST',
			url  : origin+"cust-disable.php",
			data : data,
			beforeSend: function() {
//				$("#error").fadeOut();
                                $("#submit_customer_reject").prop('disabled', true);
				$("#submit_customer_reject").append(status);
			},
			success :  function(response) {
//                            console.log("resp "+response);
					if(response.search("ok")>-1){
                                $("#submit_customer_reject").prop('disabled',  false);
                                $(".status").html(""); 
                $("#modal-msg").find(".modal-body").html("<p style='vertical-align:central;' class='text-center'>Customer Disabled!</p>");
                $("#modal-msg").modal({backdrop: "static"});

                            }
					else{
                                                $("#submit_customer_reject").prop('disabled', false);
                                $(".status").html(""); 
                $("#modal-msg").find(".modal-body").html("<p style='vertical-align:central;' class='text-center'>Customer Disable failed!</p>");
                $("#modal-msg").modal({backdrop: "static"});
					}
			  }
			});
				return false;
		}
	   /* login submit */
        
                

                                
                                
                                
                                
                                
                                
                            });
    }
			});


    });
    
    
    

    </script>
    <script>
    $(document).ready(function() {
    $('#dataTables-customers').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }
        });
        
    });
    </script>
</body>

</html>