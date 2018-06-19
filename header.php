<!DOCTYPE html>
<html>
<head>
<?php
require_once ('Classes/Classes.php');
$domain=Crm::domainName();
if(isset($_COOKIE["city"])=="" || !isset($_COOKIE["city"])) {
    setcookie("city","Pune", time()+3600*24, "/", $domain);
    ?>
<script>
    location.reload();
</script>
<?php
}
                 mysqli_close(Crm::con());
    $ref=Order::countRefund();
    
$strmaincat="SELECT distinct cat_name,cat_img FROM category where cat_type='Product' and category.cat_id<>0 order by cat_name";
$strserv_cat="SELECT distinct cat_name,cat_img FROM category where cat_type='Service' and category.cat_id<>0 order by cat_name";
$strcities="SELECT distinct city_served FROM vend_subscription where vs_pay_status='Enabled'";
	$main_cat=mysqli_query(Crm::con(), $strmaincat);
	$res_cities=mysqli_query(Crm::con(), $strcities);
        $serv_cat=mysqli_query(Crm::con(), $strserv_cat);
?>
    <meta charset="utf-8">
    <title><?php echo Crm::SiteName(); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap styles -->
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" media="screen,projection">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.7.1/slick.css"  media="screen,projection" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.7.1/slick-theme.css"  media="screen,projection" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/css/jquery.dataTables.css" media="screen,projection" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/css/dataTables.material.css" media="screen,projection" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css" media="screen,projection" />
<link rel="shortcut icon" href="favicon.ico" sizes="20x20">
<link rel="stylesheet" type="text/css" href="<?php echo Crm::root()."style.css"; ?>"  media="screen,projection">











<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>
<!--script src="autologout.js"></script-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-zoom/1.7.20/jquery.zoom.js"></script>

<!-- Latest compiled JavaScript -->
<!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/dataTables.material.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.7.1/slick.js"></script>






  <script type="text/javascript">


$(function() {

    function timeChecker() {
        setInterval(function() {
            var storedTimeStamp = sessionStorage.getItem("lastTimeStamp");  
            timeCompare(storedTimeStamp);
        },60000);
    }


    function timeCompare(timeString) {
        var maxMinutes  = 10;  //GREATER THEN 1 MIN.
        var currentTime = new Date();
        var pastTime    = new Date(timeString);
        var timeDiff    = currentTime - pastTime;
        var minPast     = Math.floor( (timeDiff/60000) ); 
//console.log("min "+minPast);
        if( minPast > maxMinutes) {
            sessionStorage.removeItem("lastTimeStamp");
//            alert("Session Timeout!");
//            window.location.href = "./logout.php";
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Session Timeout!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"Logout";
                });
            return false;
        }else {
            //JUST ADDED AS A VISUAL CONFIRMATION
//            console.log(currentTime +" - "+ pastTime+" - "+minPast+" min past");
        }
    }

    if(typeof(Storage) !== "undefined")  {
         var session = "<?php if(isset($_SESSION["user"])!="") {echo Crm::getUserType($_SESSION["user"]);} ?>";
//         console.log("session "+session);
         if(session==11 || session==1 || session==2) {
        $(document).mousemove(function() {
            var timeStamp = new Date();
            sessionStorage.setItem("lastTimeStamp",timeStamp);
        });

        timeChecker();
        }
    }
});//END JQUERY



