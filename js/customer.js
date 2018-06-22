jQuery(function($) {'use strict';
                var origin=window.location.origin+"/";
		var form_status = $('<div class="form_status"></div>');
            
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');

jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});



            function validateLogin() {
                
	 $("#login-form").validate({
      rules: {
			password: "required",
			user_email: "required"
	   },
       messages: {
            password:{
                      required: "please enter your password"
                     },
            user_email: "please enter your username"
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
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* login submit */
	   function submitForm() {
			var data = $("#login-form").serialize();
                        console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : origin+'login_process.php',
			data : data,
			beforeSend: function() {	
				$("#error").fadeOut();
                                $("#btn-login").prop('disabled', true);
				$(".loader-block").html('<h5><i class="fa fa-spinner fa-spin"></i> Validating...</h5>').fadeIn();
                                var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
				$("#btn-login").append(status);
			},
			success :  function(response) {
                            console.log("resp "+response);
                            if(response.search("Invalid")==-1) {
                            response=JSON.parse(response);
                            if(response.home_url.length!="")
                                window.location.href=origin+response.home_url;
                            else if(response.home_url.length=="" && response.type=="customer") {
			$.ajax({
				
			type : 'POST',
			url  : 'add-to-cart-from-session.php',
			beforeSend: function() {	
//				$("#error").fadeOut();
                                $("#btn-login").prop('disabled', true);
			},
			success :  function(response) {
                            console.log("resp "+response);
					if(response.search("product-success")>-1){
//                                                alert('You would receive Vendor Details soon!');
//						setTimeout(' window.location.href = "./"; ',2000);
                                window.location.href=origin+"Cart";
                                                updatecart();
                                    }
                                    else if(response.search("service")>-1) {
			$.ajax({
				
			type : 'POST',
			url  : 'serviceorder-insert.php',
			beforeSend: function() {
//				$("#error").fadeOut();
                                $("#btn-login").prop('disabled', true);
			},
			success :  function(response) {
                            console.log("resp "+response);
					if(response.search("success-service")>-1){
                 $("#modal-msg").find(".modal-body").html("<p style='vertical-align:central;' class='text-center'>Service Requested<br /> Service Provider would contact you soon!</p>");
                 $("#modal-msg .btn-close").on("click",function () {
                     window.location.href=origin;
                 });
                $("#modal-msg").modal({backdrop: "static"});
                                    }
					else{
                                            
//						window.location.href = origin;
					}
			  }
			});
                        

                                    }
					else{
                                                console.log("service else");
						window.location.href = origin;
					}
			  }
			});
					}
                                    }
					else{
                $("#error").html("<p style='vertical-align:central;' class='text-center bg-danger text-white'><i class='fa fa-exclamation' ></i>"+response+"!</p>").fadeIn().delay(5000).fadeOut();
//                                                alert(response+'!');
                                $("#btn-login").html('Sign In');
                                                $("#btn-login").prop('disabled', false);
/*									
				$("#error0").fadeIn(1000, function(){						
				$("#error0").html('<div class="red"> <span class="glyphicon glyphicon-info-sign"></span>Â  '+response+' !</div>');
                                                $("#btn-login").prop('disabled', false);
				});*/
					}
			  }
			});
				return false;
		}
	   /* login submit */
            }



            
            var path=window.location.pathname;
            console.log("path-"+path+"-");
            if(path.search("/")>-1) {
            path=path.split("/");
            path=path[1];
            }
            
        $('document').ready(function() { 
            
            if(path=="Login" || path=="login")
                console.log("validate-login called");
                validateLogin();
        });

        function updatecart() {
            
        		$.ajax({
				
			type : 'POST',
			url  : origin+"cart-count.php",
			success :  function(response) {
                            response=parseInt(response);
                            console.log("count0-"+response+"-");
                            $(".cartdata").html( response+" item(s)");
                                if(response===0 ) {
                                    $(".cart-items").css("display","none");
                                    $(".order-content").css("display","none");
                                    $(".nothing-content").css("display","block");
                                }
                                else {
                                    $(".cart-items").css("display","block");
                                    $(".order-content").css("display","block");
                                    $(".nothing-content").css("display","none");
                                }
                            }
			});

    }

     $(document).ready(function() {
        updatecart(); 
     }); 

$(document).add("#cust-register , #vend-register , #cust-update").ready(function() {
                   $("#accept").change(function() {
    if(this.checked)
	$(".submit-btn").show();
    else
	$(".submit-btn").hide();
});
 
 
  	 $("#cust-register").validate({
      rules: {
					'accept': "required",
					'addr': "required",
					captcha_code: {
                                            required: true,
                                            chkcaptcha:true
                                        },
					email1: {
                                            required: true,
                                            emaill: true,
                                            dobemailcustchk:true
                                        },
					pwd: {
                                            required: true, 
                                            minlength: 6
                                        },
					fname: {
                                            required: true,
                                            fullnamechk: true
                                        },
					uname: {
                                            required: true,
                                            minlength: 6,
                                             remote:{
                                                    url:"register-validation.php",
                                                    type:"post"
                                            }
                                        },
					zip: {
                                            required: true,
                                            number: true,
                                             remote:{
                                                    url:"register-validation.php",
                                                    type:"post"
                                            }
                                        },
					dob: {
                                            required: true,
                                            dobchk: true,
                                            dobemailcustchk:true
                                        },
					cntc: {
                                                number:true,
						required: true,
						cntclenchk: true,
                                                dobemailcustchk:true
					},
                                        cpwd: {
                                            required: true,
                                            equalTo: "#pwd"
					}
				},
				messages: {
					accept: "Please accept Terms and Conditions",
					addr: "Please enter Address",
					captcha_code: {
                                           required: "Please enter Captcha Code!",
                                           remote: "Please enter valid Captcha Code!"
                                        },
					zip: {
                                           required: "Please enter Pincode",
                                           remote: "Please enter valid Pincode!"
                                        },
					email1: {
                                           required: "Please enter Email Address",
                                           email: "Please enter a Valid Email Address",
                                           dobemailcustchk: "The email id and Contact No. are already in use!"
                                        },
					pwd: {
                                           required: "Please enter First Name",
                                           minlength: "Password should contain atleast 6 characters!"
                                        },
					fname: {
                                           required: "Please enter First Name",
                                           fullnamechk: "Please enter Alphabets only"
                                        },
					uname: {
                                           required: "Please enter User Name",
                                           minlength: "Username should contain atleast 6 characters!",
                                           remote: "The User Name is already in use by another user!"

                                        },
					cpwd: {
                                           required: "Please enter Confirm Password",
                                           pwdlenchk: "Password should contain atleast 6 characters!",
                                           equalTo: "Passwords do not match!"
                                        },
					dob: {
                                           required: "Please enter Birth Date",
                                            dobchk: "Please select appropriate Date!",
                                           dobemailcustchk: "The email id and Contact No. are already in use!"
                                        },
					cntc: {
						required: "Please enter a Mobile Number",
						number: "Please enter Numbers only",
						cntclenchk: "Your Mobile Number must consist of 10 numbers", 
                                           dobemailcustchk: "The email id and Contact No. are already in use!"
					}
				},
                                errorElement : 'em',
        errorPlacement: function(error, element) {
          var placement = $(element).data('error');
          if(element.attr("type")=="radio" || element.attr("type")=="checkbox") {
              console.log("in radio or checkbox");
              error.insertAfter(element.parents("p"));
          }
          else {
          if (placement) {
            $(placement).append(error);
          } else {
            error.insertAfter(element);
          }
      }
        },
	   submitHandler: submitRegistrationForm	
       });  
	   /* validation */
	   
	   /* login submit */
	   function submitRegistrationForm() {		
			var data = $("#cust-register").serialize();
                        console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : 'register1.php',
			data : data,
			beforeSend: function() {
                                $("#submit-register").prop('disabled', true);
//				$("#submit-register").html(preloader());
			},
			success :  function(response) {
                            console.log("resp-"+response+"-");
					if(response.search("ok ")>-1){
                                                $("#submit-register").prop('disabled', true);
//                                            window.location.href="verify-cntc.php";
//                                                alert('Registration Successful!');
//						setTimeout(' window.location.href = "./Login"; ',2000);
                    window.location.href=origin+"VerifyMobileNumber";
					}
					else{
//                            console.log("error response-"+response+"-");
                                            
                                $("#submit-register").prop('disabled', false);
                                $("#submit-register").html('Submit<i class="material-icons right">send</i>');
					}
			  }
			});
				return false;
		}
	   /* login submit */




	 $("#vend-register").validate({
      rules: {
					'accept': "required",
					'addr': "required",
					'gen': "required",
					captcha_code: {
                                            required: true,
                                            chkcaptcha:true
                                        },
					email1: {
                                            required: true,
                                            emaill: true,
                                            dobemailcustchkv:true
                                        },
					pwd: {
                                            required: true, 
                                            minlength: 6
                                        },
					fname: {
                                            required: true,
                                            fullnamechk: true
                                        },
                                         dob: {
                                            required: true,
                                            dobchk: true,
                                            dobemailcustchkv:true
                                        },
					zip: {
                                            required: true,
                                            number: true,
                                             remote:{
                                                    url:"register-validation.php",
                                                    type:"post"
                                            }
                                        },
					uname: {
                                            required: true,
                                            minlength: 6,
                                             remote:{
                                                    url:"vend-register-validation.php",
                                                    type:"post"
                                            }
                                        },
					cntc: {
                                                number:true,
						required: true,
						cntclenchk: true,
                                            dobemailcustchkv:true
					},
                                        cpwd: {
                                            required: true,
                                            equalTo: "#pwd"
					}
				},
				messages: {
					accept : "Please accept Terms and Conditions",
					gen : "Please select Gender",
					email1: {
                                           required: "Please enter Email Address",
                                           email: "Please enter a Valid Email Address",
                                           dobemailcustchkv: "The email id and Contact No. are already in use!"
                                        },
					captcha_code: {
                                           required: "Please enter Captcha Code!",
                                           remote: "Please enter valid Captcha Code!"
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
					pwd: {
                                           required: "Please enter Password",
                                           minlength: "Password should contain atleast 6 characters!"
                                        },
					fname: {
                                           required: "Please enter First Name",
                                           fullnamechk: "Please enter Alphabets only"
                                        },
					dob: {
                                           required: "Please enter Birth Date",
                                            dobchk: "Please select appropriate Date!",
                                           dobemailcustchkv: "The email id and Contact No. are already in use!"
                                        },
				        cpwd: {
                                           required: "Please enter Confirm Password",
                                           pwdlenchk: "Password should contain atleast 6 characters!",
                                           equalTo: "Passwords do not match!"
                                        },
					cntc: {
						required: "Please enter a Mobile Number",
						number: "Please enter Numbers only",
						cntclenchk: "Your Mobile Number must consist of 10 numbers",
                                           dobemailcustchkv: "The email id and Contact No. are already in use!"
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
	   submitHandler: submitVendorRegistrationForm	
       });  
	   /* validation */
	   
	   /* login submit */
	   function submitVendorRegistrationForm() {		
			var data = $("#vend-register").serialize();
                        console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : 'vendor-register1.php',
			data : data,
			beforeSend: function() {
                                $("#submit-vendor-register").prop('disabled', true);
			},
			success :  function(response) {
                            console.log("resp-"+response+"-");
					if(response.search("success")>-1){
                                                $("#submit-vendor-register").prop('disabled', true);
//                                                Materialize.toast('Registration Successful!\nWe would contact you soon for further Process', 4000);
//                                                alert('Registration Successful!\nWe would contact you soon for further Process');
//						setTimeout(' window.location.href = "how-it-works-vendor.php"; ',4000);
//                                            window.location.href="verify-cntc.php";
                                              
                    window.location.href=origin+"VerifyMobileNumber";

                            }
					else{
                            console.log("error response-"+response+"-");
                                            
                                $("#submit-vendor-register").prop('disabled', false);
                                $("#submit-vendor-register").html('Submit<i class="material-icons right">Submit</i>');
					}
			  }
			});
				return false;
		}
	   /* login submit */
           

		$( "#cust-update" ).validate( {
				rules: {
					email1: {
                        emaill1: true,
                        dobemailcustchk:true
                    },
					fname: {
                                            fullnamechk: true
                                        },
					dob: {
                                            dobchk: true
                                        },
					cntc: {
                                                number:true,
					        cntclenchku: true,
					},
					zip: {
                                            number: true,
                                             remote:{
                                                    url:"register-validation.php",
                                                    type:"post"
                                            }
                                        },

					alt: {
    						altlenchk: true,
    						notEqualTo: true,
    						number: true
					}
				},
				messages: {
					email1: {
                                           email: "Please enter a Valid Email Address",
                                           dobemailcustchk: "The email id and Contact No. are already in use!"

                                        },
					fname: {
                                           fullnamechk: "Please enter Alphabets only"
                                        },
					desg: {
                                           fullnamechk: "Please enter Alphabets only"
                                        },
					zip: {
                                           remote: "Please enter valid Pincode!"
                                        },
					dob: {
                                           dobchk: "Please select appropriate Date!"
                                        },
					cntc: {
						number: "Please enter Numbers only",
						cntclenchk: "Your Mobile Number must consist of 10 numbers",
						remote: "The Contact Number is already in use by another user!"

					},
					alt: {
						altlenchk: "Your Alternate Mobile Number must consist of 10 numbers",
						notEqualTo: "Please enter Another Number",
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
	   submitHandler: submitCustomerUpdateForm	
       });  
	   /* validation */
	   
	   /* login submit */
	   function submitCustomerUpdateForm() {		
			var data = $("#cust-update").serialize();
//                        console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : 'customer-profile-update.php',
			data : data,
			beforeSend: function() {
                                $("#submit-cust-update").prop('disabled', true);
				$("#submit-cust-update").append( form_status.html('<h5><i class="fa fa-spinner fa-spin"></i> Updating...</h5>').fadeIn() );
			},
			success :  function(response) {
//                            console.log("resp-"+response+"-");
					if(response.search("ok")>-1){
                                                $("#submit-cust-update").prop('disabled', false);
//                                                alert('Update Successful!');
              	form_status.html('<h5 class="text-success">Updated.</h5>').delay(20000).fadeOut();                    
                window.location.href="CustomerProfile";
//						setTimeout(' window.location.href = "customer-profile.php"; ',2000);
					}
					else{
//                            console.log("error response-"+response+"-");
//                                                alert(response+'!');
                  $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>"+response+"!</p>");
                $("#modal-message").modal("open");
                              $("#submit-cust-update").prop('disabled', false);
                                $("#submit-cust-update").html('Submit<i class="material-icons right">send</i>');
					}
			  }
			});
				return false;
		}

                });
                
                
                
                
                
                
                
    
