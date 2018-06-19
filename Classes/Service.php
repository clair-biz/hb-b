<?php
spl_autoload_register(function ($class) {
    include '' . $class . '.php';
});


class Service extends Base {
private $serv_name;    
private $serv_desc;
private $area;
private $vs_id;
private $cs_id;
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
    $check=0;
    $q="INSERT INTO service(serv_name,serv_desc,cs_id,";
    
    if($this->area!="" )
        $q.="area_served,";
    $q.="vs_id,ins_dt,ins_usr) values ('".mysqli_real_escape_string($this->con,$this->serv_name)."','".mysqli_real_escape_string($this->con,$this->serv_desc)."',".$this->cs_id.",";
    
    if($this->area!="" )
        $q.="'".$this->area."',";
    
    $q.=$this->vs_id.",now(),'".$this->user."')";
	echo $q;
    if(mysqli_query($this->con,$q))
      $check=1;
                 mysqli_close($this->con);
      return $check;
}

public function Update($id){
//    boolean check=0;
    $r=0;
    
    if($this->serv_name!="") {
        $ename="update service set serv_name='".mysqli_real_escape_string($this->con,$this->serv_name)."',upd_dt=now(),upd_usr='".$this->user."' where serv_id=$id";
        if(mysqli_query($this->con,$ename)){
            $r++;
       }

    }
    if($this->serv_desc!="") {
        $ename="update service set serv_desc='".mysqli_real_escape_string($this->con,$this->serv_desc)."',upd_dt=now(),upd_usr='".$this->user."' where serv_id=$id";
        if(mysqli_query($this->con,$ename)){
            $r++;
       }
    }
    if($this->cs_id!="") {
        $ename="update service set cs_id='".$this->cs_id."',upd_dt=now(),upd_usr='".$this->user."' where serv_id=$id";
        if(mysqli_query($this->con,$ename)){
            $r++;
       }

    }
                 mysqli_close($this->con);
    return $r;
}

/*public static function getcatnamebyid($id) {
    $strQuery4="select cat_name from category where cs_id=$id";
//    echo $strQuery4;
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
    return $id;
}*/

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

public static function getvendidbyservid($id){
     $obj=new Base;
    $strQuery4="select vendor.vs_id from vendor,users,service where service.vs_id=users.u_id and users.vs_id=vendor.vs_id and serv_id=$id";
//    echo $strQuery4;
    $id=0;
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close($obj->con);
    return $id;
}

public static function getservimgbyname($name){
     $obj=new Base;
    $strQuery4="select serv_img from service where serv_name='$name'";
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res)) {
                 mysqli_close($obj->con);
    return $row[0];
        }
}


public static function getservimgbycsname($name){
     $obj=new Base;
    $strQuery4="select serv_img from service,cat_sub,users where service.cs_id=cat_sub.cs_id and users.is_active='Y' and cs_name='$name' order by rand() limit 1";
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res)) {
                 mysqli_close($obj->con);
    return $row[0];
        }
}


public static function setOfflinePeriod($prod_id,$na_from,$na_to) {
     $obj=new Base;
	$q="update service set na_from=cast(N'$na_from' as date), na_to=cast(N'$na_to' as date) where serv_id=$serv_id";
	echo $q;
        $ret=false;
	if(mysqli_query($obj->con,$q))
		$ret=true;

                 mysqli_close($obj->con);
        return $ret;
}

public static function checkOfflinePeriod($prod_id) {
     $obj=new Base;
	$q="SELECT count(*) from service WHERE now() BETWEEN na_from and na_to and serv_id=$serv_id";
//	echo $q;
        $ret=0;
	$res=mysqli_query($obj->con,$q);
        if($row= mysqli_fetch_array($res))
		$ret=$row[0];

                 mysqli_close($obj->con);
        return $ret;
}



/*public static function getprodnamebyid($id){
    $strQuery4="select prod_name from product where prod_id=$id";
//    echo $strQuery4;
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
    return $id;
}

public static function getprodimgbyname($name){
    $strQuery4="select prod_img from product where prod_name='$name'";
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res))
    return $row[0];
}

public static function getcategory($name){
    $strQuery4="select cat_name from category,cat_sub,product where category.cs_id=cat_sub.cs_id and cat_sub.cs_id=product.cs_id and prod_name='$name'";
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res))
    return $row[0];
}

public static function getsubcat($name){
    $strQuery4="select cs_name from product,cat_sub where cat_sub.cs_id=product.cs_id and prod_name='$name'";
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res))
    return $row[0];
}

public static function getcsnamebyid($id){
    $strQuery4="select cs_name from cat_sub where cs_id=$id";
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res))
    return $row[0];
}

public static function getCartCount($cust_id){
    $strQuery4="select count(*) from cart where cust_id=$cust_id";
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res))
    return $row[0];
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
}

public static function getprodimgbycsname($name){
    $strQuery4="select prod_img from product,cat_sub where product.cs_id=cat_sub.cs_id and cs_name='$name' limit 1";
    $res=mysqli_query($obj->con,$strQuery4);
        if($row= mysqli_fetch_array($res))
    return $row[0];
}*/

public static function isAvailable($search_val){
     $obj=new Base;
$strQuery1="select  `serv_name` from  service,vendor,category,vend_subscription,users,cat_sub  WHERE category.cat_id=cat_sub.cat_id and service.cs_id=cat_sub.cs_id and vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and vend_subscription.vs_id=service.vs_id and users.is_active='Y' and  serv_name like '%".$search_val."%'";
$strQuery1.=" union select `serv_name` from  service,vendor,category,vend_subscription,users,cat_sub WHERE category.cat_id=cat_sub.cat_id and service.cs_id=cat_sub.cs_id and vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and vend_subscription.vs_id=service.vs_id and users.is_active='Y' and  bname like '%".$search_val."%'";
$strQuery1.=" union select `serv_name` from  service,vendor,category,vend_subscription,users,cat_sub WHERE category.cat_id=cat_sub.cat_id and service.cs_id=cat_sub.cs_id and vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and vend_subscription.vs_id=service.vs_id and users.is_active='Y' and  cs_name like '%".$search_val."%'";
$strQuery1.=" union select `serv_name` from  service,vendor,category,vend_subscription,users,cat_sub WHERE category.cat_id=cat_sub.cat_id and service.cs_id=cat_sub.cs_id and vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and vend_subscription.vs_id=service.vs_id and users.is_active='Y' and  cat_name like '%".$search_val."%'";
$strQuery1.=" union select `serv_name` from  service,vendor,category,vend_subscription,users,cat_sub WHERE category.cat_id=cat_sub.cat_id and service.cs_id=cat_sub.cs_id and vend_subscription.u_id=users.u_id and vendor.vend_id=users.vend_id and vend_subscription.vs_id=service.vs_id and users.is_active='Y' and  city_served like '%".$search_val."%'";

    $res=mysqli_query($obj->con,$strQuery1);
    $count=mysqli_num_rows($res);
//    echo $count;
                 mysqli_close($obj->con);
    return $count;    
}

public function toString() {
    return $serv_name." ".$serv_desc." ".$logo." ".$serv_file." ".$cs_id." ".$vs_id." ".$user;
}




}
