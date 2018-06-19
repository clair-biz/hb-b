<?php
spl_autoload_register(function ($class) {
    include '' . $class . '.php';
});

class ProductPrice extends Base{
private $prod_id;    
private $mrp;    
private $mrpfor;    
private $unitfor;    
private $formajor;    
private $base_prc;    
private $sell_prc;    
//private $cgst;    
//private $sgst;    
private $other_tax;    
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


/*public function canInsert() throws SQLException,ClassNotFoundException {
    boolean check=0;
    try {
    String q="";
    if(Product.chkProd(prod_id)) {
       q="select count(*) from  product_price where prod_id=".$this->prod_id.";";
    Statement ename = con().createStatement();
    ResultSet rs=ename.executeQuery(q);
            if(rs.next()) {
                if(rs.getInt(1)==0)
                    check=1;
                rs.close();
                ename.close();
            }
        }
    }
    catch(Exception e) {
    }
    return check;
}

public String cantInsert() throws SQLException,ClassNotFoundException {
    String check="";
    try {
        if(!Product.chkProd(prod_id))
            check+="Invalid Product Id";
    if(Product.chkProd(prod_id)) {    
     String q="select count(*) from  product_price where prod_id=".$this->prod_id.";";
    Statement ename = con().createStatement();
    ResultSet rs=ename.executeQuery(q);
    if(rs.next())
        if(rs.getInt(1)>0)
            check+="Already exists!";
            rs.close();
            ename.close();
    }
    }
    catch(Exception e) {
        if(e.toString().compareTo("")!=0)
        check+="Caught Exception "+e;
    }
    return check;
}*/
public function calpricewithtax(){
    $mrp=0;
    $q="select cgst,sgst,cess from tax_table,product where product.hsn_code=tax_table.hsn_code and prod_id=". $this->prod_id.";";
    echo $q;
    $g=mysqli_query($this->con,$q);
    if($row=mysqli_fetch_array($g)){
     $mrp=$this->base_prc+($this->base_prc*($row[0]/100))+($this->base_prc*($row[1]/100))+($this->base_prc*($row[2]/100));   
    }
                 mysqli_close($this->con);
return $mrp;
    
    }

public function Insert(){
    $check=false;
    $q="insert into product_price(prod_id,mrp,mrp_for,mrp_unit,for_major,sell_prc,ins_dt,ins_usr) values(".$this->prod_id.",".$this->mrp.",".$this->mrpfor.",'".$this->unitfor."',".$this->formajor.",".$this->sell_prc.",now(),'".$this->user."');";
//    Statement ename = con().createStatement();
//    System.out.println(q);
//   int p=ename.executeUpdate(q);
//   ename.close();
	//echo $q;
  if(mysqli_query($this->con,$q))
      $check=true;
                 mysqli_close($this->con);
      return $check;
}

public function Update(){
//    boolean check=0;
    //ProductPrice.pricehistinsert(prod_id);
   // int r=0;
    //System.out.println("Campaign name "+campname);
    //System.out.println("user "+user);
    //System.out.println("id "+id);
    $r=0;
    if($this->mrp!="") {
        $ename="update product_price set mrp='".$this->mrp."',upd_dt=now(),upd_usr='".$this->user."' where prod_id=".$this->prod_id;
        if(mysqli_query($this->con,$ename))
      $r=1;
      else
          echo mysqli_error($this->con);
    }
    if($this->mrpfor!="") {
        $ename="update product_price set mrp_for='".$this->mrpfor."',upd_dt=now(),upd_usr='".$this->user."' where prod_id=".$this->prod_id;
        if(mysqli_query($this->con,$ename))
      $r=1;
      else
          echo mysqli_error($this->con);
    }
    if($this->unitfor!="") {
        $ename="update product_price set mrp_unit='".$this->unitfor."',upd_dt=now(),upd_usr='".$this->user."' where prod_id=".$this->prod_id;
        if(mysqli_query($this->con,$ename))
      $r=1;
      else
          echo mysqli_error($this->con);
    }
    if($this->formajor!="") {
        $ename="update product_price set for_major='".$this->formajor."',upd_dt=now(),upd_usr='".$this->user."' where prod_id=".$this->prod_id;
        if(mysqli_query($this->con,$ename))
      $r=1;
      else
          echo mysqli_error($this->con);
    }
    if($this->base_prc!=0) {
        $ename="update product_price set base_prc='".$this->base_prc."',upd_dt=now(),upd_usr='".$this->user."' where prod_id=".$this->prod_id;
        if(mysqli_query($this->con,$ename))
      $r=1;
      else
          echo mysqli_error($this->con);
    }
    if($this->sell_prc!=0) {
        $ename="update product_price set sell_prc='".$this->sell_prc."',upd_dt=now(),upd_usr='".$this->user."' where prod_id=".$this->prod_id;
        if(mysqli_query($this->con,$ename))
      $r=1;
      else
          echo mysqli_error($this->con);
    }
    /*if($this->cgst!=0) {
        $ename="update product_price set cgst='".$this->cgst."',upd_dt=now(),upd_usr='".$this->user."' where prod_id=".$this->prod_id;
        if(mysqli_query($obj->con,$ename))
      $r=1;
      else
          echo mysqli_error($obj->con);
    }    
    if($this->sgst!=0) {
        $ename="update product_price set sgst='".$this->sgst."',upd_dt=now(),upd_usr='".$this->user."' where prod_id=".$this->prod_id;
        if(mysqli_query($obj->con,$ename))
      $r=1;
      else
          echo mysqli_error($obj->con);
    }*/
    if($this->other_tax!=0) {
        $ename="update product_price set other_tax='".$this->other_tax."',upd_dt=now(),upd_usr='".$this->user."' where prod_id=".$this->prod_id;
        if(mysqli_query($this->con,$ename))
      $r=1;
      else
          echo mysqli_error($this->con);
    }
    
                 mysqli_close($this->con);
    return $r;
}

/*public static void pricehistinsert(int p) throws SQLException,ClassNotFoundException {
    String q="Select * from product_price where prod_id=?";
    System.out.print(q);
    PreparedStatement cust = con().prepareStatement(q);
        cust.setInt(1, p);
        ResultSet rscust = cust.executeQuery();                        

        if(rscust.next()) {
            String q1="insert into product_price_hist(prod_id,mrp,base_prc,sell_prc,cgst,sgst,other_tax,ins_dt,upd_dt,ins_usr,upd_usr) values(?,?,?,?,?,?,?,?,?,?,?)";
            
    PreparedStatement cust1 = con().prepareStatement(q1);
        cust1.setInt(1, rscust.getInt(1));
        cust1.setDouble(2, rscust.getDouble(2));
        cust1.setDouble(3, rscust.getDouble(3));
        cust1.setDouble(4, rscust.getDouble(4));
        cust1.setDouble(5, rscust.getDouble(5));
        cust1.setDouble(6, rscust.getDouble(6));
        cust1.setDouble(7, rscust.getDouble(7));
        cust1.setDate(8, rscust.getDate(8));
        cust1.setDate(9, rscust.getDate(9));
        cust1.setString(10, rscust.getString(10));
        cust1.setString(11, rscust.getString(11));

        int rscust1 = cust1.executeUpdate();                        
            System.out.print(q1);
            cust1.close();
        }
rscust.close();
cust.close();
}*/
public static function calformajor($mrp,$mrpfor,$unitfor){
     $obj=new Base;
    $formajor=0; 
    switch($unitfor){
       case 'gm':
           $formajor=($mrp*1000)/$mrpfor;
           break;
       case 'mg':
           $formajor=($mrp*1000000)/$mrpfor;
           break;
       case 'Kg':
           $formajor=($mrp/$mrpfor);
           break;
       case 'ml':
           $formajor=($mrp*1000)/$mrpfor;
           break;
       case 'L':
           $formajor=($mrp/$mrpfor);
           break;
       case 'Piece':
           $formajor=($mrp/$mrpfor);
           break;
   }
   return $formajor;
}

public function toString() {
    return $this->prod_id." ".$this->mrp." ".$this->mrpfor." ".$this->unitfor." ".$this->base_prc." ".$this->sell_prc." ".$this->cgst." ".$this->sgst." ".$this->other_tax." ".$this->user;
}

/*
public static void main(String[] args) {
    try {
//            Pattern p=Pattern.compile("^(?:(?:31(\\/|-|\\.)(?:0?[13578]|1[02]))\\1|(?:(?:29|30)(\\/|-|\\.)(?:0?[1,3-9]|1[0-2])\\2))(?:(?:1[6-9]|[2-9]\\d)?\\d{2})$|^(?:29(\\/|-|\\.)0?2\\3(?:(?:(?:1[6-9]|[2-9]\\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\\d|2[0-8])(\\/|-|\\.)(?:(?:0?[1-9])|(?:1[0-2]))\\4(?:(?:1[6-9]|[2-9]\\d)?\\d{2})$");
//            System.out.print(p.matcher("2012/1/1").matches());
/*        Campaign c=new Campaign("sfd","2017-12-31","2017-12-31","s");
        System.out.println(c.toString());
        System.out.println(c.canInsert());
        System.out.println("ss "+c.cantInsert());*
SimpleDateFormat sdf = new SimpleDateFormat("dd-MM-yyyy");
java.util.Date d=new java.util.Date("2017-4-20");
String startdate=sdf.format(d);
System.out.print(startdate);
*
ProductPrice.pricehistinsert(11);
//        Campaign.Import("u");
    }
    catch(Exception e) {
        System.out.print(e);
    }*/
}
?>