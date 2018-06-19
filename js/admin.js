jQuery(function($) {'use strict';
                var origin=window.location.origin+"/";
		var form_status = $('<div class="form_status"></div>');
    var status=form_status;
    status.html('<i class="fa fa-spinner fa-spin"></i>');
            
jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});


    $(document).ready(function() {
            var path=window.location.pathname;
            console.log("path-"+path+"-");
            if(path.search("/")>-1) {
            path=path.split("/");
            path=path[1];
        }
        
$('[data-toggle="tooltip"]').tooltip();


    $("#dataTables-category").on('click','.btn-detail',function() {
       var id= $(this).attr("id");
//       console.log("console -"+id+"-");
			$.ajax({
				
			type : 'POST',
			url  : 'vendor-detail.php',
			data : "vend_id="+id,
			beforeSend: function() {
				$(this).html(preloader());
			},
			success :  function(response) {
//                            console.log("alert "+response);
                            $(".vend-details-block").html(response);
                            $(".vend-details-block").focus();
    $(".vend-details-block").ready(function() {
if ( ! $.fn.DataTable.isDataTable( '#dataTables-vend-details' ) ) {
    $('#dataTables-vend-details').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }
    });
}
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

    });


    
        
        $("#selid").change(function() {
           var selected=$(this).val();

        switch(selected) {
               case '1':
                   $(".cats").removeClass("show");
                        $("#catinsert").addClass("show");
                        $("#micat").focus();
                        $("#catinsert .show").ready(function() {
                            console.log("in cat insert");
    		$( "#main-insert" ).validate( {
				rules: {
					micattype : "required",
					micat: {
                           required: true/*,
                           namechkw: true,
                           remote:{
                           			url:"admin-category-vald.php",
                                    type:"post"
                                    }*/
                          }
				},
				messages: {
					micattype: "Please select Category Type!",
					micat: {
                                           required: "Please enter Category",
                                           namechkw: "Please enter Alphabets Only",
                                           remote: "The category already exist!"
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
		         }/*,
	   submitHandler: submitMIForm	
*/       });  
	   /* validation */
	   
	   /* login submit */
	   function submitMIForm() {
               if($("#main-insert").valid()) {
                   
                        console.log("in submit");
                   $("#main-insert").submit();
			var data = $("#main-insert").serialize();
                        console.log("data "+data);
				return false;
                            }
		}
	   /* login submit */

                            
                        });
                               break;
               case '2':
                        $("#title").html("Update Category");
                        $("#catinsert").hide();
                        $("#catupdate").show();
                        $("#mucatid").focus();
                        $("#scatinsert").hide();
                        $("#scatupdate").hide();
                        $("#catdelete").hide();
                        $("#scatdelete").hide();
                               break;
               case '3':
                        $("#title").html("Add Sub-Category");
                        $("#catinsert").hide();
                        $("#catupdate").hide();
                        $("#scatinsert").show();
                         $("#sicatid").focus();
                       $("#scatupdate").hide();
                        $("#catdelete").hide();
                        $("#scatdelete").hide();
                               break;
               case '4':
                        $("#title").html("Update Sub-Category");
                        $("#catinsert").hide();
                        $("#catupdate").hide();
                        $("#scatinsert").hide();
                        $("#scatupdate").show();
                        $("#sucatid").focus();
                        $("#catdelete").hide();
                        $("#scatdelete").hide();
                               break;
               case '5':
                        $("#title").html("Delete Category");
                        $("#catinsert").hide();
                        $("#catupdate").hide();
                        $("#scatinsert").hide();
                        $("#scatupdate").hide();
                        $("#catdelete").show();
                        $("#mdcatid").focus();
                        $("#scatdelete").hide();
                               break;
               case '6':
                        $("#title").html("Delete Sub-Category");
                        $("#catinsert").hide();
                        $("#catupdate").hide();
                        $("#scatinsert").hide();
                        $("#scatupdate").hide();
                        $("#catdelete").hide();
                        $("#scatdelete").show();
                        $("#sdcatid").focus();
                               break;
               default:
                        $("#title").html("Category Add/Update/Delete");
                        $("#catinsert").hide();
                        $("#catupdate").hide();
                        $("#scatinsert").hide();
                        $("#scatupdate").hide();
                        $("#catdelete").hide();
                        $("#scatdelete").hide();
                               break;
           }
        });
        $("#mucatid").change(function() {
           selected=$(this).val();
           switch(selected) {
               case '': $("#displayCustom").hide();
                               break;
               default : $("#displayCustom").show();
                            $("#mucat").focus();
                   break;
           }
        });
        $("#sucatid").change(function() {
           selected=$(this).val();
           switch(selected) {
               case '': $("#displayCustom1").hide();
                               break;
               default : $("#displayCustom1").show();
                        $("#sucat").focus();
                   break;
           }
        });
        $("#sicatid").change(function() {
           selected=$(this).val();
           switch(selected) {
               case '': $("#displayCustom2").hide();
                               break;
               default : $("#displayCustom2").show();
                        $("#sicat").focus();
                   break;
           }
        });


       
        $( document ).add("#catinsert,#catupdate,#catdelete").ready( function () {
jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});




    		$( "#main-update" ).validate( {
				rules: {
					mucat: {
						mucatchk: true
					}
				},
				messages: {
					mucat: {
                                           mucatchk: "The category already exist!"
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
    });

    		$( "#main-delete" ).validate( {
				rules: {
					mdcatid: {
                        remote:{
                   			url:"admin-category-vald.php",
                            type:"post"
                            }
					}
				},
				messages: {
					mdcatid: {
                                           remote: "The Vendors are subscribed to this category!"
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
    });

    		$( "#sub-delete" ).validate( {
				rules: {
					sdcatid: {
                        remote:{
                   			url:"admin-category-vald.php",
                            type:"post"
                            }
					}
				},
				messages: {
					sdcatid: {
                                           remote: "The Products/Services are added to this category!"
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
    });


		$( "#sub-insert" ).validate( {
				rules: {
					sicatid:"required",
                    sicat: {
                    sicatchk:true
							}
					
				},
				messages: {
                                        sicatid:"Please select Main category",
					sicat: {
                                           sicatchk: "The Sub Category already Exists!"
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

		$( "#sub-update" ).validate( {
				rules: {
					sucatid:"required",
                                        sucat: {
                                            sucatchk: true
                                            }
					
				},
				messages: {
                                        sucatid:"Please select category",
					sucat: {
                                           sucatchk: "The Sub Category already Exists!"
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




});

