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


    $query="select distinct vendor.vend_id,vend_fname,vend_email,vend_cntc,u_name from vendor,users where users.vend_id=vendor.vend_id and vendor.vend_id<>0";
    $cat111=Base::generateResult($query);
    ?>
    <div class="container-fluid row" style="margin-top: 40px;">
         <div class="row">
                <div class="col-lg-2 col-md-2 hide-on-small-and-down">
                    <?php
                    require 'admin-menu.php'; 
                    ?>
                    </div>   
         <div class="col-lg-10 col-md-10 col-sm-12">
            <div class="vendor-table">
                    <div class="card">
                    <h5 class="page-header">&nbsp;&nbsp;Vendors</h5>
                            <table width="100%" class="table table-striped table-responsive table-bordered table-hover" id="dataTables-vendors">
                                <thead>
        <tr class="text-center">
            <th>Name</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Accounts</th>
            <th>Active</th>
            <th></th>
      </tr>
    </thead>
    <tbody>
        <?php
      while($row=mysqli_fetch_array($cat111)){  
?>
        <tr class="text-center">
        <td><?php echo $row[1]; ?></td>
        <td><?php echo $row[4]; ?></td>
        <td><?php echo $row[2]; ?></td>
        <td><?php echo $row[3]; ?></td>
        <td><?php echo Vendor::getcountofaccounts($row[0]); ?></td>
        <td><?php echo Vendor::getcountofactiveaccounts($row[0]); ?></td>
        <td class="request"><a href="#!" class="requested-cust"  id="<?php echo $row[0]; ?>">View Details</a></td>
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
                    <div class="vend-details card" style="display:none" >
                    <div class="vend-details-btns row  col-lg-2 col-md-2 right" style="display:none" >
      
                        <a class="btn red" id="btn_close">X</a>
                    </div>
                        <div class="vend-details-block">
                            
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
?>        <!-- /#page-wrapper -->
    <script>
        
    $("#dataTables-vendors").on('click','.requested-cust',function() {
		var form_status = $('<div class="form_status"></div>');
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
       var id= $(this).attr("id");
//       console.log("console -"+id+"-");
			$.ajax({
				
			type : 'POST',
			url  : 'vendor-detail.php',
			data : "vend_id="+id,
			beforeSend: function() {
//				$(this).html(status);
			},
			success :  function(response) {
//                            console.log("alert "+response);
                            $(".vend-details-block").html(response);
                            $(".vend-details-block").focus();
    $(".vend-details-block").ready(function() {
    $('#dataTables-vend-details').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }
    });
    
    
    
    $(".request").on('click',function() {
        var This=$(this);
		var form_status = $('<div class="form_status"></div>');
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
       var id= $(this).find(".requested-cust").attr("id");
			$.ajax({
				
			type : 'POST',
			url  : 'vendor-detail.php',
			data : "vend_id="+id,
			beforeSend: function() {
//				$(This).html(status);
			},
			success :  function(response) {
                            console.log("alert "+response);
                            $(".vend-details-block").html(response);
    $(".vend-details-block").ready(function() {
    $('#dataTables-vend-details').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }
    });
    
    $('#dataTables-vend-details').add(".vendor-disable").ready(function() {
        var origin=window.location.origin+"/";
        console.log("in vend-details-table");
		var form_status = $('<div class="form_status"></div>');
            
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');

    $(".vendor-disable").on('click',function() {
        console.log("vend-disable-clicked");

        var id= $(this).attr("id");
        console.log(id+"--");
		$.ajax({
			
			type : 'POST',
			url  : origin+"vend-disable-form.php",
			data : "vs_id="+id,
			beforeSend: function() {
                             $("#submit-vendor-reject").prop('disabled', true);
				$("#submit-vendor-reject").append( form_status.html('<h5><i class="fa fa-spinner fa-spin"></i> Disable...</h5>').fadeIn() );
			},
			success :  function(response) {
                            console.log("in response");
                            if(response.search("ok")>-1){
                                                $("#submit-vendor-reject").prop('disabled', true);
//                                                alert('Update Successful!');
                	form_status.html('<h5 class="text-success">Disabled.</h5>').delay(20000).fadeOut();                    
                window.location.href="Vendors";
            }    }
			});


    });
        
    $("#dataTables-vend-details").on('click','.vendor-disable',function() {
    var origin=window.location.origin+"/";
		var form_status = $('<div class="form_status"></div>');
            
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');

        var id= $(this).attr("id");
		$.ajax({
			
			type : 'POST',
			url  : '<?php echo $root."vend-disable-form.php"; ?>',
			data : "vs_id="+id,
			beforeSend: function() {
                             $("#submit-vendor-reject").prop('disabled', true);
				$("#submit-vendor-reject").append( form_status.html('<h5><i class="fa fa-spinner fa-spin"></i> Disable...</h5>').fadeIn() );
			},
			success :  function(response) {
                            console.log("now in respones");
                            if(response.search("ok")>-1){
                                                $("#submit-vendor-reject").prop('disabled', true);
//                                                alert('Update Successful!');
                	form_status.html('<h5 class="text-success">Disabled.</h5>').delay(20000).fadeOut();                    
                window.location.href="Vendors";
            }

    }
			});


    });
        


        $("#reason").on('keyup',function() {
            var len=$(this).val().length;
//            console.log(len);
                if(len>=5)
                    $(".rejectbtn").prop("disabled",false);
                else
                    $(".rejectbtn").prop("disabled",true);
            });

});
    
    
    
    
    });
        $(".vend-details").show("slow");
        $(".vend-details-btns").show("slow");
        $(".vendor-table").hide("slow");
//        $('#dataTables-vend-details').DataTable({
//            responsive: true
//        });
    }
			});


    });
    
    $("#btn_close").on('click',function() {
        $(".vendor-table").show("slow");
        $(".vend-details").hide("slow");
        $(".vend-details-btns").hide("slow");
        
    });

    
    
    });
                            
        $(".vend-details").show("slow");
        $(".vend-details-btns").show("slow");
        $(".vendor-table").hide("slow");
//        $('#dataTables-vend-details').DataTable({
//            responsive: true
//        });
    }
			});


    });
    
    

    </script>
    <script>
    $(document).ready(function() {
    $('#dataTables-vendors').DataTable({
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