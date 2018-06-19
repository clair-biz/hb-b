<?php

 class Crm {
    static function SiteName() {
        return "HomeBiz365";
    }
    static function root() {
//        return "http://homebizdemo.clairvoyantbizinfo.com/";
        return "http://".$_SERVER["SERVER_NAME"]."/";
    }

    static function domainName() {
//        return "http://homebizdemo.clairvoyantbizinfo.com/";
        return ".homebiz365.in";
    }
     static function CopyRight() {
        return "Copyright &copy; 2017";
    }

    static function con() {
        $config= parse_ini_file("config.ini");

        $con= mysqli_connect(
            $config['db_host'],
            $config['db_user'],
            $config['db_pwd'],
            $config['db_name']) or die(mysqli_connect_errno());
//        $con= mysqli_connect("localhost", "root", "", "db_homebiz365") ;
//        $con= mysqli_connect("198.71.225.58", "db_homebiz_user", "HoMeBiZ365", "db_homebiz");
//        $con= mysqli_connect("198.71.225.58", "homebiz_user", "HoMeBiZ365", "db_homebiz365");
return $con;
    }
	 
	 static function checkUser($email,$password) {
		 $ret=0;
//		 echo $email." ".$password;
			 $q="select u_type,cust_id,vend_id from users where u_name='$email' and is_active='Y' and pwd=md5('$password')";
//			 echo $q;
		 $res=mysqli_query(Crm::con(),$q) or die("Error".mysqli_error(Crm::con()));
//			 print_r($res);
		 if($row=mysqli_fetch_array($res)){
//			 echo $row[0]."<- ->".$row[1];
//			 print_r($row);
			 if($row[0]=="Admin" && $row[1]==null && $row[2]==null)
			 $ret=11;
			 elseif($row[0]=="Vendor" && $row[1]==null && $row[2]!=null)
			 $ret=1;
			 elseif($row[0]=="Customer" && $row[1]!=null && $row[2]==null)
			 $ret=2;
			 elseif($row[0]=="Delivery" && $row[1]==null && $row[2]==null)
			 $ret=3;
		 }
		 return $ret;
	 }

	 static function getUserType($user) {
		 $ret=0;
                if($user. substr("@administrator", 0)) {
//            $admin=$user;
                    $user0= explode("@administrator", $user);
                    $user=$user0[0];
                }
			 $q="select u_type,cust_id,vend_id from users where is_active='Y' and u_name='$user'";
//			 echo $q."<br />";
		 $res=mysqli_query(Crm::con(),$q) or die(Crm::con());
//			 print_r($res);
		 if($row=mysqli_fetch_array($res)){
//			 echo $row[0]."<- ->".$row[1];
			 if($row[0]=="Admin" && $row[1]==null && $row[2]==null)
			 $ret=11;
			 if($row[0]=="Vendor" && $row[1]==null && $row[2]!=null)
			 $ret=1;
			 if($row[0]=="Customer" && $row[1]!=null && $row[2]==null)
			 $ret=2;
			 if($row[0]=="Delivery" && $row[1]==null && $row[2]==null)
			 $ret=3;
		 }
                 mysqli_close(Crm::con());
		 return $ret;
	}
        
       static function addUser($u_name,$pwd,$u_type,$cust_id,$vend_id){
           $ret=false;
            $q = "insert into users(u_name,pwd,u_type,";
            if(!is_null($cust_id) || $cust_id!=0)
                $q.="cust_id,";
            if(!is_null($vend_id) || $vend_id!=0)
                $q.="vend_id,";
            $q.="ins_dt,ins_usr) values('".mysqli_real_escape_string(Crm::con(),$u_name)."',md5('$pwd'),'$u_type',";
            if(!is_null($cust_id) || $cust_id!=0)
                $q.="$cust_id,";
            if(!is_null($vend_id) || $vend_id!=0)
                $q.="$vend_id,";
            
            $q.="now(),'$u_name');";
            echo $q;
      if(mysqli_query(Crm::con(),$q))
              $ret=true;
                 mysqli_close(Crm::con());
    return $ret;
}

public static function getSubtotal($for_val,$sfor,$cat){
    $month=0;
$quarter=0;
$half_ann=0;
$annual=0;
$sub=0;
$query="select plan_name,plan_rate from rate_plan,category where rate_plan.cat_id=category.cat_id and category.cat_id=$cat";

//echo $query;

$res= mysqli_query(Crm::con(), $query);
while($row= mysqli_fetch_array($res)) {
    switch ($row[0]) {
        case "Month" : $month=$row[1];
            break;
        case "Quarter" : $quarter=$row[1];
            break;
        case "Half Annual" : $half_ann=$row[1];
            break;
        case "Annual" : $annual=$row[1];
            break;
    }
}
/*
echo $sfor."<br />";
echo $for_val."<br />";
echo $query."<br />";
echo $month."<br />";
echo $quarter."<br />";
echo $half_ann."<br />";
echo $annual."<br />";
*/
if($sfor=="Annual")
    $for_val=$for_val*12;
elseif($sfor=="Half Annual" || $sfor=="Half")
    $for_val=$for_val*6;
elseif($sfor=="Quarter")
    $for_val=$for_val*3;

if($annual>0 && $for_val>=12) {
    $sub+=$annual*(int)($for_val/12);
    $for_val%=12;
}    
//echo "Annual<br />";
//echo $for_val."<br />";
//echo $sub."<br />";

if($half_ann>0 && $for_val>=6) {
    $sub+=$half_ann*(int)($for_val/6);
    $for_val%=6;
}    
//echo "H Annual<br />";
//echo $for_val."<br />";
//echo $sub."<br />";

if($quarter>0 && $for_val>=3) {
    $sub+=$quarter*(int)($for_val/3);
    $for_val%=3;
}    
//echo "Q<br />";
//echo $for_val."<br />";
//echo $sub."<br />";

if($month>0 && $for_val>=1)
    $sub+=$month*(int)$for_val;

//echo "sub ".$sub;
//echo "M<br />";
//echo $for_val."<br />";
                 mysqli_close(Crm::con());
return $sub;


}

public static function getcatnamebyid($id) {
    $strQuery4="select cat_name from category where cat_id=$id";
//    echo $strQuery4;
    $res=mysqli_query(Crm::con(),$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close(Crm::con());
    return $id;
}

public static function getSubscriptionOff($for_val,$sfor,$cat){
    $for=$for_val;
if($sfor=="Annual")
    $for_val=$for_val*12;
elseif($sfor=="Half Annual" || $sfor=="Half")
    $for_val=$for_val*6;

$half=NULL;
$year=NULL;

if($for_val>=6 && $for_val<12) {
	$half="Y";
	$plan="Half Annual";
	}
	
if($for_val>=12) {
	$year="Y";
	$plan="Annual";
		}
    $strQuery4="select plan_rate,disc_type,c_value from subsc_camp,rate_plan where cat_id=$cat ";
  if($half=="Y")
  $strQuery4.=" and c_for_half= '$half'";  
  
  if($year=="Y")
  $strQuery4.=" and c_for_year='$year'";  
  
    $strQuery4.=" and subsc_camp.is_active='Y' and plan_name='$plan';";
    
//    echo $strQuery4;
    $res=mysqli_query(Crm::con(),$strQuery4);
    $rate=0;
    $disc=0;
        if($row= mysqli_fetch_array($res)) {
            if($row[1]=="Percent" && $row[2]==50)
                $val=Crm::annualtoyear(($for*2)." $sfor");
                $id=$val;
            
/*        $rate=$row[0];
        if($row[1]=="Amount")
        $disc=$rate-$row[2];
        elseif($row[1]=="Percent")
        $disc=$rate*($row[2]/100);*/
        }
        else
            $id=Crm::annualtoyear("$for $sfor");
        
//                $id=$rate-$disc;
                 mysqli_close(Crm::con());
    return $id;
}


public static function getTax($for_val,$sfor,$cat){
    $month=0;
$quarter=0;
$half_ann=0;
$annual=0;
$tpmonth=0;
$tpquarter=0;
$tphalf_ann=0;
$tpannual=0;
$sub=0;
$tax=0;
$query="select plan_name,plan_rate,tax_perc from rate_plan,category where rate_plan.cat_id=category.cat_id and category.cat_id=$cat";

//echo $query;

$res= mysqli_query(Crm::con(), $query);
while($row= mysqli_fetch_array($res)) {
    switch ($row[0]) {
        case "Month" : $month=$row[1];
            $tpmonth=$row[2];
            break;
        case "Quarter" : $quarter=$row[1];
            $tpquarter=$row[2];
            break;
        case "Half Annual" :
            $half_ann=$row[1];
            $tphalf_ann=$row[2];
            break;
        case "Annual" : $annual=$row[1];
            $tpannual=$row[2];
            break;
    }
}
/*
echo $sfor."<br />";
echo $for_val."<br />";
echo $query."<br />";
echo $month."<br />";
echo $quarter."<br />";
echo $half_ann."<br />";
echo $annual."<br />";
*/
if($sfor=="Annual")
    $for_val=$for_val*12;
if($sfor=="Half Annual" || $sfor=="Half")
    $for_val=$for_val*6;
if($sfor=="Quarter")
    $for_val=$for_val*3;

if($annual>0 && $for_val>=12) {
//    $sub+=$annual*(int)($for_val/12);
    if($tax==$tpannual || $tax==0)
    $tax=$tpannual;
    $for_val%=12;
}    
//echo "Annual<br />";
//echo $for_val."<br />";
//echo $sub."<br />";

if($half_ann>0 && $for_val>=6) {
    $sub+=$half_ann*(int)($for_val/6);
    if($tax==$tphalf_ann || $tax==0)
        $tax=$tphalf_ann;
        $for_val%=6;
}    
//echo "H Annual<br />";
//echo $for_val."<br />";
//echo $sub."<br />";

if($quarter>0 && $for_val>=3) {
    $sub+=$quarter*(int)($for_val/3);
    $tax+=(($tpquarter*$quarter)/100)*(int)($for_val/3);
    $for_val%=3;
}    
//echo "Q<br />";
//echo $for_val."<br />";
//echo $sub."<br />";

if($month>0 && $for_val>=1) {
    $sub+=$month*(int)$for_val;
    $tax+=(($tpmonth*$month)/100)*(int)$for_val;

}
//echo "M<br />";
//echo $for_val."<br />";
                 mysqli_close(Crm::con());
return $tax;

}


public static function getcsnamebyid($id){
    $strQuery4="select cs_name from cat_sub where cs_id=$id";
    $res=mysqli_query(Crm::con(),$strQuery4);
    $res="";
        if($row= mysqli_fetch_array($res))
                $res=$row[0];
                 mysqli_close(Crm::con());
    return $res;
}


public static function getuidbyuname($uname) {
                if($uname. substr("@administrator", 0)) {
//            $admin=$user;
                    $user0= explode("@administrator", $uname);
                    $uname=$user0[0];
                }
	$q="select u_id from users where is_active='Y' and u_name='$uname'";
//	echo $q;
	$res=mysqli_query(Crm::con(),$q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
	else
		$id=mysqli_error(Crm::con());
                 mysqli_close(Crm::con());
	return $id;
}

public static function getdispnamebyuid($id) {
	$q="select disp_name from users where is_active='Y' and u_id=$id";
//	echo $q;
	$res=mysqli_query(Crm::con(),$q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
	else
		$id=mysqli_error(Crm::con());
                 mysqli_close(Crm::con());
	return $id;
}

public static function getWalletAmt($id) {
	$q="select wallet_amt from users where is_active='Y' and u_id=$id";
//	echo $q;
	$res=mysqli_query(Crm::con(),$q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
	else
		$id=mysqli_error(Crm::con());
                 mysqli_close(Crm::con());
	return $id;
}

public static function getWalletRedeemed($id) {
	$q="select redeemed from users where is_active='Y' and u_id=$id";
//	echo $q;
	$res=mysqli_query(Crm::con(),$q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
	else
		$id=mysqli_error(Crm::con());
                 mysqli_close(Crm::con());
	return $id;
}

public static function getunamebyuid($id) {
	$q="select u_name from users where u_id='$id'";
//	echo $q;
	$res=mysqli_query(Crm::con(),$q);
	if($row=mysqli_fetch_array($res))
		$id=$row[0];
	else
		$id=mysqli_error(Crm::con());
                 mysqli_close(Crm::con());
	return $id;
}

public static function getcatidbycatname($name){
    $strQuery4="select cat_id from category where cat_name='$name'";
//    echo $strQuery4;
    $res=mysqli_query(Crm::con(),$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close(Crm::con());
    return $id;
}

public static function getcatnamebycatid($id){
    $strQuery4="select cat_name from category where cat_id=$id";
//    echo $strQuery4;
    $res=mysqli_query(Crm::con(),$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
    return $id;
}

public static function getlocdistbyzip($id){
    $strQuery4="select loc_dist from location where loc_zip=$id";
//    echo $strQuery4;
    $res=mysqli_query(Crm::con(),$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close(Crm::con());
    return $id;
}

public static function getlocstatebyzip($id){
    $strQuery4="select loc_state from location where loc_zip=$id";
//    echo $strQuery4;
    $res=mysqli_query(Crm::con(),$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close(Crm::con());
    return $id;
}

public static function getcsidbycsname($name){
    $id="";
    $strQuery4="select cs_id from cat_sub where cs_name='$name'";
//    echo $strQuery4;
    $res=mysqli_query(Crm::con(),$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
    return $id;
}

public static function getcatidbyuname($name){
    $strQuery4="select vend_subscription.cat_id from vend_subscription,users where vend_subscription.u_id=users.u_id and users.is_active='Y' and u_name='$name'";
//    echo $strQuery4;
    $res=mysqli_query(Crm::con(),$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close(Crm::con());
    return $id;
}

public static function getcattypebyuname($name){
                    if($name. substr("@administrator", 0)) {
//            $admin=$user;
                    $user0= explode("@administrator", $name);
                    $name=$user0[0];
                }

    $strQuery4="select cat_type from category,vend_subscription,users where category.cat_id=vend_subscription.cat_id and vend_subscription.u_id=users.u_id and users.is_active='Y' and vs_pay_status='Enabled' and u_name='$name'";
//    echo $strQuery4;
    $res=mysqli_query(Crm::con(),$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close(Crm::con());
    return $id;
}

public static function getcattypebyvsid($id){

    $strQuery4="select cat_type from category,vend_subscription,users where category.cat_id=vend_subscription.cat_id and vend_subscription.u_id=users.u_id and users.is_active='Y' and vs_id=$id;";
//    echo $strQuery4;
    $res=mysqli_query(Crm::con(),$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close(Crm::con());
    return $id;
}

public static function getcattypebycsid($id){
    $strQuery4="select cat_type from category,cat_sub where category.cat_id=cat_sub.cat_id and cs_id=$id";
//    echo $strQuery4;
    $res=mysqli_query(Crm::con(),$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close(Crm::con());
    return $id;
}

public static function getAIValue($tablename){
    $strQuery4="SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES WHERE table_name = '$tablename'";
//    echo $strQuery4;
    $res=mysqli_query(Crm::con(),$strQuery4);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close(Crm::con());
    return $id;
}

public static function getcattypebycatid($id){
    $strQuery4="select cat_type from category where cat_id=$id";
//    echo $strQuery4;
    $res=mysqli_query(Crm::con(),$strQuery4) or die("error ". mysqli_error(Crm::con()));
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
    return $id;
}

 //This function separates the extension from the rest of the file name and returns it 
 public static function findexts ($filename) { 
 $filename = strtolower($filename) ; 
 $exts = explode(".", $filename) ; 
 $n = count($exts)-1; 
 $exts = $exts[$n]; 
 return $exts; 
 } 

 public static function getcountprodcsname($csname){
     $id=0;
     $q="select count(*) from product,cat_sub where product.cs_id=cat_sub.cs_id and cs_name='$csname';";
    $res=mysqli_query(Crm::con(),$q);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close(Crm::con());
    return $id;
     
 }

 public static function getcountservcsname($csname){
     $id=0;
     $q="select count(*) from service,cat_sub where service.cs_id=cat_sub.cs_id and cs_name='$csname';";
    $res=mysqli_query(Crm::con(),$q);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close(Crm::con());
    return $id;
     
 }
 
  public static function getrate($id,$name){
     $q="select plan_rate from rate_plan where cat_id=$id and plan_name='$name';";
    $res=mysqli_query(Crm::con(),$q);
        if($row= mysqli_fetch_array($res))
                $id=$row[0];
                 mysqli_close(Crm::con());
    return $id;
     
 }
 
 public static function getcountcatcontentforprod($name) {
     
     $q="select count(*) from product,cat_sub,category,users,vend_subscription where vend_subscription.u_id=users.u_id and vend_subscription.vs_id=product.vs_id and product.cs_id=cat_sub.cs_id and category.cat_id=cat_sub.cat_id and users.is_active='Y' and product.is_active='Y'  and vs_pay_status in ('Enabled','Wait4FSSAI') and cat_name='$name'";
     $res=mysqli_query(Crm::con(),$q);
     if($row= mysqli_fetch_array($res))
         $id=$row[0];
                 mysqli_close(Crm::con());
         return $id;
         
 }
 
 public static function getcountcscontentforprod($name) {
     
     $q="select count(*) from product,cat_sub,category,users,vend_subscription where vend_subscription.u_id=users.u_id and vend_subscription.vs_id=product.vs_id and product.cs_id=cat_sub.cs_id and category.cat_id=cat_sub.cat_id and users.is_active='Y' and product.is_active='Y'  and vs_pay_status in ('Enabled','Wait4FSSAI') and cs_name='$name'";
     $res=mysqli_query(Crm::con(),$q);
     if($row= mysqli_fetch_array($res))
         $id=$row[0];
                 mysqli_close(Crm::con());
         return $id;
         
 }
 public static function addDaysinDatedmy($day) {
     
     $q="select date_format(date_add(now(),interval $day day),'%d-%m-%Y');";
     $res=mysqli_query(Crm::con(),$q);
     if($row= mysqli_fetch_array($res))
         $id=$row[0];
                 mysqli_close(Crm::con());
         return $id;
         
 }
 
 
 public static function addDaysinDate($day) {
     
     $q="select date_format(date_add(now(),interval $day day), '%Y-%m-%d' );";
     $res=mysqli_query(Crm::con(),$q);
     if($row= mysqli_fetch_array($res))
         $id=$row[0];
                 mysqli_close(Crm::con());
         return $id;
         
 }
 
 public static function getcountcatcontentforserv($name) {
     
     $q="select count(*) from service,cat_sub,category,users,vend_subscription where vend_subscription.u_id=users.u_id and vend_subscription.vs_id=service.vs_id and service.cs_id=cat_sub.cs_id and category.cat_id=cat_sub.cat_id and users.is_active='Y' and service.is_active='Y' and users.u_id in (SELECT u_id FROM vend_subscription where  vs_pay_status in ('Enabled','Wait4FSSAI')) and cat_name='$name'";
     $res=mysqli_query(Crm::con(),$q);
     if($row= mysqli_fetch_array($res))
         $id=$row[0];
                 mysqli_close(Crm::con());
         return $id;
         
 }

 public static function getcountcscontentforserv($name) {
     
     $q="select count(*) from service,cat_sub,category,users,vend_subscription where vend_subscription.u_id=users.u_id and vend_subscription.vs_id=service.vs_id and service.cs_id=cat_sub.cs_id and category.cat_id=cat_sub.cat_id and users.is_active='Y' and service.is_active='Y' and users.u_id in (SELECT u_id FROM vend_subscription where  vs_pay_status in ('Enabled','Wait4FSSAI')) and cs_name='$name'";
     $res=mysqli_query(Crm::con(),$q);
     if($row= mysqli_fetch_array($res))
         $id=$row[0];
                 mysqli_close(Crm::con());
         return $id;
         
 }

public static function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

    public static function convertToMajor($qty,$unit) {
        $ret=0;
     switch($unit){
         case "gm":
         case "ml":
                        $ret=$qty/1000;
                                   break;
         case "Kg":
         case "Piece":
         case "L":
                        $ret=$qty;
                         break;
         case "mg":
                    $ret=$qty/1000000;
                                   break;
     }
     return $ret;
    }


public static function annualtoyear($vsfor) {
$for=str_replace("Annual", "Year", $vsfor);
$vs_f= explode(" ",$for );
$noofmonths=0;

if($vs_f[1]=="Year")
    $noofmonths=$vs_f[0]*12;

elseif($vs_f[1]=="Half")
    $noofmonths=$vs_f[0]*6;

$vs_for="";
if($noofmonths==12)
    $vs_for="1 Year";
elseif($noofmonths==6)
    $vs_for="6 Months";

elseif($noofmonths>12) {
    $y=intval($noofmonths/12);
    $noofmonths=(intval($noofmonths%12));

    if($y==1)
        $vs_for=$y." Year";
    else
        $vs_for=$y." Years";
    
    if($noofmonths>0) {
        if($noofmonths==1)
            $vs_for.=" $noofmonths Month";
        else
            $vs_for.=" $noofmonths Months";
    }
        }
        return $vs_for;
    }



    public static function getDiscount($prod_id,$qty,$row=0/*,$unit*/) {
//    $qty=Crm::convertToMajor($qty, $unit);
if($row==0)
    $prodcat1 ="SELECT mrp+(mrp*(tax_table.cgst/100))+(mrp*(tax_table.sgst/100))+ (mrp*(tax_table.cess/100))  from product_price,tax_table,product WHERE product.prod_id=product_price.prod_id and tax_table.hsn_code=product.hsn_code and product.prod_id=$prod_id";
elseif($row==1)
    $prodcat1 ="SELECT mrp  from product_price,tax_table,product WHERE product.prod_id=product_price.prod_id and tax_table.hsn_code=product.hsn_code and product.prod_id=$prod_id";
//    echo $prodcat1;
    $prod=mysqli_query(Crm::con(),$prodcat1);
    if($row=mysqli_fetch_array($prod)){
        $mrp=$row[0];
        }
        //rsprodcat1.close();
       // prodcat1.close();
       //mysqli_num_rows($result)
        $prodcat ="select perc_disc,camp_prod_map.prod_qty,disc_on from campaign,camp_prod_map where campaign.camp_id=camp_prod_map.camp_id and camp_prod_map.cs_id IN(select product.cs_id from product,camp_prod_map where camp_prod_map.prod_id=product.prod_id and camp_prod_map.cs_id=product.cs_id and product.prod_id=$prod_id or product.prod_id=0)  and now() BETWEEN camp_start and camp_end";
//        echo $prodcat;
       $rsprodcat =mysqli_query(Crm::con(),$prodcat);
        $q=0;
      //  System.out.println("qty "+qty);
  
        if(mysqli_num_rows($rsprodcat)==0) {
            $count=$mrp*$qty;
        }
        else {
       while($row=mysqli_fetch_array($rsprodcat)) {
        $q=$row[1];
       
            switch($row[2]) {
                
                case "Atleast" :  if($qty>=$q) {
                  // echo "in atleast qty $qty - q $q";
                                  $pd+=($row[0])/100;
                }
                                  break;
               case "Atmost" :  if($qty<=$q || $qty>$q) {
                   //echo "in atmost qty $qty - q $q";
                                  $pd+=$row[0]/100;
                }
                                  break;
                case "Multiple" :  if($qty%$q==0) {
                  // echo "in multiple qty $qty - q $q";
                                  $pd+=$row[0]/100;
                }
                                  break;
            }
        }
//            pd*=0.01;
       // echo "qty $qty<br>q $q<br>";
            mysqli_data_seek($rsprodcat, 0);
            do {
        $q=$row[1];
            
            switch($row[2]) {
                case "Atleast" :  if($qty>=$q) {
                                  $d=$mrp*$qty*$pd;
                                  $tot=$mrp*$qty;
                                  $count=$tot-$d;
                                }
                                else
                                    $count=$mrp*$qty;
                                  break;
                case "Atmost" :   if($qty<=$q) {
                                  $d=$mrp*$qty*$pd;
                                  $tot=$mrp*$qty;
                                  $count=$tot-$d;
                                }
                                  else if ($qty>$q) {
                                  $pd1=$row[0];
                                  $d=$mrp*$q*($pd1/100);
                                  $d1=$mrp*$qty*($pd-($pd1/100));
                                  $tot=$mrp*$qty;
                                  $count=$tot-($d+$d1);
                                }
                                else
                                    $count=$mrp*$qty;
                                  break;
                case "Multiple" : if($qty%$q==0) {
                                  $d=$mrp*$qty*$pd;
                                  $tot=$mrp*$qty;
                                  $count=$tot-$d;
                                }
                                else
                                    $count=$mrp*$qty;
                                  break;        
                }
        } while($row=mysqli_fetch_array($rsprodcat));
        }

                 mysqli_close(Crm::con());
        return $count;
}

}

?>