</script>
  <script type="text/javascript">
      function preloader() {
          
          var ret= "<div class=\"preloader-wrapper small active\">";
      ret+="<div class=\"spinner-layer spinner-blue\">";
        ret+="<div class=\"circle-clipper left\">";
          ret+="<div class=\"circle\"></div>";
        ret+="</div><div class=\"gap-patch\">";
          ret+="<div class=\"circle\"></div>";
        ret+="</div><div class=\"circle-clipper right\">";
          ret+="<div class=\"circle\"></div>";
        ret+="</div>";
      ret+="</div>";

      ret+="<div class=\"spinner-layer spinner-red\">";
        ret+="<div class=\"circle-clipper left\">";
          ret+="<div class=\"circle\"></div>";
        ret+="</div><div class=\"gap-patch\">";
          ret+="<div class=\"circle\"></div>";
        ret+="</div><div class=\"circle-clipper right\">";
          ret+="<div class=\"circle\"></div>";
        ret+="</div>";
      ret+="</div>";

      ret+="<div class=\"spinner-layer spinner-yellow\">";
        ret+="<div class=\"circle-clipper left\">";
          ret+="<div class=\"circle\"></div>";
        ret+="</div><div class=\"gap-patch\">";
          ret+="<div class=\"circle\"></div>";
        ret+="</div><div class=\"circle-clipper right\">";
          ret+="<div class=\"circle\"></div>";
        ret+="</div>";
      ret+="</div>";

      ret+="<div class=\"spinner-layer spinner-green\">";
        ret+="<div class=\"circle-clipper left\">";
          ret+="<div class=\"circle\"></div>";
        ret+="</div><div class=\"gap-patch\">";
          ret+="<div class=\"circle\"></div>";
        ret+="</div><div class=\"circle-clipper right\">";
          ret+="<div class=\"circle\"></div>";
        ret+="</div>";
      ret+="</div>";
    ret+="</div>";
    
    return ret;
      }
          function showproductcat() {
  $('.category-product-block').show();
  $('.category-service-block').hide();
//  console.log("in show prodcat");
    }
    
    function showservicecat() {
  $('.category-product-block').hide();
  $('.category-service-block').show();
//  console.log("in show servcat");
    }
    
        function updatecart() {
            
        			$.ajax({
				
			type : 'POST',
			url  : '<?php echo Crm::root()."cart-count.php"; ?>',
			success :  function(response) {
                            $(".cartcount").html(response);
			  }
			});

    }



        
    $(document).ready(function() {

        $("#vendor-disable-reason").on('keyup',function() {
            var len=$(this).val().length;
//            console.log(len);
                if(len>=5)
                    $(".submit-reject-vendor").prop("disabled",false);
                else
                    $(".submit-reject-vendor").prop("disabled",true);
            });

        $("#customer-disable-reason").on('keyup',function() {
            var len=$(this).val().length;
//            console.log(len);
                if(len>=5)
                    $(".submit-reject-customer").prop("disabled",false);
                else
                    $(".submit-reject-customer").prop("disabled",true);
            });



        
    $('.materialboxed').materialbox();
$('select').formSelect();    
$('.collapsible').collapsible();
$('.tabs').tabs();    
$('.dropdown-trigger').dropdown();    
        $(".sidenav").sidenav();
        updatecart();
  $('.datepicker').datepicker({
    selectMonths: true, // Creates a dropdown to control month
    yearRange: 160, // Creates a dropdown of 15 years to control year,
    today: 'Today',
    clear: 'Clear',
    close: 'Ok',
     format: 'dd-mm-yyyy',
     defaultDate:null, //some date
     closeOnSelect: true // Close upon selecting a date,
  });
    $('.timepicker').timepicker({
    default: null, // Set default time: 'now', '1:30AM', '16:30'
    fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
    twelvehour: true, // Use AM/PM or 24-hour format
    donetext: 'OK', // text for done-button
    cleartext: 'Clear', // text for clear-button
    canceltext: 'Cancel', // Text for cancel-button
    autoclose: false, // automatic close timepicker
    ampmclickable: true, // make AM PM clickable
    aftershow: function(){} //Function for after opening timepicker
  });
        $("#category-product").on('click',function() {
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root;
        });
        $("#category-service").on('click',function() {
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"Services"; 
        });
        
    $(".view-terms").on('click',function() {
                            var root="<?php echo Crm::root(); ?>";

                    var object = "<object data="+root+"uploads/terms.pdf\" type=\"application/pdf\" width=\"100%\" height=\"400px\"></object>";
                    object = object.replace(root+"uploads/terms.pdf",  root+"uploads/terms.pdf");
//                            console.log("alert "+response);
                            $("#modal-terms").find(".modal-content").html(object);
                            $("#modal-terms").modal('open');
    });



  $('.modal').modal({
  });
  
  $('.modalCategory').modal({
      dismissible: true, // Modal can be dismissed by clicking outside of the modal
      opacity: .3, // Opacity of modal background
      inDuration: 0, // Transition in duration
      outDuration: 0, // Transition out duration
      startingTop: '10%', // Starting top style attribute
      endingTop: '14%' // Ending top style attribute
  });
  
  $('.modal.searchModal').modal({
      dismissible: true, // Modal can be dismissed by clicking outside of the modal
      opacity: .3, // Opacity of modal background
      inDuration: 0, // Transition in duration
      outDuration: 0, // Transition out duration
      startingTop: '25%', // Starting top style attribute
      endingTop: '50%' // Ending top style attribute
  });
  
  $('#modal-message').modal({
      dismissible: false, // Modal can be dismissed by clicking outside of the modal
      opacity: .5, // Opacity of modal background
      inDuration: 0, // Transition in duration
      outDuration: 0, // Transition out duration
      startingTop: '25%', // Starting top style attribute
      endingTop: '30%' // Ending top style attribute
  });
  
       $(".category-slider").slick({
    autoplay: true,
    nextArrow: null,
    prevArrow: null,
    autoplaySpeed: 2000,
        lazyLoad: 'ondemand', // ondemand progressive anticipated
        infinite: true
      });
        
       $(".homebiz-slider").slick({
    vertical: true,
    verticalSwiping: true,
    autoplay: true,
    nextArrow: null,
    prevArrow: null,
    autoplaySpeed: 3000,
//        lazyLoad: 'ondemand', // ondemand progressive anticipated
        infinite: true
      });
        
      $(".center").slick({
        dots: true,
        infinite: true,
        centerMode: true,
        slidesToShow: 3,
        slidesToScroll: 3
      });
      
        $(".regular").slick({
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
        
        $(".slider-new").slick({
          autoplay:true,
    autoplaySpeed: 4000,
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
        
        
/*      $(".lazy").slick({
    autoplay: true,
    nextArrow: null,
    prevArrow: null,
    dots: true,
    autoplaySpeed: 2000,
        lazyLoad: 'ondemand', // ondemand progressive anticipated
        infinite: true
      });*/
    });
</script>


<script>
    $("document").ready(function() {
            $(".city").on("change", function() {
            var city=$(this).attr("id");
            console.log("caught "+city);
            var citysession="city="+city;
            document.cookie= citysession;
            $(".cities").text(city);
            location.reload();
            });
            
            $(".city").on("select", function() {
            var city=$(this).attr("id");
            console.log("caught "+city);
            var citysession="city="+city;
            document.cookie= citysession;
            $(".cities").text(city);
            location.reload();
            });
            
            $(".city").on("click", function() {
            var city=$(this).attr("id");
            console.log("caught "+city);
            var citysession="city="+city;
            document.cookie= citysession;
            $(".cities").text(city);
            location.reload();
            });
            

    $(".main_category").on('mouseover',function() {
//       console.log($(this).find(".main_category_item").attr("id")); 
       var cat_name=$(this).find(".main_category_item").attr("id"); 
       cat_name=cat_name.split("main_cat_");
       cat_name=cat_name[1];
       $(".main_category").css("background-color","white");
//       $(this).css("background-color","grey");
       $(".sub_category").hide();
       $("#sub_cat_"+cat_name).toggle();
    });
    
    $(".main_category").on('mouseout',function() {
//       console.log($(this).find(".main_category_item").attr("id")); 
       var cat_name=$(this).find(".main_category_item").attr("id"); 
       cat_name=cat_name.split("main_cat_");
       cat_name=cat_name[1];
       $(this).css("background-color","grey");
       $(".sub_category").hide();
       $("#sub_cat_"+cat_name).toggle();
    });
    
    
            $(".products").on('mouseover',function() {
            $(".cities-product-list").show();
       $(".category").css("background-color","white");
            
            
        });

    });
    </script>
    
    
        <script>
function isAvailable(href,data,type) {
//console.log("href "+href);
//console.log("data "+data);
var message="";
if(type=="product")
    message="No Vendors available right now!";
if(type=="service")
    message="No Service Providers available right now!";

console.log("data -"+data+"-");
        $.ajax({
            type : 'POST',
            url  : '<?php echo Crm::root()."is-available.php"; ?>',
            data : data,
            beforeSend: function() {	
//                    $("html").fadeOut();
//                    $("html").html(preloader());
            },
            success :  function(response) {
                console.log("response-"+response+"-");
                if(response.search("ok")>-1)
            window.location.href = href;
            else {
                console.log("in error"+response);
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>"+message+"</p>");
                $("#modal-message").modal("open");
//                $("html").html(preloader());
            }
            }
        });
}
                
                
$.validator.addMethod("notEqualTo", function(value, element) {
    if(value==$("#cntc").val() && value.length==10 && $("#cntc").val().length==10)
            return false;
    else
        return true;
}, "This has to be different...");

$.validator.addMethod('filesize', function(value, element, param) {
    // param = size (en bytes) 
    // element = element to validate (<input>)
    // value = value of the element (file name)
    return this.optional(element) || (element.files[0].size <= param) 
});

    $.validator.addMethod("cntclenchk", function(value, element) {
	if(value.length==10) {
  return true;
        }
}, 'Please enter a Valid Mobile Number!');

    $.validator.addMethod("pwdlenchk", function(value, element) {
	if(value.length>=6) {
  return true;
        }
}, 'Please enter a Valid Mobile Number!');


$.validator.addMethod("emaill", function(value, element) {
  // allow any non-whitespace characters as the host part
  return /^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/i.test( value );
}, 'Please enter a Valid Email Address.');

$.validator.addMethod("emaill1", function(value, element) {
  // allow any non-whitespace characters as the host part
  if(value.length==0)
      return true;
  else if(/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/i.test( value ))
  return true;
}, 'Please enter a Valid Email Address.');

$.validator.addMethod("namechk", function(value, element) {
  // allow any non-whitespace characters as the host part
  if(/^\{0,}$/i.test( value )) 
      return true;
}, 'Please enter a Valid Email Address.');

$.validator.addMethod("fullnamechk", function(value, element) {
  // allow any non-whitespace characters as the host part
  if(/^[\A-Za-z\s]*$/i.test( value )) 
      return true;
}, 'Please enter a Valid Email Address.');

$.validator.addMethod("namechkw", function(value, element) {
	  // allow any non-whitespace characters as the host part
	  if(/^[\D]{0,}$/i.test( value )) 
	      return true;
	}, 'Please enter a Valid Email Address.');


    $.validator.addMethod("pwdlenchk", function(value, element) {
	if(value.length>=6) {
  return true;
        }
}, 'Please enter a Valid Mobile Number!');

    $.validator.addMethod("pwdlenchku", function(value, element) {
	if(value.length>=6 || value.length==0) {
  return true;
        }
}, 'Please enter a Valid Mobile Number!');
$.validator.addMethod("altlenchk", function(value, element) {
	if(value.length==10 || value.length==0) {
  return true;
        }
        else
           return false;
}, 'Please enter a Valid Alternate Mobile Number');

$.validator.addMethod("dobchk", function(value, element) {
  // allow any non-whitespace characters as the host part
	var limitDate = new Date("1949-01-01");
        value=value.split("-");
        value=value[2]+"-"+value[1]+"-"+value[0];
	var inputDate = new Date(value);
// Get today's date
var todaysDate = new Date();
// call setHours to take the time out of the comparison
	if(inputDate.setHours(0,0,0,0) <= limitDate.setHours(0,0,0,0)  ||  inputDate.setHours(0,0,0,0) >= todaysDate.setHours(0,0,0,0)) {
          return false;
        }
        else {
            return true;
        }
}, 'Date of birth cannot be of present or future.');

$.validator.addMethod("cntclenchku", function(value, element) {
	if(value.length==10 || value.length==0) {
  return true;
        }
}, 'Please enter a Valid Mobile Number!');

$.validator.addMethod("chkcaptcha", function(value, element) {
	var ret=true;
  // allow any non-whitespace characters as the host part
      var data="captcha_code="+value;
      console.log("data-"+data+"-");

      ret=function() {
          var tmp=null;
			$.ajax({
			async: false,
			type : 'POST',
			url  : '<?php echo Crm::root()."chkcaptcha.php"; ?>',
			data : data,
			success : function(response) {
                             console.log("response-"+response+"-");
                             if(response.search("true")>-1)
                                tmp=true;
                             else
                                tmp=false;
                    		}
  					});
				return tmp;
            }();
// 		console.log("return "+ret);
	 return ret;
}, 'Please enter a Valid CAPTCHA.');

$.validator.addMethod("dobemailcustchk", function(value, element) {
	var ret=true;
  // allow any non-whitespace characters as the host part
 if($("#dob").val().length>0 && $("#cntc").val().length==10 && $("#email1").val().length>0) {
      var dob=$("#dob").val();
      var cntc=$("#cntc").val();
      var email=$("#email1").val();
      var data="dob="+dob+"&cntc="+cntc+"&email1="+email;
//      console.log("data "+data);

      ret=function() {
          var tmp=null;
			$.ajax({
			async: false,
			type : 'POST',
			url  : 'register-validation.php',
			data : data,
			success : function(response) {
//                             console.log("response-"+response+"-");
                             if(response.search("true")>-1)
                                tmp=true;
                             else
                                tmp=false;
                    		}
  					});
				return tmp;
            }();
	 } 
// 		console.log("return "+ret);
	 return ret;
}, 'Please enter a Valid Email Address.');

$.validator.addMethod("dobemailcustchkv", function(value, element) {
	var ret=true;
  // allow any non-whitespace characters as the host part
 if($("#dob").val().length>0 && $("#cntc").val().length==10 && $("#email1").val().length>0) {
      var dob=$("#dob").val();
      var cntc=$("#cntc").val();
      var email=$("#email1").val();
      var data="dob="+dob+"&cntc="+cntc+"&email1="+email;
//      console.log("data "+data);

      ret=function() {
          var tmp=null;
			$.ajax({
			async: false,
			type : 'POST',
			url  : 'vend-register-validation.php',
			data : data,
			success : function(response) {
//                             console.log("response-"+response+"-");
                             if(response.search("true")>-1)
                                tmp=true;
                             else
                                tmp=false;
                    		}
  					});
				return tmp;
            }();

	 }
 
// 		console.log("return "+ret);
	 return ret;
}, 'Please enter a Valid Email Address.');

        </script>
            <script>

        
        $('document').ready(function() { 
     /* validation */

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
				$("#submit-register").html(preloader());
			},
			success :  function(response) {
//                            console.log("resp-"+response+"-");
					if(response.search("ok ")>-1){
                                                $("#submit-register").prop('disabled', true);
//                                            window.location.href="verify-cntc.php";
//                                                alert('Registration Successful!');
//						setTimeout(' window.location.href = "./Login"; ',2000);
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Now verify your contact Number to Complete the registration!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"VerifyMobileNumber";
                });
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
				$("#submit-vendor-register").html(preloader());
			},
			success :  function(response) {
                            console.log("resp-"+response+"-");
					if(response.search("ok ")>-1){
                                                $("#submit-vendor-register").prop('disabled', true);
//                                                Materialize.toast('Registration Successful!\nWe would contact you soon for further Process', 4000);
//                                                alert('Registration Successful!\nWe would contact you soon for further Process');
//						setTimeout(' window.location.href = "how-it-works-vendor.php"; ',4000);
//                                            window.location.href="verify-cntc.php";
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Now verify your Mobile Number to complete registration!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"VerifyMobileNumber";
                });
					}
					else{
                            console.log("error response-"+response+"-");
                                            
                                $("#submit-vendor-register").prop('disabled', false);
                                $("#submit-vendor-register").html('Submit<i class="material-icons right">send</i>');
					}
			  }
			});
				return false;
		}
	   /* login submit */
           
     
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

	   /* login submit */
	   function submitVendorSubscriptionForm() {		
			var data = $("#vend-subsc").serialize();
                      console.log("data "+data);
			$.ajax({
				
			type : 'POST',
			url  : 'vendor-subs-insert1.php',
			data : data,
			beforeSend: function() {
                              $("#submit-vendor-Subscription").prop('disabled', true);
				$("#submit-vendor-Subscription").html(preloader());
			},
			success :  function(response) {
                          console.log("resp-"+response+"-");
					if(response.search("ok ")>-1){
                                              $("#submit-vendor-Subscription").prop('disabled', true);
//                                              Materialize.toast('Registration Successful!\nWe would contact you soon for further Process', 8000);
                                             // alert('Application Received!\nWe would contact you soon for further Process');
//						setTimeout(' window.location.href = "cart-vend.php"; ',2000);
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Added category!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"VendorSubscriptions";
                });
					}
					if(response.search("more ")>-1){
                                              $("#submit-vendor-Subscription").prop('disabled', true);
//                                              Materialize.toast('Registration Successful!\nWe would contact you soon for further Process', 8000);
                                              //alert('Application Received!\nWe would contact you soon for further Process');
//						setTimeout(' window.location.href = "vendor-subs-insert.php"; ',2000);
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Added Category!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"NewSubscription";
                });
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
				$("#submit-cust-update").html(preloader());
			},
			success :  function(response) {
//                            console.log("resp-"+response+"-");
					if(response.search("ok")>-1){
                                                $("#submit-cust-update").prop('disabled', true);
//                                                alert('Update Successful!');
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Update Successful!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href="CustomerProfile";
                });
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
				$("#submit-vend-update").html(preloader());
			},
			success :  function(response) {
//                            console.log("resp-"+response+"-");
					if(response.search("ok")>-1){
                                                $("#submit-vend-update").prop('disabled', true);
//                                                alert('Update Successful!');
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Update Successful!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href="vendor-profile.php";
                });
