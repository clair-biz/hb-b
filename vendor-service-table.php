<html>
    <body>
<?php
require_once 'data.php';

$obj=new Base;
//    print_r(json_decode($_SESSION["user"]));
$vend_name=$user->u_name;
$vs_id= $user->vs_id;
$q="select service.serv_id,serv_img,serv_name,serv_desc,serv_file,cs_name from users,service,vend_subscription,cat_sub where vend_subscription.cat_id=cat_sub.cat_id and users.u_id=vend_subscription.u_id and vend_subscription.vs_id=service.vs_id and service.is_active='Y' and service.vs_id=$vs_id;";
$prod=Base::generateResult($q);
//$prod=mysqli_query($obj->con,$q);
$cat=Base::generateResult("select DISTINCT cs_name, cs_id from cat_sub,vendor,category,users,vend_subscription where users.vend_id=vendor.vend_id and category.cat_id=cat_sub.cat_id and vend_subscription.cat_id=category.cat_id and u_name='$vend_name'");
//$cat=mysqli_query($obj->con,"select DISTINCT cs_name, cs_id from cat_sub,vendor,category,users,vend_subscription where users.vend_id=vendor.vend_id and category.cat_id=cat_sub.cat_id and vend_subscription.cat_id=category.cat_id and u_name='$vend_name'");
?>
            <div >
                <em class="hide-on-med-and-up container text-center">Note: Click on field showing Plus mark to view details. Details are displayed below the record</em>
                               <table width="100%" class="table hover centered table-responsive0 z-depth-1 hoverable" id="dataTables-vendor-service">
                                <thead>
        <tr  class="text-center">
            <th>Service</th>
            <th></th>
            <th>Description</th>
            <th>Category</th>
            <th></th>
            <th></th>
      </tr>
    </thead>
    <tbody>
        <?php
      while($row=mysqli_fetch_array($prod)){  
          $img=$root."assets/products-services/".$row["serv_img"];
?>
        <tr class="text-center">
        <td>
            <img class="img-fluid table-img"
                 style="width: auto !important; display: block !important; margin-left: auto !important;
                 margin-right: auto !important;" src="<?php echo $img; ?>"
                 onError="this.onerror=null;this.src='http://www.homebiz365.in/uploads/images/small.png';" />
        </td>
        <td><?php echo $row["serv_name"]; ?></td>
        <td><?php echo $row["serv_desc"]; ?></td>
        <td><?php echo $row["cs_name"]; ?></td>
        <td><a href="#!" data-message="<?php echo $row["serv_id"]; ?>" class="service-edit">Edit</a></td>
        <td><a href="#!" data-message="<?php echo $row["serv_id"]; ?>" class="service-delete">Delete</a></td>
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
