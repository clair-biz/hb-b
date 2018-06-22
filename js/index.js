jQuery(function($) {'use strict';
                var origin=window.location.origin;
                var api="http://api.homebiz365.in/";



            function validateUser(path) {
                console.log("validateUser called");
                $.ajax({
			url: origin+"/validate_user.php?path="+path,
			beforeSend: function(){
				$(".preloader").css("display","flex");
				$(".content").css("display","none");
				$(".preloader").html('<h5 class="container text-center"><i class="fa fa-spinner fa-spin"></i> Validating...</h5>').fadeIn();
			},
                        success: function(response) {
                            console.log("response-"+response+"-");
                            if(response.search("false")>-1) {
				$(".loader-block").html('<h5 class="text-alert">You have no permissions to view this page, redirecting to Login page</h5>').fadeIn();
               setTimeout(window.location.href = origin+"/Login",5000);
               }
               else if(response.search("true")>-1) {
				$(".preloader").css("display","none");
				$(".content").css("display","block");
                }
                        }
 		});
                
            }

            
            function canDisplayCategory(path) {
            var prodList=["","RegistrationForm","Products","AddProduct","UpdateProduct","Members","ExtendMembership","PrintReceipt","Customers","UpdateCustomer","Campaigns"];
            if(prodList.indexOf(path)>-1)
                return "product";
            }
            
            function categorySlide(type) {
                $.ajax({
                    url: origin+"/category-slider.php?type="+type,
                    success:function(response) {
                        $(".main-slider").html(response);
                    
/*                    $(".main-slider").ready(function() {
                $(".main-slider").slick({
//                    autoplay: true,
                    nextArrow: null,
                    prevArrow: null,
//                    autoplaySpeed: 2000,
                        lazyLoad: 'ondemand', // ondemand progressive anticipated
//                        infinite: true
                      });
                });*/
                }
            });
            }

            function footer() {
                $.ajax({
                    url: origin+"/footer.php",
                    success:function(response) {
                        $(".footer").html(response);
                }
            });
            }


            function newArrivalsSlide(city,type) {
                var url=origin+"/new-arrival.php?type="+type+"&city="+city;
//                console.log(url);
                $.ajax({
                    url: url,
                    success:function(response) {
                        $(".new-arrivals").html(response);

                    
                    $(".new-arrivals").ready(function() {
                $(".slider-new").slick({
//          autoplay:true,
//    autoplaySpeed: 4000,
        prevArrow: '<button class="slick-prev slick-arrow" aria-label="Previous" type="button" style=""><i class="material-icons">keyboard_arrow_left</i></button>"',
        nextArrow: '<button class="slick-next slick-arrow" aria-label="Previous" type="button" style=""><i class="material-icons">keyboard_arrow_right</i></button>"',
          infinite: true,
          mobileFirst:true,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 3
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 360,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ],
  lazyLoad: 'ondemand' // ondemand progressive anticipated
//    autoplay: true,
//    autoplaySpeed: 4000,
        });
                });
                }
            });
            }

            function productCatBlock(type) {
                $.ajax({
                    url: origin+"/product-cat-block.php?type="+type,
                    success:function(response) {
                        $(".product-category").html(response);
                        
                        $(".product-category").ready(function() {
                               $(".product-link").on('click',function(event){
    console.log("in product link");
    event.preventDefault();
var href = $(this).attr("data-message");
//        message = $(this).attr("data-message");
        var data=href.split("Products/");
//        alert("data "+data);
        data="prod="+data[1];
        console.log("data "+data);
        var type="Product";
        isAvailable(href,data,type);
//alert("product\n"+href+"\ndata "+data);
        //    myFunc();
//    alert(message);
    });
 
                               $(".service-link").on('click',function(event){
    console.log("in service link");
    event.preventDefault();
var href = $(this).attr("data-message");
//        message = $(this).attr("data-message");
        var data=href.split("Services/");
//        alert("data "+data);
        data="serv="+data[1];
        console.log("data "+data);
        var type="Service";
        isAvailable(href,data,type);
//alert("product\n"+href+"\ndata "+data);
        //    myFunc();
//    alert(message);
    });
 
                        });
                    }
                });
            }
            
        function productPopularTag(city,type) {
                $.ajax({
                    url: origin+"/product-popular.php?city="+city+"&type="+type,
                    success:function(response) {
                        $(".popular-tag").html(response);
                    $(".popular-tag").ready(function() {
                $(".slider-popular").slick({
//          autoplay:true,
//    autoplaySpeed: 4000,
        prevArrow: '<button class="slick-prev slick-arrow" aria-label="Previous" type="button" style=""><i class="material-icons">keyboard_arrow_left</i></button>"',
        nextArrow: '<button class="slick-next slick-arrow" aria-label="Previous" type="button" style=""><i class="material-icons">keyboard_arrow_right</i></button>"',
          infinite: true,
          mobileFirst:true,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 3
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 360,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ],
  lazyLoad: 'ondemand' // ondemand progressive anticipated
//    autoplay: true,
//    autoplaySpeed: 4000,
        });
                });
                    }
                });
            }
    
