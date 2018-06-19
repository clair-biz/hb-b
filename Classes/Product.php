    <?php
spl_autoload_register(function ($class) {
    include '' . $class . '.php';
});

class Product extends Base{
private $prod_name;    
private $prod_desc;
private $cs_id;
private $prod_min_time;
private $prod_unit;
private $prod_qty;
private $weight;
private $is_delivery_provided;
private $area_served;
private $vs_id;
private $hsn_code;
private $prod_replace;
private $prod_return;
private $r_within;
private $user;


  public function __get($property) {
    if (property_exists($this, $property)) {
      return $this->$property;
    }
  }

  public function __set($property, $value) {
    if (property_exists($this, $property)) {
      $this->$property = $value;
    }
  }
    

/*
public static function chkSupl($val){
    $check=0;
   
     $q="select count(*) from  vendor where vs_id=".val.";");
    //Statement ename = con().createStatement();
   // ResultSet rs=ename.executeQuery(q);
            if($row=mysqli_fetch_array($q)) {
                if($row[0]>0)
                    $check=1;
                
            }
            mysqli_free_result($q);
            //ename.close();
        return $check;
}

/*public function canInsert() {
    $check=0;
    //if(Location.chkLoc(loc_zip) && Warehouse.chkWh(nearest_wh_id)) {
    $q="select count(*) from  product where prod_name='".$prod_name."' and prod_desc='".$prod_desc."' and vend_email='".$vend_email."'");
    //Statement ename = con().createStatement();
    //ResultSet rs=ename.executeQuery(q);
    if($row=mysqli_fetch_array($q))
        if($row[0]==0)
            $check=1;
             mysqli_free_result($q);
            //ename.close();
   }
    return $check;
}

public function cantInsert(){
    $check="";
    //try {
        if(!Location.chkLoc(loc_zip))
            $check.="Invalid Zip Code!";
        if(!Warehouse.chkWh(nearest_wh_id))
            $check.="Invalid Warehouse Id!";
    if(Location.chkLoc(loc_zip) && Warehouse.chkWh(nearest_wh_id)) {
    $q="select count(*) from  vendor where vend_fname='".$vend_fname."' and vend_lname='".$vend_lname."' and vend_email='".$vend_email."'");
//Statement ename = con().createStatement();
    //ResultSet rs=ename.executeQuery(q);
    if($row=mysqli_fetch_array($q))
        if($row[0]>0)
            $check.="Already exists!";
            mysqli_free_result($q);
            //ename.close();
    }
    
    
    return $check;
}*/

public function Insert() {
    $check=false;
    $q="INSERT INTO product(prod_name,prod_desc,";
    if(isset($this->prod_img)!="")
        $q.="prod_img,";
    $q.="cs_id,";
    if(isset($this->prod_min_time)!="" && !empty($this->prod_min_time))
    $q.="prod_min_time,";
    
    $q.="prod_unit,prod_qty,is_delivery_provided,";

    if(isset($this->area_served)!="")
        $q.="area_served,";

    if(isset($this->prod_replace)!="")
        $q.="prod_replace,";

    if(isset($this->prod_return)!="")
        $q.="prod_return,";

    if(isset($this->r_within)!="")
        $q.="r_within,";
    
    if(isset($this->weight)!="")
        $q.="weight,";

    $q.="vs_id,hsn_code,ins_dt,ins_usr) values ('".mysqli_real_escape_string($this->con,$this->prod_name)."','".mysqli_real_escape_string($this->con,$this->prod_desc)."',";
    
    if(isset($this->prod_img)!="")
        $q.="'".$this->prod_img."',";
    $q.=$this->cs_id.",";
    
    if(isset($this->prod_min_time)!="" && !empty($this->prod_min_time))
    $q.=$this->prod_min_time.",";
    
    $q.="'".$this->prod_unit."',".$this->prod_qty.",'".$this->is_delivery_provided."',";

    if(isset($this->area_served)!="")
    $q.="'".$this->area_served."',";

    if(isset($this->prod_replace)!="")
    $q.="'".$this->prod_replace."',";

    if(isset($this->prod_return)!="")
    $q.="'".$this->prod_return."',";

    if(isset($this->r_within)!="")
    $q.=$this->r_within.",";

    if(isset($this->weight)!="")
    $q.="'".$this->weight."',";

    $q.= $this->vs_id.",".$this->hsn_code.",now(),'".$this->user."')";
	echo $q;
    if(mysqli_query($this->con,$q))
      $check=true;
                 mysqli_close($this->con);
      return $check;
}

public function Update($id){
//    boolean check=0;
    $r=0;
    $ename.="";
    if($this->prod_name!="") {
        $ename.="update product set prod_name='".mysqli_real_escape_string($this->con,$this->prod_name)."',upd_dt=now(),upd_usr='".$this->user."' where prod_id=$id; ";
    }
    if($this->prod_desc!="") {
        $ename.="update product set prod_desc='".mysqli_real_escape_string($this->con,$this->prod_desc)."',upd_dt=now(),upd_usr='".$this->user."' where prod_id=$id; ";
    }
    if($this->cs_id!="") {
        $ename.="update product set cs_id='".$this->cs_id."',upd_dt=now(),upd_usr='".$this->user."' where prod_id=$id; ";
    }
    if($this->prod_min_time!="") {
        $ename.="update product set prod_min_time=cast(N'".$this->prod_min_time."' as time),upd_dt=now(),upd_usr='".$this->user."' where prod_id=$id; ";
    }
    if($this->prod_unit!="") {
        $ename.="update product set prod_unit='".$this->prod_unit."',upd_dt=now(),upd_usr='".$this->user."' where prod_id=$id; ";
    }
    if($this->prod_qty!="") {
        $ename.="update product set prod_qty='".$this->prod_qty."',upd_dt=now(),upd_usr='".$this->user."' where prod_id=$id; ";
       }
    if($this->hsn_code!="") {
        $ename.="update product set hsn_code='".$this->hsn_code."',upd_dt=now(),upd_usr='".$this->user."' where prod_id=$id; ";
    }
    if($this->prod_replace!="") {
        $ename.="update product set prod_replace='".$this->prod_replace."',upd_dt=now(),upd_usr='".$this->user."' where prod_id=$id; ";
    }
    if($this->prod_return!="") {
        $ename.="update product set prod_return='".$this->prod_return."',upd_dt=now(),upd_usr='".$this->user."' where prod_id=$id; ";
    }
    if($this->r_within!="") {
        $ename.="update product set r_within=".$this->r_within.",upd_dt=now(),upd_usr='".$this->user."' where prod_id=$id; ";
    }
//    echo $ename;
        if(mysqli_multi_query($this->con,$ename))
            $r=1;
     
                 mysqli_close($this->con);
    return $r;

}


public static function getprodidbyname($name){
    $obj=new Base;
    $strQuery4="select prod_id from product where prod_name='$name'";
//    echo $strQuery4;
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close($obj->con);
    return $id;
}

public static function getservidbyname($name){
    $obj=new Base;
    $strQuery4="select serv_id from service where serv_name='$name'";
//    echo $strQuery4;
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close($obj->con);
    return $id;
}

public static function getvendidbyprodid($id){
    $obj=new Base;
    $strQuery4="select product.vs_id from vendor,users,product,vend_subscription where product.vs_id=vend_subscription.vs_id and users.u_id=vend_subscription.u_id and prod_id=$id";
//    echo $strQuery4;
    $id=0;
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close($obj->con);
    return $id;
}

public static function getleadtime($id){
    $obj=new Base;
    $strQuery4="select prod_min_time from product where prod_id=$id";
//    echo $strQuery4;
    $id=0;
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close($obj->con);
    return $id;
}

public static function canReturn($id,$type){
    $obj=new Base;
    $obj=new Base;
    $strQuery4="select $type from product where prod_id=$id";
//    echo $strQuery4;
    $id=FALSE;
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res))
                if($row[0]=="Y")
                $id=TRUE;
                 mysqli_close($obj->con);
    return $id;
}


