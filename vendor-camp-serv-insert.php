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

switch ($user->home_url) {
    case "ProductsPage" : $d="Product";
        break;
    case "ServicesPage" : $d="Service";
        break;
}


$camp_id=$_REQUEST["camp"];
$catstr="select cs_id,cs_name from cat_sub,category,vend_subscription,users where category.cat_id=cat_sub.cat_id and vend_subscription.cat_id=category.cat_id and users.u_id=vend_subscription.u_id and u_name='".$user->u_name."';";
$catres=Base::generateResult($catstr);
$prodres=Base::generateResult("select service.serv_id,serv_name from service,users where service.vs_id and u_name='".$user->u_name."' and service.vs_id=".$user->vs_id.";");
?>

    <div class="container-fluid row" style="margin-top: 40px;">
        <div class="row">
                <div class="col-md-2 col-lg-2 d-none d-md-block ">
                    <?php
                    require 'vendor-menu.php'; 
                    ?>
                    </div>
<div id="camp-insert-tab" class="col-md-10 col-lg-10">
            <div class="row">
                <div class="col-lg-12">
                    <h5 class="page-header">Service in <?php echo Campaign::getcampnamebyid($camp_id)." Offer"; ?></h5>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
    <table width="100%" class="table table-striped table-responsive0 table-bordered col s12 table-hover" id="dataTables-example">
                                <thead>
      <tr>
    <th class="text-center">Service</th>
    <th class="text-center">Category</th>
    <th class="text-center">Discount</th>
    <th class="text-center"></th>
      </tr>
    </thead>
    <tbody>
            <?php
$camp_prodres=Base::generateResult("select serv_id,cs_id,camp_serv_map.perc_disc from camp_serv_map where camp_id=$camp_id;");
while($camp_prod= mysqli_fetch_array($camp_prodres)) {
?>
        <tr class="text-center">
        <td><?php if($camp_prod[0]!=0){ echo Product::getservnamebyid($camp_prod[0]); } else {echo "-";}  ?></td>
        <td><?php if($camp_prod[1]!=0){ echo Base::getcsnamebyid($camp_prod[1]); } else {echo "-";}  ?></td>
        <td><?php echo $camp_prod[2]; ?></td>
        
         <td>
            <a href="#" data-message="<?php echo "delete_type=camp-serv&camp_id=$camp_id&type=Service&serv_id=".$camp_prod[0]."&cs_id=".$camp_prod[1]; ?>" class="camp-delete">Delete</a>
        </td>

         </tr>

<?php
}
?>
    </tbody>

      </table>
                            <!-- /.table-responsive -->


