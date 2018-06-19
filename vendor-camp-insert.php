<html>
    <body>
    <form class="form-horizontal" id="camp-insert" action="vendor-camp-insert1.php" method="post" >
            <div class="row container-fluid">
                    <h5 class="page-header col-sm-12 text-center">Add New Offer</h5>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        
    <div class="row container-fluid">
        <div class="col-md-3 col-sm-12 form-group">
            <label for="cname">Offer Name: <font style="color:red">*</font></label>
                <input type="text" class="form-control" autocomplete="off" placeholder="This Field is mandatory" id="cname" name="cname" required />
        </div>
                
        <div class="col-md-3 col-sm-12 form-group">
            <label for="stdt">Start Date: <font style="color:red">*</font></label>
                <input type="text" data-toggle="datepicker" readonly class="form-control" autocomplete="off" id="stdt" name="stdt" required />
        </div>

        <div class="col-md-3 col-sm-12 form-group">
            <label for="endt">End Date: <font style="color:red">*</font></label>
                <input type="text" data-toggle="datepicker" readonly class="form-control"  autocomplete="off" id="endt" name="endt" required />
        </div>

            <div class="col-md-3 col-sm-12 d-flex align-items-center" id="submit-block">
            <button id="submit-camp-insert" class="btn btn-block w3-button w3-blue-grey" >Add Offer</button>
            </div>
    </div>

           
            
</form>
    </body>
</html>