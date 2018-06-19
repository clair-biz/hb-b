<html>
<head>
        <title> Homebiz365-- Service Provider's Services </title>

        <?php require_once 'stylesheets.html';?>
    </head>
<body>
<section class="body" >
    <section class="preloader" ></section>
    <section class="content" >
<?php
require_once 'data.php';


$vend_name=$user->u_name;
$vend_id=Base::getuidbyuname($user->u_name);
$q="select service.serv_id,serv_img,serv_name,serv_desc,serv_file from users,service,vend_subscription where users.u_id=vend_subscription.u_id and vend_subscription.vs_id=service.vs_id and service.is_active='Y' and u_name='$vend_name';";
$prod=Base::generateResult($q);
$cat=Base::generateResult("select DISTINCT cs_name, cs_id from cat_sub,vendor,category,users,vend_subscription where users.vend_id=vendor.vend_id and category.cat_id=cat_sub.cat_id and vend_subscription.cat_id=category.cat_id and u_name='$vend_name'");
?>
               
   <div class="container-fluid" style="margin-top: 40px;">
            <div class="row">
                 <div class="col-md-2 col-lg-2 hide-on-small-and-down">
                    <?php
                    require 'vendor-menu.php'; 
                    ?>
                    </div>
    
<div class="card col-lg-10 col-sm-12 col-md-offset-1 col-md-10">
            <div >
                <em class="hide-on-med-and-up text-center">Note: Click on field showing Plus mark to view details. Details are displayed below the record</em>
            </div>
    <table width="100%" class="table table-striped table-responsive table-bordered table-hover" id="dataTables-vendor-service">
    <thead>
        <tr  class="">
            <th>Service</th>
            <th>Name</th>
            <th>Description</th>
            <th>Service File</th>
            <!--th></th-->
            <th></th>
      </tr>
    </thead>
    <tbody>
        <?php
      while($row=mysqli_fetch_array($prod)){  
          $img=$root."uploads/products-services/".$row[1];
?>
        <tr class="text-center">
        <td>
            <img class="responsive-img table-img"
                 style="width: auto !important; display: block !important; margin-left: auto !important;
                 margin-right: auto !important;" src="<?php echo $img; ?>"
                 onError="this.onerror=null;this.src='http://www.homebiz365.in/uploads/images/small.png';" />
        </td>
        <td><?php echo $row[2]; ?></td>
        <td><?php echo $row[3]; ?></td>
        <td><?php echo $row[4]; ?></td>
          <!--td><a href="#!" data-message="<?php echo $row[0]; ?>" class="service-offline">Set Offline</a-->
          <td><a href="#!" data-message="<?php echo $row[0]; ?>" class="service-delete">Delete</a>
        </tr>

<?php }

//mysqli_free_result($req);
//req.close();
//stmtreq.close();
?>
  
    </tbody>
                            </table>
                            <!-- /.table-responsive -->
             </div>
            <!-- /.row -->

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
  $('#dataTables-vendor-service').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }
    });
});

    $("#dataTables-vendor-service").on('click','.service-delete',function() {
        var id= $(this).attr("data-message");
		$.ajax({
			
			type : 'POST',
			url  : 'serv_delete.php',
			data : "serv_id="+id,
			beforeSend: function() {
				$(this).html(preloader());
			},
			success :  function(response) {
                          if(response.search("ok")>-1) {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='text-center'>Service Deleted!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo $root; ?>";
                    window.location.href=root+"ServicesPage";
                });
                        }
//                            alert("Product Deleted Successfully");
                        else {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='text-center'>Unable to delete Service!\nPlease try again</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo $root; ?>";
                    window.location.href=root+"ServicesPage";
                });
                            }
    }
			});


    });

    $(".service-delete").on('click',function() {
        var id= $(this).attr("data-message");
		$.ajax({
			
			type : 'POST',
			url  : 'serv_delete.php',
			data : "serv_id="+id,
			beforeSend: function() {
				$(this).html(preloader());
			},
			success :  function(response) {
                          if(response.search("ok")>-1) {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='text-center'>Service Deleted!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo $root; ?>";
                    window.location.href=root+"ServicesPage";
                });
                        }
//                            alert("Product Deleted Successfully");
                        else {
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='text-center'>Unable to delete Service!\nPlease try again</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo $root; ?>";
                    window.location.href=root+"ServicesPage";
                });
                            }
    }
			});


    });
    
    

    </script>

    </body>
</html>
