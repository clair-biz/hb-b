<?php
spl_autoload_register(function ($class) {
    include '' . $class . '.php';
});

class Customer extends Base{
private $cust_id;    
private $cust_fname;    
private $cust_lname;    
private $cust_cntc;
private $is_cntc_validated;
private $cust_alt_cntc;
private $cust_email;
private $is_email_validated;
private $cust_addr;
private $loc_zip;
private $cust_dob;
private $cust_gen;
private $pwd;
private $u_name;
private $sa_id;
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

public function Insert(){
     $p=false;
    $q = "insert into customer(cust_fname,cust_cntc,is_cntc_validated,";
   $q.="cust_email,is_email_validated,cust_addr,loc_zip,cust_dob,cust_gen,ins_dt,ins_usr)";
   $q.="values('".$this->cust_fname."',".$this->cust_cntc.",'".$this->is_cntc_validated."',";
   
      $q.="'".$this->cust_email."','".$this->is_email_validated."','".$this->cust_addr."',".$this->loc_zip.",cast(N'".$this->cust_dob."' as date),";
      $q.="'".$this->cust_gen."',now(),'".$this->cust_fname."');";
      
      echo $q;
      if(Base::generateResult($q))
      $p=true;
      
   return $p;
}

public function Update($id){
//   boolean check=false;
    $r=false;
    
    $ename="";
    if($this->cust_fname!="")
        $ename.="update customer set cust_fname='".$this->cust_fname."',upd_dt=now(),upd_usr='".$this->user."' where cust_id=$id; ";

        if($this->cust_cntc!=0)
    $ename.="update customer set cust_cntc=".$this->cust_cntc.",upd_dt=now(),upd_usr='".$this->user."' where cust_id=$id; ";

    if($this->cust_alt_cntc!=0)
    $ename.="update customer set cust_alt_cntc=".$this->cust_alt_cntc.",upd_dt=now(),upd_usr='".$this->user."' where cust_id=$id; ";

    if($this->cust_email!="")
        $ename.="update customer set cust_email='".$this->vend_email."',upd_dt=now(),upd_usr='".$this->user."' where cust_id=$id; ";
    
    if($this->cust_addr!="")
        $ename.="update customer set cust_addr='".mysqli_real_escape_string($this->con,$this->cust_addr)."',upd_dt=now(),upd_usr='".$this->user."' where cust_id=$id; ";
    
     if($this->loc_zip!=0)
        $ename.="update customer set loc_zip=".$this->loc_zip.",upd_dt=now(),upd_usr='".$this->user."' where cust_id=$id; ";

        if($this->cust_dob!="")
        $ename.="update customer set cust_dob='".$this->cust_dob."',upd_dt=now(),upd_usr='".$this->user."' where cust_id=$id; ";

        if($this->cust_gen!="")
        $ename.="update customer set cust_gen='".$this->cust_gen."',upd_dt=now(),upd_usr='".$this->user."' where cust_id=$id; ";

        if(Base::generateMultiResult($ename))
      $r=true;
     
    return $r;
}

public static function getcustidbyuname($uname) {
    $obj=new Base;
                if(strstr($uname,"@administrator")) {
//            $admin=$user;
                    $user0= explode("@administrator", $uname);
                    $uname=$user0[0];
                }
	$q="select cust_id from users where u_name='$uname'";
//	echo $q;
	$res=Base::generateResult($q);

	if($row=mysqli_fetch_array($res))
		$id=$row[0];
	else
		$id=mysqli_error($obj->con);
                 mysqli_close($obj->con);
return $id;
	}

public static function getcustidbyemail($email) {
    $obj=new Base;
	$q="select cust_id from customer where cust_email='$email'";
//	echo $q;
        $id=0;
	$res=Base::generateResult($q);

	if($row=mysqli_fetch_array($res))
		$id=$row[0];
//	else
//	echo mysqli_error($obj->con);
                 mysqli_close($obj->con);
return $id;
	}
        
        public static function getcustidbyecd($email,$cntc,$dob) {
            $obj=new Base;
	$q="select cust_id from customer where cust_email='$email' and cust_cntc=$cntc and cust_dob=cast(N'$dob' as date);";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];

        return $id;
}

public static function getcustcntcbyemail($email) {
    $obj=new Base;
	$q="select cust_cntc from customer where cust_email='$email'";
//	echo $q;
	$res=Base::generateResult($q);

	if($row=mysqli_fetch_array($res))
		$id=$row[0];
	else
		$id=mysqli_error($obj->con);
                 mysqli_close($obj->con);
return $id;
	}

public static function getcustcntcbyid($id) {
    $obj=new Base;
	$q="select cust_cntc from customer where cust_id=$id";
//	echo $q;
	$res=Base::generateResult($q);

	if($row=mysqli_fetch_array($res))
		$id=$row[0];
	else
		$id=mysqli_error($obj->con);
                 mysqli_close($obj->con);
return $id;
	}

