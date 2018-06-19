<html>
    <head>
        <title> Homebiz365-- Privacy Policies </title>
        <?php require_once 'stylesheets.html';?>
    </head>
<body>
<section class="body" >
    <section class="preloader" ></section>
    <section class="content" >
<?php
require_once 'data.php';
?>
        <div class="container-fluid" style="margin-top: 40px;">
    <h5 class="text-center"><b>Privacy Policies</b></h5>
    <button type="button" onclick="window.top.close();" class="terms-btn btn red right" >Close</button>
    <object class="term-div" data='<?php echo $root."assets/policies.pdf"; ?>' 
        type='application/pdf' 
        width='100%' 
        height='70%'>
            <p>Your web browser doesn't have a PDF plugin.
                Instead you can <a href="<?php echo $root."assets/policies.pdf"; ?>">click here to
  download the PDF file.</a></p>
    </object>
    <button type="button" onclick="window.top.close();" class="terms-btn btn red right" >Close</button>

</div>
</section>    
      <section class="footer" style="margin-top: 10px !important; width: auto !important;" ></section>
      
</section>
<?php
require_once 'scripts.html';
?><script>
$(window).resize(function() {

$('.term-div').css('height', window.innerHeight+'px');

});		
</script>
    </body>
</html>
