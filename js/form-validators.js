jQuery(function($) {'use strict';
                var origin=window.location.origin;
                var api="http://api.homebiz365.in/";

    $.validator.addMethod("greaterThan0", function(value, element) {
  // allow any non-whitespace characters as the host part
  if(value>0 || value.length==0)
      return true;
}, 'Please enter a Valid Email Address.');


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
			url  : origin+"/chkcaptcha.php",
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
			url  : origin+'/register-validation.php',
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
			url  : origin+'/vend-register-validation.php',
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


  $.validator.addMethod("chkleadtime", function(value, element) {
	var ret=true;
 
       var id=$(".btn-add-to-cart").val();
//       var qty_min=$("#qty_min_"+id).text();
//       console.log("qty "+qty_min);
//       qty_min=qty_min.split(" ");
//            console.log("Id in chkcamp "+qty_min);
//             var dt=NULL;
             
//            if($("#reqd_"+id).val().length>0 )
//            dt=$("#reqd_"+id).val();
        console.log("dt "+value);
            var data="type=lead&prod="+id+"&req_dt="+value;
        console.log("data in chkleadtime "+data);
        
      ret=function() {
          var tmp=null;
			$.ajax({
			async: false,
			type : 'POST',
			url  : origin+"/datechk.php",
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
 		console.log("return "+ret);
	 return ret;
}, 'Please enter a Valid Email Address.');

  
  $.validator.addMethod("chkisfull", function(value, element) {
	var ret=true;
 
       var id=$(".btn-add-to-cart").val();
//       var qty_min=$("#qty_min_"+id).text();
//       console.log("qty "+qty_min);
//       qty_min=qty_min.split(" ");
//            console.log("Id in chkcamp "+qty_min);
//             var dt=NULL;
             
//            if($("#reqd_"+id).val().length>0 )
//            dt=$("#reqd_"+id).val();
        console.log("dt "+value);
            var data="type=full&prod="+id+"&req_dt="+value;
        console.log("data in chkisfull "+data);
        
      ret=function() {
          var tmp=null;
			$.ajax({
			async: false,
			type : 'POST',
			url  : origin+"/datechk.php",
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
 		console.log("return "+ret);
	 return ret;
}, 'Please enter a Valid Email Address.');



        $.validator.addMethod("mucatchk", function(value, element) {
        	var ret=true;
          // allow any non-whitespace characters as the host part
         if($("#mucatid").val().length>0 && value.length>0) {
              var mucatid=$("#mucatid").val();
              var data="mucatid="+mucatid+"&mucat="+value;
//              console.log("data "+data);

              ret=function() {
                  var tmp=null;
        			$.ajax({
        			async: false,
        			type : 'POST',
        			url  : 'admin-category-vald.php',
        			data : data,
        			success : function(response) {
//                                     console.log("response-"+response+"-");
                                     if(response.search("true")>-1)
                                        tmp=true;
                                     else
                                        tmp=false;
                            		}
          					});
        				return tmp;
                    }();
        	 }
//         		console.log("return "+ret);
        	 return ret;
        }, 'Please enter a Valid Email Address.');

        $.validator.addMethod("sicatchk", function(value, element) {
        	var ret=true;
          // allow any non-whitespace characters as the host part
         if($("#sicatid").val().length>0 && value.length>0) {
              var sicatid=$("#sicatid").val();
              var data="sicatid="+sicatid+"&sicat="+value;
//              console.log("data "+data);

              ret=function() {
                  var tmp=null;
        			$.ajax({
        			async: false,
        			type : 'POST',
        			url  : 'admin-category-vald.php',
        			data : data,
        			success : function(response) {
//                                     console.log("response-"+response+"-");
                                     if(response.search("true")>-1)
                                        tmp=true;
                                     else
                                        tmp=false;
                            		}
          					});
        				return tmp;
                    }();
        	 }
//         		console.log("return "+ret);
        	 return ret;
        }, 'Please enter a Valid Email Address.');

        $.validator.addMethod("sucatchk", function(value, element) {
        	var ret=true;
          // allow any non-whitespace characters as the host part
         if($("#sucatid").val().length>0 && value.length>0) {
              var sucatid=$("#sucatid").val();
              var data="sucatid="+sucatid+"&sucat="+value;
//              console.log("data "+data);

              ret=function() {
                  var tmp=null;
        			$.ajax({
        			async: false,
        			type : 'POST',
        			url  : 'admin-category-vald.php',
        			data : data,
        			success : function(response) {
//                                     console.log("response-"+response+"-");
                                     if(response.search("true")>-1)
                                        tmp=true;
                                     else
                                        tmp=false;
                            		}
          					});
        				return tmp;
                    }();
        	 }
//         		console.log("return "+ret);
        	 return ret;
        }, 'Please enter a Valid Email Address.');

 

});