//						setTimeout(' window.location.href = "vendor-profile.php"; ',2000);
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
				$("#submit-bank").html(preloader());
			},
			success :  function(response) {
//                            console.log("resp-"+response+"-");
					if(response.search("ok")>-1){
                                                $("#submit-bank").prop('disabled', true);
//                                                alert('Update Successful!');
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>Update Successful!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    window.location.href="vendor-profile.php";
                });
//						setTimeout(' window.location.href = "vendor-profile.php"; ',2000);
					}
					else{
//                            console.log("error response-"+response+"-");
//                                                alert(response+'!');
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='center-align'>"+response+"!</p>");
                $("#modal-message").modal("open");
                                $("#submit-bank").prop('disabled', false);
                                $("#submit-bank").html('Submit<i class="material-icons right">send</i>');
					}
			  }
			});
				return false;
		}

$(".product-link").click(function(event){
    event.preventDefault();
var href = $(this).attr("data-message");
//        message = $(this).attr("data-message");
        var data=href.split("Products/");
//        alert("data "+data);
        data="prod="+data[1];
        console.log("data "+data);
        var type="product";
        isAvailable(href,data,type);
//alert("product\n"+href+"\ndata "+data);
        //    myFunc();
//    alert(message);
});
           
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
           
$(".service-link").click(function(event){
    event.preventDefault();
var href = $(this).attr("data-message");
//        message = $(this).attr("data-message");
        var data=href.split("Services/");
//        alert("data "+data);
        data="serv="+data[1];
        console.log("data "+data);
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
});



        </script>






  