/*    function categoryModal(inArr) {
    if(inArr.category_product==false && inArr.modal_category_product==false) {
            $("#categoryProductModal").modal("hide"); 
console.log(inArr);
            }
            if(inArr.category_product==true || inArr.modal_category_product==true) {
            $("#categoryProductModal").modal("show"); 
console.log(inArr);

                }

    }*/
//var inArr = {modal_category_product:false, category_product:false, category_service:false};
    function getCityList(city) {
                    $(".currentCity").html(city);
        
    $.ajax({
       url: origin+"/citychk.php?type=list&city="+city,
       async: false,
       success: function(response) {
           console.log(response);
           $(".cities").html(response);
           
    $(".city").on('click',function() {
        var changeCity=$(this).attr("data-city");
   city=setCity(changeCity);
   getCityList(city);
   console.log("city changed-"+city+"-");
   loadFiles(city,"Product");
});

       }
    });
    
    }
    
    function getCategoryMenu(val,type) {
                    
           console.log("in menu function");
        var url=origin;
        switch(type) {
            case "Product": url=url+"/product-menu.php?val="+val;
                break;
            case "Service": url=url+"/service-menu.php?val="+val;
                break;
        }
    $.ajax({
       url: url,
       async: false,
       success: function(response) {
//           console.log(response);
           $(".category-menu").html(response);
           

       }
    });
    
    }
    
    function navigationBar(path,city,type) {
            $.ajax({
               url: origin+"/navigation.php",
               success: function(response) {
                   $(document).ready(function() {
                $(".body").before(response);
                
                $(".search-form").ready(function() {
                                     $(".search-form").validate({
      rules: {
                      searchText: "required"
	   },
       messages: {
       },
        errorPlacement: function(error, element) {
          var placement = $(element).data('error');
          if (placement) {
            $(placement).append(error);
          } else {
            error.insertAfter(element);
          }
        },
	   submitHandler: submitSearchForm	
       });  
	   /* validation */
	   
	   /* login submit */
	   function submitSearchForm() {
			var data = $(".search-form").serialize();
                        console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : origin+'/search.php',
			data : data,
			beforeSend: function() {	
                            
                        },
                        success: function(response) {
                            response=JSON.parse(response);
                            console.log(response);
                            console.log(response.type);
                            setType(response.type.slice(0,-1));
                            window.location.href=response.location;
                        }
                      
                  });
              }
 
                });
                
                
                $(".navbar .navbar-expand-md .sticky-top").ready(function() {
                    

                    
                    
                    //                    
var products = new Bloodhound({
    datumTokenizer: function (d) {
        return Bloodhound.tokenizers.whitespace(d.name);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: origin+"/prod-serv-search-list.php?type=Product&json=true"
});

var services = new Bloodhound({
    datumTokenizer: function (d) {
        return Bloodhound.tokenizers.whitespace(d.name);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: origin+"/prod-serv-search-list.php?type=Service&json=true"
});


                    $('#bloodhound .typeahead').typeahead({
                        // minimum character length needed before suggestions start getting rendered.
                        minLength: 2,
                        //Highlights the matched string, in the result set.
                        highlight: true,
                        //If false, the typeahead will not show a hint in the text box (autocomplete).
                        hint: true
                        },
                      {
                        name: 'products',
                        display: 'name',
                        source: products.ttAdapter(),
                        templates: {
                            header: '<h6 class="team">Products</h6>'
                        }
                  },
                      {
                        name: 'services',
                        display: 'name',
                        source: services.ttAdapter(),
                        templates: {
                            header: '<h6 class="team">Services</h6>'
                        }
                  });

                  $(".tt-dataset-products .tt-selectable").on('click',function() {
                      console.log("product clicked");
                     $(".typeahead").attr("data-click","Product"); 
                  });
                  
                  
                  
                    getCityList(city);
                    setType(type);
                       $(".categories").removeClass("active");
                       $("#category_"+type).find(".categories").addClass("active");
                       $("#navbar"+type+"drop").addClass("active");
                       

                    $(".categories").on('click',function() {
                       var changeType=$(this).attr("data-type");
                       $(".categories-link").removeClass("active");
//                       $(this).addClass("active");
                        console.log("in category change"+changeType);
                       $("#category_"+changeType).find(".categories").addClass("active");
                       $("#navbar"+changeType+"drop").addClass("active");
                       setType(changeType);
                var pathh=window.location.pathname;
                pathh=pathh.split("/");
                pathh=pathh[1];
                console.log("path=>"+pathh+"<=");
                       if(pathh=="")
                       loadFiles(city,changeType);
                   else
                       window.location.href=origin;
                    });
                    
                    
                    
                                        $("#goOfflineModal").ready(function() {
                    $("#vend-offline").validate({
      rules: {
					'from': "required",
					'to': "required"
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
	   submitHandler: submitGoOfflineForm	
       });

	   function submitGoOfflineForm() {		
			var data = $("#vend-offline").serialize();
                      console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : origin+'/go-offline.php',
			data : data,
			beforeSend: function() {
                              $("#btn-submit").prop('disabled', true);
			},
			success :  function(response) {
                          console.log("resp-"+response+"-");
                                $(".content").prepend("<p style='vertical-align:central;' class='text-center bg-info text-white'><i class='fa fa-exclamation' ></i> "+response+"!</p>").fadeIn().delay(5000).fadeOut();
			  }
			});
				return false;
		}
	   /* login submit */
           
                    });

                    
                    
                        });
                   });
               }
            });
        }

            var path=window.location.pathname;
            console.log("path-"+path+"-");
            if(path.search("/")>-1) {
            path=path.split("/");
            path=path[1];
            }
