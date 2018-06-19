<html>
    <body>
<?php
$search_val="";
if(isset($_REQUEST["serv"])!="")
$search_val= str_replace("_"," ", rawurldecode($_REQUEST['serv']));

$type="serv";
require_once 'data.php';

$strQuery="select  `serv_name` from  service,vendor,category,vend_subscription,users,cat_sub  WHERE category.cat_id=cat_sub.cat_id and service.cs_id=cat_sub.cs_id and vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and vend_subscription.vs_id=service.vs_id and users.is_active='Y' and  serv_name like '%".$search_val."%'";
$strQuery.=" union select `serv_name` from  service,vendor,category,vend_subscription,users,cat_sub WHERE category.cat_id=cat_sub.cat_id and service.cs_id=cat_sub.cs_id and vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and vend_subscription.vs_id=service.vs_id and users.is_active='Y' and  bname like '%".$search_val."%'";
$strQuery.=" union select `serv_name` from  service,vendor,category,vend_subscription,users,cat_sub WHERE category.cat_id=cat_sub.cat_id and service.cs_id=cat_sub.cs_id and vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and vend_subscription.vs_id=service.vs_id and users.is_active='Y' and  cs_name like '%".$search_val."%'";
$strQuery.=" union select `serv_name` from  service,vendor,category,vend_subscription,users,cat_sub WHERE category.cat_id=cat_sub.cat_id and service.cs_id=cat_sub.cs_id and vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and vend_subscription.vs_id=service.vs_id and users.is_active='Y' and  cat_name like '%".$search_val."%'";
$strQuery.=" union select `serv_name` from  service,vendor,category,vend_subscription,users,cat_sub WHERE category.cat_id=cat_sub.cat_id and service.cs_id=cat_sub.cs_id and vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and vend_subscription.vs_id=service.vs_id and users.is_active='Y' and  city_served like '%".$search_val."%'";

$search_res=Base::generateResult($strQuery);
$numofrow=count($search_res);

?>
<div class="container-fluid hide-on-small-and-down" style="margin-top: 40px;">
<div id="gototop"> </div>
<div class=" row">
    <div class="col-lg-2 col-md-4" >
        <div class="row">
            <?php //require_once 'shop-by.php';?>
        </div>
        <div class="row">
            <?php //require_once 'popular-tags.php';?>
        </div>
        <div class="row">
            <?php //require_once 'advertisement-1.php';?>
        </div>
        
	</div>
    <div class="col-lg-8 col-md-8 col-sm-12">
    <?php 
      if($numofrow>0)  { ?>
      <h5 class="result"><b>    
      <?php 
      echo $search_val;
      ?></b></h5>
      <?php 
      }
      else {
          ?>
          <script>
        $('document').ready(function() { 
          var val="<?php echo $search_val; ?>";
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='text-center'>No Service Providers for "+val+"!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"Services";
                });
                });
//          alert("No result found for "+val);
//          window.location.href="service-index.php";
          </script>
<?php      }
          ?>

    <div class="col-lg-12 service-list" id="<?php echo "service_list_".$serv_name;?>" style="margin-top: 5px; margin-bottom: 5px; " hidden>
    <div class="card service-list-title">
				  <h5  class="truncate text-center" data-toggle="tooltip" >
                                      <b><span class="serv_name logo-color-b"></span></b>

                                      <button class="service-list-close btn red right" ><i class="material-icons h6">close</i></button>
                                  </h5>
    </div>
    <div class="center service-list-menu">

    </div>
        

</div> 

<?php         
        $count=1;
