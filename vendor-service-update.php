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
        

        
        <div class="container-fluid" style="margin-top: 40px !important;" >
        <div class="row">
            <div class="col-md-2 col-lg-2 hide-on-small-and-down">
                    <?php
                    require 'vendor-menu.php'; 
                    ?>
                    </div>

            <div class="card col-lg-10 col-md-offset-1 col-md-10">

            <div class="row">
                    <h5 class="page-header text-center">Update Service</h5>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <?php require_once 'service-update0.php';?>
            </div>
            <div class="service-content">
            </div>
        </div>
        </div>
</div>
<!-- Modal Structure -->
    <div id="modal-update-service-details" class="modal" >
        <div class="modal-content"></div>
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


        $("#serv_id").change(function() {
          var selected=$(this).val();
          if(selected!="") {
			$.ajax({
				
			type : 'POST',
			url  : '<?php echo Crm::root()."service-update-form.php"; ?>',
			data : "serv_id="+selected,
			beforeSend: function() {
				$(".service-content").html(preloader());
			},
			success :  function(response) {
                            console.log("file"+response);
				$(".service-content").html(response);
                                $("#sname").focus();
                                $('select').material_select();
    function showothercat() {
        var val=$("#subcat").val();
        console.log("subcat val "+val);
        switch(val) {
            case "0": $(".cat1").show();
                break;
            default: $(".cat1").hide();
        }
    }
    $("#subcat").on('click', function() {
        showothercat();
        console.log("subcat clicked");
    });
    $("#subcat").on('change', function() {
        showothercat();
        console.log("subcat changed");
    });

    $(".view-file").on('click',function() {
        var id=$(this).attr("id");
        $(".details").toggle();
			$.ajax({
				
			type : 'POST',
			url  : '<?php echo Crm::root()."view-pdf.php"; ?>',
			data : "id="+id,
			beforeSend: function()
			{	
				$("#error").fadeOut();
				$(".view-file").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; loading ...');
			},
			success :  function(response) {
                            console.log("file"+response);
                            if(response!="") {
                                var object=null;
                            	var ext = response.split(".");
                            	
	ext=ext[(ext.length)-1];
	if(ext=="png" || ext=="jpeg" || ext=="gif" || ext=="jpg")
		type="image/"+ext;
	else if(ext=="pdf" || ext=="PDF")
		type="application/"+ext;
    if(ext!=="docx" && ext!=="doc") {
    	if(ext=="png" || ext=="jpeg" || ext=="gif" || ext=="jpg")
            object = "<object src="+{response}+" style=\"height: 100% !important; margin-left:auto !important; margin-right:auto !important; width: auto !important; \" ><embed src="+response+" style=\"height: 100% !important; margin:auto !important; display:block !important;  \"></embed></object>";

            else if(ext=="pdf" || ext=="PDF")
                    object = "<object data="+{response}+" type="+type+" style=\"height: 100% !important; margin-left:auto !important; margin-right:auto !important; width: 100% !important; \" ></object>";
                    object = object.replace({response},  response);
    }
    else {
                        object = "<iframe src="+{response}+" width=\"100%\" height=\"100% !important;\"></iframe>";
                        object = object.replace({response},  response);


    }

                            console.log("alert obj "+object);
                            $("#modal-service-brochure").find(".modal-content").html(object);
                            $("#modal-service-brochure").modal('open');

                            if(ext=="docx" || ext=="doc")
                                $("#modal-service-brochure").modal('close');
                                
                            }
                            else
                                alert("Brochure/ Flyer not uploaded by the Service Provider");
                            },
                                    complete: function() {
				$(".view-file").html('<span class="glyphicon glyphicon-arrow-down"></span> View Brochure/Flyer');
                            }
                                        
			});

    });
    $(".close-file").on('click',function() {
    $(this).hide();
    $(".details").hide();
    $(".view-file").show();
    $(".view-file").html("<span class=\"glyphicon  glyphicon-arrow-down\"></span> View Brochure/Flyer");
    });
                            }
                                        
			});
          }
       });
       
       
    $.validator.addMethod("greaterThan0", function(value, element) {
  // allow any non-whitespace characters as the host part
  if(value>0 || value.length==0)
      return true;
}, 'Please enter a Valid Email Address.');
   
$.validator.addMethod('filesize', function(value, element, param) {
    // param = size (en bytes) 
    // element = element to validate (<input>)
    // value = value of the element (file name)
    return this.optional(element) || (element.files[0].size <= param) 
});


    
    $("form.serv-update").ready( function () {

		$( ".serv-update" ).validate( {
				rules: {
					file: {
                                            accept: "image/jpg,image/png,image/jpeg,image/gif",
                                            filesize: 1048576
                                        },
					file1: {
                                            accept: "application/pdf,application/docx,application/doc,image/jpg,image/png,image/jpeg,image/gif",
                                            filesize: 1048576*5
                                        }
				},
				messages: {
					file: {
                                           accept: "Provide jpg,jpeg,png or gif image!",
                                             filesize: "The image size should be less than 1MB!"
                                        },
					file1: {
                                           accept: "Provide pdf,docx,doc or image!",
                                             filesize: "The Brochure size should be less than 5MB!"
                                        }
				},
                                errorElement : 'em',
        errorPlacement: function(error, element) {
          var placement = $(element).data('error');
          if (placement) {
            $(placement).append(error);
          } else {
            error.insertAfter(element);
          }
        }
			} );
                    });

    </script>
</body>
</html>