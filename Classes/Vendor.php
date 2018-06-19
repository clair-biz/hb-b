<?php
spl_autoload_register(function ($class) {
    include '' . $class . '.php';
});


class Vendor extends Base {
private $vend_id;    
private $vend_fname;    
private $vend_cntc;    
private $is_cntc_validated;    
private $vend_email;
private $is_email_validated;
private $vend_addr;
private $loc_zip;
private $vend_dob;
private $u_id;
private $cat_id;
private $other_cat;
private $vend_open_time;
private $vend_close_time;
private $city_served;
private $area_served;
private $bname;
private $fssai_no;
private $vs_for;
private $pwd;
private $u_name;
private $vs_id;
private $vs_subtotal;
private $vs_total;
private $vs_tax;
private $vs_pay_status;
private $na_from;
private $na_to;

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
    
public function Insert(){
    $p=false;
    $q = "insert into vendor(vend_id,vend_fname,vend_cntc,is_cntc_validated,vend_email,is_email_validated,vend_addr,loc_zip,vend_dob,ins_dt,ins_usr)";
   $q.="values(".$this->vend_id.",'".$this->vend_fname."',".$this->vend_cntc.",'".$this->is_cntc_validated."','".$this->vend_email."','".$this->is_email_validated."','".$this->vend_addr."',".$this->loc_zip.",cast(N'".$this->vend_dob."' as date),now(),'".$this->u_name."')";
      echo "<br />Insert vendor ".$q;

      if(Base::generateResult($q))
      $p=true;
   return $p;
}

public function Update($id){
//   boolean check=false;
    $r=false;
    $q="";
    if($this->vend_fname!="") {
        $q.="update vendor set vend_fname='".$this->vend_fname."',upd_dt=now(),upd_usr='".$this->u_name."' where vend_id=$id; ";
    }
    if($this->vend_lname!="") {    
        $q.="update vendor set vend_lname='".$this->vend_lname."',upd_dt=now(),upd_usr='".$this->u_name."' where vend_id=$id; ";
    }
    if($this->vend_cntc!=0) {
        $q.="update vendor set vend_cntc=".$this->vend_cntc.",upd_dt=now(),upd_usr='".$this->u_name."' where vend_id=$id; ";
    }
    if($this->vend_email!="") {    
        $q.="update vendor set vend_email='".$this->vend_email."',upd_dt=now(),upd_usr='".$this->u_name."' where vend_id=$id; ";
    }
    
    if($this->vend_addr!="") {
        $q.="update vendor set vend_addr='".$this->vend_addr."',upd_dt=now(),upd_usr='".$this->u_name."' where vend_id=$id; ";
    }
    
     if($this->loc_zip!=0) {
        $q.="update vendor set loc_zip=".$this->loc_zip.",upd_dt=now(),upd_usr='".$this->u_name."' where vend_id=$id; ";
    }
    
     if($this->bname!=0) {
        $q.="update vend_subscription set bname='".$this->bname."',upd_dt=now(),upd_usr='".$this->u_name."' where vs_id=".$this->vs_id." ;";
    }
    //echo $q;
        if(Base::generateMultiResult($q)){
      $r=true;
        }
     
//    echo $msg;
    return $r;
}
/*
public static function getvendnamebyid($uname) {
	$q="select disp_name from users where u_name='$uname'";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
	else
		
	return $id;
}
*/

public static function isfssairegistered($uname){
    $obj=new Base;
                if(strstr($uname,"@administrator")) {
//            $admin=$user;
                    $user0= explode("@administrator", $uname);
                    $uname=$user0[0];
                }

    
    $q="select count(*) from users,vend_subscription where users.u_id=vend_subscription.u_id and vend_subscription.vs_pay_status='Wait4FSSAI' and users.is_active='Y' and u_name='$uname'";    
            $ret=0;
	$res=Base::generateResult($q);
        if($row= mysqli_fetch_array($res))
		$ret=$row[0];

                 
        return $ret;

}


public static function getvendnamebyunamefromvendor($uname) {
    $obj=new Base;
  $q="select vend_fname from vendor,users where vendor.vend_id=users.vend_id and u_name='$uname'";
//  echo $q;
  $res=Base::generateResult($q);
  if($row=mysqli_fetch_array($res))
    $id=$row[0];
                 
  return $id;
}

public static function getvendareaserved($id) {
    $obj=new Base;
	$q="select area_served from vend_subscription where u_id=$id";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function setOfflinePeriod($vs_id,$na_from,$na_to) {
    $obj=new Base;
	$q="update vend_subscription set na_from=cast(N'$na_from' as date), na_to=cast(N'$na_to' as date)  where vs_id=$vs_id";
//	echo $q;
        $ret=false;
	if(Base::generateResult($q))
		$ret=true;

                 
        return $ret;
}

public static function setOrderFullDate($vs_id,$na_date) {
    $obj=new Base;
	$q="insert into vend_unavail(vs_id,vu_date,ins_dt,ins_usr) values ($vs_id,cast(N'$na_date' as date),now(),'".$_SESSION["user"]."');";
	echo $q;
        $ret=false;
	if(Base::generateResult($q))
		$ret=true;

                 
        return $ret;
}

public static function checkOfflinePeriod($vs_id) {
    $obj=new Base;
	$q="SELECT count(*) from vend_subscription WHERE  now() BETWEEN na_from and na_to and vs_pay_status in ('Enabled','Wait4FSSAI') and  vs_id=$vs_id";
//	echo $q;
        $ret=0;
	$res=Base::generateResult($q);
        if($row= mysqli_fetch_array($res))
		$ret=$row[0];

                 
        return $ret;
}

public static function getvendnamebyuname($uname) {
    $obj=new Base;
                if(strstr($uname,"@administrator")) {
//            $admin=$user;
                    $user0= explode("@administrator", $uname);
                    $uname=$user0[0];
                }

	$q="select vend_fname from users,vendor where vendor.vend_id=users.vend_id and u_type='Vendor' and u_name='$uname'";
	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];

        
	return $id;
}

public static function getvendcntcbyprodid($id) {
    $obj=new Base;
	$q="select vend_cntc from users,vendor,product,vend_subscription where users.u_id=vend_subscription.u_id and product.vs_id=vend_subscription.vs_id and users.vend_id=vendor.vend_id and prod_id=$id";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getvendcntcbyuid($id) {
    $obj=new Base;
	$q="select vend_cntc from users,vendor where users.vend_id=vendor.vend_id and u_id=$id";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getvendcntcbyvendid($id) {
    $obj=new Base;
	$q="select vend_cntc from vendor where vend_id=$id";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getvendemailbyvendid($id) {
    $obj=new Base;
	$q="select vend_email from vendor where vend_id=$id";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getvendnamebyprodid($id) {
    $obj=new Base;
	$q="select bname from vend_subscription,product where product.vs_id=vend_subscription.vs_id and prod_id=$id";
//	echo $q;\
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getvendidbyvsid($id) {
    $obj=new Base;
	$q="select vend_id from vend_subscription,users where vend_subscription.u_id=users.u_id and vs_id=$id";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getbnamebyvsid($id) {
    $obj=new Base;
	$q="select bname from vend_subscription where vs_id=$id";
	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getvendnamebyid($id) {
    $obj=new Base;
	$q="select vend_fname from vendor where vend_id=$id";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getvendcntcbyservid($id) {
    $obj=new Base;
	$q="select vend_cntc from users,vendor,service,vend_subscription where users.u_id=vend_subscription.u_id and service.vs_id=vend_subscription.vs_id and users.vend_id=vendor.vend_id and serv_id=$id";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getvendnamebyservid($id) {
    $obj=new Base;
	$q="select bname from vend_subscription,service where service.vs_id=vend_subscription.vs_id and serv_id=$id";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getvendidbyuname($uname) {
    $obj=new Base;
                if(strstr($uname,"@administrator")) {
//            $admin=$user;
                    $uname0= explode("@administrator", $uname);
                    $uname=$uname0[0];
                }
    
	$q="select vend_id from users where is_active='Y' and u_name='$uname'";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getvendidbyuid($uid) {
    $obj=new Base;
	$q="select vend_id from users where u_id=$uid";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getvendidbyemail($email) {
    $obj=new Base;
	$q="select vend_id from vendor where vend_email='$email'";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getvendidbyecd($email,$cntc,$dob) {
    $obj=new Base;
	$q="select vend_id from vendor where vend_email='$email' and vend_cntc=$cntc and vend_dob=cast(N'$dob' as date);";
	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getvendcntcbyemail($email) {
    $obj=new Base;
	$q="select vend_cntc from vendor where vend_email='$email'";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}
public static function getvendcntcbyuname($uname) {
    $obj=new Base;
                if(strstr($uname,"@administrator")) {
//            $admin=$user;
                    $user0= explode("@administrator", $uname);
                    $uname=$user0[0];
                }

	$q="select vend_cntc from vendor,users where vendor.vend_id=users.vend_id and u_name='$uname'";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getvendemailbyuid($id) {
    $obj=new Base;
	$q="select vend_email from vendor,users where vendor.vend_id=users.vend_id and u_id='$id'";
	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getsubscriptionstatus($uname) {
    $obj=new Base;
                if(strstr($uname,"@administrator")) {
//            $admin=$user;
                    $user0= explode("@administrator", $uname);
                    $uname=$user0[0];
                }

	$q="select vs_pay_status from vend_subscription,users where vend_subscription.u_id=users.u_id and u_name='$uname'";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getcountofaccounts($id) {
    $obj=new Base;
	$q="select count(users.u_id) from vend_subscription,users where vend_subscription.u_id=users.u_id and is_active='Y' and vend_id=$id";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getcountofactiveaccounts($id) {
    $obj=new Base;
	$q="select count(users.u_id) from vend_subscription,users where vend_subscription.u_id=users.u_id and vs_pay_status in ('Enabled','Wait4FSSAI') and is_active='Y' and vend_id=$id";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getloczipbyvendname($name){
    $obj=new Base;
    $strQuery4="select loc_zip from vendor where vend_fname='$name'";
//    echo $strQuery4;
    $res=Base::generateResult($strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 
    return $id;
}

public static function getaddrbyvendname($name){
    $obj=new Base;
    $strQuery4="select vend_addr from vendor where vend_fname='$name'";
//    echo $strQuery4;
    $res=Base::generateResult($strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 
    return $id;
}


public static function getvstodate($id) {
    $obj=new Base;
	$q="select vs_to from vend_subscription where u_id=$id";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function is_email_validated($id) {
    $obj=new Base;
	$q="select is_email_validated from vendor where vend_id=$id";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function isVerified($id) {
    $obj=new Base;
    $ret=false;
	$q="select count(*) from vendor where is_cntc_validated='Y' and vend_id=$id";
//	$q="select count(*) from vendor where is_email_validated='Y' and is_cntc_validated='Y' and vend_id=$id";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
                if($row[0]>=1)
		$ret=true;
                 
	return $ret;
}

public static function isSubscribed($user) {
    $obj=new Base;
    $ret=false;
                if(strstr($user,"@administrator")) {
//            $admin=$user;
                    $user0= explode("@administrator", $user);
                    $user=$user0[0];
                }


	$q="select count(*) from vend_subscription,users where users.u_id=vend_subscription.u_id and now() between vs_from and vs_to and vs_pay_status in ('Enabled','Wait4FSSAI') and users.is_active='Y' and u_name='$user'";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
                if($row[0]>=1)
		$ret=true;
                 
	return $ret;
}

public static function countactiveSubscription($user) {
    $obj=new Base;
    $ret=false;
                if(strstr($user,"@administrator")) {
//            $admin=$user;
                    $user0= explode("@administrator", $user);
                    $user=$user0[0];
                }

	$q="select count(*) from vend_subscription,users where users.u_id=vend_subscription.u_id and now() between vs_from and vs_to and vs_pay_status in ('Enabled','Wait4FSSAI') and users.is_active='Y' and u_name='$user'";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$ret=$row[0];
                 
	return $ret;
}

public static function getvsidbyuname($uname) {
    $obj=new Base;
                if(strstr($uname,"@administrator")) {
//            $admin=$user;
                    $user0= explode("@administrator", $uname);
                    $uname=$user0[0];
                }

	$q="select vs_id from vend_subscription,users where users.u_id=vend_subscription.u_id and users.is_active='Y' and u_name='$uname';";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getvsidbyunamencatid($uname,$cat_id) {
    $obj=new Base;
                if(strstr($uname,"@administrator")) {
//            $admin=$user;
                    $user0= explode("@administrator", $uname);
                    $uname=$user0[0];
                }

	$q="select vs_id from vend_subscription,users where users.u_id=vend_subscription.u_id and u_name='$uname' and users.is_active='Y' and cat_id=$cat_id;";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getcatidbyvsid($id) {
    $obj=new Base;
	$q="select cat_id from vend_subscription where vs_id=$id;";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getcattypebyvsid($id) {
    $obj=new Base;
	$q="select cat_type from vend_subscription,category where category.cat_id=vend_subscription.cat_id and vs_id=$id;";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function is_cntc_validated($id) {
    $obj=new Base;
	$q="select is_cntc_validated from vendor where vend_id=$id";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getvsforbyvsid($id) {
    $obj=new Base;
	$q="select vs_for from vend_subscription where vs_id=$id";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
                 
	return $id;
}

public static function getuidbyvsid($id) {
    $obj=new Base;
	$q="select u_id from vend_subscription where vs_id=$id";
	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];

        
	return $id;
}

public static function getVendorCountCart($u_id) {
    $obj=new Base;
    	$ret=0;
            if(isset($u_id)!="" || !empty($u_id)) {
        $q="SELECT count(*) from vs_cart WHERE vs_cart.u_id=$u_id;";
//        echo $q;
    $res=Base::generateResult($q);
	 if($row=mysqli_fetch_array($res))
		$ret=$row[0];
            }
                 
        return $ret;
 }

 public static function removeVendorCartItem($cart_id) {
    $obj=new Base;
    	$ret=false;
        $q="delete from vs_cart where vsc_id=$cart_id;";
//        echo $q;
    if(Base::generateResult($q))
		$ret=true;

                 
	return $ret;
}

 public static function getUAFrom($vs_id) {
    $obj=new Base;
    	$ret=false;
        $q="select na_from from vend_subscription where vs_id=$vs_id;";
//        echo $q;
    $res=Base::generateResult($q);
    if($row= mysqli_fetch_array($res))
		$ret=$row[0];

                 
	return $ret;
}

 public static function getUATo($vs_id) {
    $obj=new Base;
    	$ret=false;
        $q="select na_to from vend_subscription where vs_id=$vs_id;";
//        echo $q;
    $res=Base::generateResult($q);
    if($row= mysqli_fetch_array($res))
		$ret=$row[0];

                 
	return $ret;
}

 public static function checkCurDate($vs_id,$date) {
    $obj=new Base;
    	$ret=false;
        $q="select count(*) from vend_subscription where cast(N'$date' as date) not between na_from and na_to and vs_id=$vs_id;";
        echo $q;
    $res=Base::generateResult($q);
    if($row= mysqli_fetch_array($res))
		$ret=$row[0];

                 
	return $ret;
}

 public static function enableVendor($vst_id) {
    	$ret=false;
        $q="select vs_id from vs_trans where vst_id=$vst_id;";
//        echo $q;
    $res=Base::generateResult($q);
    $query="";
    while($row= mysqli_fetch_array($res)) {
        $vs_for=Vendor::getvsforbyvsid($row[0]);
//    $vs_for=Base::annualtoyear($vs_for);
    $vs_for= explode(" ", $vs_for);
    $noofmonths=0;
    if($vs_for[1]=="Annual")
        $noofmonths=$vs_for[0]*12;
    
    elseif($vs_for[1]=="Half")
        $noofmonths=$vs_for[0]*6;
            $date = date_create();
    $todate=date_add($date,date_interval_create_from_date_string("$noofmonths months"));
    $todate=date_format($todate,"Y-m-d");
    
            $query.="update vend_subscription set vs_pay_status='Enabled',vs_from=now(),vs_to=cast(N'$todate' as date),vs_for=NULL where vs_id=".$row[0].";";
    }
    echo $query;
    if(mysqli_multi_query($obj->con, $query))
    $ret=true;

                 
	return $ret;
}

function removeVendorCartforUser() {
        
    	$ret=false;
        $q="delete from vs_cart where u_id=".$this->u_id." and cat_id=".$this->cat_id." and cat_id<>0 and bname='".$this->bname."' ";
        if(!empty($this->other_cat))
            $q.=" and other_cat='".$this->other_cat."';";
//        echo $q;
    if(Base::generateResult($q))
		$ret=true;
                 mysqli_close($this->con);
	return $ret;
}



function newVendorSubscription(){
           $ret=false;
            $q = "insert into vend_subscription(";
            if(!empty($this->vs_id))
            $q.= "vs_id,";
            
            $q.="u_id,cat_id,bname,";

            if(!empty($this->other_cat) && $this->cat_id==0)
                $q.="other_cat,";
            
            if(!empty($this->fssai_no) && $this->cat_id==39 )
                $q.="fssai_no,";
            
               if($this->vend_open_time!="" && $this->vend_close_time!="")
   $q.="vend_open_time,vend_close_time,";

               if(!empty($this->city_served) && $this->city_served!="")
               $q.="city_served,";
               
               if(!empty($this->area_served) && $this->area_served!="")
               $q.="area_served,";
               
               if($this->vs_pay_status!="" && $this->vs_pay_status=="Enabled" || $this->vs_pay_status=="Wait4FSSAI")
                   $q.="vs_from,vs_to,vs_for,";
                   
/*               if(!empty($this->vs_from) && $this->vs_from!="")
               $q.="vs_from,";

               if(!empty($this->vs_to) && $this->vs_to!="")
               $q.="vs_to,";
               */
               if(!empty($this->vs_for) && $this->vs_for!="" && $this->vs_pay_status!="Enabled" && $this->vs_pay_status!="Wait4FSSAI")
               $q.="vs_for,";
               
               if(!empty($this->vs_subtotal) && $this->vs_subtotal!=0)
               $q.="vs_subtotal,";
               
               if(!empty($this->vs_tax) && $this->vs_tax!=0)
               $q.="vs_tax,";
               
               if(!empty($this->vs_disc) && $this->vs_disc!=0)
               $q.="vs_disc,";
               
               if(!empty($this->vs_total) && $this->vs_total!=0)
               $q.="vs_total,";
               
               if($this->vs_pay_status!="" && $this->vs_pay_status!="New")
               $q.="vs_pay_status,";
               
               if(!empty($this->delivery) && $this->delivery!="")
               $q.="delivery,";
               
               if(!empty($this->remark) && $this->remark!="")
               $q.="remark,";
               
               $q.="ins_dt,ins_usr) values(";
               
            if(!empty($this->vs_id))
            $q.= $this->vs_id.",";
            
               $q.=$this->u_id.",".$this->cat_id.",'".$this->bname."',";

               if(!empty($this->other_cat) && $this->cat_id==0)
                $q.="'".$this->other_cat."',";
               
              if(!empty($this->fssai_no) && $this->fssai_no!=0 && $this->cat_id==39)
                $q.="'".$this->fssai_no."',";
               
               if($this->vend_open_time!="" && $this->vend_close_time!="")
               $q.="cast(N'".$this->vend_open_time."' as time),cast(N'".$this->vend_close_time."' as time),";
               
               if(!empty($this->city_served) && $this->city_served!="")
               $q.="'".$this->city_served."',";
               
               if(!empty($this->area_served) && $this->area_served!="")
               $q.="'".$this->area_served."',";
               
               if($this->vs_pay_status!="" && $this->vs_pay_status=="Enabled"  || $this->vs_pay_status=="Wait4FSSAI") {
    $vs_for= explode(" ", $this->vs_for);
    $for=Base::getSubscriptionOff($vs_for[0],$vs_for[1], $this->cat_id);
//    $vs_for=Base::annualtoyear($this->vs_for);
//    echo $for;
    $for= explode(" ", $for);
    $noofmonths=2;
    print_r($for);
    if($this->vs_pay_status=="Enabled") {
    if($for[1]=="Year" || $for[1]=="Years") {
        echo $for[1];
        $noofmonths=$for[0]*12;
    }
    elseif($for[1]=="Months")
        $noofmonths=$for[0]*6;
    }
//    echo $noofmonths;
//    $this->vs_for=$for[0]." ";
    if($for[1]=="Year" || $for[1]=="Years")
        $this->vs_for=$for[0]." Annual";
    else
        $this->vs_for=$for[0]." Half Annual";
    $date = date_create();
    $todate=date_add($date,date_interval_create_from_date_string("$noofmonths months"));
    $todate=date_format($todate,"Y-m-d");
    if($this->vs_pay_status=="Enabled")
    $q.="now(),cast(N'$todate' as date), NULL,";
    if($this->vs_pay_status=="Wait4FSSAI")
    $q.="now(),cast(N'$todate' as date), '".$this->vs_for."',";
               
               }

               if(!empty($this->vs_for) && $this->vs_for!="" && $this->vs_pay_status!="Enabled" && $this->vs_pay_status!="Wait4FSSAI")
               $q.="'".$this->vs_for."',";
               
               if(!empty($this->vs_subtotal) && $this->vs_subtotal!=0)
               $q.=$this->vs_subtotal.",";
               
               if(!empty($this->vs_tax) && $this->vs_tax!=0)
               $q.=$this->vs_tax.",";
               
               if(!empty($this->vs_disc) && $this->vs_disc!=0)
               $q.=$this->vs_disc.",";
               
               if(!empty($this->vs_total) && $this->vs_total!=0)
               $q.=$this->vs_total.",";
               
               if($this->vs_pay_status!="" && $this->vs_pay_status!="New")
               $q.="'".$this->vs_pay_status."',";
               
               if(!empty($this->delivery) && $this->delivery!="")
               $q.="'".$this->delivery."',";
               
               if(!empty($this->remark) && $this->remark!="")
               $q.="'".$this->remark."',";
               
               $q.="now(),'".$this->bname."');";

               echo $q;
/*               $u_name=Base::getdispnamebyuid($u_id);
               $category=Base::getcatnamebycatid($cat_id);
               $vend_cntc=Vendor::getvendcntcbyuid($u_id);
/*               echo "$u_name<br />";
               echo "$u_id<br />";
               echo "$category<br />";
               echo "$vend_cntc<br />";
               */
      if(Base::generateResult($q) && $this->removeVendorCartforUser()) // && Sms::NewVendorNotification($u_name,$category,$vend_cntc))
              $ret=true;
//        if($cat_id!=0) {
/*        if(Sms::msgAutoApproveVendorAdmin(Base::getdispnamebyuid($u_id),Base::getcatnamebycatid($cat_id),Vendor::getvendcntcbyuid($u_id)))
*/          
//        }
        
                 mysqli_close($this->con);
    return $ret;
}

public static function bankdetailsprovided($uname){
    $obj=new Base;
     $ret=false;
    if(strstr($uname,"@administrator")) {
//            $admin=$user;
                    $user0= explode("@administrator", $uname);
                    $uname=$user0[0];
                }
    $q="select count(*) from vend_bank,users where users.u_id=vend_bank.u_id and u_name='$uname'"; 
//    echo $q;
    $res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$ret=$row[0];
                 
	return $ret;
}

public static  function newVstId() {
    $obj=new Base;
    $out=1;
    $q="select vst_id from vs_trans order by vst_id desc";
//    echo $q."<br>";
    $res= Base::generateResult( $q);
    if($row= mysqli_fetch_array($res))
            $out+=$row[0];
    
                 
    return $out;
}

static function newvstransaction($vst_id,$vs_id,$type,$amt,$status,$track_id,$bank_ref,$user) {
    $obj=new Base;
    $q="insert into vs_trans(vst_id,vs_id,vst_type,vst_amount,vst_status,vspt_id,vsbank_ref,ins_dt,ins_usr) values ($vst_id,$vs_id,'$type',$amt,'$status','$track_id','$bank_ref',now(),'$user');";
//    echo $q;
      if(Base::generateResult($q)) // && Sms::NewVendorNotification($u_name,$category,$vend_cntc))
              $ret=true;

                 
     return $ret;
}

static function updatevstransaction($vst_id,$status,$rpt_id,$user) {
    $obj=new Base;
    
    $q="update vs_trans set vst_status='$status',rpt_id='$rpt_id', upd_dt=now(), upd_usr='$user' where vst_id=$vst_id;";
//    echo $q;
      if(Base::generateResult($q) or die ("error".mysqli_error($obj->con))) // && Sms::NewVendorNotification($u_name,$category,$vend_cntc))
              $ret=true;

                 
     return $ret;
}


        function vendorCart(){
           $ret=false;
            $q = "insert into vs_cart(u_id,bname,cat_id,";
            
            if(!empty($this->other_cat) && $this->cat_id==0)
                $q.="other_cat,";

            if(!empty($this->fssai_no) && $this->fssai_no!="")
                $q.="fssai_no,";

            
               if($this->vend_open_time!="" && $this->vend_close_time!="")
   $q.="vend_open_time,vend_close_time,";
               if($this->city_served!="")
               $q.="city_served,";
               
               $q.="vs_for,ins_dt,ins_usr) values(".$this->u_id.",'$this->bname',".$this->cat_id.",";
            if(!empty($this->other_cat) && $this->cat_id==0)
                $q.="'$this->other_cat',";
               
            if($this->fssai_no!="")
                $q.="'$this->fssai_no',";
               
               if($this->vend_open_time!="" && $this->vend_close_time!="")
               $q.="cast(N'".$this->vend_open_time."' as time),cast(N'".$this->vend_close_time."' as time),";
               
               if($this->city_served!="")
               $q.="'".$this->city_served."',";
               $q.="'".$this->vs_for."',now(),".$this->u_id.")";
               
/*              echo $q;
/*               $u_name=Base::getdispnamebyuid($u_id);
               $category=Base::getcatnamebycatid($cat_id);
               $vend_cntc=Vendor::getvendcntcbyuid($u_id);
/*              echo "$u_name<br />";
               echo "$u_id<br />";
               echo "$category<br />";
               echo "$vend_cntc<br />";
               */
      if(Base::generateResult($q)) // && Sms::NewVendorNotification($u_name,$category,$vend_cntc))
              $ret=true;
//        if($cat_id!=0) {
/*        if(Sms::msgAutoApproveVendorAdmin(Base::getdispnamebyuid($u_id),Base::getcatnamebycatid($cat_id),Vendor::getvendcntcbyuid($u_id)))
*/          
//        }
        
                 mysqli_close($this->con);
    return $ret;
}


public static function validate($email) {
    $obj=new Base;
//    $cust_id=Customer::getcustidbyuname($uname);
	$q="update vendor set is_validated='Y' where vend_email='$email'";
//	echo $q;
	if(Base::generateResult($q))
		$ret=true;
	else
		$ret=false;
                 
return $ret;
	}


	public function toString() {
    return $this->vend_fname."<br>l".$this->vend_lname."<br>c".$this->vend_cntc."<br>a".$this->vend_alt_cntc."<br>e".$this->vend_email."<br>add".$this->vend_addr."<br>z".$this->loc_zip."<br>u".$this->u_name;
}



}
