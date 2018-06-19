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
                    <h5 class="page-header">Update Product</h5>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <?php require_once 'product-update0.php';?>
            </div>
            <div class="product-content">
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
            responsive: true
        });
    });
    
        $("#prod_id").change(function() {
          var selected=$(this).val();
          if(selected!="") {
			$.ajax({
				
			type : 'POST',
			url  : '<?php echo Crm::root()."product-update-form.php"; ?>',
			data : "prod_id="+selected,
			beforeSend: function() {
				$(".product-content").html(preloader());
			},
			success :  function(response) {
                            console.log("file"+response);
				$(".product-content").html(response);
                                $('select').formSelect();
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

    $("#unit").on('change',function() {
       var val=$(this).val();
       switch(val) {
           case "Kg" :
           case "mg":
           case "gm":
                        $(".mrp").html("for 1 Kg");
                        break;
           case "L":
           case "ml":
                        $(".mrp").html("for 1 Litre");
                        break;
           default :
                        $(".mrp").html("");
                        break;
                        
       }
    });

                            }
                                        
			});
          }
       });
    </script>
    <script>
$.validator.addMethod("namechk", function(value, element) {
  // allow any non-whitespace characters as the host part
  if(/[A-Za-z]{0,}/i.test( value )) 
  {
      return true;
  }
  else
      return false;
}, 'Please enter a Valid Email Address.');

     
    $.validator.addMethod("greaterThan0", function(value, element) {
  // allow any non-whitespace characters as the host part
  if(value>0 || value.length==0)
      return true;
}, 'Please enter a Valid Email Address.');


		$( ".product-content" ).ready( function () {

		$( "#prod-update" ).validate({
				rules: {
					file: {
                                            accept: "image/jpg,image/png,image/jpeg,image/gif",
                                            filesize: 1048576
                                             },
					qty: {
                                            number:true,
                                            greaterThan0: true
                                             },
                                         mrp: {
                                            greaterThan0: true,
                                            number: true
                                        },
					base: {
                                            greaterThan0: true,
                                            number: true
                                        },
					sp: {
                                            greaterThan0: true,
                                            number: true
                                        },
					cgst: {
                                            number: true,
                                            greaterThan0: true
                                        },
					sgst: {
                                            number: true,
                                            greaterThan0: true
                                        }
                                        
				},
				messages: {
					file: {
                                           accept: "Provide jpg,jpeg,png or gif image!",
                                            filesize: "The image size should be less than 1MB!"
					},
					qty: {
					   greaterThan0: "Please enter Quantity greater than 0",
						number: "Please enter Numbers only"
					},
                                        mrp: {
                                           greaterThan0: "Please enter MRP greater than 0",
                                           number: "Please enter Numbers only"
                                        },
					base: {
                                           greaterThan0: "Please enter Base Price greater than 0",
                                           number: "Please enter Numbers only"
                                        },
					sp: {
                                           greaterThan0: "Please enter Selling Price greater than 0",
                                           number: "Please enter Numbers only"
                                        },
					cgst: {
                                           greaterThan0: "Please enter CGST than 0",
                                           number: "Please enter Numbers only"
                                        },
					sgst: {
                                          greaterThan0: "Please enter CGST than 0",
                                           number: "Please enter Numbers only"
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
                        
		} );


        </script>
</body>
</html>