</head>
<body>
    <header >
            <div class="navbar-fixed" style="z-index: 1050 !important;">
 <nav class="nav-extended white">
     <div class="nav-wrapper row" style="height: 60px !important; line-height: 60px; margin-bottom: 0px; padding: 0 0 !important;"> 
         <a href="<?php echo Crm::root();?>" class="col col-img l2 s4 m3" style="height: 60px !important"><img class="responsive-img " src="<?php echo Crm::root()."uploads/images/logo.png"; ?>" style="padding-left: 5px; padding-top: 5px; padding-bottom:  2px; margin-bottom: -5px;"></a>
      <a href="#" data-target="mobile-demo" class="sidenav-trigger black-text h-30 right"><i class="material-icons">menu</i></a>
      <ul id="nav-mobile-top" class="hide-on-small-only right">
       <li class="col m4 " style="height:64px !important; padding-right: 5px;">
        <a class="waves-effect waves-light black-text modal-trigger" style="height: 60px !important;" href="#modal-search">
            Search</a></li>
      </ul>
      
      
    </div>
     <div class="nav-wrapper hide-on-small-only row green h-30 darken-3" style="min-height: 30px !important; height: 30px !important; margin-bottom: 0px !important;" >
      <ul id="nav-mobile left" class="left hide-on-small-only h-30" style="min-height: 30px !important; height: 30px !important; margin-bottom: 0px !important; position: absolute !important;" >
        <li><a href="<?php echo Crm::root();?>">Home</a></li>
        
        <?php 
        if(isset($_SESSION["user"])!="" && $_SESSION["user"]!=null && Crm::getUserType($_SESSION["user"])!=2 ) {
        ?>
        <li><a href="<?php
		  if(isset($_SESSION["user"])!="" && $_SESSION["user"]!=null && Crm::getUserType($_SESSION["user"])==11 )
                      echo Crm::root()."AdminDashboard";
                  if(Vendor::countactiveSubscription($_SESSION["user"])>1)
                      echo Crm::root()."VendorDashboard";                  
                  if(Vendor::countactiveSubscription($_SESSION["user"])==1) {
		  
                  if(isset($_SESSION["user"])!="" && $_SESSION["user"]!=null && Crm::getUserType($_SESSION["user"])==1 
                          && isset($_COOKIE['vs_id'])!="" && Crm::getcattypebycatid(Vendor::getcatidbyvsid($_COOKIE["vs_id"]))=="Product")
                      echo Crm::root()."ProductsPage";
            
		  elseif(isset($_SESSION["user"])!="" && $_SESSION["user"]!=null && Crm::getUserType($_SESSION["user"])==1 
                          && isset($_COOKIE['vs_id'])!="" && Crm::getcattypebycatid(Vendor::getcatidbyvsid($_COOKIE["vs_id"]))=="Service")
                      echo Crm::root()."ServicesPage";
                  }
            
            ?>">Dashboard
            </a>
        </li>
        <?php 
        }
        
        if(!isset($_SESSION["user"]) || isset($_SESSION["user"])!="" && $_SESSION["user"]!=null && Crm::getUserType($_SESSION["user"])==2) {
		  ?>
        
<!-- Modal Trigger -->

        <li class="category-tabs"><a class="waves-effect waves-light modal-trigger" id="category-product" href="#modal-category">Products</a></li>
<li class="category-tabs"><a class="waves-effect waves-light modal-trigger" id="category-service" href="#modal-category">Services</a></li>
       <?php
		  }
		  else if(isset($_SESSION["user"]) && $_SESSION["user"]!=null) {
		  $email=$_SESSION["user"];
			if(Crm::getUserType($_SESSION["user"])==11) {
		  ?>
<!-- Dropdown Structure -->
<ul id="dropdown-rate-plan-navbar" class="dropdown-content">
    <li><a href="<?php echo Crm::root()."AdminRateChart"; ?>">View Rate Chart</a></li>
    <li><a href="<?php echo Crm::root()."UpdateRate"; ?>">Update Rate Chart</a></li>
</ul>

<li><a class="dropdown-trigger" href="#!" data-target="dropdown-rate-plan-navbar">Rate Chart<i class="material-icons right h-30">arrow_drop_down</i></a></li>


<ul id="dropdown-new-request" class="dropdown-content">
    <?php
        require 'admin-notification.php';
        
    ?>
</ul>

<li><a class="dropdown-trigger" href="#!" data-target="dropdown-new-request">New Requests<i class="material-icons right h-30">arrow_drop_down</i></a></li>

                <li><a href="<?php echo Crm::root()."Vendors"; ?>">Vendors</a></li>
                <li><a href="<?php echo Crm::root()."Customers"; ?>">Customers</a></li>
                <li><a href="<?php echo Crm::root()."Categories"; ?>">Categories</a></li>   
                <li><a href="<?php echo Crm::root()."Refunds"; ?>">Refunds
                    <?php
                    if($ref>0)
                        echo "($ref)";
                    ?>
                    </a></li>   
                <li><a href="<?php echo Crm::root()."Reports"; ?>">Reports</a></li>   
       <?php
                        }
			if(Crm::getUserType($_SESSION["user"])==1) {
		  if(isset($_SESSION["user"])!="" && $_SESSION["user"]!=null && Crm::getUserType($_SESSION["user"])==1 && isset($_COOKIE["vs_id"])>0 ) {
                            $b=Crm::getcattypebycatid(Vendor::getcatidbyvsid($_COOKIE["vs_id"]));

                      ?>
<!-- Dropdown Structure -->
<ul id="dropdown-prod-serv-navbar" class="dropdown-content">
<?php
                          if( isset($_COOKIE['vs_id'])!="" && $b=="Product") {
		  ?>
    <li><a href="<?php echo Crm::root()."ProductsPage"; ?>">My Products</a></li>
    <li><a href="<?php echo Crm::root()."AddProduct"; ?>">Add Product</a></li>
    <li><a href="<?php echo Crm::root()."UpdateProduct"; ?>">Update Product</a></li>
    
<?php 
                          }
		  elseif(isset($_COOKIE['vs_id'])!="" && $b=="Service") {
		  ?>
    <li><a href="<?php echo Crm::root()."ServicesPage"; ?>">My Services</a></li>
    <li><a href="<?php echo Crm::root()."AddService"; ?>">Add Service</a></li>
    <li><a href="<?php echo Crm::root()."UpdateService"; ?>">Update Service</a></li>

    <?php
                  }
      if(Campaign::getcountcampbyuname($_SESSION["user"])>0) {
      ?>
  <li><a href="<?php echo Crm::root()."MyOffers"; ?>">My Offers</a></li>
  <?php 
      }
  ?>
  <li><a href="<?php echo Crm::root()."AddOffer"; ?>">Add New Offer</a></li>
  <?php 

  if(Campaign::getcountcampbyuname($_SESSION["user"])>0 && isset($_COOKIE["vs_id"])!="" && !empty($_COOKIE["vs_id"])) {
      
              if($b == 'Product'){
  ?>
  <li><a class="waves-effect waves-light modal-trigger" href="#modal-camp-prod-insert">Link Products to Offer</a></li>
  <?php
              }
              else{
  ?>
  <li><a class="waves-effect waves-light modal-trigger" href="#modal-camp-serv-insert">Link Services to Offer</a></li>
  <?php
              }
  ?>
  <li><a href="<?php echo Crm::root()."UpdateOffer"; ?>">Update Offer</a></li>
  <?php 
  }
  ?>

</ul>
<li><a class="dropdown-trigger" href="#!" data-target="dropdown-prod-serv-navbar"><?php echo $b; ?><i class="material-icons right h-30">arrow_drop_down</i></a></li>
                        <?php
                  }

if(isset($_SESSION["user"])!="" && Crm::getUserType($_SESSION["user"])==1 ) {
    ?>
<!-- Dropdown Structure -->
<ul id="dropdown-subsc-navbar" class="dropdown-content">
                <li><a href="<?php echo Crm::root()."RateChart"; ?>">Rate Chart</a></li>
  <li><a href="<?php echo Crm::root()."NewSubscription"; ?>">New Subscription</a></li>
<!-- Dropdown Structure ->
<ul id="dropdown-subsc-navbar" class="dropdown-content">
  <!--li><a href="vendor-subs.php">Existing Subscription</a></li-->
<?php
if(isset($_SESSION["user"])!="" && Crm::getUserType($_SESSION["user"])==1 && isset($_COOKIE["vs_id"])>0 && Vendor::getVendorCountCart(Crm::getuidbyuname($_SESSION["user"]))>0) {
    ?>
  <li><a href="<?php echo Crm::root()."VendorSubscriptions"; ?>">Checkout!</a></li>
<?php
}

?>
</ul>
<li><a class="dropdown-trigger" href="#!" data-target="dropdown-subsc-navbar">Subscriptions<i class="material-icons right h-30">arrow_drop_down</i></a></li>

<?php
if(isset($_COOKIE["vs_id"])>0 && isset($_SESSION["user"])!="" && $_SESSION["user"]!=null && Crm::getUserType($_SESSION["user"])==1 
    && Crm::getcattypebycatid(Vendor::getcatidbyvsid($_COOKIE["vs_id"]))=="Product") {
    ?>
<ul id="dropdown-ua-navbar" class="dropdown-content">
                <li><a href="<?php echo Crm::root()."OrderFullChart"; ?>">View Order Full Chart</a></li>
                <li><a href="<?php echo Crm::root()."OrderFull"; ?>">Set Order Full</a></li>
                <li><a class="waves-effect waves-light modal-trigger" href="#modal-go-offline">
                            <?php
        $is_offline=Vendor::checkOfflinePeriod($_COOKIE["vs_id"]);
        if($is_offline==0)
            echo "Set Vendor Unavailable";
        elseif($is_offline==1)
            echo "You are Offline";
        ?>
</a></li>
</ul>

<li><a class="dropdown-trigger" href="#!" data-target="dropdown-ua-navbar">Set Unavailability<i class="material-icons right h-30">arrow_drop_down</i></a></li>

  <!--li><a href="vendor-subs-insert.php">New Subscription</a></li>
</ul>
<li><a class="dropdown-trigger" href="#!" data-target="dropdown-subsc-navbar">Subscription<i class="material-icons right h-30">arrow_drop_down</i></a></li-->
 
       <?php
                            }
                        }
                        }
                  }
		  if(!isset($_SESSION["user"]) || isset($_SESSION["user"])==""
                          || (isset($_SESSION["user"])!="" && ( Crm::getUserType($_SESSION["user"])!=11
                                  && (Crm::getUserType($_SESSION["user"])!=1 && isset($_COOKIE["vs_id"])!="")
                                  || (Crm::getUserType($_SESSION["user"])==2 && isset($_COOKIE["cust"])!="")
                                  ||  (Crm::getUserType($_SESSION["user"])==1 && !isset($_COOKIE["vs_id"])) )  ) ) {
                        ?>
        <li><a href="<?php echo Crm::root()."About"; ?>">About Us</a></li>
        <li><a href="<?php echo Crm::root()."Contact"; ?>">Contact Us</a></li>
        <?php
                  }
        ?>
      </ul>
      <ul id="nav-mobile-right" class="right hide-on-small-only h-30" style="min-height: 30px !important; height: 30px !important; margin-bottom: 0px !important;" >
       <?php
		  if(!isset($_SESSION["user"]) ) {
		  ?>
<!-- Dropdown Structure -->
<ul id="dropdown-city-navbar" class="dropdown-content">
<?php
    while ($cities= mysqli_fetch_array($res_cities)) {
        if($_COOKIE['city']!=$cities[0]) { ?>
    <li><a class="city" id="<?php echo $cities[0]; ?>" href="#"><?php echo $cities[0]; ?></a></li>
<?php
                                        }
                                    }
            ?>
</ul>
<li><a class="dropdown-trigger"  href="#!" data-target="dropdown-city-navbar"><span><?php echo $_COOKIE["city"]."<i class=\"material-icons right h-30\">arrow_drop_down</i>";?></span></a></li>

    <li><a href="<?php echo Crm::root()."Login"; ?>"><i class="material-icons left h-30">person</i>Login / Register</a></li>

          
        <?php
            }
		  else if(isset($_SESSION["user"]) && $_SESSION["user"]!=null) {
		  $email=$_SESSION["user"];
			if(Crm::getUserType($_SESSION["user"])==2) {
                            $wallet_amt=Crm::getWalletAmt(Crm::getuidbyuname($_SESSION["user"]));
                            if($wallet_amt>0) {
		  ?>
<li><?php echo "Wallet &#8377; $wallet_amt/-"; ?></li>
        <?php
			}
		  ?>
<li><a href="<?php echo Crm::root()."Cart"; ?>" class="cartcount"></a></li>
        <?php
			}
		  ?>

                <!-- Dropdown Structure -->
<ul id="dropdown-profile-navbar" class="dropdown-content">
    <li><a href="<?php
			if(Crm::getUserType($_SESSION["user"])==11)
				echo Crm::root()."AdminDashboard";
			if(Crm::getUserType($_SESSION["user"])==1)
				echo Crm::root()."VendorProfile";
			if(Crm::getUserType($_SESSION["user"])==2)
				echo Crm::root()."CustomerProfile";
			?>"><span class="glyphicon glyphicon-user"></span> <?php
			if(Crm::getUserType($_SESSION["user"])==1 || Crm::getUserType($_SESSION["user"])==2)
			echo "My Account";
			 elseif(Crm::getUserType($_SESSION["user"])==11)
				 echo "Dashboard";
			?>
        </a>
    </li>
    <?php 
			if(Crm::getUserType($_SESSION["user"])!=2) {
                            ?>

    <li><a href="<?php echo Crm::root()."ChangePassword/".$_SESSION['user'] ; ?>"><span class="glyphicon glyphicon-log-out"></span> Change Password </a></li>
    <?php }
    ?>
    <li><a href="<?php echo Crm::root()."Logout"; ?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
</ul>
<li><a class="dropdown-trigger" href="#!" data-target="dropdown-profile-navbar"><i class="material-icons left h-30">person</i>
        <?php
			if(Crm::getUserType($_SESSION["user"])==11)
			  echo "Administrator";
			if(Crm::getUserType($_SESSION["user"])==1)
			  echo Vendor::getvendnamebyuname($email);
			if(Crm::getUserType($_SESSION["user"])==2)
			  echo Customer::getcustnamebyuname($email);
			if(Crm::getUserType($_SESSION["user"])==3)
			  echo "Tago";
			?>
        <i class="material-icons right h-30">arrow_drop_down</i></a>
</li>
        
       <?php
   }
