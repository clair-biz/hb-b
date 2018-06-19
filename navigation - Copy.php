<?php
require_once 'data.php';
$col=[8,2,2];
if(($user!="" && $user->type=="customer") || $user=="")
    $col=[6,2,2,2];
    
?>
<div class="navbar fixed-top p-0">
<div class="container-fluid mx-0 p-0 d-none d-sm-block navigation-bar">
    <div class="row container-fluid head-block m-0 pl-5" style="background: #009846; ">
    <div class="<?php echo "col-md-".$col[0]; ?>">
        <ul class="navbar-nav">
      <li class="nav-item">
          <p class="nav-link" >Turn your Business around and Make it stand out!!
      <span>
        <a href="<?php echo $root."StartSelling"?>">For Business</a>
      </span>
          </p>
      </li>
        </ul>
    </div>
    <div class="<?php echo "col-md-".$col[1]; ?>">
        <ul class="navbar-nav">
            <?php
$strcities="SELECT distinct city_served FROM vend_subscription where vs_pay_status='Enabled' and city_served<>'".$_COOKIE["city"]."'; ";
            $cities=Base::generateResult($strcities);
            ?>
      <li class="nav-item dropdown">
          <a class="nav-link float-right dropdown-toggle" data-toggle="dropdown" href="#" style="display: inline !important;"><span class="currentCity"></span></a>
          <div class="dropdown-menu cities" style="z-index: 1055 !important;">
          </div>

      </li>
        </ul>
    </div>
            
            