<form class="form-horizontal row" id="camp-serv-insert" action="<?php echo $root."vendor-camp-serv-insert1.php"; ?>" method="post">
<div class="col-md-10 offset-md-1 col-lg-10 offset-lg-1 ">
       <div class="row mb-3">
            <p class="col-md-4" for="campon">Offer On:</p>
            <div class="col-md-4">
                <select class="form-control" id="campon" name="campon" required>
                    <option value="">-select-</option>
                    <option value="1">Service</option>
                    <option value="2">Category</option>
                </select>
                </div>
        </div>
        <div id="displayService" class="md-3" style="display:none !important;">
	<div class="form-group" data-parent="#displayService">
       <div class="row">
            <p class="col-md-4" >Service:</p>
            <div class="col-md-4">
                <select class="form-control" id="serv" name="serv" >
                    <option selected="true" value="0">-Select-</option>

                <?php
      while($prod= mysqli_fetch_array($prodres)){  
                    ?>
                    <option value="<?php echo $prod[0]; ?>"><?php echo $prod[1]; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
	</div>
	</div>
        </div>
        
        <div id="displayCat" class="md-3" style="display:none !important;">
	<div class="form-group" data-parent="#displayCat">
       <div class="row">
            <p class="col-md-4" >Service Category:</p>
            <div class="col-md-4">
                <select class="form-control" id="pc" name="pc" >
                    <option selected="true" value="">-Select-</option>
                <?php
      while($cat= mysqli_fetch_array($catres)){  
                    ?>
                    <option value="<?php echo $cat[0]; ?>"><?php echo $cat[1]; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            </div>
            </div>
	</div>
   
    <div class="row mb-3">
            <p class="col-md-4" >Discount:</p>
            <div class="col-md-4">
                <input type="text" class="form-control" autocomplete="off" placeholder="This Field is mandatory" id="disc" name="disc" required />
            </div>
        </div>
    
    <div class="row mb-3">
            <p class="col-md-4">Add Campaign Image <font style="color:red">*</font>:</p>
                <div class="col-md-4 form-group">
                    <input class="form-control" name="file" type="file" id="customfile" accept="image/jpg,image/png,image/jpeg,image/gif" >
<em>Note: The image size should not be more than 1 MB</em>
                </div>
                </div>

    
    <div class="row btns-block">
                <input type="hidden" value="<?php echo $camp_id; ?>" name="camp_id"/>
	<div class="col-md-3 offset-md-1 col-lg-3 offset-lg-1 ">
            <button type="submit" id="" name="sub" value="more" class="btn btn-block btn-primary" >Add More</button>
	</div>
	<div class="col-md-3 offset-md-1 col-lg-3 offset-lg-1 ">
            <button type="submit" id="" name="sub" value="submit" class="btn btn-block btn-primary" >Done</button>
	</div>
    </div>
    </div>
</form>

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
    $("#dataTables-example").on('click','.camp-delete',function() {
                var origin=window.location.origin+"/";
		var form_status = $('<div class="form_status"></div>');
        var data= $(this).attr("data-message");
        var This=$(this);
    console.log("data -"+data+"-");
        
		$.ajax({
			
			type : 'POST',
			url  : origin+"vend-camp-delete.php",
			data : data,
			beforeSend: function() {
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
				This.html(status);
			},
			success :  function(response) {
                            console.log("response -"+response+"-");
                        if(response.search("success")>-1) {
                                $(".vendor-campaign").prepend("<p style='vertical-align:central;' class='text-center bg-success text-white'><i class='fa fa-exclamation' ></i> Delete Successful!</p>").fadeIn().delay(5000).fadeOut();
                                $(".vendor-campaign").scrollTop();
                                setTimeout(function() {
                    window.location.reload();
                                },5000);
                        }
//                            alert("Product Deleted Successfully");
                        else {
                                $(".vendor-campaign").prepend("<p style='vertical-align:central;' class='text-center bg-danger text-white'><i class='fa fa-exclamation' ></i> Delete Failed!</p>").fadeIn().delay(5000).fadeOut();
                            }
//                            alert("Unable to Delete Product");
        console.log("alert-"+response+"-");
//                           setTimeout(' window.location.href = "vendor-product.php"; ',2000);
    }
			});


    });


            </script>

        <script>
/*             $("#campon").change(function() {
          var selected=$(this).val();
console.log(selected);
        switch(selected) {
               case 'Category':
               case 'Product':
                        $("#prod-cat-block").toggle();
          			$.ajax({
				
			type : 'POST',
			url  : 'prod_camp_list.php',
			data : "prod="+selected,
			beforeSend: function()
			{	
				$("#error").fadeOut();
				$(".btn-list").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success :  function(response) {
//                            console.log("alert "+response);
                            $("#prod-cat-block").show();
                            $("#prod-cat-block").html(response);
                            console.log(response);

    }
			});
                               break;
               default:
                        $("#prod-cat-block").hide();
                               break;
          }
          

        });*/

            </script>
    <script>
        $("#campon").change(function() {
           selected=$(this).val();
           switch(selected) {
               case '1': $("#displayService").show();
                         $("#displayCat").hide();
                               break;
               case '2': $("#displayCat").show();
                         $("#displayService").hide();
                               break;
               default : $("#displayService").hide();
                         $("#displayCat").hide();
                        break;
           }
//           alert("selected "+selected);
        });
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
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