//    $(".product").each(function() {

    function chkcampcart(id,element){
//       var id=$(".btn-add-to-cart").val();
//       var qty_min=$("#qty_min_"+id).text();
//       console.log("qty "+qty_min);
//       qty_min=qty_min.split(" ");
//            console.log("Id in chkcamp "+qty_min);
             var qty=0;
             
            if( typeof( $(element).find("#qty").val())!=="undefined" )
            qty=parseInt($(element).find("#qty").val());
        
//        qty*=parseFloat(qty_min["prod_id"]);
//        var unit=qty_min[1];
            var data="prod="+id+"&qty="+qty;//+"&unit="+unit;
            console.log("data in chkcamp "+data);

                    $.ajax({
			async: false,
			type : 'POST',
			url  : origin+"campchk.php",
			data : data,
			success : function(response) {
                             console.log("response-"+response+"-");
            $(element).find(".subtotal").html(response);
                    		}
                        });
            
    }

    
    $(".btn-pos").on('click',function() {
        var element=$(this).parents(".product");
        var qty=parseInt($(element).find(".can-change-qty").val());
        $(element).find(".can-change-qty").val(parseInt(qty+1));
        var prod_id=$(element).attr("data-prod");
        console.log("in btn-pos"+prod_id);
        chkcampcart(prod_id,element);
    });

    $(".btn-neg").on('click',function() {
        var element=$(this).parents(".product");
        var qty=parseInt($(element).find(".can-change-qty").val());
        $(element).find(".can-change-qty").val(parseInt(qty-1));
        var prod_id=$(element).attr("data-prod");
        console.log("in btn-pos"+prod_id);
        chkcampcart(prod_id,element);
    });

                
                
            $(".btn-pos, .btn-neg, .can-change").on('blur',function() {
                var slot=null;
                var qty=null;
                var reqd=null;
                var cart_id=null;
                var product=$(this).parents(".product");
                var prod=product.attr("data-prod");
                var cart_id=product.attr("data-cart");
                var reqd_val=null;
                if(product.find("can-change-qty")) {
                    qty=parseInt(product.find("#qty").val());
                }
                if(product.find("can-change-slot")) {
                    slot=product.find("#slot").val();
                }
                if(product.find("can-change-req")) {
                    reqd=product.find("input[name=req]").val();
                    if(reqd>0) {
                        for(var i=0;i<reqd;i++) {
                            if(reqd_val!==null)
                        reqd_val+=","+product.find("#req"+i).val();
                    else
                        reqd_val+=product.find("#req"+i).val();
                        
                        }
                    }
                }
                
                var data="prod_id="+prod+"&qty="+qty+"&slot="+slot+"&reqd="+reqd+"&cart_id="+cart_id;
                console.log("data"+data+"-");
		event.preventDefault();
		var form_status = $('<div class="form_status"></div>');
		$.ajax({
			url: origin+"add-to-cart.php",
                        data: data,
			beforeSend: function(){
                            product.prop("disabled",true);
//				product.append( form_status.html('<h5><i class="fa fa-spinner fa-spin"></i> Updating...</h5>').fadeIn() );
			},
                        success: function(response) {
                            
                            console.log("response-"+response+"-");
                            if(response.search("success")>-1) 
			form_status.html('<h5 class="text-success">Updated.</h5>').delay(20000).fadeOut();
                        }
 		});

            });

 /*   $(".product-details").ready(function() {
//        alert("caught");
    var now = new Date();
    var month=now.getMonth()+1;
    var date=now.getDate()+1;
    if(month<10)
        month="0"+month;
    if(date<10)
        date="0"+date;
    var today = date+ '-' + month+ '-' + now.getFullYear();

    $(this).find("input[id^=reqd]").val(today);
        
    });*/
    
    function chkcamp(){
       var id=$(".btn-add-to-cart").val();
//       var qty_min=$("#qty_min_"+id).text();
//       console.log("qty "+qty_min);
//       qty_min=qty_min.split(" ");
//            console.log("Id in chkcamp "+qty_min);
             var qty=0;
             
            if($("#qty_"+id).val().length>0 )
            qty=parseInt($("#qty_"+id).val());
        
//        qty*=parseFloat(qty_min["prod_id"]);
//        var unit=qty_min[1];
            var data="prod="+id+"&qty="+qty;//+"&unit="+unit;
            console.log("data in chkcamp "+data);

                    $.ajax({
			async: false,
			type : 'POST',
			url  : origin+"campchk.php",
			data : data,
			success : function(response) {
                             console.log("response-"+response+"-");
            $("#subtotal_"+id).find(".subtotal").html("&#8377; "+response+"/-");
                    		}
                        });
            
    }

    $(".qty").on('keyup', chkcamp);
