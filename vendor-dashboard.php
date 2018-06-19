<html>
<head>
<title> Homebiz365-- Vendor's products </title>
        <?php require_once 'stylesheets.html';?>
    </head>
<body>
<section class="body" >
    <section class="preloader" ></section>
    <section class="content" >
<?php
require_once 'data.php';

    
$query="select cat_id,bname,vs_id from vend_subscription,users where vend_subscription.u_id=users.u_id and vs_pay_status in('Enabled','Wait4FSSAI') and u_name='".$user->u_name."';";
$result=Base::generateResult($query);

?>
<div class="container-fluid" style="margin-top: 80px; margin-bottom: 80px;">
    <h5 class="page-header center-align" style="font-size: 16px;">Select Category</h5>
    <div class="row" style="margin-bottom: 5px;">
      <div class="col-sm-12 col-lg-4 col-lg-offset-4">
          <ul class="collection">
    <?php
    while($row= mysqli_fetch_array($result)) {
    ?>
        <li style="cursor: pointer;" class="collection-item category-panel teal" id="<?php echo $row[2]; ?>" >
          <span class="center-align">
              <?php
              echo Base::getcatnamebycatid($row[0])." (".$row[1].")";
              ?>
          </span>
        </li>
    <?php
    }
    ?>
          </ul>
</div>
    </div>
</div>
      </section>    
      <section class="footer" style="margin-top: 10px !important; width: auto !important;" ></section>
      
</section>
<?php
require_once 'scripts.html';
?>

