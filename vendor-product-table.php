<html>
    <body>
<?php
require_once 'data.php';

$obj=new Base;
//    print_r(json_decode($_SESSION["user"]));
$vend_name=$user->u_name;
$vs_id= $user->vs_id;
$q="select product.prod_id as 'prod_id',prod_img,prod_name,prod_desc,cs_name,mrp from product,cat_sub,product_price where product.prod_id=product_price.prod_id and cat_sub.cs_id=product.cs_id and product.is_active='Y' and product.vs_id=$vs_id";
$prod=Base::generateResult($q);
//$prod=mysqli_query($obj->con,$q);
$cat=Base::generateResult("select DISTINCT cs_name, cs_id from cat_sub,vendor,category,users,vend_subscription where users.vend_id=vendor.vend_id and category.cat_id=cat_sub.cat_id and vend_subscription.cat_id=category.cat_id and u_name='$vend_name'");
//$cat=mysqli_query($obj->con,"select DISTINCT cs_name, cs_id from cat_sub,vendor,category,users,vend_subscription where users.vend_id=vendor.vend_id and category.cat_id=cat_sub.cat_id and vend_subscription.cat_id=category.cat_id and u_name='$vend_name'");
?>
            <div >
                <em class="hide-on-med-and-up container text-center">Note: Click on field showing Plus mark to view details. Details are displayed below the record</em>
                               <table width="100%" class="table hover centered table-responsive0 z-depth-1 hoverable" id="dataTables-vendor-product">
                                <thead>
        <tr  class="text-center">
            <th>Product</th>
            <th></th>
            <th>Description</th>
            <th>Category</th>
            <th>Price</th>
            <th></th>
            <th></th>
      </tr>
    </thead>
    <tbody>
        <?php
      while($row=mysqli_fetch_array($prod)){  
          $img=$root."assets/products-services/".$row["prod_img"];
?>
        <tr class="text-center">
        <td>
            <img class="img-fluid table-img"
                 style="width: auto !important; display: block !important; margin-left: auto !important;
                 margin-right: auto !important;" src="<?php echo $img; ?>"
                 onError="this.onerror=null;this.src='http://www.homebiz365.in/uploads/images/small.png';" />
        </td>
        <td><?php echo $row["prod_name"]; ?></td>
        <td><?php echo $row["prod_desc"]; ?></td>
        <td><?php echo $row["cs_name"]; ?></td>
        <td><?php echo $row["mrp"]; ?></td>
        <td><a href="#!" data-message="<?php echo $row["prod_id"]; ?>" class="product-edit">Edit</a></td>
        <td><a href="#!" data-message="<?php echo $row["prod_id"]; ?>" class="product-delete">Delete</a></td>
        </tr>

<?php }

//mysqli_free_result($req);
//req.close();
//stmtreq.close();
?>
  
    </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
    </body>
</html>