?>
      </ul>
      
      
      
                

      
      
    </div>
  </nav>
            </div>
        </header>

    
    
    
    
    
    
    
    
    
    
    
    
    
<ul class="sidenav" id="mobile-demo" style="z-index: 1052 !important;" >

        <li><a href="<?php echo Crm::root();?>">Home</a></li>
        
        <?php 
        if(isset($_SESSION["user"])!="" && $_SESSION["user"]!=null && Crm::getUserType($_SESSION["user"])!=2 ) {
        ?>
        <li><a href="<?php
		  if(isset($_SESSION["user"])!="" && $_SESSION["user"]!=null && Crm::getUserType($_SESSION["user"])==11 )
                      echo Crm::root()."AdminDashboard";
                  if(Vendor::countactiveSubscription($_SESSION["user"])>1)
                      echo Crm::root()."VendorDashboard";                  
                  if(Vendor::countactiveSubscription($_SESSION["user"])==1) {
		  
                  if(isset($_SESSION["user"])!="" && $_SESSION["user"]!=null && Crm::getUserType($_SESSION["user"])==1 
                          && isset($_COOKIE['vs_id'])!="" && Crm::getcattypebycatid(Vendor::getcatidbyvsid($_COOKIE["vs_id"]))=="Product")
                      echo Crm::root()."ProductsPage";
            
		  elseif(isset($_SESSION["user"])!="" && $_SESSION["user"]!=null && Crm::getUserType($_SESSION["user"])==1 
                          && isset($_COOKIE['vs_id'])!="" && Crm::getcattypebycatid(Vendor::getcatidbyvsid($_COOKIE["vs_id"]))=="Service")
                      echo Crm::root()."ServicesPage";
                  }
            
            ?>">Dashboard
            </a>
        </li>
        <?php 
        }
        
        if(!isset($_SESSION["user"]) || isset($_SESSION["user"])!="" && $_SESSION["user"]!=null && Crm::getUserType($_SESSION["user"])==2) {
		  ?>
        
<!-- Dropdown Structure -->
<ul id="dropdown-product-navbar-mob" class="dropdown-content">
    <?php
       mysqli_data_seek($main_cat,0);
while($row = mysqli_fetch_array($main_cat)) {
?>
              <li><a href="<?php echo Crm::root()."Products/".$row[0]; ?>"><b style="color: blue"><?php echo $row[0]; ?></b></a></li>
              <?php
}
?>
</ul>
<li><a class="dropdown-trigger" href="#!" data-target="dropdown-product-navbar-mob">Products<i class="material-icons right h-30">arrow_drop_down</i></a></li>

        
<!-- Dropdown Structure -->
<ul id="dropdown-service-navbar-mob" class="dropdown-content">
    <?php
       mysqli_data_seek($serv_cat,0);
while($row = mysqli_fetch_array($serv_cat)) {
?>
              <li><a href="<?php echo Crm::root()."Services/".$row[0]; ?>"><b style="color: blue"><?php echo $row[0]; ?></b></a></li>
              <?php
}
?>
</ul>
<li><a class="dropdown-trigger" href="#!" data-target="dropdown-service-navbar-mob">Services<i class="material-icons right h-30">arrow_drop_down</i></a></li>
       <?php
		  }
		  else if(isset($_SESSION["user"]) && $_SESSION["user"]!=null) {
		  $email=$_SESSION["user"];
			if(Crm::getUserType($_SESSION["user"])==11) {
		  ?>
<!-- Dropdown Structure -->
<ul id="dropdown-rate-plan-navbar-mob" class="dropdown-content">
    <li><a href="<?php echo Crm::root()."AdminRateChart"; ?>">View Rate Chart</a></li>
    <li><a href="<?php echo Crm::root()."UpdateRate"; ?>">Update Rate Chart</a></li>
</ul>

<li><a class="dropdown-trigger" href="#!" data-target="dropdown-rate-plan-navbar-mob">Rate Chart<i class="material-icons right h-30">arrow_drop_down</i></a></li>


<ul id="dropdown-new-request-mob" class="dropdown-content">
    <?php
        require 'admin-notification.php';
        
    ?>
</ul>

<li><a class="dropdown-trigger" href="#!" data-target="dropdown-new-request-mob">New Requests<i class="material-icons right h-30">arrow_drop_down</i></a></li>

                <li><a href="<?php echo Crm::root()."Vendors"; ?>">Vendors</a></li>
                <li><a href="<?php echo Crm::root()."Customers"; ?>">Customers</a></li>
                <li><a href="<?php echo Crm::root()."Categories"; ?>">Categories</a></li>   
                <li><a href="<?php echo Crm::root()."Refunds"; ?>">Refunds
                    <?php 
                    if($ref>0)
                        echo "(".$ref.")";
                    ?>
                    </a></li>   
                <li><a href="<?php echo Crm::root()."Reports"; ?>">Reports</a></li>   
       <?php
                        }

			if(Crm::getUserType($_SESSION["user"])==1) {
		  if(isset($_SESSION["user"])!="" && $_SESSION["user"]!=null && Crm::getUserType($_SESSION["user"])==1 && isset($_COOKIE["vs_id"])>0 ) {
                            $b=Crm::getcattypebycatid(Vendor::getcatidbyvsid($_COOKIE["vs_id"]));

                      ?>
<!-- Dropdown Structure -->
<ul id="dropdown-prod-serv-navbar-mob" class="dropdown-content">
<?php
                          if( isset($_COOKIE['vs_id'])!="" && $b=="Product") {
		  ?>
    <li><a href="<?php echo Crm::root()."ProductsPage"; ?>">My Products</a></li>
    <li><a href="<?php echo Crm::root()."AddProduct"; ?>">Add Product</a></li>
    <li><a href="<?php echo Crm::root()."UpdateProduct"; ?>">Update Product</a></li>
    
<?php 
                          }
		  elseif(isset($_COOKIE['vs_id'])!="" && $b=="Service") {
		  ?>
    <li><a href="<?php echo Crm::root()."ServicesPage"; ?>">My Services</a></li>
    <li><a href="<?php echo Crm::root()."AddService"; ?>">Add Service</a></li>
    <li><a href="<?php echo Crm::root()."UpdateService"; ?>">Update Service</a></li>

    <?php
                  }
      if(Campaign::getcountcampbyuname($_SESSION["user"])>0) {
      ?>
  <li><a href="<?php echo Crm::root()."MyOffers"; ?>">My Offers</a></li>
  <?php 
      }
  ?>
  <li><a href="<?php echo Crm::root()."AddOffer"; ?>">Add New Offer</a></li>
  <?php 

  if(Campaign::getcountcampbyuname($_SESSION["user"])>0 && isset($_COOKIE["vs_id"])!="" && !empty($_COOKIE["vs_id"])) {
      
              if($b == 'Product'){
  ?>
  <li><a class="waves-effect waves-light modal-trigger" href="#modal-camp-prod-insert">Link Products to Offer</a></li>
  <?php
              }
              else{
  ?>
  <li><a class="waves-effect waves-light modal-trigger" href="#modal-camp-serv-insert">Link Services to Offer</a></li>
  <?php
              }
  ?>
  <li><a href="<?php echo Crm::root()."UpdateOffer"; ?>">Update Offer</a></li>
  <?php 
  }
  ?>

</ul>
<li><a class="dropdown-trigger" href="#!" data-target="dropdown-prod-serv-navbar-mob"><?php echo $b; ?><i class="material-icons right h-30">arrow_drop_down</i></a></li>
                        <?php
                  }

if(isset($_SESSION["user"])!="" && Crm::getUserType($_SESSION["user"])==1 ) {
    ?>
<!-- Dropdown Structure -->
<ul id="dropdown-subsc-navbar-mob" class="dropdown-content">
                <li><a href="<?php echo Crm::root()."RateChart"; ?>">Rate Chart</a></li>
  <li><a href="<?php echo Crm::root()."NewSubscription"; ?>">New Subscription</a></li>
<!-- Dropdown Structure ->
<ul id="dropdown-subsc-navbar" class="dropdown-content">
  <!--li><a href="vendor-subs.php">Existing Subscription</a></li-->
<?php
if(isset($_SESSION["user"])!="" && Crm::getUserType($_SESSION["user"])==1 && isset($_COOKIE["vs_id"])>0 && Vendor::getVendorCountCart(Crm::getuidbyuname($_SESSION["user"]))>0) {
    ?>
  <li><a href="<?php echo Crm::root()."VendorSubscriptions"; ?>">Checkout!</a></li>
<?php
}

?>
</ul>
<li><a class="dropdown-trigger" href="#!" data-target="dropdown-subsc-navbar-mob">Subscriptions<i class="material-icons right h-30">arrow_drop_down</i></a></li>

<?php
if(isset($_COOKIE["vs_id"])>0) {
    ?>
<ul id="dropdown-ua-navbar-mob" class="dropdown-content">
                <li><a href="<?php echo Crm::root()."OrderFullChart"; ?>">View Order Full Chart</a></li>
                <li><a href="<?php echo Crm::root()."OrderFull"; ?>">Set Order Full</a></li>
                <li><a class="waves-effect waves-light modal-trigger" href="#modal-go-offline">
                            <?php
        $is_offline=Vendor::checkOfflinePeriod($_COOKIE["vs_id"]);
        if($is_offline==0)
            echo "Set Vendor Unavailable";
        elseif($is_offline==1)
            echo "You are Offline";
        ?>
</a></li>
</ul>

<li><a class="dropdown-trigger" href="#!" data-target="dropdown-ua-navbar-mob">Set Unavailability<i class="material-icons right h-30">arrow_drop_down</i></a></li>

  <!--li><a href="vendor-subs-insert.php">New Subscription</a></li>
</ul>
<li><a class="dropdown-trigger" href="#!" data-target="dropdown-subsc-navbar">Subscription<i class="material-icons right h-30">arrow_drop_down</i></a></li-->
 
       <?php
                            }
                        }
                        }
                  }
		  if(!isset($_SESSION["user"]) || isset($_SESSION["user"])==""
                          || (isset($_SESSION["user"])!="" && ( Crm::getUserType($_SESSION["user"])!=11
                                  && (Crm::getUserType($_SESSION["user"])!=1 && isset($_COOKIE["vs_id"])!="")
                                  || (Crm::getUserType($_SESSION["user"])==2 && isset($_COOKIE["cust"])!="")
                                  ||  (Crm::getUserType($_SESSION["user"])==1 && !isset($_COOKIE["vs_id"])) )  ) ) {
                        ?>
        <li><a href="<?php echo Crm::root()."About"; ?>">About Us</a></li>
        <li><a href="<?php echo Crm::root()."Contact"; ?>">Contact Us</a></li>
        <?php
                  }


                  		  if(!isset($_SESSION["user"]) ) {
		  ?>
<!-- Dropdown Structure -->
<ul id="dropdown-city-navbar-mob" class="dropdown-content">
<?php
    while ($cities= mysqli_fetch_array($res_cities)) {
        if($_COOKIE['city']!=$cities[0]) { ?>
    <li><a class="city" id="<?php echo $cities[0]; ?>" href="#"><?php echo $cities[0]; ?></a></li>
<?php
                                        }
                                    }
            ?>
</ul>
<li><a class="dropdown-trigger"  href="#!" data-target="dropdown-city-navbar-mob"><span><?php echo $_COOKIE["city"]."<i class=\"material-icons right h-30\">arrow_drop_down</i>";?></span></a></li>

<!-- Dropdown Structure -->
<ul id="dropdown-login-navbar-mob" class="dropdown-content">
    <li><a href="<?php echo Crm::root()."Login"; ?>">Login</a></li>
    <li class="divider"></li>
    <li><a href="<?php echo Crm::root()."CustomerRegistration"; ?>">Customer Registration</a></li>
    <li><a href="<?php echo Crm::root()."VendorRegistration"; ?>">Vendor Registration</a></li>
</ul>
    <li><a href="<?php echo Crm::root()."Login"; ?>"><i class="material-icons left h-30">person</i>Login / Register</a></li>

          
        <?php
            }
		  else if(isset($_SESSION["user"]) && $_SESSION["user"]!=null) {
		  $email=$_SESSION["user"];
			if(Crm::getUserType($_SESSION["user"])==2) {
                            $wallet_amt=Crm::getWalletAmt(Crm::getuidbyuname($_SESSION["user"]));
                            if($wallet_amt>0) {
		  ?>
<li><a href="#!" ><?php echo "Wallet &#8377; $wallet_amt/-"; ?></a></li>
        <?php
			}
		  ?>
<li><a href="<?php echo Crm::root()."Cart"; ?>" class="cartcount"></a></li>
        <?php
			}
		  ?>

                <!-- Dropdown Structure -->
<ul id="dropdown-profile-navbar-mob" class="dropdown-content">
    <li><a href="<?php
			if(Crm::getUserType($_SESSION["user"])==11)
				echo Crm::root()."AdminDashboard";
			if(Crm::getUserType($_SESSION["user"])==1)
				echo Crm::root()."VendorProfile";
			if(Crm::getUserType($_SESSION["user"])==2)
				echo Crm::root()."CustomerProfile";
			?>"><span class="glyphicon glyphicon-user"></span> <?php
			if(Crm::getUserType($_SESSION["user"])==1 || Crm::getUserType($_SESSION["user"])==2)
			echo "My Account";
			 elseif(Crm::getUserType($_SESSION["user"])==11)
				 echo "Dashboard";
			?>
        </a>
    </li>
    <?php 
			if(Crm::getUserType($_SESSION["user"])!=2) {
                            ?>

    <li><a href="<?php echo Crm::root()."ChangePassword/".$_SESSION['user'] ; ?>"><span class="glyphicon glyphicon-log-out"></span> Change Password </a></li>
    <?php }
    ?>
    <li><a href="<?php echo Crm::root()."Logout"; ?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
</ul>
<li><a class="dropdown-trigger" href="#!" data-target="dropdown-profile-navbar-mob"><i class="material-icons left h-30">person</i>
        <?php
			if(Crm::getUserType($_SESSION["user"])==11)
			  echo "Administrator";
			if(Crm::getUserType($_SESSION["user"])==1)
			  echo Vendor::getvendnamebyuname($email);
			if(Crm::getUserType($_SESSION["user"])==2)
			  echo Customer::getcustnamebyuname($email);
			?>
        <i class="material-icons right h-30">arrow_drop_down</i></a>
</li>
        
       <?php
   }
