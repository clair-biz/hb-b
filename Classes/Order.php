<?php
spl_autoload_register(function ($class) {
    include '' . $class . '.php';
});

class Order extends Base{
private $ord_id;
private $cart_id;
private $type;
private $cust_id;
private $prod_id;    
private $bs_id;    
private $qty;    
private $unit;    
private $rate;    
private $cgst;    
private $sgst;    
private $cess;    
private $ship_rate;    
private $wallet;    

private $req_on;
private $name;
private $cntc;
private $email;
private $zip;
private $addr;
private $subtotal;
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


public function OrderInsert() {
	$ret=false;
        $q="insert into order_detail(ord_id,prod_id,ord_qty,ord_rate,cgst,sgst,cess,ins_dt,ins_usr) values(".$this->ord_id.",".$this->prod_id.",".$this->qty.",".$this->rate.",".$this->cgst.",". $this->sgst.",". $this->cess.",now(),'".$this->user."')";
        echo $q;
    if(Base::generateResult($q))
		$ret=true;

//                 mysqli_close($this->con);
	return $ret;
}


public static function checkCart($cust_id,$prod_id,$req_dt,$bs_id) {
    $obj=new Base;
    $ret=0;
    $q="select qty from cart where cust_id=$cust_id and prod_id=$prod_id and req_dt=cast(N'$req_dt' as date) and bs_id=$bs_id;";
    echo $q;
    $res= Base::generateResult( $q);
    if($row= mysqli_fetch_array($res))
            $ret=$row[0];
    
    return $ret;
}

public static function getCartId($cust_id,$prod_id,$req_dt,$bs_id) {
    $obj=new Base;
    $ret=0;
    $q="select cart_id from cart where cust_id=$cust_id and prod_id=$prod_id and req_dt=cast(N'$req_dt' as date) and bs_id=$bs_id;";
    echo $q;
    $res= Base::generateResult( $q);
    if($row= mysqli_fetch_array($res))
            $ret=$row[0];
    
    return $ret;
}

public function CartInsert() {
    	$ret=false;
        $count=Order::checkCart($this->cust_id, $this->prod_id, $this->req_on, $this->bs_id);
        if($count==0) {

            $q="insert into cart(cust_id,prod_id,qty,req_dt,bs_id,ins_dt,ins_usr) values(".$this->cust_id.",".$this->prod_id.",".$this->qty.",cast(N'".$this->req_on."' as date),".$this->bs_id.",now(),'".$this->user."')";
        }
        elseif($count>0) {
            $cart_id=Order::getCartId($this->cust_id, $this->prod_id, $this->req_on, $this->bs_id);
            $q0="select qty from cart where cart_id=$cart_id";
            echo $q0;
            $res=Base::generateResult($q0);//Base::generateResult($q0);
            if($row= mysqli_fetch_array($res)) {
                $this->qty= $this->qty+$row[0];
            }

        $q="update cart set qty=".$this->qty." where cart_id=$cart_id;";
        }
        echo $q;
    if(Base::generateResult($q)) {
		$ret=true;
    }
//                 mysqli_close($this->con);
	return $ret;
}
public static  function newOrdId() {
    $obj=new Base;
    $out=1;
    $q="SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'ord_trans'";
//    echo $q."<br>";
    $res= Base::generateResult( $q);
    if($row= mysqli_fetch_array($res))
            $out=$row[0];
    
//                 mysqli_close($obj->con);
    return $out;
}

public static  function newServiceOrdId() {
    $obj=new Base;
    $out=1;
    $q="select ord_id from serviceordertbl order by ord_id desc";
    $res= Base::generateResult( $q);
    if($row= mysqli_fetch_array($res))
            $out+=$row[0];
    
//                 mysqli_close($obj->con);
    return $out;
}

public static  function getOrdCost($cust_id,$vs_id,$req_dt,$bs_id,$charge=0) {
    $obj=new Base;
    $out=0;
    $q="SELECT product.prod_id,qty FROM `cart`,product where product.prod_id=cart.prod_id and cust_id=$cust_id and bs_id=$bs_id and req_dt='$req_dt' and vs_id=$vs_id";
//    echo $q;
    $res= Base::generateResult( $q);
    while($row= mysqli_fetch_array($res)) 
            $out+=Base::getDiscount($row[0],$row[1],$charge);

//                 mysqli_close($obj->con);
    return $out;
}

public static  function getOrdAmt($ord_id) {
    $obj=new Base;
    $out=0;
    $q="SELECT ord_amount+sc_cust FROM ordertbl where ord_id=$ord_id;";
//    echo $q;
    $res= Base::generateResult( $q);
    if($row= mysqli_fetch_array($res))
            $out=$row[0];
    
//                 mysqli_close($obj->con);
    return $out;
}

public static  function getShipCharge($cust_id,$vs_id,$req_dt,$bs_id,$type) {
    $obj=new Base;
    $out=0;
    $q="";
    $ord_cost=Order::getOrdCost($cust_id, $vs_id, $req_dt, $bs_id,1);
//    $q="SELECT product.prod_id,qty*mrp,((qty*mrp)/$ord_cost)*100, ship_charge+sum((((qty*mrp)/$ord_cost)*100)*(tax_table.cgst/100))+sum((((qty*mrp)/$ord_cost)*100)*(tax_table.sgst/100))+sum((((qty*mrp)/$ord_cost)*100)*(tax_table.cess/100))  as c, (ship_charge+sum((((qty*mrp)/$ord_cost)*100)*(tax_table.cgst/100))+sum((((qty*mrp)/$ord_cost)*100)*(tax_table.sgst/100))+sum((((qty*mrp)/$ord_cost)*100)*(tax_table.cess/100)))*($type/100)  FROM ship_charge,`cart`,product_price,product,tax_table where tax_table.hsn_code=product.hsn_code and product.prod_id=product_price.prod_id and cart.prod_id=product.prod_id and qty*mrp BETWEEN min_ord and max_ord  and bs_id=$bs_id and req_dt='$req_dt' and vs_id=$vs_id";
    $q="SELECT product.prod_id,qty*mrp,((qty*mrp)/$ord_cost)*100, ship_charge  as c, (ship_charge*($type/100) )  FROM ship_charge,`cart`,product_price,product,tax_table where tax_table.hsn_code=product.hsn_code and product.prod_id=product_price.prod_id and cart.prod_id=product.prod_id and qty*mrp BETWEEN min_ord and max_ord  and bs_id=$bs_id and req_dt='$req_dt' and vs_id=$vs_id";
//    echo $q;
    $res= Base::generateResult( $q);
    if($row= mysqli_fetch_array($res))
            $out+=$row[4];
    
//                 mysqli_close($obj->con);
    return $out;
}

public static  function getInvcProdAmt($invc_id) {
    $obj=new Base;
    $out=0;
    $q="";
    $q="select sum(ord_rate*ord_qty) from ordertbl,order_detail,invoice WHERE order_detail.ord_id=ordertbl.ord_id and invoice.ord_id=ordertbl.ord_id and invc_id=$invc_id";
//    echo $q;
    $res= Base::generateResult( $q);
    if($row= mysqli_fetch_array($res))
            $out+=$row[0];
    
//                 mysqli_close($obj->con);
    return $out;
}

public static function removeCartItem($cart_id) {
    $obj=new Base;
    	$ret=false;
        $q="delete from cart where cart_id=$cart_id;";
//        echo $q;
    if(Base::generateResult($q))
		$ret=true;

//                 mysqli_close($obj->con);
	return $ret;
}

public static function cancelOrderCustomer($ord_id) {
    $obj=new Base;
    	$ret=false;
        $q="update ordertbl set ord_status='Canceled' where ord_id=$ord_id;";
//        echo $q;
    if(Base::generateResult($q))
		$ret=true;

//                 mysqli_close($obj->con);
	return $ret;
}

