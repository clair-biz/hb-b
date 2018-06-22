<?php
spl_autoload_register(function ($class) {
    include '' . $class . '.php';
});
class Campaign extends Base {
private $camp_name;    
private $camp_start;    
private $camp_end;
private $u_id;
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
/*public static function chkCamp($val){
    $check=false;
    try {
     $q="";
    //if(!sd.after(ed))
       $q="select count(*) from  campaign where camp_id<>0 and camp_id="+val+";";
    Statement ename = con().createStatement();
    ResultSet rs=ename.executeQuery(q);
            if(rs.next()) {
                if(rs.getInt(1)>0)
                    check=true;
            }
    rs.close();
    ename.close();
    }
    catch(Exception e) {
    }
    return check;
}*/



public function Insert(){
    $check=false;
    $q="insert into campaign(camp_name,camp_start,camp_end,u_id,ins_dt,ins_usr) values ('".$this->camp_name."',cast(N'".$this->camp_start."' as date),cast(N'".$this->camp_end."' as date),".$this->u_id.",now(),'".$this->user."');";
   //echo $q;
     if(mysqli_query($this->con,$q))
		$check=true;

                 mysqli_close($this->con);
	return $check;
}

public function Update($id){
//    boolean check=false;
    $r=false;
    $ename="";
    if($this->camp_name!="") {
        $ename.="update campaign set camp_name='".$this->camp_name."',upd_dt=now(), upd_usr='".$this->user."' where camp_id=$id;";
//      if(mysqli_query($obj->con,$ename)){
//      $r=true;
//        }
     }
    //if(this.campstart.compareTo("")!=0 && this.campstart.compareTo("-")!=0) {
    if($this->camp_start!="") {
        $ename.="update campaign set camp_start='".$this->camp_start."',upd_dt=now(), upd_usr='".$this->user."' where camp_id=$id;";
//      if(mysqli_query($obj->con,$ename)){
//      $r=true;
//        }
     }
    if($this->camp_end!="") {
        $ename.="update campaign set camp_end='".$this->camp_end."',upd_dt=now(), upd_usr='".$this->user."' where camp_id=$id;";
//      if(mysqli_query($obj->con,$ename)){
//      $r=true;
//        }
     }
     echo $ename;
    if(Base::generateMultiResult($ename))
    $r=true;
     
    return $r;
}