foreach ($search_res as $prods) {
//            while($prods = mysqli_fetch_array($prodres)) {
                $n= explode(" ", $prods["serv_name"]);
                $serv_name= implode("_", $n);
          $img=$root."assets/products-services/".$prods["serv_img"];
//if($count==1) {                        
?>
<!--div class="row" style="margin-bottom: 10px;"-->
    <?php
//}
?>
    <div class="service" id="<?php echo "service_".$serv_name;?>" >
    <div class="col-lg-3 service-display" id="<?php echo "service_display_".$serv_name;?>" >
          <div class="card">
            <div class="card-image">
                <a class="" href="#">
                    <img height="150" width="320" class="responsive-img"
             style="height: 150px !important; width: auto !important;
             display: block !important; margin-left: auto !important;
             margin-right: auto !important;"
             src="<?php echo $img; ?>"
             onError="this.onerror=null;this.src='uploads/images/small.png';" />
                </a>
            </div>
            <div class="card-content">
                <h6  class="truncate text-center black-text" style="font-size: 16px;">
                    <a class="black-text" href="#" data-toggle="tooltip" 
                                         title="<?php echo $prods["serv_name"]; ?>">
                                 <b><?php echo $prods["serv_name"]; ?></b></a></h6>
            </div>
          </div>
</div>
        
</div>

    <?php
//    if($count==4){
//    $count=1;
    ?>
<!--/div-->

                        <?php //}
//                        else
//                        $count++;
}?>

        
    </div>
    

    
</div>
</div>


    <div class="hide-on-large-only">
<div id="gototop"> </div>
<!-- 
Body Section 
-->
<?php require 'category-navbar-mob.php';?>
<div class="container-fluid" style="margin-top: 5px !important;">
<?php

?>
    <div class="col-sm-12">
    <?php 
      if($numofrow>0)  { ?>
      <h5 class="result"><b>    
      <?php 
      echo $search_val;
      ?></b></h5>
      <?php 
      }
      else {
          ?>
          <script>
        $('document').ready(function() { 
          var val="<?php echo $search_val; ?>";
                $("#modal-message").find(".modal-content").html("<p style='vertical-align:central;' class='text-center'>No Service Providers for "+val+"!</p>");
                $("#modal-message").modal("open");
                $("#modal-message").find(".modal-close").click(function() {
                    $("#modal-message").modal("close");
                    var root="<?php echo Crm::root(); ?>";
                    window.location.href=root+"Services";
                });
                });
//          alert("No result found for "+val);
//          window.location.href="service-index.php";
          </script>
<?php      }
          ?>

    <div class="col s12 mservice-list"  style="margin-top: 5px; margin-bottom: 5px; display:none !important;" >
    <div class="card mservice-list-title">
      <h5 style="font-size: 16px !important;" class="truncate text-center" data-toggle="tooltip" >
                                      <b><span class="serv_name logo-color-b"></span></b>
                                      <button class="mservice-list-close btn red right" ><i class="material-icons h6">close</i></button>
                                  </h5>
    </div>
    <div class="center mservice-list-menu">

    </div>
        

</div> 
<div class="row" style="margin-bottom: 10px;">

<?php         
        $count=1;
foreach ($search_res as $prods) {
//            while($prods = mysqli_fetch_array($prodres)) {
                $n= explode(" ", $prods["serv_name"]);
                $serv_name= implode("_", $n);
          $img=$root."assets/products-services/".$prods["serv_img"];
//if($count==1) {                        
?>
<!--div class="row" style="margin-bottom: 10px;"-->
    <?php
//}
?>
    <div class="mservice col s6" id="<?php echo "mservice_".$serv_name;?>" >
    <div class="mservice-display" id="<?php echo "mservice_display_".$serv_name;?>" >
          <div class="card">
            <div class="card-image">
                <a class="" href="#">
                    <img class="responsive-img"
             style="height: 100px !important; width: auto !important;
             display: block !important; margin-left: auto !important;
             margin-right: auto !important;"
             src="<?php echo $img; ?>"
             onError="this.onerror=null;this.src='http://www.homebiz365.in/uploads/images/small.png';" />
                </a>
            </div>
            <div class="card-content" style="padding: 5px !important;">
                <h6  class="truncate text-center black-text" style="font-size: 12px;">
                    <a class="black-text" href="#" data-toggle="tooltip" 
                                         title="<?php echo $prods["serv_name"]; ?>">
                                 <b><?php echo $prods["serv_name"]; ?></b></a></h6>
            </div>
          </div>
</div>
        
</div>

    <?php
//    if($count==4){
//    $count=1;
    ?>
<!--/div-->

                        <?php //}
//                        else
//                        $count++;
}?>

   </div>     
    </div>
    

    
</div>
</div>


