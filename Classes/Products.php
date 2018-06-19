<?php
spl_autoload_register(function ($class) {
    include '' . $class . '.php';
});

class Products extends Base {

    public function __construct(){
        parent::__construct();              // Init parent contructor
        parent::con();                 // Initiate Database connection
//        $this->con();                 // Initiate Database connection
}



public function searchProducts($search_val){
    
$strQuery="select  `prod_name`,prod_img from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='".$_COOKIE["city"]."' and users.is_active='Y' and product.is_active='Y' and prod_name like '%".$search_val."%'";
$strQuery.=" union select `prod_name`,prod_img from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='".$_COOKIE["city"]."' and users.is_active='Y' and product.is_active='Y' and  product.area_served like '%".$search_val."%'";
$strQuery.=" union select `prod_name`,prod_img from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='".$_COOKIE["city"]."' and users.is_active='Y' and product.is_active='Y' and  bname like '%".$search_val."%'";
$strQuery.=" union select `prod_name`,prod_img from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='".$_COOKIE["city"]."' and users.is_active='Y' and product.is_active='Y' and  cs_name like '%".$search_val."%'";
$strQuery.=" union select `prod_name`,prod_img from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='".$_COOKIE["city"]."' and users.is_active='Y' and product.is_active='Y' and  cat_name like '%".$search_val."%'";
$strQuery.=" union select `prod_name`,prod_img from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='".$_COOKIE["city"]."' and users.is_active='Y' and product.is_active='Y' and  vend_addr like '%".$search_val."%'";
$strQuery.=" union select `prod_name`,prod_img from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='".$_COOKIE["city"]."' and users.is_active='Y' and product.is_active='Y' and  loc_zip like '%".$search_val."%'";

//echo $strQuery;
    $res=mysqli_query($this->con,$strQuery);
    $output= mysqli_fetch_all($res,MYSQLI_ASSOC);
    return $output;

/*    if($output!="")
        $this->response($this->json($output), 200);    
	else
		$this->response($this->json(array("status"=>"Bad Request")), 400);        
*/
}

private function newArrivals(){
         $obj= json_decode($_REQUEST["obj"]);
     $city=$obj->city;
     $type=$obj->type;
     
     $checkquery="SELECT distinct vs_id,cat_type
 from vend_subscription,category
  WHERE  now() not BETWEEN na_from and na_to
  and category.cat_id=vend_subscription.cat_id  
   and vs_pay_status in ('Enabled','Wait4FSSAI')
	 and vs_id<>0
 order by vs_id desc ;";
//     echo "query-$checkquery-";
     $rescheck= mysqli_query($this->con, $checkquery);
     $list=array();
//     $serv_list=array();
     while($rowcheck= mysqli_fetch_array($rescheck)) {
                 $vs_id=$rowcheck[0];
         switch ($type) {
             case "Product": 
                 $queryProduct="SELECT distinct prod_name,product.prod_id as 'prod_id',bname as 'vendor',
                prod_img,mrp+(mrp*(tax_table.cgst/100))+(mrp*(tax_table.sgst/100))+ (mrp*(tax_table.cess/100)) as 'mrp',
                product.vs_id as 'vs_id',
                date_format(vend_subscription.na_from,'%d/%m/%Y') as 'na_from',date_format(vend_subscription.na_to,'%d/%m/%Y') as 'na_to',vs_pay_status as 'vendor_status',
                prod_qty,prod_unit
                from tax_table,product,users,vend_subscription,product_price
                where tax_table.hsn_code=product.hsn_code
                and product_price.prod_id=product.prod_id
                and vend_subscription.u_id=users.u_id
                and product.vs_id=vend_subscription.vs_id
                and vend_subscription.vs_id=$vs_id
                 and product.vs_id<>0
                 and users.is_active='Y'
                 and product.is_active='Y'
                 and vs_pay_status in ('Enabled','Wait4FSSAI')
                 and  city_served='$city' order by prod_id desc limit 3;";

    $resprod=mysqli_query($this->con,$queryProduct);
    $outputprod= mysqli_fetch_all($resprod,MYSQLI_ASSOC);
    
    if($outputprod!="")
    $list= array_merge($list,$outputprod);

                 break;
             
             case "Service": 
                 $queryService="SELECT distinct serv_name,service.serv_id,bname,serv_img,service.area_served,service.vs_id,
                        date_format(vend_subscription.na_from,'%d/%m/%Y'),date_format(vend_subscription.na_to,'%d/%m/%Y'),vs_pay_status
                        from service,cat_sub,users,vend_subscription where vend_subscription.u_id=users.u_id
                        and service.vs_id=vend_subscription.vs_id
                        and service.vs_id<>0
                        and users.is_active='Y'
                        and service.is_active='Y'
                        and vs_pay_status in ('Enabled','Wait4FSSAI')
                        and city_served='$city'"
                         . " and vend_subscription.vs_id=$vs_id
                         order by serv_id desc limit 3;";

    $resserv=mysqli_query($this->con,$queryService);
    $outputserv= mysqli_fetch_all($resserv,MYSQLI_ASSOC);
    
    if($outputserv!="")
    $list= array_merge($list,$outputserv);

                 break;

             default:
                 break;
         }
     }

//     $array=array();
//     $array["new_products"]=$prod_list;
//     $array["new_services"]=$serv_list;

    if($list!="")
        $this->response($this->json($list), 200);    
	else
		$this->response($this->json(array("status"=>"Bad Request")), 400);        

}

private function foodSubCategories(){
         $obj= json_decode($_REQUEST["obj"]);
     $city=$obj->city;
//     $type=$obj->type;
     $querycheck="select distinct cat_name
         from category,vend_subscription,users,product
         where vend_subscription.cat_id=category.cat_id
        and users.u_id=vend_subscription.u_id
        and users.is_active='Y'
 and city_served='$city'
 and product.vs_id=vend_subscription.vs_id
 and product.is_active='Y'
 and cat_name in ('Food Items','Bakery Items')
 and vs_pay_status in ('Enabled','Wait4FSSAI')
         and category.cat_id<>0;";
     $rescheck= mysqli_query($this->con, $querycheck);
     
     $list=array();
     while($rowcheck= mysqli_fetch_array($rescheck)) {
     
     $query="SELECT distinct cs_name,category.cat_id,cat_name,prod_img
 from category, cat_sub as cs,vend_subscription,product,users
 where vend_subscription.cat_id=category.cat_id
 and category.cat_id=cs.cat_id
 and city_served='$city'
 and cs_name <>cat_name
 and product.vs_id=vend_subscription.vs_id
 and users.u_id=vend_subscription.u_id
 and users.is_active='Y'
 and product.is_active='Y'
 and vs_pay_status in ('Enabled','Wait4FSSAI')
 and category.cat_id<>0
and prod_img=(select prod_img from product,cat_sub where cs.cs_id=cat_sub.cs_id and product.cs_id=cs.cs_id order by rand() limit 1)
  and category.cat_name='".$rowcheck[0]."'
  order by cat_id,cs_name;";
//     echo "query-$query-";
     $res= mysqli_query($this->con, $query);
//     $serv_list=array();
     $row= mysqli_fetch_all($res,MYSQLI_ASSOC);
     $list= array_merge($list,$row);
     }
//         print_r($list);

//     $array=array();
//     $array["new_products"]=$prod_list;
//     $array["new_services"]=$serv_list;

         if($list!="")
        $this->response($this->json($list), 200);    
	else
		$this->response($this->json(array("status"=>"Bad Request")), 400);        
}

/*
private function productSubCategories(){
         $obj= json_decode($_REQUEST["obj"]);
     $city=$obj->city;
//     $type=$obj->type;
     $querycheck="select distinct cat_name
         from category,vend_subscription,users,product
         where vend_subscription.cat_id=category.cat_id
        and users.u_id=vend_subscription.u_id
        and users.is_active='Y'
 and product.vs_id=vend_subscription.vs_id
 and product.is_active='Y'
 and vs_pay_status in ('Enabled','Wait4FSSAI')
         and category.cat_id<>0;";
     $rescheck= mysqli_query($this->con, $querycheck);
     
     $list=array();
     while($rowcheck= mysqli_fetch_array($rescheck)) {
     
     $query="SELECT distinct cs_name,category.cat_id,cat_name
 from category, cat_sub,vend_subscription,product,users
 where vend_subscription.cat_id=category.cat_id
 and category.cat_id=cat_sub.cat_id
 and city_served='$city'
 and cs_name <>cat_name
 and product.vs_id=vend_subscription.vs_id
 and users.u_id=vend_subscription.u_id
 and users.is_active='Y'
 and product.is_active='Y'
 and vs_pay_status in ('Enabled','Wait4FSSAI')
 and category.cat_id<>0
 and category.cat_name='".$rowcheck[0]."'
  order by cat_id,cs_name;";
//     echo "query-$query-";
     $res= mysqli_query($this->con, $query);
//     $serv_list=array();
     $row= mysqli_fetch_all($res,MYSQLI_ASSOC);
     $list[$rowcheck[0]]=$row;
     }
//         print_r($list);

//     $array=array();
//     $array["new_products"]=$prod_list;
//     $array["new_services"]=$serv_list;

         if($list!="")
        $this->response($this->json($list), 200);    
	else
		$this->response($this->json(array("status"=>"Bad Request")), 400);        
}
*/
private function foodType(){
         $obj= json_decode($_REQUEST["obj"]);
     $cat_id=$obj->cat_id;
     $prod_id="";
     if(isset($obj->prod_id)!=0)
     $prod_id=$obj->prod_id;
    $strQuery4="select DISTINCT product.prod_id,prod_name,prod_desc,prod_img,V,N,mrp
from product,food_program,food_type,category,product_price
where product.prod_id=food_program.prod_id
and product_price.prod_id=product.prod_id
and category.cat_id=product.cat_id
and product.prod_id=food_type.prod_id
and category.cat_id=$cat_id";
    if($prod_id!="")
        $query.=" and product.prod_id<>$prod_id;";
    else
        $query.=";";

//    echo $strQuery4;
    if($res=mysqli_query($this->con,$strQuery4)) {
    $output=array();
    $output= mysqli_fetch_all($res,MYSQLI_ASSOC);
    $this->response($this->json($output), 200);    
    }
	else
		$this->response($this->json(array("status"=>"Bad Request")), 400);        
}

private function prodDetails(){
         $obj= json_decode($_REQUEST["obj"]);
     $prod_id=$obj->prod_id;
    $strQuery4="select DISTINCT prod_name,prod_desc,cat_img,V,N,prod_qty,prod_unit,mrp,options,to_select
from product,food_program,food_type,product_price,category
where product.prod_id=food_program.prod_id
and product.prod_id=product_price.prod_id
and product.cat_id=category.cat_id
and product.prod_id=food_type.prod_id
and product.prod_id=$prod_id";
                    

//    echo $strQuery4;
    if($res=mysqli_query($this->con,$strQuery4)) {
    $output=array();
    $output= mysqli_fetch_all($res,MYSQLI_ASSOC);
    $this->response($this->json($output), 200);    
    }
	else
		$this->response($this->json(array("status"=>"Bad Request")), 400);        
}

private function prodOptions(){
         $obj= json_decode($_REQUEST["obj"]);
     $prod_id=$obj->prod_id;
    $strQuery4="select po_id,prod_option from prod_options where prod_id=$prod_id";
                    

//    echo $strQuery4;
    if($res=mysqli_query($this->con,$strQuery4)) {
    $output=array();
    $output= mysqli_fetch_all($res,MYSQLI_ASSOC);
    $this->response($this->json($output), 200);    
    }
	else
		$this->response($this->json(array("status"=>"Bad Request")), 400);        
}

private function bookSlot(){
            $strQuery4="select bs_id,bs_from,bs_to from booking_slots order by bs_id;";
                    

//    echo $strQuery4;
    if($res=mysqli_query($this->con,$strQuery4)) {
    $output=array();
    $output= mysqli_fetch_all($res,MYSQLI_ASSOC);
    $this->response($this->json($output), 200);    
    }
	else
		$this->response($this->json(array("status"=>"Bad Request")), 400);        
}

private function cartDisplay(){
             $obj= json_decode($_REQUEST["obj"]);
     $cust_id=$obj->cust_id;
    
    $strQuery4="select prod_id,options,qty,bs_id,cart_id from cart where cust_id=$cust_id;";
                    

//    echo $strQuery4;
    if($res=mysqli_query($this->con,$strQuery4)) {
    $output=array();
    $output= mysqli_fetch_all($res,MYSQLI_ASSOC);
    $this->response($this->json($output), 200);    
    }
	else
		$this->response($this->json(array("status"=>"Bad Request")), 400);        
}

private function cartProd(){
             $obj= json_decode($_REQUEST["obj"]);
     $prod_id=$obj->prod_id;
    
    $strQuery4="select prod_name,prod_desc,cat_img,V,G,mrp,options,to_select from product,product_price,food_type,category where category.cat_id=product.cat_id and product.prod_id=product_price.prod_id and product.prod_id=food_type.prod_id and product.prod_id=".$prod_id.";";
                    

//    echo $strQuery4;
    if($res=mysqli_query($this->con,$strQuery4)) {
    $output=array();
    $output= mysqli_fetch_all($res,MYSQLI_ASSOC);
    $this->response($this->json($output), 200);    
    }
	else
		$this->response($this->json(array("status"=>"Bad Request")), 400);        
}

private function countSlots(){
             $obj= json_decode($_REQUEST["obj"]);
     $cust_id=$obj->cust_id;
    
    $strQuery4="select distinct cart.bs_id,bs_from,bs_to from cart,product,booking_slots where booking_slots.bs_id=cart.bs_id and cart.prod_id=product.prod_id and cust_id=$cust_id ;";
                    

//    echo $strQuery4;
    if($res=mysqli_query($this->con,$strQuery4)) {
    $output=array();
    $output= mysqli_fetch_all($res,MYSQLI_ASSOC);
    $this->response($this->json($output), 200);    
    }
	else
		$this->response($this->json(array("status"=>"Bad Request")), 400);        
}

/*
     *  Encode array into JSON
    *
    private function json($data){
        if(is_array($data)){
            return json_encode($data);
        }
    }*/
}
?>