/*            var p=["Products","Services"];
            if(p.indexOf(path)>-1) {
                console.log("in p-"+path+"-");
                setType(path);
                var city=Cookies.get("city");
                loadFiles(city,path);
            }
*/
    //            $(document).ready(function() {
var Default=["Services","Products","Cart","CustomerRegistration","VendorRegistration","About","FAQ","Contact","HowItWorks","StartSelling","Login","Logout","PrivacyPolicy","Terms","VerifyMobileNumber"];
var Customer=["Services","Products","OrderCheckOut","MyOrders","CustomerProfile","CustomerRegistration","ForgotPassword","ChangePassword","Return"];
var Delivery=["Delivery"];
var Vendor=["ProductsPage","BankDetails","OrdersPage","VendorSubscriptions","RateChart","ChangePassword","SubscriptionPayment","AddOffer","AddProductToOffer","AddServiceToOffer","UpdateOffer","MyOffers","VendorDashboard","AddProduct","UpdateProduct","VendorProfile","OrderFullChart","OrderFull","ServicesPage","VendorRegistration","AddService","UpdateService","NewSubscription"];
var Admin=["AdminDashboard","Categories","Customers","UpdateRate","Vendors","Refunds","AddRatePlan","AdminRateChart","SubscriptionRequest","Reports"];
//            var list=["AdminDashboard","RegistrationForm","Products","AddProduct","UpdateProduct","Members","ExtendMembership","PrintReceipt","Customers","UpdateCustomer","Campaigns"];
            console.log("pathh-"+path+"-");
            console.log("customer-"+Customer.indexOf(path)+"-");
            console.log("vendor-"+Vendor.indexOf(path)+"-");
            console.log("admin-"+Admin.indexOf(path)+"-");
            console.log("delivery-"+Delivery.indexOf(path)+"-");
            console.log("default-"+Default.indexOf(path)+"-");
            if( (Customer.indexOf(path)>-1
            || Vendor.indexOf(path)>-1
            || Admin.indexOf(path)>-1
            || Delivery.indexOf(path)>-1 )
            && Default.indexOf(path)==-1 ) {
        console.log("validate-user called");
        
            validateUser(window.location.pathname);
        }
        
        else
        console.log("validate-user not called");
//            window.location.href=origin+"/Logout";

/*    $("a").on('click',function() {
        var val=$(this).val();
        if(val!="#") {
            validateUser(val);
        }
    });

});
*/            