?>

        
      </ul>
      

      <!-- Modal Structure -->
      <div id="modal-category" class="modalCategory modal" style="top: 10% !important;" >
    <div class="modal-content" style="position: relative !important; top:0 !important; left:0;">
<?php require_once 'category-product.php';?>
<?php require_once 'category-service.php';?>
    </div>
  </div>

	<!-- Modal Structure -->
    <div id="modal-search" class="modal modal-fixed-footer">
    <div class="modal-content">
<?php require_once 'search-form.php';?>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">close</a>
    </div>
  </div>
          

	<!-- Modal Structure -->
    <div id="modal-disable-vendor" class="modal bottom-sheet">
    <div class="modal-content">

    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">close</a>
    </div>
  </div>
          
	<!-- Modal Structure -->
    <div id="modal-disable-customer" class="modal bottom-sheet">
    <div class="modal-content">

    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">close</a>
    </div>
  </div>
          
	<!-- Modal Structure -->
    <div id="modal-camp-prod-insert" class="modal bottom-sheet">
    <div class="modal-content">
<?php
if(isset($_SESSION["user"])!="" && Campaign::getcountcampbyuname($_SESSION["user"])>0)
    require_once 'camp-prod-insert0.php'; ?>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">close</a>
    </div>
  </div>
    <div id="modal-camp-serv-insert" class="modal bottom-sheet">
    <div class="modal-content">
