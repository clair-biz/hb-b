<html>
    <body>
    <?php 
    require_once 'data.php';
    $id=$_REQUEST["vs_id"];
    ?>
        <div class="modal-content">
<div class="row modal-body">
    <div class="offset-md-3 col-md-6">
        <form id="search-form" action="vend-disable.php" >
            <div class="row">
                <div class="justify-content-center mr-5"><p>Mention reason to disable <?php echo Vendor::getbnamebyvsid($id); ?></p></div>
    <textarea id="vendor-disable-reason" name="reason"></textarea>
    <input type="hidden" name="vs_id" value="<?php echo $id; ?>" />
                  </div>
         
                  <div class="row">
    <div class="offset-md-4 col-md-4" >
      <button type="submit" id="submit-vendor-reject" class="btn button" disabled>Disable</button>
    </div>
                  </div>
             
              </form>
</div>
        </div>
    </div>
<!--script>
$(document).ready(function() {
    $("#vendor-disable-reason").on('keyup',function() {
        var len=$(this).val().length;
//        console.log(len);
            if(len>=5)
                $("#submit-vendor-reject").prop("disabled",false);
            else
                $("#submit-vendor-reject").prop("disabled",true);
        });
    });

</script-->
    </body>
</html>
