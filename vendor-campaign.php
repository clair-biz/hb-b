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

//$vend_name=$_SESSION["user"];
$u_id=Base::getuidbyuname($user->u_name);
switch ($user->home_url) {
    case "ProductsPage" : $d="Product";
        break;
    case "ServicesPage" : $d="Service";
        break;
}


$q="select DISTINCT camp_name,camp_id, date_format(camp_start,'%d-%m-%Y'),date_format(camp_end,'%d-%m-%Y') from campaign where u_id=$u_id";

$prod=Base::generateResult($q);
//$prod=mysqli_query(Base::con(),$q);
$q="select DISTINCT cs_name, cs_id from cat_sub,vendor,category,users,vend_subscription where vend_subscription.vs_id=vendor.vs_id and category.cat_id=cat_sub.cat_id and vend_subscription.cat_id=category.cat_id and u_name='$vend_name'";
$cat=Base::generateResult($q);
?>
   <div class="container-fluid" style="margin-top: 40px;">
         <div class="row">
                <div class="col-md-2 col-lg-2 d-none d-md-block">
                    <?php
                    require 'vendor-menu.php'; 
                    ?>
                    </div>
                <div class="col-md-10 col-lg-10 col-sm-12">
                    <div class="card" >
                        <?php require_once 'vendor-camp-insert.php';?>
                    </div>
                    <div class="card vendor-campaign">
                    <h5 class="page-header text-center">My Offers</h5>
                        <div class="card-body">
                            <table width="100%" class="table table-striped table-responsive0 table-bordered table-hover" id="dataTables-example">
                                <thead>
        <tr  class="text-center">
            <th>Offer Name</th> 
            <th>Start Date</th>
            <th>End Date</th>
            <th></th>
            <th></th>
            <th></th>
      </tr>
    </thead>
    <tbody>
        <?php
      while($row=mysqli_fetch_array($prod)){  
?>
        <tr class="text-center">
        
        <td><?php echo $row[0]; ?></td>
        <td><?php echo $row[2]; ?></td>
        <td><?php echo $row[3]; ?></td>
        <td class="request"><a href="<?php if($d=="Product"){ 
            echo $root."AddProductToOffer/".$row[1];
        }
        elseif($d=="Service"){
           echo $root."AddServiceToOffer/".$row[1]; 
        }
?>"  id="<?php
        if($d=="Product")
        echo $row[1]."&type=Product";
        elseif($d=="Service")
        echo $row[1]."&type=Service";
        
        ?>"><?php if($d=="Product"){
            echo "Add Products";
        }
        elseif($d=="Service"){
            echo "Add Services";
        }?>
        </a></td>
        <td><a class="requested-camp" href="#" data-message="<?php
        echo $row[1];
        ?>">Edit</a></td>
        <td><a class="camp-delete" href="#" data-message="<?php
        if($d=="Product")
        echo "type=Product&delete_type=camp&camp_id=".$row[1];
        elseif($d=="Service")
        echo "type=Service&delete_type=camp&camp_id=".$row[1];
        
        ?>">Delete</a></td>
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
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    
                    <div class="camp-details row justify-content-center" style="display:none" >
                                <div class="col-md-6 card">
                                    <div class="card-body" >
                    <div class="camp-details-btns float-right" style="display:none" >
                        <a class="btn btn-danger" id="btn_close">X</a>
                    </div>
                                <div class="camp-details-block">
                                    
                                </div>
                                    </div>
                                </div>
                    </div>
                <!-- /.col-lg-12 -->
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
    
    $("#dataTables-example").on('click','.requested-camp',function() {
                var origin=window.location.origin+"/";
		var form_status = $('<div class="form_status"></div>');
       var id= $(this).attr("data-message");
       console.log("id "+id);
			$.ajax({
				
			type : 'POST',
			url  : '<?php echo $root."campaign-update-form.php"; ?>',
			data : "camp_id="+id,
			beforeSend: function() {
//				$(this).html(preloader());
			},
			success :  function(response) {
//                            console.log("alert "+response);
                            $(".camp-details-block").html(response);

        $(".camp-details-block #camp-update").find("#cname").focus();
        $(".camp-details-block #camp-update").ready(function() {
            
                var d = new Date();
//                $("#endt").prop("disabled",true);
                            console.log("in datepicker camp-upd"+d);
    $("#stdt, #endt").css("background-color","#fff","important");
       $('#stdt, #endt').datepicker({
            startDate: d,
            format: 'dd-mm-yyyy'
        });
/*        
        $("#stdt").on('change',function() {
                $("#endt").prop("disabled","false");
            
           var d1=date($(this).val());
           
       $('#endt').datepicker({
            startDate: d1,
            format: 'dd-mm-yyyy'
        });
        
        });
*/




		$( "#camp-update" ).validate( {
				rules: {
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
	   submitHandler: submitVendorCampUpdateForm	
       });  
	   /* validation */
	  
	   /* login submit */
	   function submitVendorCampUpdateForm() {		
			var data = $("#camp-update").serialize();
//                        console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : 'vendor-campaign-update1.php',
			data : data,
			beforeSend: function() {
                                $("#submit-camp-update").prop('disabled', true);
				$("#submit-camp-update").append( form_status.html('<h5><i class="fa fa-spinner fa-spin"></i></h5>').fadeIn() );
			},
			success :  function(response) {
                            console.log("resp-"+response+"-");
					if(response.search("success")>-1){
                                                $("#submit-camp-update").prop('disabled', true);
                                $("#camp-update").prepend("<p style='vertical-align:central;' class='text-center bg-success text-white'><i class='fa fa-exclamation' ></i> Update Successful!</p>").fadeIn().delay(5000).fadeOut();
                                setTimeout(window.location.reload(), 3000);
					}
					else{
                                $("#camp-update").prepend("<p style='vertical-align:central;' class='text-center bg-info text-white'><i class='fa fa-exclamation' ></i> Unable to Update! Please try again!</p>").fadeIn();

                                }
			  }
			});
				return false;
		}

        });

        $(".camp-details").show("slow");
        $(".camp-details-btns").show("slow");
//        $(".vendor-campaign").hide("slow");
//        $('#dataTables-camp-details').DataTable({
//            responsive: true
//        });
            }
	});
    });
    
    $("#btn_close").on('click',function() {
        $(".vendor-campaign").show("slow");
        $(".camp-details").hide("slow");
        $(".camp-details-btns").hide("slow");
        
    });
    

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
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
        responsive: true,
        retrieve: true,
        destroy: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }
        });
    });
    </script>
</body>

</html>