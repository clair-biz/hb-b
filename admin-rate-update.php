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
?>
    

        <!-- Navigation -->
         

        
        <div class="container-fluid" style="margin-top: 40px;">
         <div class="row">
                <div class="col-md-2 col-lg-2 d-sm-none d-md-block">
                    <?php
                    require 'admin-menu.php'; 
                    ?>
                    </div>
 
            
        <div class=" col-lg-10  col-md-10">
        <div class="card ">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                    <h5 class="page-header text-center">Update Charges</h5>
                <!-- /.col-lg-12 -->
                <div class="row " style="display: block;">
                <?php require_once 'rate-update0.php';?>
            </div>
                <div class="rate-content row " style="display: block;">
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
    
    
       
        <!-- /#page-wrapper -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }
        });
    });
    
        $("#cat_id").change(function() {
            var hy=$("#hy").val();
          var selected=$(this).val();
          if(selected!="") {
			$.ajax({
				
			type : 'POST',
			url  : 'rate-update-form.php',
			data : "cat_id="+selected+"&hy="+hy,
			beforeSend: function() {
				$(".rate-content").html(preloader());
			},
			success :  function(response) {
                            console.log("file"+response);
				$(".rate-content").html(response);
                                $('select').material_select();
                                $("#rate").focus();
                            }
                                        
			});
          }
       });
    </script>
</body>
</html>