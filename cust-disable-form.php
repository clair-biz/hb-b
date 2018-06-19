<html>
    <body>
    <?php 
    require_once 'data.php';
    $id=$_REQUEST["cust_id"];
    ?>
        <div class="modal-content">
<div class="row modal-body">
    <div class="col-md-6 offset-md-3">
        <form id="search-form" action="cust-disable.php" >
            <div class="justify-content-center row">
            <div class="text-center"><p>Mention reason to disable <?php echo Customer::getcustnamebyid($id); ?></p></div>
                  <div class="">
    <textarea id="customer-disable-reason" name="reason"></textarea>
    <input type="hidden" name="cust_id" value="<?php echo $id; ?>" />
                  </div>
            </div>
                  <div class="row">
    <div class="col-md-4 offset-md-4" >
      <button type="submit" id="submit-customer-reject" class="btn button" disabled>Disable</button>
    </div>
                  </div>
             
              </form>
</div>
        </div>
    </div>
<script>
$(document).ready(function() {
    $("#customer-disable-reason").on('keyup',function() {
        var len=$(this).val().length;
//        console.log(len);
            if(len>=5)
                $("#submit-customer-reject").prop("disabled",false);
            else
                $("#submit-customer-reject").prop("disabled",true);
        });
    });

</script>
    </body>
</html>
