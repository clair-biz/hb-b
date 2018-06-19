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
         <div class="col-md-2  col-lg-2  hide-on-small-and-down">
                    <?php
                    require 'vendor-menu.php'; 
                    ?>
                    </div>
    
<div class="card col-md-10  col-lg-10 col-md-offset-1">
            <div class="row">
                    <h5 class="page-header center-align">Update Offer</h5>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <?php require_once 'campaign-update0.php';?>
            </div>
            <div class="display-list-camp-prod">
            </div>
            <div class="campaign-content">
                
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
    
        $("#camp_id").change(function() {
            var options=$("input[name=options]:checked").val();
          var selected=$(this).val();
          console.log("option "+options);
          $(".display-list-camp-prod").hide();
          $(".campaign-content").hide();

          if(selected!="") {
              switch(options) {
                  case "campaign" :               
			$.ajax({
				
			type : 'POST',
			url  : '<?php echo Crm::root()."campaign-update-form.php"; ?>',
			data : "camp_id="+selected,
			beforeSend: function() {
				$(".campaign-content").html(preloader());
				$(".campaign-content").show();
				
			},
			success :  function(response) {
                            console.log("file"+response);
				$(".campaign-content").html(response);
				$(".campaign-content").show();
                                $('select').formSelect();
  $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 160, // Creates a dropdown of 15 years to control year,
    today: 'Today',
    clear: 'Clear',
    close: 'Ok',
     format: 'dd-mm-yyyy',
     defaultDate:null, //some date
     closeOnSelect: true // Close upon selecting a date,
  });
                            }
                                        
			});
                        break;
                    case "campprodcat" :

        				$(".campaign-content").hide();
                        
                        $.ajax({
				
			type : 'POST',
			url  : '<?php echo Crm::root()."campprodcat-list.php"; ?>',
			data : "camp_id="+selected,
			beforeSend: function() {
				$(".display-list-camp-prod").html(preloader());
		          $(".display-list-camp-prod").show();
			},
			success :  function(response) {
//                            console.log("file"+response);
				$(".display-list-camp-prod").html(response);
                                $('select').formSelect();
                                M.updateTextFields();
                                $(".display-list-camp-prod").show();
                                $(".display-list-camp-prod").ready(function() {
                                    $("#cpm").change(function() {
                                        console.log("cpm change");
                                     var val=$(this).val();
                                     document.cookie="cpm="+val;
                                     val=val.split("-");
                                     var camp=val[0];
                                     var prod=val[1];
                                     var cs_id=val[2];
                                     var data="camp_id="+camp;
                                     if(prod!=0)
                            			data+="&prod="+prod;   
                                     else
                            			data+="&cs_id="+cs_id;   

                                     $.ajax({
                            				
                             			type : 'POST',
                             			url  : '<?php echo Crm::root()."campprodcat-update-form.php"; ?>',
                             			data : data,
                             			beforeSend: function() {
                             				$(".campaign-content").html(preloader());
                            				$(".campaign-content").show();
                             			},
                             			success :  function(response) {
//                                                         console.log("file"+response);
                             				$(".campaign-content").html(response);
                            				$(".campaign-content").show();
                                                             $('select').formSelect();
                                                             M.updateTextFields();
                                                         }
                                                                     
                             			});
                            			
                                    });

                                    });

                            }
                                        
			});
                        break;
                    case "campservcat" :

        				$(".campaign-content").hide();
                        
                        $.ajax({
				
			type : 'POST',
			url  : '<?php echo Crm::root()."campservcat-list.php"; ?>',
			data : "camp_id="+selected,
			beforeSend: function() {
				$(".display-list-camp-prod").html(preloader());
		          $(".display-list-camp-prod").show();
			},
			success :  function(response) {
//                            console.log("file"+response);
				$(".display-list-camp-prod").html(response);
                                $('select').formSelect();
                                M.updateTextFields();
                                $(".display-list-camp-prod").show();
                                $(".display-list-camp-prod").ready(function() {
                                    $("#cpm").change(function() {
                                        console.log("cpm change");
                                     var val=$(this).val();
                                     document.cookie="cpm="+val;
                                     val=val.split("-");
                                     var camp=val[0];
                                     var serv=val[1];
                                     var cs_id=val[2];
                                     var data="camp_id="+camp;
                                     if(serv!=0)
                            			data+="&serv="+serv;   
                                     else
                            			data+="&cs_id="+cs_id;   

                                     $.ajax({
                            				
                             			type : 'POST',
                             			url  : '<?php echo Crm::root()."campservcat-update-form.php"; ?>',
                             			data : data,
                             			beforeSend: function() {
                             				$(".campaign-content").html(preloader());
                            				$(".campaign-content").show();
                             			},
                             			success :  function(response) {
//                                                         console.log("file"+response);
                             				$(".campaign-content").html(response);
                            				$(".campaign-content").show();
                                                             $('select').formSelect();
                                                             M.updateTextFields();
                                                         }
                                                                     
                             			});
                            			
                                    });

                                    });

                            }
                                        
			});
                        break;
                }       
          }
       });
    
        $("input[name=options]").change(function() {
            var selected=$("#camp_id").val();
          var options=$("input[name=options]:checked").val();
          console.log("option->camp\n"+options+"->"+selected);
          $(".display-list-camp-prod").hide();
          $(".campaign-content").hide();
          if(selected!="") {
              switch(options) {
                  case "campaign" :               
                      $(".display-list-camp-prod").hide();
			$.ajax({
				
			type : 'POST',
			url  : '<?php echo Crm::root()."campaign-update-form.php"; ?>',
			data : "camp_id="+selected,
			beforeSend: function() {
				$(".campaign-content").html(preloader());
				$(".campaign-content").show();
			},
			success :  function(response) {
//                            console.log("file"+response);
				$(".campaign-content").html(response);
				$(".campaign-content").show();
                                $('select').formSelect();
                            }
                                        
			});
                        break;
                    case "campprodcat" :

                        
                        $.ajax({
				
			type : 'POST',
			url  : '<?php echo Crm::root()."campprodcat-list.php"; ?>',
			data : "camp_id="+selected,
			beforeSend: function() {
				$(".display-list-camp-prod").html(preloader());
                $(".display-list-camp-prod").show();
			},
			success :  function(response) {
  //                          console.log("file"+response);
				$(".display-list-camp-prod").html(response);
                $(".display-list-camp-prod").show();
                                $('select').formSelect();
                                M.updateTextFields();
                                $(".display-list-camp-prod").show();
                                $(".display-list-camp-prod").ready(function() {
                                    $("#cpm").change(function() {
                                        console.log("cpm change");
                                     var val=$(this).val();
                                     document.cookie="cpm="+val;
                                     val=val.split("-");
                                     var camp=val[0];
                                     var prod=val[1];
                                     var cs_id=val[2];
                                     var data="camp_id="+camp;
                                     if(prod!=0)
                            			data+="&prod="+prod;   
                                     else
                            			data+="&cs_id="+cs_id;   

                                     $.ajax({
                            				
                             			type : 'POST',
                             			url  : '<?php echo Crm::root()."campprodcat-update-form.php"; ?>',
                             			data : data,
                             			beforeSend: function() {
                             				$(".campaign-content").html(preloader());
                            				$(".campaign-content").show();
                             			},
                             			success :  function(response) {
                                                         console.log("file"+response);
                             				$(".campaign-content").html(response);
                            				$(".campaign-content").show();
                                                             $('select').formSelect();
                                                             M.updateTextFields();
                                                         }
                                                                     
                             			});
                            			
                                    });

                                    });

                            }
                                        
			});
                        break;
                    case "campservcat" :

                        
                        $.ajax({
				
			type : 'POST',
			url  : '<?php echo Crm::root()."campservcat-list.php"; ?>',
			data : "camp_id="+selected,
			beforeSend: function() {
				$(".display-list-camp-prod").html(preloader());
                $(".display-list-camp-prod").show();
			},
			success :  function(response) {
  //                          console.log("file"+response);
				$(".display-list-camp-prod").html(response);
                $(".display-list-camp-prod").show();
                                $('select').formSelect();
                                M.updateTextFields();
                                $(".display-list-camp-prod").show();
                                $(".display-list-camp-prod").ready(function() {
                                    $("#cpm").change(function() {
                                        console.log("cpm change");
                                     var val=$(this).val();
                                     document.cookie="cpm="+val;
                                     val=val.split("-");
                                     var camp=val[0];
                                     var serv=val[1];
                                     var cs_id=val[2];
                                     var data="camp_id="+camp;
                                     if(serv!=0)
                            			data+="&serv="+serv;   
                                     else
                            			data+="&cs_id="+cs_id;   

                                     $.ajax({
                            				
                             			type : 'POST',
                             			url  : '<?php echo Crm::root()."campservcat-update-form.php"; ?>',
                             			data : data,
                             			beforeSend: function() {
                             				$(".campaign-content").html(preloader());
                            				$(".campaign-content").show();
                             			},
                             			success :  function(response) {
                                                         console.log("file"+response);
                             				$(".campaign-content").html(response);
                            				$(".campaign-content").show();
                                                             $('select').formSelect();
                                                             M.updateTextFields();
                                                         }
                                                                     
                             			});
                            			
                                    });

                                    });

                            }
                                        
			});
                        break;
                }       
          }
       });
    </script>
</body>
</html>