<?php            
          if(($user!="" && $user->u_name!="" && $user->cust_id!="" ) || $user=="") { ?>
    <div class="<?php echo "col-md-".$col[2]; ?>">
        <ul class="navbar-nav">
      <li class="nav-item">
          <a class="nav-link float-right" href="<?php echo $root."Cart"; ?>" style="display: inline !important; color: white;"><i class="fas fa-shopping-cart"></i> Cart <span class="cartdata"></span></a>
      </li>
        </ul>
    </div>
            <?php
                  }
                  ?>
    <div class="<?php 
    if($user!="") {
    if($user->type=="customer")
    echo "col-md-".$col[3];
    else 
    echo "col-md-".$col[2];
              }
    else
        echo "col-md-".$col[2];
  
    ?>">
        <ul class="navbar-nav">
            <?php
            if($user!="") { ?>
    <!-- Dropdown -->
    <li class="nav-item dropdown">
        <a class="nav-link float-right dropdown-toggle" 
           id="navbardrop" data-toggle="dropdown" style="display: inline !important; color: white;">
            <b><?php echo $user->u_name; ?></b>
        </a>
        <div class="dropdown-menu" style="z-index: 1051 !important;">
        <a class="dropdown-item" href="<?php
        if($user->type=="vendor")
        echo $root."VendorProfile";
        elseif($user->type=="customer")
        echo $root."CustomerProfile";
        elseif($user->type=="customer")
        echo $root."AdminDashboard";
        
        ?>"><?php
        if($user->type=="Admin")
        echo "Dashboard";
        else
        echo "My Profile";
            
            ?></a>
            <?php
            if($user->type=="admin") { ?>
        <a class="dropdown-item" href="<?php echo $root."ChangePassword/".$user->u_name;
        
        ?>">Change Password</a>
            <?php
            }
            ?>
        <a class="dropdown-item" href="<?php echo $root."Logout"; ?>">Logout</a>
      </div>
    </li>
                  <?php
          }
          else {
          ?>
    <li class="nav-item">
        <a class="nav-link float-right" href="<?php echo $root."Login";?>" style="display: inline !important;">Login / Register</a>
      </li>
        <?php
          }
          ?>
        </ul>
    </div>
        </div>

    <nav class="navbar navbar-expand-md navbar-light sticky-top0  bg-white shadow " style="z-index: 1050 !important; padding-left: 5% !important; padding-right: 5% !important;">
  <!-- Brand -->
   <a class="navbar-brand" href="<?php echo $root;?>">
    <img src="<?php echo $root."assets/images/logo.png"; ?>" alt="Logo" >
  </a>
  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" aria-controls="collapsibleNavbar" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
    <nav class="navbar-nav d-block d-sm-none">
        <form class="form-inline" action="/action_page.php" >
  <div class="input-group mb-2 mr-sm-2" style="height: 2rem !important;">
          <input class="form-control" type="text" placeholder="Search">
    <div class="input-group-append">
        <div class="input-group-text bg-success" style="padding: 0 !important;">
          <button class="btn btn-success" style="height: 2rem !important;" type="submit">Search</button>
      </div>
    </div>
  </div>
        </form>
    </nav>
  
  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav navTop mr-auto ml-5">
        
        <?php
        if(($user!="" && $user->type=="customer") || $user=="") { ?>
      <li class="nav-item category-modals btn-group" id="category_product">
        <a class="nav-link categories btn btn-link" data-type="Product" data-toggle="modal" data-target="#categoryProductModal" href="#">Products</a>
      <a class="nav-link dropdown-toggle dropdown-toggle-split" href="#" id="navbarproductdrop" data-toggle="dropdown">
        
      </a>
      <div class="dropdown-menu">
        <?php
          require_once 'category-product.php';
          
          ?>
      </div>
      </li>
            
      <li class="nav-item category-modals btn-group" id="category_service">
        <a class="nav-link categories btn btn-link" data-type="Service" data-toggle="modal" data-target="#categoryServiceModal" href="#">Services</a>
      <a class="nav-link dropdown-toggle dropdown-toggle-split" href="#" id="navbarservicedrop" data-toggle="dropdown">
        
      </a>
      <div class="dropdown-menu">
        <?php
          require_once 'category-service.php';
          
          ?>
      </div>
      </li>
            
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $root."About";?>">About Us</a>
      </li>
            
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $root."Contact";?>">Contact Us</a>
      </li>
            
      <?php
        }

        elseif($user!="" && $user->type!="customer") {
            if($user->type=="vendor") {
                
                
                if($user->vs_count>1) { ?>
    <li class="nav-item dropdown">
        <a class="nav-link float-right dropdown-toggle" 
           id="navbardrop" data-toggle="dropdown" style="display: inline !important; color: white;">
            <?php echo Base::getcatnamebycatid(Vendor::getcatidbyvsid($user->vs_id));
 ?>
        </a>
        <div class="dropdown-menu" style="z-index: 1051 !important;"> <?php
$query="select cat_id,bname,vs_id from vend_subscription,users where vend_subscription.u_id=users.u_id and vs_pay_status in('Enabled','Wait4FSSAI') and u_name='".$user->u_name."';";
$result=Base::generateResult($query);

    while($row= mysqli_fetch_array($result)) { ?>
        <a class="dropdown-item category-panel" data-message="<?php echo $row[2]; ?>" href="#" ><?php
        echo Base::getcatnamebycatid($row[0])."( ".$row[1]." )";
        ?>
        </a>
    <?php
        }
    ?>
      </div>
    </li>
    <?php
                    
                }
            ?>
    
    
    <li class="nav-item dropdown">
        <a class="nav-link float-right dropdown-toggle" 
           id="navbardrop" data-toggle="dropdown" style="display: inline !important; color: white;">
            <?php echo $user->vs_type."s"; ?>
        </a>
        <div class="dropdown-menu" style="z-index: 1051 !important;">
        <a class="dropdown-item" href="<?php
        echo $root.$user->vs_type."sPage";
        ?>"><?php
        echo "My ".$user->vs_type."s";
            ?></a>
        <a class="dropdown-item" href="<?php
        echo $root."Add".$user->vs_type;
        ?>">
            Add
            <?php
        echo $user->vs_type;
        ?>
</a>
        <a class="dropdown-item" href="<?php
        echo $root.$user->vs_type."Page";
         ?>">Update
            <?php
        echo $user->vs_type;
        ?>
</a>
        <a class="dropdown-item" href="<?php echo $root."MyOffers"; ?>">My Offers</a>

      </div>
    </li>
    
    
    <li class="nav-item dropdown">
        <a class="nav-link float-right dropdown-toggle" 
           id="navbardrop" data-toggle="dropdown" style="display: inline !important; color: white;">
            Subscriptions
        </a>
        <div class="dropdown-menu" style="z-index: 1051 !important;">
        <a class="dropdown-item" href="<?php
        echo $root."RateChart";
        ?>">Rate Chart
        </a>
        <a class="dropdown-item" href="<?php
        echo $root."NewSubscription";
        ?>">New Subscription
        </a>
            <?php
            if($user->pending_subsc>0) { ?>
        <a class="dropdown-item" href="<?php
        echo $root."VendorSubscriptions";
        ?>">
            Checkout
        </a>
            <?php
            }
            ?>
        <a class="dropdown-item" href="<?php
        echo $root."BankDetails";
        ?>">Bank Details
        </a>
      </div>
    </li>
<?php
            if($user->vs_type=="Product") { ?>
      <li class="nav-item" >
        <a class="nav-link" href="<?php echo $root."OrdersPage";?>">Orders</a>
      </li>
      
    <li class="nav-item dropdown">
        <a class="nav-link float-right dropdown-toggle" 
           id="navbardrop" data-toggle="dropdown" style="display: inline !important; color: white;">
            Set Unavailability
        </a>
        <div class="dropdown-menu" style="z-index: 1051 !important;">
        <a class="dropdown-item" href="<?php
        echo $root."OrderFullChart";
        ?>">View Orders Full Chart
        </a>
        <a class="dropdown-item" href="<?php
        echo $root."OrderFull";
        ?>">Set Orders Full
        </a>
        <!--a class="dropdown-item" data-toggle="modal" data-target="#goOfflineModal">
            Set Vendor Unavailable
        </a-->
      </div>
    </li>

            <?php
            }
            ?>
                        
      <?php
        }
        elseif($user->type=="admin") { ?>
      <li class="nav-item" >
        <a class="nav-link" href="<?php echo $root.$user->home_url;?>">Dashboard</a>
      </li>
            
      <li class="nav-item" id="category_service">
        <a class="nav-link" data-toggle="modal" data-target="#categoryServiceModal" href="#">Services</a>
      </li>
            
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $root."About";?>">About Us</a>
      </li>
            
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $root."Contact";?>">Contact Us</a>
      </li>
            
      <?php
            }
        }
        ?>
        
    </ul>
    <nav class="navbar-nav d-none d-sm-block">
        <form class="form-inline" action="/action_page.php">
          <input class="form-control" type="text" placeholder="Search">
          <button class="btn btn-success" style="background-color: #009846 !important;" type="submit">Search</button>
        </form>
    </nav>
  </div> 
</nav>
</div>
</div>

    <?php
//          if((isset($user)!="" && $user->type=='customer') ||!isset($user)) { ?>
<!-- The Modal -->
<div class="modal fade" id="modal-ord-cancel" >
    <div class="modal-dialog" >
  </div>
</div>


<!-- The Modal -->
<div class="modal fade" id="modal-disable-vendor" style="z-index: 1050 !important;">
    <div class="modal-dialog" >
  </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="modal-disable-customer" style="z-index: 1050 !important;">
    <div class="modal-dialog" >
  </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="modal-msg" style="z-index: 1050 !important;">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" >
        <div class="modal-body align-items-center d-flex justify-content-center" >
            
        </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<?php
//          }
          ?>
</body>
</html>