function setCity(changeCity) {
var city="Pune";
    if (typeof(Cookies.get("city"))==="undefined" ) {
        console.log("in undefined");
        if(changeCity=="") {
$.get("https://ipinfo.io", function(response) {
    city=response.city;
//    Cookies.set("city",response.city,{domain: ".homebiz365.in"});
    console.log(response.city);
}, "jsonp");
        }
        else {
            city=changeCity;
            
        }
            
            console.log("city-"+city+"-");
    $.ajax({
       url: origin+"/citychk.php?type=check&city="+city,
       async: false,
       success: function(response) {
           if(response.search(city)>-1)
        Cookies.set("city",response,{domain: ".homebiz365.in"});
    else
        Cookies.set("city","Pune",{domain: ".homebiz365.in"});
        
       }
    });
    getCityList(city);
 // no cookie
} else {
 // have cookie
    if(changeCity!="") {
        Cookies.set("city",changeCity,{domain: ".homebiz365.in"});
    getCityList(city);
    }
    city=Cookies.get("city");
    
}


return city;
}

function setType(changeType) {
var type="Product";
    if (typeof(Cookies.get("type"))==="undefined" ) {
        console.log("in undefined");
        if(changeType!="") 
            type=changeType;
            
        
        Cookies.set("type",type,{domain: ".homebiz365.in"});
 // no cookie
} else {
 // have cookie
    if(changeType!="") {
        Cookies.set("type",changeType,{domain: ".homebiz365.in"});
    }
    type=Cookies.get("type");
    
}


return type;
}




$(".city").on('click',function() {
   var city=$(this).attr("data-city");
   setCity(city);
   var type=Cookies.get("type");
   console.log("city changed-"+city+"-");
   
   loadFiles(city,type);
});

function loadFiles(city,type) {
                       categorySlide(type);

                    newArrivalsSlide(city,type);
//                foodItemSlide(city);
//                productSlide();
//                serviceSlide();
                var pathh=window.location.pathname;
                pathh=pathh.split("/");
                var val="";
                
            console.log("in menu p-"+pathh+"-");
            var index=["","#"];
            var list=["Products","Services"];
            console.log("in menu-"+list.indexOf(pathh[1])+"-");
            if(list.indexOf(pathh[1])>-1) {
                console.log("p-"+pathh.length+"-");
                var len=pathh.length;
                if(len==4)
                    val=pathh[3];
                else if(len==3)
                    val=pathh[2];
                
                }

                if(index.indexOf(pathh[1])>-1) {
                productCatBlock(type);
                productPopularTag(city,type);
            }
                if(list.indexOf(pathh[1])>-1) {
                getCategoryMenu(val,type);
                }
}

	$(document).ready(function() {
            var city=setCity("");
            var type=setType("");
            console.log("city ready-"+city+"-");
$('[data-toggle="tooltip"]').tooltip();
//            getCategoryLists();
//            getNewArrivals(city);
//            var type=canDisplayCategory(path);
//            var type="Product";
                   navigationBar(path,city,type);
                loadFiles(city,type);
                
               footer();

            var list=["AdminDashboard","RegistrationForm","Products","AddProduct","UpdateProduct","Members","ExtendMembership","PrintReceipt","Customers","UpdateCustomer","Campaigns"];
            console.log("pathh-"+path+"-");
            console.log("index-"+list.indexOf(path)+"-");
//            if(list.indexOf(path)>-1)
//            validateUser(window.location.pathname);
            
//          if(path=="")
//              $("#category-product").addClass("active");
        
    });

            
            
    function isAvailable(href,data,type) {
//console.log("href "+href);
//console.log("type "+type);
var message="";
if(type=="Product")
    message="No Vendors available right now!";
if(type=="Service")
    message="No Service Providers available right now!";

console.log("data -"+data+"-");
        $.ajax({
            type : 'POST',
            url  : origin+"/is-available.php",
            data : data,
            beforeSend: function() {	
//                    $("html").fadeOut();
//                    $("html").html(preloader());
            },
            success :  function(response) { 
                console.log("response-"+response+"-");
                if(response.search("ok")>-1) {
            window.location.href = href;
            setType(type);
        }
            else {
                console.log("in error"+response);
                $("#modal-msg").find(".modal-body").html("<p style='vertical-align:central;' class='text-center'>"+message+"</p>");
                $("#modal-msg").modal({backdrop: "static"});
//                $("html").html(preloader());
            }
            }
        });
}

            
            
           
$(".product-link-from-top").click(function(event){
//    event.preventDefault();
$("#modal-category").modal("close");
var href = $(this).attr("data-message");
//        message = $(this).attr("data-message");
        var data=href.split("Products/");
//        alert("data "+data);
        data="prod="+data[1];
//        console.log("data "+data);
        var type="product";
        isAvailable(href,data,type);
//alert("product\n"+href+"\ndata "+data);
        //    myFunc();
//    alert(message);
});
           
