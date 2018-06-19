jQuery(function($) {'use strict';
                var origin=window.location.origin+"/";
		var form_status = $('<div class="form_status"></div>');
    var status=form_status;
    status.html('<i class="fa fa-spinner fa-spin"></i>');
            
jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});


function displayProductTable() {
    
		$.ajax({
			
			type : 'POST',
			url  : origin+"vendor-product-table.php",
			beforeSend: function() {
				$(".product-content").html(status);
			},
			success :  function(response) {
//                            console.log("response -"+response+"-");
                            $(".product-content").html(response);
    $(".product-content").ready(function() {
        
if ( ! $.fn.DataTable.isDataTable( '#dataTables-vendor-product' ) ) {
    $('#dataTables-vendor-product').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
    }
        });
        
    }

    $(".product-delete").on('click',function() {
        var id= $(this).attr("data-message");
    console.log("data -"+id+"-");
        
		$.ajax({
			
			type : 'POST',
			url  : origin+"prod_delete.php",
			data : "prod_id="+id,
			beforeSend: function() {
				$(this).html(status);
			},
			success :  function(response) {
//                            console.log("response -"+response+"-");
                        if(response.search("ok")>-1) {
                                $(".product-update-block").prepend("<p style='vertical-align:central;' class='text-center bg-success text-white'><i class='fa fa-exclamation' ></i> Update Successful!</p>").fadeIn().delay(5000).fadeOut();
                         window.location.reload();       
                        }
//                            alert("Product Deleted Successfully");
                        else {
                            }
//                            alert("Unable to Delete Product");
        console.log("alert-"+response+"-");
//                           setTimeout(' window.location.href = "vendor-product.php"; ',2000);
    }
			});


    });
    
    $(".product-edit").on('click',function() {
    var This=$(this);
        var origin=window.location.origin+"/";
		var form_status = $('<div class="form_status d-flex align-items-center"></div>');
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
        var id= $(this).attr("data-message");
    console.log("data -"+id+"-");
        
		$.ajax({
			
			type : 'POST',
			url  : origin+"product-update-form.php",
			data : "prod_id="+id,
			beforeSend: function() {
				$(This).append(status);
			},
			success :  function(response) {
//                            console.log("response -"+response+"-");
                            $(".product-update-block").html(response);
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
                            
                            $("#prod-update").ready(function() {
//                            $(".product-update-block").focus();
                            status.html("");
                                function showothercat() {
        var val=$("#subcat").val();
       // console.log("subcat val "+val);
        switch(val) {
            case "0": $(".cat1").show();
                break;
            default: $(".cat1").hide();
        }
    }
    $("#subcat").on('click', function() {
        showothercat();
        //console.log("subcat clicked");
    });
    $("#subcat").on('change', function() {
        showothercat();
        //console.log("subcat changed");
    });
    $("#subcat").on('select', function() {
        showothercat();
       // console.log("subcat selected");
    });
     
     function showothercity() {
        var val=$("#city").val();
        console.log("city val "+val);
        switch(val) {
            case "0": $(".city1").show();
                break;
            default: $(".city1").hide();
        }
    }
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
    

    $("#unit, #qty").on('change',function() {
        
       var unit=$("#unit").val();
       var qty=$("#qty").val();
       if(unit.length>0 && qty.length>0)
       $(".base_prc").html("for "+qty+" "+unit );
    });
    
        
                    $(".prod-update").validate({
				rules: {
					file: {
                                            fileType: {
                                                "types": ["image/jpg","image/png","image/jpeg","image/gif"]
                                            },
                                            maxFileSize: {
                                                "unit": "MB",
                                                "size": "1"
                                            },
                                            minFileSize: {
                                                "unit": "KB",
                                                "size": "0"
                                            }
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
                                        },
                                        cat1: {
                                            required: {
                                                depends: function() {
                                                    var cat_opt=$("#subcat").val();
                                                    
                                                    switch(cat_opt) {
                                                        case "0": return true;
                                                            break;
                                                        default: return false;
                                                            break;
                                                        }
                                                    }
                                                }
                                        }
                                        
				},
				messages: {
					file: {
                                           accept: "Provide jpg,jpeg,png or gif image!"
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
        },
	   submitHandler: submitProductUpdateForm	
       });  

	   function submitProductUpdateForm() {
			var data = new FormData( $(".prod-update")[0]);
//                        alert("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : origin+'vendor-product-update1.php',
                        processData: false,
                        enctype: 'multipart/form-data',
                        contentType: false ,
                        timeout: 600000,
                        data : data,
			beforeSend: function() {	
				$("#error").fadeOut();
                                $("#submit-prod-update").prop('disabled', true);
				$(".loader-block").html('<h5><i class="fa fa-spinner fa-spin"></i> Validating...</h5>').fadeIn();
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
				$("#submit-prod-update").append(status);
			},
			success :  function(response) {
                            console.log("resp "+response);
                            if(response.search("success")>-1) {
                                $(".product-update-block").prepend("<p style='vertical-align:central;' class='text-center bg-success text-white'><i class='fa fa-exclamation' ></i> Update Successful!</p>").fadeIn().delay(5000).fadeOut();
//                                setTimeout( displayProductTable(),5000);
                                    window.location.reload();
                            }
                            else {
                                $(".product-update-block").prepend("<p style='vertical-align:central;' class='text-center bg-danger text-white'><i class='fa fa-exclamation' ></i> Update Failed!</p>").fadeIn().delay(5000).fadeOut();
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
    
    $("#dataTables-vendor-product").on('click','.product-delete',function() {
        var id= $(this).attr("data-message");
        var This=$(this);
    console.log("data -"+id+"-");
        
		$.ajax({
			
			type : 'POST',
			url  : origin+"prod_delete.php",
			data : "prod_id="+id,
			beforeSend: function() {
				This.html(status);
			},
			success :  function(response) {
                            console.log("response -"+response+"-");
                        if(response.search("ok")>-1) {
                                $(".product-content").prepend("<p style='vertical-align:central;' class='text-center bg-success text-white'><i class='fa fa-exclamation' ></i> Delete Successful!</p>").fadeIn().delay(5000).fadeOut();
                                $(".product-content").scrollTop();
                                setTimeout(function() {
                    window.location.reload();
                                },5000);
                        }
//                            alert("Product Deleted Successfully");
                        else {
                                $(".product-content").prepend("<p style='vertical-align:central;' class='text-center bg-danger text-white'><i class='fa fa-exclamation' ></i> Update Failed!</p>").fadeIn().delay(5000).fadeOut();
                            }
//                            alert("Unable to Delete Product");
        console.log("alert-"+response+"-");
//                           setTimeout(' window.location.href = "vendor-product.php"; ',2000);
    }
			});


    });
    
    });
                        }
                    });

    
    
}


function displayServiceTable() {
    
		$.ajax({
			
			type : 'POST',
			url  : origin+"vendor-service-table.php",
			beforeSend: function() {
				$(".service-content").html(status);
			},
			success :  function(response) {
//                            console.log("response -"+response+"-");
                            $(".service-content").html(response);
    $(".service-content").ready(function() {
        
if ( ! $.fn.DataTable.isDataTable( '#dataTables-vendor-service' ) ) {
    $('#dataTables-vendor-service').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
    }
        });
    }

    $(".service-delete").on('click',function() {
        var id= $(this).attr("data-message");
    console.log("data -"+id+"-");
        
		$.ajax({
			
			type : 'POST',
			url  : origin+"serv_delete.php",
			data : "serv_id="+id,
			beforeSend: function() {
				$(this).html(status);
			},
			success :  function(response) {
//                            console.log("response -"+response+"-");
                        if(response.search("ok")>-1) {
                                $(".service-update-block").prepend("<p style='vertical-align:central;' class='text-center bg-success text-white'><i class='fa fa-exclamation' ></i> Delete Successful!</p>").fadeIn().delay(5000).fadeOut();
                         window.location.reload();       
                        }
//                            alert("Product Deleted Successfully");
                        else {
                            }
//                            alert("Unable to Delete Product");
        console.log("alert-"+response+"-");
//                           setTimeout(' window.location.href = "vendor-product.php"; ',2000);
    }
			});


    });
    
    $(".service-edit").on('click',function() {
    var This=$(this);
        var origin=window.location.origin+"/";
		var form_status = $('<div class="form_status d-flex align-items-center"></div>');
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
        var id= $(this).attr("data-message");
    console.log("data -"+id+"-");
        
		$.ajax({
			
			type : 'POST',
			url  : origin+"vendor-service-update-form.php",
			data : "serv_id="+id,
			beforeSend: function() {
				$(This).append(status);
			},
			success :  function(response) {
//                            console.log("response -"+response+"-");
                            $(".service-update-block").html(response);
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
                            
                            $("#serv-update").ready(function() {
//                            $(".product-update-block").focus();
                            status.html("");
                                function showothercat() {
        var val=$("#subcat").val();
       // console.log("subcat val "+val);
        switch(val) {
            case "0": $(".cat1").show();
                break;
            default: $(".cat1").hide();
        }
    }
    $("#subcat").on('click', function() {
        showothercat();
        //console.log("subcat clicked");
    });
    $("#subcat").on('change', function() {
        showothercat();
        //console.log("subcat changed");
    });
    $("#subcat").on('select', function() {
        showothercat();
       // console.log("subcat selected");
    });
     
     function showothercity() {
        var val=$("#city").val();
        console.log("city val "+val);
        switch(val) {
            case "0": $(".city1").show();
                break;
            default: $(".city1").hide();
        }
    }
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
    

    $("#unit, #qty").on('change',function() {
        
       var unit=$("#unit").val();
       var qty=$("#qty").val();
       if(unit.length>0 && qty.length>0)
       $(".base_prc").html("for "+qty+" "+unit );
    });
    
        
                    $("#serv-update").validate({
				rules: {
                                    sname: "required",
					file: {
                                            accept: "image/jpg,image/png,image/jpeg,image/gif",
                                            maxFileSize: {
                                                "unit": "MB",
                                                "size": "1"
                                            },
                                            minFileSize: {
                                                "unit": "KB",
                                                "size": "0"
                                            }
                                             },
					file1: {
                                            accept: "application/pdf,application/docx,application/doc,image/jpg,image/png,image/jpeg,image/gif",
                                            maxFileSize: {
                                                "unit": "MB",
                                                "size": "5"
                                            },
                                            minFileSize: {
                                                "unit": "KB",
                                                "size": "0"
                                            }
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
	   submitHandler: submitServiceUpdateForm	
       });  

	   function submitServiceUpdateForm() {
			var data = new FormData( $("#serv-update")[0]);
//                        alert("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : origin+'vendor-service-update1.php',
                        processData: false,
                        enctype: 'multipart/form-data',
                        contentType: false ,
                        timeout: 600000,
                        data : data,
			beforeSend: function() {	
				$("#error").fadeOut();
                                $("#submit-serv-update").prop('disabled', true);
				$(".loader-block").html('<h5><i class="fa fa-spinner fa-spin"></i> Validating...</h5>').fadeIn();
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
				$("#submit-serv-update").append(status);
			},
			success :  function(response) {
                            console.log("resp "+response);
                            if(response.search("success")>-1) {
                                $(".service-update-block").prepend("<p style='vertical-align:central;' class='text-center bg-success text-white'><i class='fa fa-exclamation' ></i> Update Successful!</p>").fadeIn().delay(5000).fadeOut();
//                                setTimeout( displayProductTable(),5000);
                                    window.location.reload();
                            }
                            else {
                                $(".service-update-block").prepend("<p style='vertical-align:central;' class='text-center bg-danger text-white'><i class='fa fa-exclamation' ></i> Update Failed!</p>").fadeIn().delay(5000).fadeOut();
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
    
    $("#dataTables-vendor-service").on('click','.service-delete',function() {
        var id= $(this).attr("data-message");
        var This=$(this);
    console.log("data -"+id+"-");
        
		$.ajax({
			
			type : 'POST',
			url  : origin+"serv_delete.php",
			data : "serv_id="+id,
			beforeSend: function() {
				This.html(status);
			},
			success :  function(response) {
                            console.log("response -"+response+"-");
                        if(response.search("ok")>-1) {
                                $(".service-content").prepend("<p style='vertical-align:central;' class='text-center bg-success text-white'><i class='fa fa-exclamation' ></i> Delete Successful!</p>").fadeIn().delay(5000).fadeOut();
                                $(".service-content").scrollTop();
                                setTimeout(function() {
                    window.location.reload();
                                },5000);
                        }
//                            alert("Product Deleted Successfully");
                        else {
                                $(".service-content").prepend("<p style='vertical-align:central;' class='text-center bg-danger text-white'><i class='fa fa-exclamation' ></i> Update Failed!</p>").fadeIn().delay(5000).fadeOut();
                            }
//                            alert("Unable to Delete Product");
        console.log("alert-"+response+"-");
//                           setTimeout(' window.location.href = "vendor-product.php"; ',2000);
    }
			});


    });
    
    });
                        }
                    });

    
    
}


    $(document).ready(function() {
            var path=window.location.pathname;
            console.log("path-"+path+"-");
            if(path.search("/")>-1) {
            path=path.split("/");
            path=path[1];
        }
        
$('[data-toggle="tooltip"]').tooltip();

                                if(path.search("ProductsPage")>-1 ) {
                                displayProductTable();
   $(".product-content").ready(function() {     
if ( ! $.fn.DataTable.isDataTable( '#dataTables-vendor-product' ) ) {
    $('#dataTables-vendor-product').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
    }
        });
    }
    });
    }
    
                                else if(path.search("ServicesPage")>-1 ) {
                                displayServiceTable();
                            
   $(".service-content").add("#dataTables-vendor-service").ready(function() {     
if ( ! $.fn.DataTable.isDataTable( '#dataTables-vendor-service' ) ) {
    $('#dataTables-vendor-service').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
    }
        });
    }
    });
    
        }
});


    $(document).ready(function() {
		$( "#serv-insert" ).validate( {
				rules: {
					sname:"required",
                                        sdesc:"required",
                                        subcat:"required",
					file: {
                                            required: true,
                                            accept: "image/jpg,image/png,image/jpeg,image/gif",
                                            maxFileSize: {
                                                "unit": "MB",
                                                "size": "1"
                                            },
                                            minFileSize: {
                                                "unit": "KB",
                                                "size": "0"
                                            }
                                        },
					file1: {
                                            accept: "application/pdf,application/docx,application/doc,image/jpg,image/png,image/jpeg,image/gif",
                                            maxFileSize: {
                                                "unit": "MB",
                                                "size": "5"
                                            },
                                            minFileSize: {
                                                "unit": "KB",
                                                "size": "0"
                                            }
                                        }
				},
				messages: {
					file: {
                                            required: "Please provide image!",
                                            accept: "Provide jpg,jpeg,png or gif image!",
                                           filesize: "The image size should be less than 1MB!"
                                        },
					file1: {
                                            accept: "Provide pdf,docx,doc or image!",
                                            filesize: "The Brochure size should be less than 5MB!"
                                        },
					sname:"Please enter Service Name",
                                        sdesc:"Please enter Description",
                                        subcat:"Please select category"
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
	   submitHandler: submitServiceInsertForm	
       });  

	   function submitServiceInsertForm() {
			var data = new FormData( $("#serv-insert")[0]);
                        console.log("data "+data.toString() );
			$.ajax({
				
			type : 'POST',
			url  : origin+'vendor-serv-insert1.php',
                        processData: false,
                        enctype: 'multipart/form-data',
                        contentType: false ,
                        timeout: 600000,
                        data : data,
			beforeSend: function() {	
				$("#error").fadeOut();
                                $("#submit-serv-insert").prop('disabled', true);
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
				$("#submit-serv-insert").append(status);
			},
			success :  function(response) {
                            console.log("resp "+response);
                            if(response.search("success")>-1) {
                                $("#serv-insert").prepend("<p style='vertical-align:central;' class='text-center bg-success text-white'><i class='fa fa-exclamation' ></i> Added Successfully!</p>").fadeIn().delay(5000).fadeOut();
//                                setTimeout( displayProductTable(),5000);
                                    window.location.href=origin+"ServicesPage";
                            }
                            else {
                                $("#submit-serv-insert").prop('disabled', true);
                                $("#submit-serv-insert").find(".form_status").html('');
                                
                                $("#serv-insert").prepend("<p style='vertical-align:central;' class='text-center bg-danger text-white'><i class='fa fa-exclamation' ></i> Unable to Add Service!</p>").fadeIn().delay(5000).fadeOut();
                            }
                                
			  }
			});
				return false;
		}
 
    });


    $(document).add(".cat1").ready( function () {
    function showothercat() {
        var val=$("#subcat").val();
       // console.log("subcat val "+val);
        switch(val) {
            case "0": $(".cat1").show();
                break;
            default: $(".cat1").hide();
        }
    }
    $("#subcat").on('click', function() {
        showothercat();
        //console.log("subcat clicked");
    });
    $("#subcat").on('change', function() {
        showothercat();
        //console.log("subcat changed");
    });
    $("#subcat").on('select', function() {
        showothercat();
       // console.log("subcat selected");
    });
     
     function showothercity() {
        var val=$("#city").val();
        console.log("city val "+val);
        switch(val) {
            case "0": $(".city1").show();
                break;
            default: $(".city1").hide();
        }
    }
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
    

    $("#unit, #qty").on('change',function() {
        
       var unit=$("#unit").val();
       var qty=$("#qty").val();
       if(unit.length>0 && qty.length>0)
       $(".base_prc").html("for "+qty+" "+unit );
    });


		$( "#prod-insert" ).validate( {
				rules: {
					pname:"required",
                                        subcat:"required",
					file: {
                                            required: true,
                                            fileType: {
                                                "types": ["image/jpg","image/png","image/jpeg","image/gif"]
                                        },
                                            maxFileSize: {
                                                "unit": "MB",
                                                "size": "1"
                                            },
                                            minFileSize: {
                                                "unit": "KB",
                                                "size": "0"
                                            }
                                             },
                                      qty: {
    						required: true,
                                                number:true
                                        },
                                         base_prc: {
                                            required: true,
                                            number: true
                                        },
					cgst: {
                                            required: true,
                                            number: true
                                        },
					cat1: {
                                            required: true,
                                            namechk: true
                                        },
					sgst: {
                                            required: true,
                                            number: true
                                        }    
                                        
				},
				messages: {
					file: {
                                           accept: "Provide jpg,jpeg,png or gif image!",
                                            required: "Please provide image!",
                                            filesize: "The image size should be less than 1MB!"
                                        },
					pname:"Please enter Product Name",
                                        subcat:"Please select category",
					
					qty: {
						required: "Please enter a Quantity",
                                           greaterThan0: "Please enter Quantity greater than 0",
						number: "Please enter Numbers only"
					},
                                        base_prc: {
                                           required: "Please enter MRP",
                                           number: "Please enter Numbers only"
                                        },
					cgst: {
                                           required: "Please enter CGST",
                                           number: "Please enter Numbers only"
                                        },
					cat1: {
                                           required: "Please enter Category",
                                           namechk: "Please enter Alphabets only"
                                        },
					sgst: {
                                           required: "Please enter SGST",
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
        },
	   submitHandler: submitProductInsertForm	
       });  

	   function submitProductInsertForm() {
			var data = new FormData( $("#prod-insert")[0]);
                        console.log("data "+data.toString() );
			$.ajax({
				
			type : 'POST',
			url  : origin+'vendor-prod-insert1.php',
                        processData: false,
                        enctype: 'multipart/form-data',
                        contentType: false ,
                        timeout: 600000,
                        data : data,
			beforeSend: function() {	
				$("#error").fadeOut();
                                $("#submit-prod-insert").prop('disabled', true);
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
				$("#submit-prod-insert").append(status);
			},
			success :  function(response) {
                            console.log("resp "+response);
                            if(response.search("success")>-1) {
                                $("#prod-insert").prepend("<p style='vertical-align:central;' class='text-center bg-success text-white'><i class='fa fa-exclamation' ></i> Update Successful!</p>").fadeIn().delay(5000).fadeOut();
//                                setTimeout( displayProductTable(),5000);
                                    window.location.href=origin+"ProductsPage";
                            }
                            else {
                                $("#submit-prod-insert").prop('disabled', true);
                                $("#submit-prod-insert").find(".form_status").html('');
                                
                                $("#prod-insert").prepend("<p style='vertical-align:central;' class='text-center bg-danger text-white'><i class='fa fa-exclamation' ></i> Update Failed!</p>").fadeIn().delay(5000).fadeOut();
                            }
                                
			  }
			});
				return false;
		}

		} );

                $(document).ready(function() {
		$( "#camp-insert" ).validate( {
				rules: {
					cname:"required",
                                        stdt:"required",
                                        enddt:"required",
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
	   submitHandler: submitCampaignInsertForm	
       });  

	   function submitCampaignInsertForm() {
			var data = $("#camp-insert").serialize();
               
			$.ajax({
				
			type : 'POST',
			url  : origin+'vendor-camp-insert1.php',
                        processData: false,
                        data : data,
			beforeSend: function() {	
				$("#error").fadeOut();
                                $("#submit-camp-insert").prop('disabled', true);
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
				$("#submit-camp-insert").append(status);
			},
			success :  function(response) {
                            console.log("resp "+response);
                            if(response.search("success")>-1) {
                                $(".vendor-campaign").prepend("<p style='vertical-align:central;' class='text-center bg-success text-white'><i class='fa fa-exclamation' ></i> Added Successful!</p>").fadeIn().delay(5000).fadeOut();
//                                setTimeout( displayProductTable(),5000);
                                    window.location.href=origin+"MyOffers";
                            }
                            else {
                                $("#submit-camp-insert").prop('disabled', true);
                                $("#submit-camp-insert").find(".form_status").html('');
                                
                                $(".vendor-campaign").prepend("<p style='vertical-align:central;' class='text-center bg-danger text-white'><i class='fa fa-exclamation' ></i> Unable to Add New Offer!</p>").fadeIn();
                            }
                                
			  }
			});
				return false;
		}
                
                
                     $("#vend-subsc").validate({
      rules: {
					'cat': "required",
					'city': "required",
					/*pwd: {
                                            required: true, 
                                            minlength: 6
                                        },
					uname: {
                                            required: true,
                                            minlength: 6,
                                             remote:{
                                                    url:"vend-register-validation.php",
                                                    type:"post"
                                            }
                                        },*/
					bname: {
                                            required: true /*,
                                             remote:{
                                                    url:"vend-register-validation.php",
                                                    type:"post"
                                            }*/
                                        },
                                        city_c: {
                                            required: true,
                                            fullnamechk: true
                                        },
                                    	for_val: {
    						required:true,
                                                number: true
    						
					}
				},
				messages: {
					cat: "Please select category",
					city: "Please Select City",
					bname: {
					required: "Please select Business name",
                                           remote: "Business name unavailable!"
                                        },
					city_c: {
                                           required: "Please enter City ",
                                          fullnamechk: "Please enter appropriate name"
                                        },
					for_val: {
       						required: "Please enter Subscription Plan",
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
        },
	   submitHandler: submitVendorSubscriptionForm	
       });

	   function submitVendorSubscriptionForm() {		
			var data = $("#vend-subsc").serialize();
                      console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : origin+'vendor-subs-insert1.php',
			data : data,
			beforeSend: function() {
                              $("#submit-vendor-Subscription").prop('disabled', true);
			},
			success :  function(response) {
                          console.log("resp-"+response+"-");
					if(response.search("ok ")>-1){
                                              $("#submit-vendor-Subscription").prop('disabled', true);
//                                              Materialize.toast('Registration Successful!\nWe would contact you soon for further Process', 8000);
                                             // alert('Application Received!\nWe would contact you soon for further Process');
//						setTimeout(' window.location.href = "cart-vend.php"; ',2000);
                
                    window.location.href=origin+"VendorSubscriptions";
					}
					if(response.search("more ")>-1){
                                              $("#submit-vendor-Subscription").prop('disabled', true);
                    window.location.href=origin+"NewSubscription";
					}
					else{
//                          console.log("error response-"+response+"-");
                              $("#submit-vendor-Subscription").prop('disabled', false);
                              $("#submit-vendor-Subscription").html('Submit<i class="material-icons right">send</i>');
					}
			  }
			});
				return false;
		}
	   /* login submit */
         

                        $("#prod-order-full").validate({
      rules: {
					'ofdate': "required"
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
	   submitHandler: submitProdOrderFullForm	
       });

	   function submitProdOrderFullForm() {		
			var data = $("#prod-order-full").serialize();
                      console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : origin+'prod-ordfull1.php',
			data : data,
			beforeSend: function() {
                              $("#btn-submit").prop('disabled', true);
			},
			success :  function(response) {
                          console.log("resp-"+response+"-");
                                $(".content").prepend("<p style='vertical-align:central;' class='text-center bg-info text-white'><i class='fa fa-exclamation' ></i> "+response+"!</p>").fadeIn().delay(5000).fadeOut();
                                setTimeout(window.location.href=origin+"OrderFullChart",5000);
			  }
			});
				return false;
		}
	   /* login submit */
         
         

                });
                
                
 
 $(document).add("#vend-update , #vend-bank").ready(function() {
    
		$( "#vend-update" ).validate( {
				rules: {
					email1: {
                                            emaill1: true,
                                            dobemailcustchkv:true
                                        },
					fname: {
                                            fullnamechk: true
                                        },
					zip: {
                                            number: true,
                                             remote:{
                                                    url:"register-validation.php",
                                                    type:"post"
                                            }
                                        },
					bname: {
                                             remote:{
                                                    url:"vend-register-validation.php",
                                                    type:"post"
                                            }
                                        },
					cntc: {
                                                number:true,
						cntclenchku: true,
					},
					for_val: {
    						required:true,
                                                number: true
    						
					}
				},
				messages: {
					addr: "Please enter Address",
					gen : "Please select Gender",
					cat: "Please select category",
					city: "Please Enter City",
					email1: {
                                           required: "Please enter Email Address",
                                           email: "Please enter a Valid Email Address",
                                           dobemailcustchkv: "The email id and Contact No. are already in use!"
                                        },
					uname: {
                                           required: "Please enter Username",
                                           minlength: "Please enter atleast 6 Characters",
                                           remote: "Username unavailable!"
                                        },
					zip: {
                                           required: "Please enter Pincode",
                                           remote: "Please enter valid Pincode!"
                                        },
					bname: {
					required: "Please select Business name",
                                           remote: "Business name unavailable!"
                                        },
					fname: {
                                           required: "Please enter First Name",
                                           fullnamechk: "Please enter Alphabets only"
                                        },
					cntc: {
						required: "Please enter a Mobile Number",
						number: "Please enter Numbers only",
						cntclenchk: "Your Mobile Number must consist of 10 numbers",
						remote: "Mobile No. already registered!"
					},
					for_val: {
       						required: "Please enter Subscription Plan",
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
        },
	   submitHandler: submitVendorUpdateForm	
       });  
	   /* validation */
	   
	   /* login submit */
	   function submitVendorUpdateForm() {		
			var data = $("#vend-update").serialize();
//                        console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : 'vendor-profile-update.php',
			data : data,
			beforeSend: function() {
                                $("#submit-vend-update").prop('disabled', true);
				$("#submit-vend-update").append( form_status.html('<h5><i class="fa fa-spinner fa-spin"></i> Updating...</h5>').fadeIn() );
			},
			success :  function(response) {
//                            console.log("resp-"+response+"-");
					if(response.search("ok")>-1){
                                                $("#submit-vend-update").prop('disabled', true);
//                                                alert('Update Successful!');
                	form_status.html('<h5 class="text-success">Updated.</h5>').delay(20000).fadeOut();                    
                window.location.href="VendorProfile";
					}
					else{
//                            console.log("error response-"+response+"-");
//                                                alert(response+'!');
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>"+response+"!</p>");
                $("#modal-message").modal("open");
                                $("#submit-vend-update").prop('disabled', false);
                                $("#submit-vend-update").html('Submit<i class="material-icons right">send</i>');
					}
			  }
			});
				return false;
		}

		$( "#vend-bank" ).validate( {
				rules: {
					ac_no: "required",
					reac_no: {
                                            required: true,
                                            equalTo: "#ac_no"
					},
					ac: "required",
					aname: "required",
					ifsc: "required"
				},
				messages: {
					ac_no: "Please enter Account Number",
					reac_no : {
                                        required: "Please Re enter Account Number",
                                        equalTo: "Account Numbers do not match!"
                                        },
					ac: "Please select Account Type",
					aname: "Please Enter Account Holder Name",
					ifsc: "Please Enter IFSC Code"
					
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
	   submitHandler: submitVendorBankForm	
       });  
	   /* validation */
	  
	   /* login submit */
	   function submitVendorBankForm() {		
			var data = $("#vend-bank").serialize();
//                        console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : 'vendor-bank-update.php',
			data : data,
			beforeSend: function() {
                                $("#submit-bank").prop('disabled', true);
				$("#submit-vend-update").append( form_status.html('<h5><i class="fa fa-spinner fa-spin"></i></h5>').fadeIn() );
			},
			success :  function(response) {
//                            console.log("resp-"+response+"-");
					if(response.search("ok")>-1){
                                                $("#submit-bank").prop('disabled', true);
                                $("#vend-bank").prepend("<p style='vertical-align:central;' class='text-center bg-info text-white'><i class='fa fa-exclamation' ></i> Update Successful!</p>").fadeIn().delay(5000).fadeOut();
                                setTimeout(window.location.reload(), 3000);
					}
					else{
                                $("#vend-bank").prepend("<p style='vertical-align:central;' class='text-center bg-info text-white'><i class='fa fa-exclamation' ></i> Unable to Update! Please try again!</p>").fadeIn();

                                }
			  }
			});
				return false;
		}
 
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
                                $("#camp-update").prop('disabled', true);
				$("#submit-camp-update").append( form_status.html('<h5><i class="fa fa-spinner fa-spin"></i></h5>').fadeIn() );
			},
			success :  function(response) {
//                            console.log("resp-"+response+"-");
					if(response.search("ok")>-1){
                                                $("#submit-camp-update").prop('disabled', true);
                                $("#camp-update").prepend("<p style='vertical-align:central;' class='text-center bg-info text-white'><i class='fa fa-exclamation' ></i> Update Successful!</p>").fadeIn().delay(5000).fadeOut();
                                setTimeout(window.location.reload(), 3000);
					}
					else{
                                $("#camp-update").prepend("<p style='vertical-align:central;' class='text-center bg-info text-white'><i class='fa fa-exclamation' ></i> Unable to Update! Please try again!</p>").fadeIn();

                                }
			  }
			});
				return false;
		}
 
		$( "#camp-prod-insert" ).validate( {
				rules: {
					campon: "required",
					disc_on: "required",
					qty: "required",
					disc: "required",
					prod: {
                                            required: {
                                                depends: function() {
                                                    if($("#campon").val()=="1")
                                                        return true;
                                                    
                                                }
                                            }
                                                },
					pc: {
                                            required: {
                                                depends: function() {
                                                    if($("#campon").val()=="2")
                                                        return true;
                                                    
                                                }
                                            }
                                                },
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
	   submitHandler: submitCampProdInsertForm	
       });  
	   /* validation */
	  
	   /* login submit */
	   function submitCampProdInsertForm() {		
			var data = $("#camp-prod-insert").serialize();
//                        console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : origin+'vendor-camp-prod-insert1.php',
			data : data,
			beforeSend: function() {
                                $(".btns-block").prop('disabled', true);
				$(".btns-block").append( form_status.html('<h5><i class="fa fa-spinner fa-spin"></i></h5>').fadeIn() );
			},
			success :  function(response) {
//                            console.log("resp-"+response+"-");
					if(response.search("submit")>-1 
					|| response.search("more")>-1 ){
                                            $("#camp-prod-insert").prepend("<p style='vertical-align:central;' class='text-center bg-success text-white'><i class='fa fa-exclamation' ></i> Product/ Category Added to Offer!</p>").fadeIn().delay(5000).fadeOut();
                                setTimeout(function() {
                    window.location.reload();
                                },3000);
					}
					else{
                                $(".btns-block").prop('disabled', false);
                                            $("#camp-prod-insert").prepend("<p style='vertical-align:central;' class='text-center bg-danger text-white'><i class='fa fa-exclamation' ></i> Unable to add Product/ Category to Offer! Try Again</p>").fadeIn().delay(5000).fadeOut();
					}
			  }
			});
				return false;
		}
 
 
		$( "#camp-serv-insert" ).validate( {
				rules: {
					campon: "required",
					disc: "required",
					serv: {
                                            required: {
                                                depends: function() {
                                                    if($("#campon").val()=="1")
                                                        return true;
                                                    
                                                }
                                            }
                                                },
					pc: {
                                            required: {
                                                depends: function() {
                                                    if($("#campon").val()=="2")
                                                        return true;
                                                    
                                                }
                                            }
                                                },
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
	   submitHandler: submitCampServInsertForm	
       });  
	   /* validation */
	  
	   /* login submit */
	   function submitCampServInsertForm() {		
			var data = $("#camp-serv-insert").serialize();
//                        console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : origin+'vendor-camp-serv-insert1.php',
			data : data,
			beforeSend: function() {
                                $(".btns-block").prop('disabled', true);
				$(".btns-block").append( form_status.html('<h5><i class="fa fa-spinner fa-spin"></i></h5>').fadeIn() );
			},
			success :  function(response) {
//                            console.log("resp-"+response+"-");
					if(response.search("submit")>-1 
					|| response.search("more")>-1 ){
                                            $("#camp-serv-insert").prepend("<p style='vertical-align:central;' class='text-center bg-success text-white'><i class='fa fa-exclamation' ></i> Service/ Category Added to Offer!</p>").fadeIn().delay(5000).fadeOut();
                                setTimeout(function() {
                    window.location.reload();
                                },3000);
					}
					else{
                                $(".btns-block").prop('disabled', false);
                                            $("#camp-serv-insert").prepend("<p style='vertical-align:central;' class='text-center bg-danger text-white'><i class='fa fa-exclamation' ></i> Unable to add Service/ Category to Offer! Try Again</p>").fadeIn().delay(5000).fadeOut();
					}
			  }
			});
				return false;
		}
 
 
 
                         $("#return-form").validate({
				rules: {
					file: {
                                            fileType: {
                                                "types": ["image/jpg","image/png","image/jpeg","image/gif"]
                                            },
                                            maxFileSize: {
                                                "unit": "MB",
                                                "size": "1"
                                            },
                                            minFileSize: {
                                                "unit": "KB",
                                                "size": "0"
                                            }
                                             },
					check_list: {
                                            "required": true
                                             },
					reason: {
                                            "required": true
                                             }
				},
				messages: {
					file: {
                                           accept: "Provide jpg,jpeg,png or gif image!"
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
        },
	   submitHandler: submitReturnForm	
       });  

	   function submitReturnForm() {
			var data = new FormData( $("#return-form")[0]);
//                        alert("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : origin+'return-form1.php',
                        processData: false,
                        enctype: 'multipart/form-data',
                        contentType: false ,
                        timeout: 600000,
                        data : data,
			beforeSend: function() {	
				$("#error").fadeOut();
                                $("#submit-prod-update").prop('disabled', true);
				$(".loader-block").html('<h5><i class="fa fa-spinner fa-spin"></i> Validating...</h5>').fadeIn();
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
				$("#submit-return").append(status);
			},
			success :  function(response) {
                            console.log("resp "+response);
                            if(response.search("success")>-1) {
                $("#modal-msg").find(".modal-body").html("<p style='vertical-align:central;' class='text-center'>Requested for Return!</p>");
                $("#modal-msg").modal({ backdrop: "static" });
                $("#modal-msg").find(".btn-close").on('click',function() {
                   window.location.href= origin+"MyOrders"; 
                });
                            }
                            else {
                $("#modal-msg").find(".modal-body").html("<p style='vertical-align:central;' class='text-center'>Unable to process Request!</p>");
                $("#modal-msg").modal({ backdrop: "static" });
                            }
                                
			  }
			});
				return false;
		}
	   /* login submit */


 });

});