public static function getprodnamebyid($id){
    $obj=new Base;
    $strQuery4="select prod_name from product where prod_id=$id";
//    echo $strQuery4;
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close($obj->con);
    return $id;
}
public static function getservnamebyid($id){
    $obj=new Base;
    $strQuery4="select serv_name from service where serv_id=$id";
//    echo $strQuery4;
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close($obj->con);
    return $id;
}

public static function getprodimgbyname($name){
    $obj=new Base;
    $strQuery4="select prod_img from product where prod_name='$name' order by rand() limit 1";
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res)) {
                 mysqli_close($obj->con);
    return $row[0];
        }
}

public static function getcategory($name){
    $obj=new Base;
    $strQuery4="select cat_name from category,cat_sub,product where category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and prod_name='$name'";
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res)) {
                 mysqli_close($obj->con);
    return $row[0];
        }
}

public static function getsubcat($name){
    $obj=new Base;
    $strQuery4="select cs_name from product,cat_sub where cat_sub.cs_id=product.cs_id and prod_name='$name'";
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res)) {
                 mysqli_close($obj->con);
    return $row[0];
        }
}

public static function getCartCount($cust_id){
    $obj=new Base;
    $strQuery4="select count(*) from cart where cust_id=$cust_id";
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res)) {
                 mysqli_close($obj->con);
    return $row[0];
}
}

public static function setOfflinePeriod($prod_id,$na_from,$na_to) {
    $obj=new Base;
	$q="update product set na_from=cast(N'$na_from' as date), na_to=cast(N'$na_to' as date) where prod_id=$prod_id";
	echo $q;
        $ret=false;
	if(mysqli_query($obj->con,$q))
		$ret=true;

                 mysqli_close($obj->con);
        return $ret;
}