 public static function getCountCart($cust_id) {
     $obj=new Base;
    	$ret=0;
            if(isset($cust_id)!="" || !empty($cust_id)) {
        $q="SELECT count(*) from cart WHERE cust_id=$cust_id;";
    $res=Base::generateResult($q);
	 if($row=mysqli_fetch_array($res))
		$ret=$row[0];
            }
//                 mysqli_close($obj->con);
        return $ret;
 }
 
 /*
public static function RequestOrder($vend_id,$cust_id,$ord_id) {
	$ret=false;
        $q="select product.prod_id,prod_name,qty,mrp,req_dt,unit,cart_id from cart,product,product_price where product.prod_id=product_price.prod_id and cart.prod_id=product.prod_id and cust_id=$cust_id and vend_id=$vend_id;";
//    echo $q."<br>";
    $total=0;
        $msg="Order Details<br>";
    $res=Base::generateResult($q);
    while ($row= mysqli_fetch_array($res)) {
       $o=new Order($ord_id,$cust_id,$row[0],$row[4],$row[2],$row[5],$row[3],$_SESSION["user"]);
       if($o->OrderInsert() && Order::removeCartItem($row[6]) ) {
           if($row[5]=="GM" || $row[5]=="mL")
        $total+=$row[3]*($row[2]/1000);
                    else
        $total+=$row[2]*$row[3];
        $msg.="<br>Required On: ".$row[4];
        $msg.="<br>Product: ".$row[1];
        $msg.="<br>Qty: ".$row[2]." ".$row[5];
        $msg.="<br>Price: ".$row[3];
        
           if($row[5]!="GM" || $row[5]!="mL")
        $msg.="<br>Subtotal: ".($row[3]*$row[2]);
           else
        $msg.="<br>Subtotal: ".($row[3]*($row[2]/1000));
        }
        $msg.="<br>";
    }
    $msg.="<br>Total Amount: $total";

    $vendmsg=$msg."<br>";

    $custmsg="Thank you, for Ordering through www.homebiz365.in<br><br>$msg<br>";

    $cust_subject="HomeBiz365 - Order Request Received";
    $vend_subject="HomeBiz365 - Order Notification";
    
    $q="select disp_name,vend_cntc,vend_email from vendor,users where vendor.vend_id=users.vend_id and u_id=$vend_id;";
//    echo $q;
    $res=Base::generateResult($q);
    while ($row= mysqli_fetch_array($res)) {
        $vend_email=$row[2];
        $vend_cntc=$row[1];
        $vend_name=$row[0];
        $custmsg.="<br>Vendor Name: ".$row[0];
        $custmsg.="<br>Contact: ".$row[1];
        $custmsg.="<br>Email ID: ".$row[2];
    }
    
    $q="select cust_fname,cust_lname,cust_cntc,cust_email from customer where cust_id=$cust_id;";
//    echo $q;
    $res=Base::generateResult($q);
    while ($row= mysqli_fetch_array($res)) {
        $cust_email=$row[3];
        $cust_cntc=$row[2];
        $cust_name=$row[0]." ".$row[1];
        $vendmsg.="<br>Please contact ".$row[0]." ".$row[1];
        $vendmsg.="<br>Contact: ".$row[2];
        $vendmsg.="<br>Email ID: ".$row[3];
    $vendmsg.="<br>to provide the above mentioned products.";
    }
    $cattype1="Order Request";
if(Email::sendEmail($cust_name,$cust_email,$cust_subject,$custmsg) && Email::sendEmail($vend_name,$vend_email,$vend_subject,$vendmsg)
    && Sms::sendOrderInfo($cust_name,$cust_cntc,"Order Request","Received","") && Sms::sendOrderNotification($vend_name,$vend_cntc,$cattype1))
    return true;
else
    return false;


    }
 */
public static function getTax($prod_id,$type) {
    $obj=new Base;
    $ret=0;
    if($type=="cess")
    $query="select ((mrp*(tax_table.cgst/100)+mrp*(tax_table.sgst/100) )*((tax_table.cess/100))) from product,product_price,tax_table where product.prod_id=product_price.prod_id and product.hsn_code=tax_table.hsn_code and product.prod_id=$prod_id;";
    else
    $query="select (mrp*(tax_table.$type/100)) from product,product_price,tax_table where product.prod_id=product_price.prod_id and product.hsn_code=tax_table.hsn_code and product.prod_id=$prod_id;";
    echo $query;
    $res=Base::generateResult($query);
	 if($row=mysqli_fetch_array($res))
		$ret=$row[0];
            
//                 mysqli_close($obj->con);
        return $ret;
 }

