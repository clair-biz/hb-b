<?php
spl_autoload_register(function ($class) {
    include '' . $class . '.php';
});

class CampProd extends Base{

private $camp_id;
private $prod_id;
private $prod_qty;
private $unit;
private $disc_on;
private $perc_disc;
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
    

public function Insert(){
    if($this->prod_id!=0) {
    $query="select cat_sub.cs_id from product,cat_sub where product.cs_id=cat_sub.cs_id and prod_id=".$this->prod_id.";" ;  
    $res= mysqli_query($this->con, $query);
            if($row=mysqli_fetch_array($res))
        $this->cs_id=$row[0];
  //  map.close();
    //stmtcat.close();
    }
    
    $q="insert into camp_prod_map(camp_id,prod_id,";
    if($this->disc_on!="")
        $q.="disc_on,";
    $q.="prod_qty,unit,perc_disc,cs_id,ins_dt,ins_usr) values(".$this->camp_id.",".$this->prod_id.",";
    if($this->disc_on!="")
        $q.="'".$this->disc_on."',";
    $q.=$this->prod_qty.",'".$this->unit."',".$this->perc_disc.",".$this->cs_id.",now(),'".$this->user."');";
    echo $q;
   if(mysqli_query($this->con,$q))
     $out=true;
   else
       $out=false;
                 mysqli_close($this->con);
   return $out;
}

public static function Delete($camp_id,$prod_id,$cs_id){
    $obj=new Base;
    $r=0;
    if($prod_id>0)
    $q="delete from camp_prod_map where camp_id=$camp_id and prod_id=$prod_id ;";  

else if($prod_id==0)
    $q="delete from camp_prod_map where camp_id=$camp_id and prod_cat='$cs_id';";  
    $r = (mysqli_query($obj->con,$q)); 
                 mysqli_close($obj->con);
    return $r;
}

public function Update() {
$r=0;
$ename="";
if($this->prod_id!=0 && $this->cs_id==0) {
    if($this->disc_on!=0) {
        $ename.= "update camp_prod_map set disc_on='".$this->disc_on."',upd_dt=now(),upd_usr='".$this->user."' where camp_id='".$this->camp_id."' and prod_id=".$this->prod_id.";";
//        if(mysqli_query($obj->con,$ename)){
//    $r++;
//    }
   } 
    
if($this->prod_qty!=0) {
    $ename.="update camp_prod_map set prod_qty='".$this->prod_qty."',upd_dt=now(),upd_usr='".$this->user."' where camp_id='".$this->camp_id."' and prod_id=".$this->prod_id.";";
//        if(mysqli_query($obj->con,$ename)){
//    $r++;
//    }
  }
    if($this->perc_disc!=0) {    
        $ename.= "update camp_prod_map set perc_disc='".$this->perc_disc."',upd_dt=now(),upd_usr='".$this->user."' where camp_id='".$this->camp_id."' and prod_id=".$this->prod_id.";";
//        if(mysqli_query($obj->con,$ename)){
//    $r++;
//    }
}
    if($this->unit!=0) {    
        $ename.= "update camp_prod_map set unit='".$this->unit."',upd_dt=now(),upd_usr='".$this->user."' where camp_id='".$this->camp_id."' and prod_id=".$this->prod_id.";";
//        if(mysqli_query($obj->con,$ename)){
//    $r++;
//    }
}

}
    if($this->prod_id==0 && $this->cs_id!="" && $this->cs_id!="-") {
    if($this->disc_on!=0) {
        $ename.= "update camp_prod_map set disc_on='".$this->disc_on."',upd_dt=now(),upd_usr='".$this->user."' where camp_id='".$this->camp_id."' and cs_id=".$this->cs_id.";";
//        if(mysqli_query($obj->con,$ename)){
//    $r++;
//    }   
    }
    if($this->prod_qty!=0) {
        $ename.= "update camp_prod_map set prod_qty='".$this->prod_qty."',upd_usr='".$this->user."' where camp_id='".$this->camp_id."' and cs_id=".$this->cs_id.";";
//        if(mysqli_query($obj->con,$ename)){
//    $r++;
//    }   
    }
    if($this->perc_disc!=0) {    
        $ename.= "update camp_prod_map set perc_disc='".$this->perc_disc."',upd_dt=now(),upd_usr='".$this->user."' where camp_id='".$this->camp_id."' and cs_id=".$this->cs_id.";";
//        if(mysqli_query($obj->con,$ename)){
//    $r++;
//    }   
    }
    if($this->unit!=0) {    
       $ename.= "update camp_prod_map set unit='".$this->unit."',upd_dt=now(),upd_usr='".$this->user."' where camp_id='".$this->camp_id."' and cs_id=".$this->cs_id.";";
//        if(mysqli_query($obj->con,$ename)){
//    $r++;
//    }   
    }
    
}
//echo $ename;
    if(mysqli_multi_query($this->con, $ename)) {
                 mysqli_close($this->con);
    return 1;
    }
    else {
                 mysqli_close($this->con);
        return 0;    
    }
}

public static function removeCampProd($camp_id,$prod_id,$cs_id) {
    $obj=new Base;
    	$ret=false;
        $q="delete from camp_prod_map where camp_id=$camp_id and prod_id=$prod_id and cs_id=$cs_id;";
//        echo $q;
    if(mysqli_query($obj->con,$q))
		$ret=true;

                 mysqli_close($obj->con);
	return $ret;
}




public function toString() {
    return "c".$this->camp_id." p".$this->prod_id." do".$this->disc_on." q".$this->prod_qty." u".$this->unit." d".$this->perc_disc." cs".$this->cs_id." u".$this->user;
}


}
?>