<footer>
<?php
require_once 'footer.php';
?>
</footer>
<script>
$(".service-display").on('click',function() {
	$(this).parent(".service").addClass("last-item");
	var list=$(this).parent(".service")	;
	$(".service-list").show("slow");
	var id=list.attr("id");
	id=id.split("service_");
	id=id[1];

			$.ajax({
				
			type : 'POST',
			url  : '<?php echo Crm::root()."service_list.php"; ?>',
			data : "serv="+id,
			beforeSend: function() {
                            list.find(".service-list-menu").html(preloader());
			},
			success :  function(response) {
                $(".service-list").find(".service-list-menu").html(response);
                var prod_list_id="service_list_"+id;
                $(".service-list").attr("id",prod_list_id);
                var name=id.replace(/_/g," ");
                $(".service-list-title").find(".serv_name").html(name);
                var scrollval=$(".result").position().top-100;
//                console.log("scrollval0 "+scrollval);
                $(window).scrollTop(scrollval);
    }
			});

});

$(".service-list-close").on('click',function() {
	var id=$(".service-list").attr("id");
	id=id.split("list_");
	id=id[1];
	var scrollval=$(".last-item").position().top;
	$(window).scrollTop(scrollval);
	$(".service-list").hide("slow");
	$("#service_"+id).removeClass("last-item");
});


$(".mservice-display").on('click',function() {
	$(this).parent(".mservice").addClass("mlast-item");
	var list=$(this).parent(".mservice")	;
	$(".mservice-list").show("slow");
	var id=list.attr("id");
	id=id.split("mservice_");
	id=id[1];

			$.ajax({
				
			type : 'POST',
			url  : '<?php echo Crm::root()."service_list.php"; ?>',
			data : "serv="+id,
			beforeSend: function() {
                            list.find(".mservice-list-menu").html(preloader());
			},
			success :  function(response) {
                $(".mservice-list").find(".mservice-list-menu").html(response);
                var prod_list_id="mservice_list_"+id;
                $(".mservice-list").attr("id",prod_list_id);
                var name=id.replace(/_/g," ");
                $(".mservice-list-title").find(".serv_name").html(name);
                var scrollval=$(".mresult").position().top-100;
//                console.log("scrollval0 "+scrollval);
                $(window).scrollTop(scrollval);
    }
			});

});

$(".mservice-list-close").on('click',function() {
	var id=$(".mservice-list").attr("id");
	id=id.split("mservice_list_");
	id=id[1];
	var scrollval=$(".mlast-item").position().top;
	$(window).scrollTop(scrollval);
	$(".mservice-list").hide("slow");
	$("#mservice_"+id).removeClass("mlast-item");
});

</script>

<script>
function categorytab(inArr) {
    $("#category-product, #category-service").on('mouseenter',function () {
    if(inArr.category_product==true ) 
        showproductcat();
    else if(inArr.category_service==true )
        showservicecat();
        
          $('#modal-category').modal("open"); 
    
    });

    $("#category-product, #category-service").on('mouseleave',function () {
        $("#modal-category").on('mouseleave',function () {
    if(inArr.modal_category==false) {
//        console.log("inArrleave\n"+inArr.modal_category+"\n"+inArr.category_product+"\n"+inArr.category_service);
          $('#modal-category').modal("close"); 
      }
  });
    });
}


var inArr = {modal_category:false, category_product:false, category_service:false};

$('#modal-category').mouseover(function(){
    inArr.modal_category = true;
//    console.log("in modcat mouseover"+inArr.modal_category);
});
$('#category-product').mouseover(function(){
    inArr.category_product = true;
//    console.log("in prodcat mouseover"+inArr.category_product);
});
$('#category-service').mouseover(function(){
    inArr.category_service = true;
//    console.log("in servcat mouseover"+inArr.category_service);
});

$('#modal-category').mouseout(function(){
    inArr.modal_category = false;
//    console.log("modcat\n"+inArr.modal_category+"\n"+inArr.category_product+"\n"+inArr.category_service);
});
$('#category-product').mouseout(function(){
    inArr.category_product = false;
//    console.log("in prodcat mouseout"+inArr.category_product);
});
$('#category-service').mouseout(function(){
    inArr.category_service = false;
//    console.log("in servcat mouseout"+inArr.category_service);
});

    
    categorytab(inArr);

</script>

    </body>
</html>