//    $(".unit").on('change', chkcamp);
    
    $(".qty").on('change', chkcamp);
//    });
    
    $(".btn-add-to-cart").on('click', function() {
        console.log("btn clicked add to cart");
        var prod_id=$(this).val();
        var form_id="#form_"+prod_id;
//        console.log("prod "+prod_id);
//        console.log("form "+form_id);
	 $(".form-cart").validate({
      rules: {
			qty: {
                            required: true/*,
                            chkqty: true*/
                        },
			slot: {
                            required: true
                        },
			reqd: {
                            required: true,
                            chkleadtime: true,
                            chkisfull: true
                        }
	   },
       messages: {
     			reqd: {
                            required: "When Do You require?",
                            chkleadtime: "Please select date post Lead time",
                            chkisfull: "Orders Full for Selected Date!"
                        },
     			qty: {
                            required: "Please Enter Quantity"/*,
                            chkqty: "Quantity should be greater than Minimum Order Quantity "*/
                        },
     			slot: {
                            required: "Please Select Time Slot"
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
	   submitHandler: submitCartForm	
       });

        /* login submit */
	   function submitCartForm() {
			var data = $(form_id).serialize();
                        console.log("data prod_details "+data);
			$.ajax({
				
			type : 'POST',
			url  : origin+"add-to-cart.php",
			data : data,
			beforeSend: function() {
//				$("#error").fadeOut();
                                $("#submit_prod_"+prod_id).prop('disabled', true);
				$("#submit_prod_"+prod_id).parents(".product-footer").find(".status").html(status);
			},
			success :  function(response) {
//                            console.log("resp "+response);
					if(response.search("success")>-1){
                                                $("#submit_prod_"+prod_id).prop('disabled', false);
                                                $("#submit_prod_"+prod_id).html('<i class="material-icons">shopping_cart</i> Add to Cart');
                $("#modal-msg").find(".modal-body").html("<p style='vertical-align:central;' class='text-center'>Product Added to Cart!</p>");
                $("#modal-msg").modal({backdrop: "static"});
                                                $(".status").html("");
                                                updatecart();

                            }
					else{
                                                $("#submit_prod_"+prod_id).prop('disabled', false);
                                                updatecart();
                $("#modal-msg").find(".modal-body").html("<p style='vertical-align:central;' class='text-center'>Unable to Add Product to Cart!</p>");
                $("#modal-msg").modal({backdrop: "static"});
                                                $(".status").html("");
					}
			  }
			});
				return false;
		}
	   /* login submit */
        
    });
                
                 
    $(".btn-call-4-service").on('click', function() {
        console.log("btn clicked add to cart");
        var serv_id=$(this).val();
//        var form_id="#form_"+serv_id;
        console.log("serv "+serv_id);
//        console.log("form "+form_id);
    var data="serv="+serv_id;
    console.log("data-"+data+"-");
			$.ajax({
				
			type : 'POST',
			url  : origin+"serviceorder-insert.php",
			data : data,
			beforeSend: function() {	
//				$("#error").fadeOut();
                                $("#submit_serv_"+serv_id).prop('disabled', true);
				$("#submit_serv_"+serv_id).append(status);
			},
			success :  function(response) {
                            console.log("data "+data);
                            console.log("resp "+response);
					if(response.search("success-service")>-1){
                                                $("#submit_serv_"+serv_id).html('Contact Service Provider');
                $("#modal-msg").find(".modal-body").html("<p style='vertical-align:central;' class='text-center'>Service Requested!\nService Provider would contact you soon!</p>");
                $("#modal-msg").modal({ backdrop: "static" });
                                                updatecart();
                                    }
                                    else if(response.search("login")>-1) {
                				//$("#submit_serv_"+serv_id).html(preloader());
                    window.location.href=origin+"Login";
                                    }
			  }
			});

    });

    $(".view-file").on('click',function() {
        var id=$(this).attr("data-val");
        console.log("id-"+id+"-");
        $(".details").toggle();
			$.ajax({
				
			type : 'POST',
			url  : origin+"view-pdf.php",
			data : "id="+id,
			beforeSend: function()
			{	
				$("#error").fadeOut();
				$(".view-file").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; loading ...');
			},
			success :  function(response) {
                            console.log("file -"+response+"-");
                            if(response.search("/.")>-1) {
                                var object=null;
                            	var ext = response.split(".");
                                var type="";
                            	
	ext=ext[(ext.length)-1];
	if(ext=="png" || ext=="jpeg" || ext=="gif" || ext=="jpg")
		type="image/"+ext;
	else if(ext=="pdf" || ext=="PDF")
		type="application/"+ext;
    if(ext!=="docx" && ext!=="doc") {
    	if(ext=="png" || ext=="jpeg" || ext=="gif" || ext=="jpg")
            object = "<object class='img-fluid' src="+{response}+" ><embed class='img-fluid' src="+response+" ></embed></object>";

            else if(ext=="pdf" || ext=="PDF")
                    object = "<object data="+{response}+" type="+type+" style=\"height: 100% !important; margin-left:auto !important; margin-right:auto !important; width: 100% !important; \" ></object>";
                    object = object.replace({response},  response);
    }
    else {
                        object = "<iframe src="+{response}+" width=\"100%\" height=\"100% !important;\"></iframe>";
                        object = object.replace({response},  response);


    }

                            console.log("alert obj "+object);
                            $("#modal-msg").find(".modal-body").html(object);
                            $("#modal-msg").modal('show');

                            if(ext=="docx" || ext=="doc")
                                $("#modal-service-brochure").modal('close');
                                
                            }
                            else {
                $("#modal-msg").find(".modal-body").html("<p style='vertical-align:central;' class='text-center'>Brochure / Flyer not uploaded by the Service Provider!</p>");
                $("#modal-msg").modal("show");
                            }
//                                alert("Brochure/ Flyer not uploaded by the Service Provider");
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

                 
         
$(".product-display").on('click',function() {
$(this).parent(".product").addClass("last-item");
var list=$(this).parent(".product");
$(".product-list").show("slow");
var id=list.attr("id");
id=id.split("product_");
id=id[1];
console.log("id "+id);
		var form_status = $('<div class="form_status"></div>');
			$.ajax({
				
			type : 'POST',
			url  : origin+"product_list.php",
			data : "prod="+id,
			beforeSend: function() {
                                  var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
                          list.find(".product-list-menu").append(status);
			},
			success :  function(response) {
//                            console.log("prod_list data-"+response+"-");
                            $(".product-list").find(".product-list-menu").html(response);
                            var prod_list_id="product_list_"+id;
                            $(".product-list").attr("id",prod_list_id);
                            var name=id.replace(/_/g," ");
                            $(".product-list-title").find(".prod_name").html(name);
                            var scrollval=$(".result").position().top-100;
                            console.log("scrollval0 "+scrollval);
                            $(window).scrollTop(scrollval);
                            
                            $(".show_desc").on('click',function() {
                                var id=$(this).attr("id");
                                id=id.split("show_desc_");
                                id=id[1];
                                $("#desc_block_"+id).show();
                            });


$(".form-cart").ready(function() {

    var d = new Date();
    var lead=1;
    var val=$(".dt").attr("data-lead");
    console.log("dtt-"+val+"-");
    if(typeof(val)!=="undefined" && val!=="")
        lead=parseInt(val);
    d.setDate(d.getDate() + lead);
        console.log("in 5 -"+d+"-");
    $(".dt").css("background-color","#fff","important");
       $('.dt').datepicker({
            startDate: d,
            format: 'dd-mm-yyyy'
        });


    function chkcamp(){
       var id=$(".btn-add-to-cart").val();
//       var qty_min=$("#qty_min_"+id).text();
//       console.log("qty "+qty_min);
//       qty_min=qty_min.split(" ");
//            console.log("Id in chkcamp "+qty_min);
             var qty=0;
             
            if($("#qty_"+id).val().length>0 )
            qty=parseInt($("#qty_"+id).val());
        
//        qty*=parseFloat(qty_min[0]);
//        var unit=qty_min[1];
            var data="prod="+id+"&qty="+qty;//+"&unit="+unit;
            console.log("data in chkcamp "+data);

                    $.ajax({
			async: false,
			type : 'POST',
			url  : origin+"campchk.php",
			data : data,
			success : function(response) {
                             console.log("response-"+response+"-");
            $("#subtotal_"+id).find(".subtotal").html("&#8377; "+response+"/-");
                    		}
                        });
            
    }
    
    $(".qty").on('keyup', chkcamp);
//    $(".unit").on('change', chkcamp);
    
    $(".qty").on('change', chkcamp);

    
    
    $(".btn-add-to-cart").on('click', function() {
        console.log("btn clicked add to cart");
        var prod_id=$(this).val();
        var form_id="#form_"+prod_id;
//        console.log("prod "+prod_id);
//        console.log("form "+form_id);
	 $(".form-cart").validate({
      rules: {
			qty: {
                            required: true/*,
                            chkqty: true*/
                        },
			slot: {
                            required: true
                        },
			reqd: {
                            required: true,
                            chkleadtime: true,
                            chkisfull: true
                        }
	   },
       messages: {
     			reqd: {
                            required: "When Do You require?",
                            chkleadtime: "Please select date post Lead time",
                            chkisfull: "Orders Full for Selected Date!"
                        },
     			qty: {
                            required: "Please Enter Quantity"/*,
                            chkqty: "Quantity should be greater than Minimum Order Quantity "*/
                        },
     			slot: {
                            required: "Please Select Time Slot"
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
	   submitHandler: submitCartForm	
       });

        /* login submit */
	   function submitCartForm() {
			var data = $(form_id).serialize();
                        console.log("data prod_details "+data);
			$.ajax({
				
			type : 'POST',
			url  : origin+"add-to-cart.php",
			data : data,
			beforeSend: function() {
//				$("#error").fadeOut();
                                $("#submit_prod_"+prod_id).prop('disabled', true);
				$("#submit_prod_"+prod_id).parents(".product-footer").find(".status").html(status);
			},
			success :  function(response) {
//                            console.log("resp "+response);
					if(response.search("success")>-1){
                                                $("#submit_prod_"+prod_id).prop('disabled', false);
                                                $("#submit_prod_"+prod_id).html('<i class="material-icons">shopping_cart</i> Add to Cart');
                                                updatecart();
                $("#modal-msg").find(".modal-body").html("<p style='vertical-align:central;' class='text-center'>Product Added to Cart!</p>");
                $("#modal-msg").modal({backdrop: "static"});
                                                $(".status").html("");
//                                $(".form_status").html("");

                            }
					else{
                                                $("#submit_prod_"+prod_id).prop('disabled', false);
                                                updatecart();
                                                $(".status").html("");
                $("#modal-msg").find(".modal-body").html("<p style='vertical-align:central;' class='text-center'>Unable to add Product to Cart!</p>");
                $("#modal-msg").modal({backdrop: "static"});
					}
			  }
			});
				return false;
		}
	   /* login submit */
        
    });
                
                
    
    });


    }
			});

});

$(".product-list-close").on('click',function() {
var id=$(".product-list").attr("id");
id=id.split("product_list_");
id=id[1];
//console.log("idd"+id);
var scrollval=$(".last-item").position().top+$(".product-list").position().top+200;
//console.log("scroll "+scrollval);
/*$('html, body').stop().animate({
    scrollTop: scrollval
}, 2000);*/
$(window).scrollTop(scrollval);
$(".product-list").hide("slow");
$("#product_"+id).removeClass("last-item");
});


         
$(".service-display").on('click',function() {
$(this).parent(".service").addClass("last-item");
var list=$(this).parent(".service");
$(".service-list").show("slow");
var id=list.attr("id");
console.log("id -"+id+"-");
id=id.split("service_");
id=id[1];
console.log("id "+id);
		var form_status = $('<div class="form_status"></div>');
			$.ajax({
				
			type : 'POST',
			url  : origin+"service_list.php",
			data : "serv="+id,
			beforeSend: function() {
                                  var status=form_status;
                                status.html('<i class="fa fa-spinner fa-spin"></i>');
                          list.find(".service-list-menu").append(status);
			},
			success :  function(response) {
                            console.log("serv_list data-"+response+"-");
                            $(".service-list").find(".service-list-menu").html(response);
                            var prod_list_id="service_list_"+id;
                            $(".service-list").attr("id",prod_list_id);
                            var name=id.replace(/_/g," ");
                            $(".service-list-title").find(".serv_name").html(name);
                            var scrollval=$(".result").position().top-100;
                            console.log("scrollval0 "+scrollval);
                            $(window).scrollTop(scrollval);
                            
                            $(".show_desc").on('click',function() {
                                var id=$(this).attr("id");
                                id=id.split("show_desc_");
                                id=id[1];
                                $("#desc_block_"+id).show();
                            });

                            $(".service-details").ready(function() {
    $(".btn-call-4-service").on('click', function() {
        console.log("btn clicked add to cart");
        var serv_id=$(this).val();
//        var form_id="#form_"+serv_id;
        console.log("serv "+serv_id);
//        console.log("form "+form_id);
    var data="serv="+serv_id;
    console.log("data-"+data+"-");
			$.ajax({
				
			type : 'POST',
			url  : origin+"serviceorder-insert.php",
			data : data,
			beforeSend: function() {	
//				$("#error").fadeOut();
                                $("#submit_serv_"+serv_id).prop('disabled', true);
				$("#submit_serv_"+serv_id).append(status);
			},
			success :  function(response) {
                            console.log("data "+data);
                            console.log("resp "+response);
					if(response.search("success-service")>-1){
                                                $("#submit_serv_"+serv_id).html('Contact Service Provider');
                $("#modal-msg").find(".modal-body").html("<p style='vertical-align:central;' class='text-center'>Service Requested!\nService Provider would contact you soon!</p>");
                $("#modal-msg").modal({ backdrop: "static" });
                                    }
                                    else if(response.search("login")>-1) {
                				//$("#submit_serv_"+serv_id).html(preloader());
                    window.location.href=origin+"Login";
                                    }
			  }
			});

    });

 
                            });


    }
			});

});

$(".service-list-close").on('click',function() {
var id=$(".service-list").attr("id");
id=id.split("service_list_");
id=id[1];
//console.log("idd"+id);
var scrollval=$(".last-item").position().top+$(".service-list").position().top+200;
//console.log("scroll "+scrollval);
/*$('html, body').stop().animate({
    scrollTop: scrollval
}, 2000);*/
$(window).scrollTop(scrollval);
$(".service-list").hide("slow");
$("#service_"+id).removeClass("last-item");
});











});

