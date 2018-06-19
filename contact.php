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
    <div class="container-fluid" style="margin-top: 40px; min-height: 75vh;">
<div id="gototop"> </div>
<div class="row">
<div class="col-md-10 col-lg-10 offset-md-1">
    <div class="card">
    <div class="row">
<div class="col-md-4 offset-md-1">

    <h5 style="font-size: 16px; margin-bottom: 10px; "><b> Contact Us </b></h5>
    <div class="row mb-3">
        <div class="col-md-2 col-sm-2 col-lg-1 text-right">
            <strong><i class="material-icons">local_post_office</i></strong>
        </div>
        <div class="col-md-10 col-sm-10 col-lg-11">
            <strong>info@homebiz365.in</strong>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-2 col-sm-2 col-lg-1 text-right">
            <strong><i class="material-icons">phone</i></strong>
        </div>
        <div class="col-md-10 col-sm-10 col-lg-11">
            <strong>9373512915<br>
                9673006100
            </strong>
        </div>
    </div>

    
    
<div class="row mb-3">
    <div class="col-md-8 col-sm-12 col-lg-9">
        <p style="margin-top: 0px;">Sadguru Sadan,<br>
 S.No. 32/1, Plot No.10,<br>
Erandawane, Pune -411004</p>
    </div>
</div>

</div>
		<div class="col-md-4 offset-md-1">
		<form class="form-horizontal" id="mail-form" mehtod="post" action="sendmail.php">
                    <div class="row">
                        <div class="col-md-5">
                            <p><b>Email For: </b></p>
                        </div>
          <div class="form-group col-md-7">
              <select class="form-control" name="type">
                  <option value="Enquiry" selected>Enquiry</option>
                  <option value="Complaint">Complaint</option>
              </select>           
          </div>
                </div>
                    <div class="form-group" style="margin-top: 0rem;">
              <input type="text" placeholder="name" name="name" required class="form-control"/>
          </div>
		   <div class="form-group" style="margin-top: 0rem;">
              <input type="email" placeholder="email" name="emaill" required class="form-control"/>
          </div>
		   <div class="form-group" style="margin-top: 0rem;">
              <input type="text" placeholder="subject" name="sub" required class="form-control"/>
          </div>
          <div class="form-group" style="margin-top: 0rem;">
              <textarea rows="3" id="textarea" name="msg" placeholder="Message" required class="form-control"></textarea>           
          </div>
                    <div class="col-sm-12 form-group">
                    <div class="row">
                        <div class="col-md-5">
                        <img id="captcha" class="img-fluid" src="<?php echo $root."Classes/securimage/securimage_show.php"; ?>" alt="CAPTCHA Image" />
                        </div>
                        <div class="col-md-7 form-group">
                        <input type="text" id="captcha_code" class="form-control" name="captcha_code" size="10" maxlength="6" />
                        <a href="#" onclick="document.getElementById('captcha').src = '<?php echo $root."Classes/securimage/securimage_show.php?"; ?>' + Math.random(); return false"><i class="material-icons">autorenew</i> Different Image</a>
                        </div>
                    </div>
                </div>

            <button class="shopBtn" type="submit">Send Email</button>

      </form>
		</div>
    </div>
    </div>
    </div>
    </div>
<a href="#" class="gotop"><i class="icon-double-angle-up"></i></a>
    </div>


 </section>    
      <section class="footer" style="margin-top: 10px !important; width: auto !important;" ></section>
      
</section>
<?php
require_once 'scripts.html';
?>    <script>

$.validator.addMethod("chkcaptcha", function(value, element) {
	var ret=true;
  // allow any non-whitespace characters as the host part
      var data="captcha_code="+value;
      console.log("data "+data);

      ret=function() {
          var tmp=null;
			$.ajax({
			async: false,
			type : 'POST',
			url  : '<?php echo $root."chkcaptcha.php"; ?>',
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

        $('document').ready(function() { 
 	 $("#mail-form").validate({
      rules: {
					sub: "required",
					msg: "required",
					captcha_code: {
                                            required: true,
                                            chkcaptcha:true
                                        },
					email1: {
                                            required: true,
                                            emaill: true
                                        },
					name: {
                                            required: true,
                                            fullnamechk: true
                                        }
				},
				messages: {
					sub: "Please enter Subject",
					msg: "Please enter Message",
					captcha_code: {
                                           required: "Please enter Captcha Code!",
                                           remote: "Please enter valid Captcha Code!"
                                        },
					email1: {
                                           required: "Please enter Email Address",
                                           email: "Please enter a Valid Email Address",
                                           dobemailcustchk: "The email id and Contact No. are already in use!"
                                        },
					name: {
                                           required: "Please enter Name",
                                           fullnamechk: "Please enter Alphabets only"
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
    });

    </script>
    </body>
</html>