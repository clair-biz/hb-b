<?php
spl_autoload_register(function ($class) {
    include '' . $class . '.php';
});

class CampServ extends Base{
private $camp_id;
private $serv_id;
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
    if($this->serv_id!=0) {
    $query="select cat_sub.cs_id from service,cat_sub where service.cs_id=cat_sub.cs_id and serv_id=".$this->serv_id.";" ;  
    $res= mysqli_query($this->con, $query);
            if($row=mysqli_fetch_array($res))
        $this->cs_id=$row[0];
  //  map.close();
    //stmtcat.close();
    }
    
    $q="insert into camp_serv_map(camp_id,serv_id,perc_disc,cs_id,ins_dt,ins_usr) values(".$this->camp_id.",".$this->serv_id.",".$this->perc_disc.",".$this->cs_id.",now(),'".$this->user."');";
  echo $q;
   if(mysqli_query($this->con,$q))
     $out=true;
   else
       $out=false;
                 mysqli_close($this->con);
   return $out;
}

public static function Delete($camp_id,$serv_id,$cs_id){
    $obj=new Base;
    $r=0;
    if($serv_id>0)
    $q="delete from camp_serv_map where camp_id=$camp_id and serv_id=$serv_id ;";  

else if($serv_id==0)
    $q="delete from camp_serv_map where camp_id=$camp_id and serv_cat='$cs_id';";  
    $r = (mysqli_query($obj->con,$q)); 
                 mysqli_close($obj->con);
    return $r;
}

public function Update() {
$r=0;
$ename="";
if($this->serv_id!=0 && $this->cs_id==0) {
       if($this->perc_disc!=0) {    
        $ename.= "update camp_serv_map set perc_disc='".$this->perc_disc."',upd_dt=now(),upd_usr='".$this->user."' where camp_id='".$this->camp_id."' and serv_id=".$this->serv_id.";";
//        if(mysqli_query($obj->con,$ename)){
//    $r++;
//    }
}
   

}
    if($this->serv_id==0 && $this->cs_id!="" && $this->cs_id!="-") {
    if($this->perc_disc!=0) {    
        $ename.= "update camp_serv_map set perc_disc='".$this->perc_disc."',upd_dt=now(),upd_usr='".$this->user."' where camp_id='".$this->camp_id."' and cs_id=".$this->cs_id.";";
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

public static function removeCampServ($camp_id,$serv_id,$cs_id) {
    $obj=new Base;
    	$ret=false;
        $q="delete from camp_serv_map where camp_id=$camp_id and serv_id=$serv_id and cs_id=$cs_id;";
//        echo $q;
    if(mysqli_query($obj->con,$q))
		$ret=true;

                 mysqli_close($obj->con);
	return $ret;
}




public function toString() {
    return "c".$this->camp_id." p".$this->serv_id." do".$this->perc_disc." cs".$this->cs_id." u".$this->user;
}


}
?>