 public static function getcamps($cust,$prod) {
     $obj=new Base;
     $camps="";
    $q="SELECT qty from cart WHERE cust_id=$cust and prod_id=$prod";
        $res=mysqli_query($obj->con,$q);                    
        while($row=mysqli_fetch_array($res)) {
        $cartq=0;
        $prod_qty=0;
        $cartq=$row[0];
    $q1="SELECT distinct camp_name,camp_prod_map.prod_qty,disc_on from camp_prod_map,campaign WHERE camp_prod_map.camp_id=campaign.camp_id and curdate() between camp_start and camp_end and  camp_prod_map.prod_id=$prod union SELECT camp_name,camp_prod_map.prod_qty,disc_on from camp_prod_map,campaign WHERE camp_prod_map.camp_id=campaign.camp_id and curdate() between camp_start and camp_end and camp_prod_map.prod_cat=(SELECT prod_cat FROM product WHERE prod_id=$prod)";
    $res1=mysqli_query($obj->con,$q1);    
    while($row1=mysqli_fetch_array($res1)) {
        $prod_qty=$row1[1];
//        System.out.println(rsprodcat.getString(1)+" "+rsprodcat.getString(2)+" "+rsprodcat.getString(3)+" "+rsprodcat.getString(4));
            switch($row1[2]) {
                case "Atleast" :  if($cartq>=$prod_qty) {
                                    if($camps.compareTo("")==0)
                                    $camps=$row1[0];
                                    else
                                    $camps.="; ".$row1[0];
                                  }
                                  break;
                case "Atmost" :   if($cartq<=$prod_qty) {
                                    if($camps.compareTo("")==0)
                                    $camps=$row1[0];
                                    else
                                    $camps.="; ".$row1[0];
                                  }
                                  break;
                case "Multiple" : if($cartq%$prod_qty==0) {
                                    if($camps.compareTo("")==0)
                                    $camps=$row1[0];
                                    else
                                    $camps.="; ".$row1[0];
                                  }
                                  break;
                }
        }
        
        }
                 mysqli_close($obj->con);
        return camps;
}
 
public static function getcampnames($prod,$qty) {
    $obj=new Base;
     $camps="<b>Offers Applicable:<b><br />";
    $p="SELECT camp_name,prod_qty,disc_on,perc_disc from product_price,camp_prod_map,campaign WHERE camp_prod_map.prod_id=product_price.prod_id and camp_prod_map.camp_id=campaign.camp_id and curdate() between camp_start and camp_end and product_price.prod_id=$prod";
     $res2=(mysqli_query($obj->con,$p));
   //echo "Quantity".$qty;
        while($row2=mysqli_query($res2)) {
        $prod_qty=0;
        $prod_qty=$row2[1];
        
//        System.out.println(rsprodcat.getString(1)+" "+rsprodcat.getString(2)+" "+rsprodcat.getString(3)+" "+rsprodcat.getString(4)+"%");
            switch($row2[2]) {
                case "Atleast" :  if($qty>=$prod_qty) {
                                    $camps.=$row2[0]." ".$row2[3]."% Off<br />";
                                  }
                                  break;
                case "Atmost" :   if($qty<=$prod_qty) {
                                    $camps.=$row2[0]." ".$row2[3]."% Off<br />";
                                  }
                                  break;
                case "Multiple" : if($qty%$prod_qty==0) {
                                    $camps.=$row2[0]." ".$row2[3]."% Off<br />";
                                  }
                                  break;
                }
        }
                 mysqli_close($obj->con);
        return camps;
}

/* public static String getcampaign(int prodid,String pc,int qty) throws SQLException,ClassNotFoundException {
     String camp="";
    PreparedStatement campaign = con().prepareStatement("Select camp_name from camp_prod_map cpm,campaign where cpm.camp_id=campaign.camp_id and prod_id=? and prod_cat=? and qty=?");
        campaign.setInt(1, prodid);
        campaign.setString(2, pc);
        campaign.setInt(3, qty);
        ResultSet rscampaign = campaign.executeQuery();                        
        if(rscampaign.next()) {
            camp=rscampaign.getString(1);
        }
        rscampaign.close();
        campaign.close();
        return camp;
 }
 public static int getcampid(String campname) throws SQLException,ClassNotFoundException {
     int camp=0;
    PreparedStatement campaign = con().prepareStatement("Select camp_name from campaign where camp_name=?");
        campaign.setString(1, campname);
        ResultSet rscampaign = campaign.executeQuery();                        
        if(rscampaign.next()) {
            camp=rscampaign.getInt(1);
        }
        rscampaign.close();
        campaign.close();
        return camp;
 }*/

 public static function campcheck($campname,$startdate,$enddate){
     $obj=new Base;
    $b=false;
    $q ="Select count(*) from campaign where camp_name=$campname and camp_start=$startdate and camp_end=$enddate";
    $cust=mysqli_query($obj->con,$q);
        if($row3=mysqli_fetch_array($cust)) {
            if($row3[0]>0)
            $b=true;
        }
                 mysqli_close($obj->con);
        return $b;
}

 public static function getcampidbyname($campname){
     $obj=new Base;
    $b=0;
    $q ="Select camp_id from campaign where camp_name='$campname'";
    $cust=mysqli_query($obj->con,$q);
        if($row3=mysqli_fetch_array($cust)) {
            $b=$row3[0];
        }
                 mysqli_close($obj->con);
//        rscust.close();
//        cust.close();
        return $b;
}

 public static function getcampnamebyid($campid){
     $obj=new Base;
    $b=0;
    $q ="Select camp_name from campaign where camp_id=$campid";
    $cust=mysqli_query($obj->con,$q);
        if($row3=mysqli_fetch_array($cust)) {
            $b=$row3[0];
        }
                 mysqli_close($obj->con);
//        rscust.close();
//        cust.close();
        return $b;
}

