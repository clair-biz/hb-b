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
//Statement stmtcat=packcrm.Crm.con().createStatement();    
$query="select cat_id,cat_name,cat_type from category where cat_id<>0 order by cat_name;";
$cat=Base::generateResult($query);
//Statement stmtcat111=packcrm.Crm.con().createStatement();    

?>
     <div class="container-fluid" style="margin-top: 40px;">
    
            <div class="row">
                <div class="col-lg-2 col-md-4 hide-on-small-and-down">
                    <?php
                    require 'admin-menu.php'; 
                    ?>
                    </div>
        <div class="card col-md-10 col-sm-12 col-lg-10">
            <div class="row">
                        <h5 class="page-header container text-center">&nbsp;&nbsp;Rate Chart</h5>
                        <form>
                            <table width="100%" class="table table-striped table-responsive0 table-bordered table-hover" id="dataTables-category">
                                <thead>
        <tr class="text-center">
            <th>Category Name</th>
            <th>Type</th>
            <th>Half Annual Charge</th>
            <th>Annual Charge</th>
        </tr>
    </thead>
    <tbody>
        <?php
      while($row= mysqli_fetch_assoc($cat)){  
?>
        <tr class="text-center">
        <td>
            <span class="data">
            <?php echo $row["cat_name"]; ?>
            </span>
            <span class="fields">
                    <div class="form-group">
                        <input type="text" name="cat_name[]" class="form-control" id="<?php echo "cat_name".$row["cat_id"]; ?>" placeholder="<?php echo $row["cat_name"]; ?>" />
                    </div>
            </span>
        </td>
        <td>
            <span class="data">
            <?php echo $row["cat_type"]; ?>
            </span>
            <span class="fields">
                    <div class="form-group">
                        <select name="cat_type[]" class="form-control" id="<?php echo "cat_type_".$row["cat_id"]; ?>" >
                            <option value="<?php echo $row["cat_type"]; ?>" ><?php echo $row["cat_type"]; ?></option>
                        <?php
                        if($row["cat_type"]=="Product")
                            $other="Service";
                        else
                            $other="Product";
                            ?>
                            
                            <option value="<?php echo $other; ?>" ><?php echo $other; ?></option>
                            <?php
                          
                        ?>
                        </select>
                    </div>
            </span>
        </td>

        <td>
            <span class="data">
            <?php echo Base::getrate($row["cat_id"],"Half Annual"); ?>
            </span>
            <span class="fields">
                    <div class="form-group">
                        <input type="text" name="rate_ha[]" class="form-control" id="<?php echo "rate_ha".$row["cat_id"]; ?>"
                        placeholder="<?php echo Base::getrate($row["cat_id"],"Half Annual"); ?>"
                        value="<?php echo Base::getrate($row["cat_id"],"Half Annual"); ?>" />
                        
                    </div>
            </span>
        </td>
        
        <td>
            <span class="data">
            <?php echo Base::getrate($row["cat_id"],"Annual"); ?>
            </span>
            <span class="fields">
                    <div class="form-group">
                        <input type="text" name="rate_a[]" class="form-control" id="<?php echo "rate_a".$row["cat_id"]; ?>"
                        placeholder="<?php echo Base::getrate($row["cat_id"],"Annual"); ?>"
                        value="<?php echo Base::getrate($row["cat_id"],"Annual"); ?>" />
                        
                    </div>
            </span>
        </td>
        
            <td>
                <span class="data">
                    <a class="btn-link btn btn-edit" data-value="<?php echo $row[0]; ?>" >Edit</a>
                </span>
                <span class="fields">
                    <button class="btn-link btn btn-update" name="btn_submit" type="button" value="<?php echo "Update_".$row[0]; ?>" >Update</button>
                    <button class="btn-link btn btn-delete" formnovalidate name="btn_submit" type="submit" value="<?php echo "Delete_".$row[0]; ?>" >Delete</button>
                </span>
            </td>
            
        </tr>


<?php }
//mysqli_free_result($cat111);
//stmtcat111.close();
?>
  
    </tbody>

                            </table>
                            <!-- /.table-responsive -->
            </form>
                </div>
                <!-- /.col-lg-12 -->
                


            </div>      

    </div>
     </div>
    </section>
    <footer class="footer" ></footer>
    
</section>
    
<?php
require_once 'scripts.html';
?>
    
        <script>
    $(document).ready(function() {
        $('#dataTables-category').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }
    });
        $('#dataTables-example1').DataTable({
        responsive: true,
  drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }
        });
    });
    </script>
    </body>
</html>