public static function validate($email) {
    $obj=new Base;
//    $cust_id=Customer::getcustidbyuname($uname);
	$q="update customer set is_validated='Y' where cust_email='$email'";
//	echo $q;
	if(Base::generateResult($q))
		$ret=true;
	else
		$ret=false;
                 mysqli_close($obj->con);
return $ret;
	}

        
public static function getcustnamebyuname($uname) {
    $obj=new Base;
                if(strstr($uname,"@administrator")) {
//            $admin=$user;
                    $user0= explode("@administrator", $uname);
                    $uname=$user0[0];
                }

	$q="select cust_fname from customer,users where customer.cust_id=users.cust_id and u_name='$uname'";
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$name=$row[0];
	else
		$name=mysqli_error($obj->con);
                 mysqli_close($obj->con);
return $name;
	}

	public static function getcustidbyuid($id) {
            $obj=new Base;
	$q="select cust_id from users where u_id=$id;";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$name=$row[0];
	else
		$name=mysqli_error($obj->con);
                 mysqli_close($obj->con);
return $name;
	}

/*	public static function getcustfnamebyid($id) {
	$q="select cust_fname from customer where cust_id=$id;";
//	echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$name=$row[0]." ".$row[1];
	else
		$name=mysqli_error($obj->con);
return $name;
	}*/

public static function getcustnamebyid($id) {
    $obj=new Base;
	$q="select cust_fname from customer where cust_id='$id'";
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$name=$row[0];
	else
		$name=mysqli_error($obj->con);
                 mysqli_close($obj->con);
return $name;
	}
	
	public static function getcustemailbyuid($id) {
            $obj=new Base;
	    $q="select cust_email from customer,users where customer.cust_id=users.cust_id and u_id=$id";
	    //	echo $q;
	    $res=Base::generateResult($q);
	    if($row=mysqli_fetch_array($res))
	        $id=$row[0];
	        else
	            $id=mysqli_error($obj->con);
                 mysqli_close($obj->con);
	            return $id;
	}
	

public static function getcustemailbyid($id) {
    $obj=new Base;
	$q="select cust_email from customer where cust_id='$id'";
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$name=$row[0];
	else
		$name=mysqli_error($obj->con);
                 mysqli_close($obj->con);
return $name;
	}

public function checkShipAddr() {
	$q="select count(*) from ship_addr where cust_id=$this->cust_id and sa_name='".$this->cust_fname."' and sa_email='".$this->cust_email."' and sa_cntc=".$this->cust_cntc." and sa_addr='".$this->cust_addr."' and loc_zip=".$this->loc_zip;
        echo $q."<br><br><br><br><br>";
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$name=$row[0];
        
        return $name;
    }
        
public function InsertShipAddr(){
    $res=false;
    $q="insert into ship_addr(sa_id,cust_id,sa_name,sa_cntc,sa_email,sa_addr,loc_zip,ins_dt,ins_usr) values(".$this->sa_id.",".$this->cust_id.",'".$this->cust_fname."',".$this->cust_cntc.",'".$this->cust_email."','".$this->cust_addr."',".$this->loc_zip.",now(),'".$this->cust_fname."')";
        echo $q."<br><br><br><br><br>";
    if(Base::generateResult($q))
            $res=true;

                 mysqli_close($this->con);
        return $res;    
}

public function getSAID(){
    $q="select sa_id from ship_addr where cust_id=$this->cust_id and sa_name='".$this->cust_fname."' and sa_email='".$this->cust_email."' and sa_cntc=".$this->cust_cntc." and sa_addr='".$this->cust_addr."' and loc_zip=".$this->loc_zip;
    echo $q;
	$res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$name=$row[0];

        return $name;
}


public function toString() {
    return $this->cust_fname."<br />l".$this->cust_lname."<br />c".$this->cust_cntc."<br />a".$this->cust_alt_cntc."<br />e".$this->cust_email."<br />add".$this->cust_addr."<br />z".$this->loc_zip."<br />d".$this->cust_dob."<br />g".$this->cust_gen."<br />u".$this->user;
}

public static  function getCntcforRejection($pr_id,$field){
    $obj=new Base;
    $q="select $field from customer,ordertbl,prod_return where prod_return.ord_id=ordertbl.ord_id and ordertbl.cust_id=customer.cust_id and pr_id=$pr_id";
    $res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$cntc=$row[0];
	else
		$cntc=mysqli_error($obj->con);
//        echo $cntc;
                 mysqli_close($obj->con);
return $cntc;
    
}
public static  function getEmailforRefund($pr_id,$field){
    $obj=new Base;
    $q="select $field from customer,ordertbl,prod_return where prod_return.ord_id=ordertbl.ord_id and ordertbl.cust_id=customer.cust_id and pr_id=$pr_id";
    $res=Base::generateResult($q);
	if($row=mysqli_fetch_array($res))
		$cntc=$row[0];
	else
		$cntc=mysqli_error($obj->con);
        echo $cntc;
                 mysqli_close($obj->con);
return $cntc;
    
}
}
?>