 public static function canReturn($ord_id,$prod_id) {
     $obj=new Base;
    $ret=0;
    $query="select ordertbl.ord_id,order_detail.prod_id, prod_return,prod_replace, ordertbl.r_within, delivery_date, delivery_status,date_add(delivery_date, INTERVAL ordertbl.r_within day)
from ordertbl,order_detail,product
where order_detail.ord_id=ordertbl.ord_id
and product.prod_id=order_detail.prod_id
and now() BETWEEN delivery_date and date_add(delivery_date, INTERVAL ordertbl.r_within day)
and 'Y' in (prod_return,prod_replace)
and ordertbl.ord_id=$ord_id and product.prod_id=$prod_id;";
//    echo $query;
    $res=Base::generateResult($query);
    $nos=0;
    $nos= mysqli_num_rows($res);
//	 if($row=mysqli_fetch_array($res))
//		$ret=$row[0];
            
//                 mysqli_close($obj->con);
        return $nos;
 }

public static function RequestOrder($ord_id,$cust_id,$prod_id,$user) {
    $obj=new Base;
	$ret=false;
            $vend_id=Product::getvendidbyprodid($prod_id);
        $q="insert into ordertbl(ord_id,cust_id,prod_id,ins_dt,ins_usr) values($ord_id,$cust_id,$prod_id,now(),'$user');";
//        echo $q;
        $cattype1="Product";
        $cust_cntc=Customer::getcustcntcbyid($cust_id);
        $cust_name=Customer::getcustnamebyid($cust_id);
        $vend_cntc=Vendor::getvendcntcbyprodid($prod_id);
        $vend_name=Vendor::getvendnamebyprodid($prod_id);
        $prod_name=Product::getprodnamebyid($prod_id);
    if (Base::generateResult($q) && Sms::sendOrderInfo($cust_name,$cust_cntc,$prod_name,$vend_name,$vend_cntc) && Sms::sendOrderNotification($cust_name,$cust_cntc,$prod_name,$vend_name,$vend_cntc)) {
//                 mysqli_close($obj->con);
    return true;
    }
else {
//                 mysqli_close($obj->con);
    return false;
}
    }
 
public function invcGenerate($amount,$invc_dt) {
    $obj=new Base;
	$ret=false;
            $invc_id=Base::getAIValue("invoice");
        $q="insert into invoice values(invc_id,ord_id,invc_amt,invc_dt,ins_dt,ins_usr) values($invc_id,$this->ord_id,$amount,$invc_dt,now(),'".$_SESSION["user"]."');";
        echo $q;
    if (Base::generateResult($q) ) {
        $data="1;abc;10;1;10;5;0.5;10.5";
// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->BodyTitle();
$pdf->ImprovedTable($invc_id);
$pdf->AddPage();
$pdf->SetFont('Times','',12);
for($i=1;$i<=40;$i++)
//                 mysqli_close($obj->con);
	$pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output();

    }
else {
//                 mysqli_close($obj->con);
    return false;
}
    }
 
public static function ServiceRequestOrder($ord_id,$cust_id,$serv_id,$user) {
    $obj=new Base;
	$ret=false;
//            $vend_id=service::getvendidbyservid($serv_id);
        $q="insert into serviceordertbl(ord_id,cust_id,serv_id,ins_dt,ins_usr) values($ord_id,$cust_id,$serv_id,now(),'$user');";
//        echo $q;
        $cust_cntc=Customer::getcustcntcbyid($cust_id);
        $cust_name=Customer::getcustnamebyid($cust_id);
        $vend_cntc=Vendor::getvendcntcbyservid($serv_id);
        $vend_name=Vendor::getvendnamebyservid($serv_id);
        $serv_name=Service::getservnamebyid($serv_id);
    if (Base::generateResult($q) && Sms::sendOrderInfoService($cust_name,$cust_cntc,$serv_name,$vend_name,$vend_cntc) && Sms::sendOrderNotificationService($cust_name,$cust_cntc,$serv_name,$vend_name,$vend_cntc))
    return true;
else
    return false;
    }
 
