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
        <div class="container-fluid row" style="margin-top: 40px;">
    <h5 class="page-header"><b> How It Works- For Customers </b></h5>
    <div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" style=" text-align: justify !important; text-justify: inter-word !important;">
        <div class="container">
        <img src="<?php echo Crm::root()."uploads/images/How It works-customers.png"; ?>" class="responsive-img" />
        </div>
    </div>
</div>
        </section>    
      <section class="footer" style="margin-top: 10px !important; width: auto !important;" ></section>
      
</section>
<?php
require_once 'scripts.html';
?>
    </body>
</html>