 public static function getcampcountonproduct($id){
    $b=0;
    $obj= new Base;
    $q ="select COUNT(campaign.camp_id) from campaign,product,cat_sub,camp_prod_map WHERE campaign.camp_id=camp_prod_map.camp_id and product.prod_id=camp_prod_map.prod_id and cat_sub.cs_id=product.cs_id and cat_sub.cs_id=camp_prod_map.cs_id and now() BETWEEN camp_start and camp_end and product.prod_id=$id";
//    echo $q;
    $cust=mysqli_query($obj->con,$q);
        if($row3=mysqli_fetch_array($cust)) {
            $b=$row3[0];
        }
                 mysqli_close($obj->con);
        return $b;
}

 public static function getcampcountonservice($id){
     $obj=new Base;
    $b=0;
    $q ="select COUNT(campaign.camp_id) from campaign,service,cat_sub,camp_serv_map WHERE campaign.camp_id=camp_serv_map.camp_id and service.serv_id=camp_serv_map.serv_id and cat_sub.cs_id=service.cs_id and cat_sub.cs_id=camp_serv_map.cs_id and now() BETWEEN camp_start and camp_end and service.serv_id=$id";
//    echo $q;
    $cust=mysqli_query($obj->con,$q);
        if($row3=mysqli_fetch_array($cust)) {
            $b=$row3[0];
        }
                 mysqli_close($obj->con);
        return $b;
}


public static function removeCampaign($camp_id) {
    $obj=new Base;
    	$ret=false;
        $q="delete from campaign where camp_id=$camp_id;";
//        echo $q;
    if(mysqli_query($obj->con,$q))
		$ret=true;

                 mysqli_close($obj->con);
	return $ret;
}

 public static function getcampnamesbyprodid($id){
     $obj=new Base;
    $b="";
    $q ="select camp_name,camp_prod_map.prod_qty,unit,perc_disc from campaign,product,cat_sub,camp_prod_map WHERE campaign.camp_id=camp_prod_map.camp_id and product.prod_id=camp_prod_map.prod_id and cat_sub.cs_id=product.cs_id and cat_sub.cs_id=camp_prod_map.cs_id and now() BETWEEN camp_start and camp_end and product.prod_id=$id";

    $cust=mysqli_query($obj->con,$q);
        while($row3=mysqli_fetch_array($cust)) {
            if($b!="")
                $b.="<br />";
            
            $b.=$row3[0]." <br />Get ".$row3[3]."% discount on ".$row3[1]." ".$row3[2];
        }
                 mysqli_close($obj->con);
//        rscust.close();
//        cust.close();
        return $b;
}

 public static function getcampnamesbyservid($id){
     $obj=new Base;
    $b="";
    $q ="select camp_name,perc_disc from campaign,service,cat_sub,camp_serv_map WHERE campaign.camp_id=camp_serv_map.camp_id and service.serv_id=camp_serv_map.serv_id and cat_sub.cs_id=service.cs_id and cat_sub.cs_id=camp_serv_map.cs_id and now() BETWEEN camp_start and camp_end and service.serv_id=$id";

    $cust=mysqli_query($obj->con,$q);
        while($row3=mysqli_fetch_array($cust)) {
            $b.="<br />".$row3[0]." offer<br />Get ".$row3[1]."% Off";
        }
                 mysqli_close($obj->con);
//        rscust.close();
//        cust.close();
        return $b;
}

 public static function getcountcampbyuname($uname){
     $obj=new Base;
    $b=0;
                if($uname. substr("@administrator", 0)) {
//            $admin=$user;
                    $user0= explode("@administrator", $uname);
                    $uname=$user0[0];
                }
    $q ="select count(camp_id) from campaign,users WHERE users.u_id=campaign.u_id and u_name='$uname'";

    $cust=mysqli_query($obj->con,$q);
        while($row3=mysqli_fetch_array($cust)) 
            $b=$row3[0];
                 mysqli_close($obj->con);
//        rscust.close();
//        cust.close();
        return $b;
}




public function toString() {
    return $this->campname." ".$this->campstart." ".$this->campend." ".$this->user;
}


}
?>