<?php
if(isset($_SESSION["user"])!="" && Campaign::getcountcampbyuname($_SESSION["user"])>0)
    require_once 'camp-serv-insert0.php'; ?>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">close</a>
    </div>
  </div>
          
	<!-- Modal Structure -->
    <div id="modal-service-brochure" class="modal modal-fixed-footer" >
    <div class="modal-content" style="height: 100% !important;">
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">close</a>
    </div>
  </div>

    <!-- Modal Structure -->
    <div id="modal-message" class="modal modal-message" style="overflow-y: hidden;" >
        <div class="modal-content" style="margin: 50px; font-size: 18px; color: black">
        </div>
        <div class="modal-footer" >
            <a href="#!" class="center-align modal-action modal-close waves-effect waves-green red white-text btn-flat chip" style="margin-right: 0px; font-size: 18px; padding: 0 1rem; ">Ok</a>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="modal-ord-cancel" class="modal modal-message" style="overflow-y: hidden;" >
        <div class="modal-content" style="margin: 50px; font-size: 18px; color: black">
        </div>
        <div class="modal-footer" >
            <a href="#!" class="center-align modal-action modal-close waves-effect waves-green red white-text btn-flat chip" style="margin-right: 0px; font-size: 18px; padding: 0 1rem; ">Ok</a>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="modal-go-offline" class="modal bottom-sheet" >
        <div class="modal-content" style="">
            <form action="go-offline.php" id="vend-offline" method="post">
                <div class="row">
                    <div class="col offset-l3 offset-m3 l6 m6 s12">
                <div class="row">
                    <p class="center-align"><em class="center-align">Period of Unavailability</em></p>
                </div>
                <div class="row">
                    <div class="col l6 m6 s12">
            <p class="col m4 l4 s4 right-align">From <font style="color:red">*</font>:</p>
                <div class="col m8 l8 s8 input-field">
            <label for="from">From:</label>
                <input type="text" class="datepicker" autocomplete="off" id="from" name="from" />
                </div>
                </div>

                    <div class="col l6 m6 s12">
            <p class="col m4 l4 s4 right-align">To <font style="color:red">*</font>:</p>
                <div class="col m8 l8 s8 input-field">
            <label for="to">To:</label>
                <input type="text" class="datepicker" autocomplete="off" id="to" name="to" />
                </div>
                </div>
                            
                    </div>
                       
        <div class="row">
            <div class="col offset-m4 m4 center-align s12 submit-btn" >
                <button  type="submit" class="btn waves-effect waves-light" >Set
                <i class="material-icons right">send</i>
                </button>
            </div>
        </div>

                            
                    </div>
                </div>

            </form>
        </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">close</a>
    </div>

    </div>

    <!-- Modal Structure -->
    <div id="modal-set-order-full" class="modal bottom-sheet" >
        <div class="modal-content" style="">
            <form action="go-offline.php" id="vend-offline-ord" method="post">
                <div class="row">
                    <div class="col offset-l3 offset-m3 l6 m6 s12">
                <div class="row">
                    <p class="center-align"><em class="center-align">Order Full Date</em></p>
                </div>
                <div class="row">
                    <div class="col l6 m6 s12 offset-l3 offset-m3">
            <p class="right-align">Order Full Date <font style="color:red">*</font>:</p>
                <div class="input-field">
            <label for="from">Order Full Date:</label>
                <input type="text" class="datepicker" autocomplete="off" id="ofdate" name="ofdate" />
                </div>
                </div>
                    </div>
                       
        <div class="row">
            <div class="col offset-m4 m4 center-align s12 submit-btn" >
                <button  type="submit" class="btn waves-effect waves-light" >Set
                <i class="material-icons right">send</i>
                </button>
            </div>
        </div>

                            
                    </div>
                </div>

            </form>
        </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">close</a>
    </div>

    </div>


</body>
</html>