$(".service-link-from-top").click(function(event){
//    event.preventDefault();
console.log("in service link");
$("#modal-category").modal("close");
var href = $(this).attr("data-message");
//        message = $(this).attr("data-message");
        var data=href.split("Services/");
//        alert("data "+data);
        data="serv="+data[1];
//        console.log("data "+data);
        var type="service";
        isAvailable(href,data,type);
//alert("product\n"+href+"\ndata "+data);
        //    myFunc();
//    alert(message);
});
           
  
  $("#na-prod, #na-serv").on('click',function() {
      var id=$(this).attr("id");
      console.log("clicked -"+id+"-");
      var message="";
              if(id=="na-prod")
                          message="Product Currently Unavailable!"
              if(id=="na-serv")
                          message="Service Currently Unavailable!"
                              
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>"+message+"</p>");
                $("#modal-message").modal("open");
            });
   
    
    $(document).add("#camp-update, #vend-register, #cust-register, #cust-update").ready(function() {
        console.log("in 4 datepicker");
        /*
    $('[data-toggle="datepicker"]').datepicker({
            format: 'dd-mm-yyyy'
        });
       */ 
    var d = new Date();
    d.setFullYear(d.getFullYear() - 10);
    $("#dob").css("background-color","#fff","important");
    $('#dob').datepicker({
            endDate: d,
            format: 'dd-mm-yyyy'
        });
        
});

    $(document).add("#camp-insert").ready(function() {
    var d = new Date();
    $("[data-toggle='datepicker']").css("background-color","#fff","important");
    $('[data-toggle="datepicker"]').datepicker({
            startDate: d,
            format: 'dd-mm-yyyy'
        });
        
});

$(document).add(".form-cart").ready(function() {
        console.log("in 5 datepicker");
//    var lead=1;
    var val=$(".dt").attr("data-lead");
    console.log("dtt->"+val+"-");
    var d = new Date(val);
    console.log("dtt->"+d+"-");
//    if(typeof(val)!=="undefined" && val!=="")
//        lead=parseInt(val);
//    d.setDate(d.getDate() + lead);
//        console.log("in 5 -"+d+"-");
    $(".dt").css("background-color","#fff","important");
       $('.dt').datepicker({
            startDate: d,
            format: 'dd-mm-yyyy'
        });
 
});

$(document).add("form #camp-update").ready(function() {
        console.log("in 6 datepicker");
    var d = new Date();
    $("#stdt, #endt").css("background-color","#fff","important");
       $('#stdt, #endt').datepicker({
            startDate: d,
            format: 'dd-mm-yyyy'
        });
        
        $("#stdt").on('change',function() {
           var d1=date($(this).val());
           
       $('#endt').datepicker({
            startDate: d1,
            format: 'dd-mm-yyyy'
        });
        
        });
        
 
});

$(document).add("#category-Product, #category-Service").ready(function() {
                                  $(".product-link").on('click',function(event){
    console.log("in product link");
    event.preventDefault();
var href = $(this).attr("data-message");
//        message = $(this).attr("data-message");
        var data=href.split("Products/");
//        alert("data "+data);
        data="prod="+data[1];
        console.log("data "+data);
        var type="Product";
        isAvailable(href,data,type);
//alert("product\n"+href+"\ndata "+data);
        //    myFunc();
//    alert(message);
    });
 
                               $(".service-link").on('click',function(event){
    console.log("in service link");
    event.preventDefault();
var href = $(this).attr("data-message");
//        message = $(this).attr("data-message");
        var data=href.split("Services/");
//        alert("data "+data);
        data="serv="+data[1];
        console.log("data "+data);
        var type="Service";
        isAvailable(href,data,type);
//alert("product\n"+href+"\ndata "+data);
        //    myFunc();
//    alert(message);
    });
 
});


});