 public static function getWalletAmt($user){
     $obj=new Base;
    if($user. substr("@administrator", 0)) {
//            $admin=$user;
                    $user0= explode("@administrator", $user);
                    $user=$user0[0];
                }
    $q="select wallet_amt from users where u_name='$user'";
     $m=Base::generateResult($q);
    if($row=mysqli_fetch_array($m)){
		$amt=$row[0];
            }
//                 mysqli_close($obj->con);
        return $amt;
}

public static function getReturnProdAmt($ord_id,$prod_id){
    $obj=new Base;
    $q="select ord_rate from order_detail where order_detail.ord_id=$ord_id and order_detail.prod_id=$prod_id";
    $m=Base::generateResult($q);
     if($row=mysqli_fetch_array($m)){
		$pr_amount=$row[0];
            }
//                 mysqli_close($obj->con);
        return $pr_amount;
}
 
public static function countRefund(){
    $obj=new Base;
    
    $q="select count(*) from prod_return where pr_status='Refund';";
    $m=Base::generateResult($q);
     if($row=mysqli_fetch_array($m)){
		$pr_amount=$row[0];
            }
//                 mysqli_close($obj->con);
        return $pr_amount;
}
 
public static function getBSdatabyprid($pr_id,$field){
    $obj=new Base;
    $q="select booking_slots.$field from prod_return,ordertbl,booking_slots where booking_slots.bs_id=ordertbl.bs_id and ordertbl.ord_id=prod_return.ord_id and pr_id=$pr_id;";
    $m=Base::generateResult($q);
     if($row=mysqli_fetch_array($m)){
		$pr_amount=$row[0];
            }
//                 mysqli_close($obj->con);
        return $pr_amount;
}
 
}
?>