<html>
<body>
<?php
require_once 'data.php';
$cat_id= $_REQUEST['cat_id'];
      ?>
    <div class="container-fluid row">
    <div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 ">
            <?php
            $strsubcat="select distinct cs_name,cat_sub.cs_id,count(product.prod_id) as 'count'
from category,cat_sub,product
where category.cat_id=cat_sub.cat_id
and product.cs_id=cat_sub.cs_id
and cs_name not in (select distinct cat_name from category)
and category.cat_id=$cat_id 
group by cs_name; ";

echo $strsubcat;            
            $rescs= Base::generateResult($strsubcat);
?>            
             <div class="category-table">
                    <div class="card">
                    <h5 class="page-header container text-center">Categories</h5>
                            <table width="100%" class="table table-striped table-responsive table-bordered table-hover" id="dataTables-categories">
                                <thead>
        <tr class="text-center">
            <th>Sub Category</th>
            <th>Products/ Services<br /> in Category</th>
            <th></th>
      </tr>
    </thead>
    <tbody>
        <?php
      while($row=mysqli_fetch_array($rescs)) {
?>
        <tr class="text-center ">   
            <td>
                <span class="data"><?php echo $row["cs_name"]; ?></span>
                <span class="fields">
                    <div class="form-group">
                        <input type="text" name="cs_name[]" class="form-control" id="cs_name" placeholder="<?php echo $row["cs_name"]; ?>" />
                    </div>
                </span>
            </td>
        <td  ><?php echo $row["count"]; ?></td>
            <td>
                <span class="data">
                    <button class="btn-link btn btn-edit" type="button" data-value="<?php echo $row[0]; ?>" >Edit</button>
                </span>
                <span class="fields">
                    <button class="btn-link btn btn-update" name="btn_submit" type="button" value="<?php echo "Update_".$row["cs_id"]; ?>" >Update</button>
                    <button class="btn-link btn btn-delete" formnovalidate name="btn_submit" type="submit" value="<?php echo "Delete_".$row["cs_id"]; ?>" >Delete</button>
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
                            
                            
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    </div>
    </div>
    </div>
</body>
</html>