public static function checkOfflinePeriod($prod_id) {
    $obj=new Base;
	$q="SELECT count(*) from product WHERE now() BETWEEN na_from and na_to and prod_id=$prod_id";
//	echo $q;
        $ret=0;
	$res=mysqli_query($obj->con,$q);
        if($row= mysqli_fetch_array($res))
		$ret=$row[0];

                 mysqli_close($obj->con);
        return $ret;
}

public static function getMaxRWithin($ord_id) {
    $obj=new Base;
	$q="SELECT max(r_within) from product,order_detail WHERE product.prod_id=order_detail.prod_id and ord_id=$ord_id";
	echo $q;
        $ret=0;
	$res=mysqli_query($obj->con,$q);
        if($row= mysqli_fetch_array($res))
		$ret=$row[0];

                 mysqli_close($obj->con);
        return $ret;
}

public static function getTaxAmtFromOrder($ord_id,$field) {
    $obj=new Base;
	$q="SELECT sum($field) from order_detail WHERE ord_id=$ord_id";
//	echo $q;
        $ret=0;
	$res=mysqli_query($obj->con,$q);
        if($row= mysqli_fetch_array($res))
		$ret=$row[0];

                 mysqli_close($obj->con);
        return $ret;
}

public static function canSettle($ord_id) {
    $obj=new Base;
    $int=Product::getMaxRWithin($ord_id);
	$q="SELECT count(*) from ordertbl WHERE now() > date_add(delivery_date,interval $int day) and ord_id=$ord_id";
//	echo $q;
        $ret=0;
	$res=mysqli_query($obj->con,$q);
        if($row= mysqli_fetch_array($res))
		$ret=$row[0];

                 mysqli_close($obj->con);
        return $ret;
}


/*public static function getsuplemailbyid($id){
     $vend_email="";
//Statement stmtcust=con().createStatement();
//ResultSet cust=stmtcust.executeQuery("Select cust_id from customer where cust_fname like '".scust."%' and cust_lname like '%".scust."'");
    $cust =mysqli_prepare($obj->con,"Select vend_email from vendor where vs_id=?");
    mysqli_stmt_bind_param($cust,$id);
        //ResultSet rscust = cust.executeQuery();                        

        if($row=mysqli_fetch_array($cust)) {
            $vend_email=$row[1];
        }          
//        rscust.close();
  //      cust.close();
        return $vend_email;
}*/

public static function getprodimgbycsname($name){
    $obj=new Base;
    $strQuery4="select prod_id from product,cat_sub,users,vend_subscription where vend_subscription.u_id=users.u_id and vend_subscription.vs_id=product.vs_id and product.cs_id=cat_sub.cs_id and users.is_active='Y' and cs_name='$name' order by rand() limit 1";
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res)) {
                 mysqli_close($obj->con);
    return "product_".$row[0].".jpg";
        }
}

public static function isAvailable($search_val){
    $obj=new Base;
$strQuery1="select  `prod_name` from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='".$_COOKIE["city"]."' and users.is_active='Y' and prod_name like '%".$search_val."%'";
$strQuery1.=" union select `prod_name` from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='".$_COOKIE["city"]."' and users.is_active='Y' and  product.area_served like '%".$search_val."%'";
$strQuery1.=" union select `prod_name` from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='".$_COOKIE["city"]."' and users.is_active='Y' and  bname like '%".$search_val."%'";
$strQuery1.=" union select `prod_name` from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='".$_COOKIE["city"]."' and users.is_active='Y' and  cs_name like '%".$search_val."%'";
$strQuery1.=" union select `prod_name` from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='".$_COOKIE["city"]."' and users.is_active='Y' and  cat_name like '%".$search_val."%'";
$strQuery1.=" union select `prod_name` from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='".$_COOKIE["city"]."' and users.is_active='Y' and  vend_addr like '%".$search_val."%'";
$strQuery1.=" union select `prod_name` from  product,cat_sub,vendor,category,vend_subscription,users WHERE vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and category.cat_id=cat_sub.cat_id and cat_sub.cs_id=product.cs_id and vend_subscription.vs_id=product.vs_id and city_served ='".$_COOKIE["city"]."' and users.is_active='Y' and  loc_zip like '%".$search_val."%'";

    $res=mysqli_query($obj->con,$strQuery1);
    $count=mysqli_num_rows($res);
//    echo $count;
                 mysqli_close($obj->con);
    return $count;
    
}

public function toString() {
    return $prod_name." ".$prod_desc." ".$prod_cat_main." ".$prod_cat_sub." ".$prod_img." ".$prod_min_time." ".$prod_unit." ".$prod_qty." ".$user;
}




}
