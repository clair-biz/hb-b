<?php
require_once 'Classes/Classes.php';
$from_dt="";
$to_dt="";

if(isset($_REQUEST["from_dt"])!="" && !empty($_REQUEST["from_dt"])
&& isset($_REQUEST["to_dt"])!="" && !empty($_REQUEST["to_dt"]) ) {
$date = date_create($_REQUEST["from_dt"]);
$from_dt= date_format($date, "Y-m-d");
$date = date_create($_REQUEST["to_dt"]);
$to_dt= date_format($date, "Y-m-d");
}

switch ($_REQUEST["type"]) {
    case "transaction" : {
$vs_id=$_REQUEST["vs_id"];

$today= date_format(date_create(), "d-m-Y");
$filename="Transaction Report-$today";
if($vs_id!=0)
    $filename.="-".Vendor::getbnamebyvsid($vs_id);

if($from_dt!="" && $to_dt!="")
    $filename.="-Period ".$_REQUEST["from_dt"]." to ".$_REQUEST["to_dt"];

$query="SELECT distinct ordertbl.ord_id as 'Order No',date_format(ordertbl.ins_dt,'%d-%m-%Y') as 'Order Date',";

if($vs_id==0)
    $query.="bname as 'Vendor',";

$query.="cust_fname as 'Customer',date_format(delivery_date,'%d-%m-%Y') as 'Delivery Date',invc_amt as 'Invoice Amount',ord_amount as 'Order Amount',
sc_cust as 'Shipping Charges Paid By Customer',sc_vend as 'Shipping Charges Payable By Vendor'
from ordertbl,customer,ord_trans,vend_subscription,product,order_detail,invoice
where customer.cust_id=ordertbl.cust_id
and invoice.ord_id=ordertbl.ord_id
and order_detail.ord_id=ordertbl.ord_id
and product.prod_id=order_detail.prod_id
and product.vs_id=vend_subscription.vs_id
and ordertbl.ot_id=ord_trans.ot_id
and is_settled='N'
and now() > date_add(delivery_date, interval ordertbl.r_within day)
and ord_status='Completed'";

if($from_dt!="" && $to_dt!="")
    $query.=" and date_add(delivery_date, interval ordertbl.r_within day) between cast(N'$from_dt' as date) and cast(N'$to_dt' as date)";

if($vs_id!=0)
    $query.=" and vend_subscription.vs_id=$vs_id ;";
else
    $query.=" order by ordertbl.ord_id";
//echo $query;
    $cat111=mysqli_query(Crm::con(),$query);
    $can=0;
    

      $row= mysqli_fetch_array($cat111,MYSQLI_ASSOC);
      $headers= mysqli_fetch_fields($cat111);
      $head=array();
      foreach ($headers as $header)
          $head[]=$header->name;
      $index=count($head);
      $tabindex=$index;
      $array[0]="CGST";
      $array[1]="SGST";
      $array[2]="CESS";
      $array[3]="Total GST";
      $array[4]="Payable to Vendor";
      $head= array_merge($head,$array);
      $fp= fopen("php://output", "w");
      if($fp && $cat111) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    fputcsv($fp, array_values($head));
    while ($row= mysqli_fetch_array($cat111,MYSQLI_ASSOC)) {
        $cgst=Product::getTaxAmtFromOrder($row["Order No"],"cgst");
        $sgst=Product::getTaxAmtFromOrder($row["Order No"],"sgst");
        $cess=Product::getTaxAmtFromOrder($row["Order No"],"cess");
        $gstTotal=$cgst+$sgst+$cess;
        $toVendor=( (($row["Order Amount"])-$gstTotal)+($row["Shipping Charges Payable By Vendor"]) )  ;
//        echo "-$cgst-";
        $array=array();
        $array[0]=$cgst;
        $array[1]=$sgst;
        $array[2]=$cess;
        $array[3]=$gstTotal;
        $array[4]=$toVendor;
        $row= array_merge($row,$array);
        fputcsv($fp, array_values($row));
    $sumcgst+=$cgst;
    $sumsgst+=$sgst;
    $sumcess+=$cess;

    $suminvc+=$row["Invoice Amount"];
    $sumordamt+=$row["Order Amount"];
    $sumsccust+=$row["Shipping Charges Paid By Customer"];
    $sumscvend+=$row["Shipping Charges Payable By Vendor"];
    $sumpayable+=$toVendor;
    }
    if($vs_id==0)
     $array=["","","","","Total",$suminvc,$sumordamt,$sumsccust,$sumscvend,$sumcgst,$sumsgst,$sumcess,($sumcgst+$sumsgst+$sumcess),$sumpayable];   
    elseif($vs_id!=0)
     $array=["","","","Total",$suminvc,$sumordamt,$sumsccust,$sumscvend,$sumcgst,$sumsgst,$sumcess,($sumcgst+$sumsgst+$sumcess),$sumpayable];   
        fputcsv($fp, array_values($array));
      }
      
      
      
      }
      break;
      

    case "delivery" : {
        $case=$_REQUEST["case"];

$today= date_format(date_create(), "d-m-Y");
$filename="Delivery Report-$today";
    if($case!="")
        $filename.="-$case";

    if($from_dt!="" && $to_dt!="")
    $filename.="-Period ".$_REQUEST["from_dt"]." to ".$_REQUEST["to_dt"];


//            if(!empty($row[1]) && empty($row[2]) ) {
                $query="select DISTINCT d_id as 'Id',d_type as 'Delivery Type',d_date as 'Expected Delivery Date',d_on as 'Delivered On',d_status as 'Delivery Status',ordertbl.ord_id as 'Order No.',bname as 'Pickup Name',vend_addr as 'Pickup Address',sa_name as 'Drop Name',sa_addr as 'Drop Address'
from ordertbl,ship_addr,delivery,vendor,vend_subscription,users,product,order_detail
where ordertbl.ord_id=delivery.ord_id
and  ordertbl.sa_id=ship_addr.sa_id
and users.u_id=vend_subscription.u_id
and vend_subscription.vs_id=product.vs_id
and order_detail.prod_id=product.prod_id
and order_detail.ord_id=ordertbl.ord_id
and vendor.vend_id=users.vend_id
and ship_addr.cust_id=ordertbl.cust_id ";
                
        if($case=="Delivered")
            $query.=" and d_status='Delivered' ";
        elseif($case=="Not Delivered")
            $query.=" and d_status is null";
        
        if($from_dt!="" && $to_dt!="")
            $query.=" and d_date between cast(N'$from_dt' as date) and cast(N'$to_dt' as date) ";
$query.=" union select DISTINCT d_id as 'Id',d_type as 'Delivery Type',d_date as 'Expected Delivery Date',d_on as 'Delivered On',d_status as 'Delivery Status',ordertbl.ord_id as 'Order No.',sa_name as 'Pickup Name',sa_addr as 'Pickup Address',bname as 'Drop Name',vend_addr as 'Drop Address'
from ordertbl,ship_addr,delivery,vendor,vend_subscription,users,product,order_detail,prod_return
where  prod_return.pr_id=delivery.pr_id
and prod_return.prod_id=product.prod_id
and prod_return.ord_id=ordertbl.ord_id
and  ordertbl.sa_id=ship_addr.sa_id
and users.u_id=vend_subscription.u_id
and vend_subscription.vs_id=product.vs_id
and order_detail.prod_id=product.prod_id
and order_detail.ord_id=ordertbl.ord_id
and vendor.vend_id=users.vend_id
and ship_addr.cust_id=ordertbl.cust_id ";

        if($case=="Delivered")
            $query.=" and d_status='Delivered' ";
        elseif($case=="Not Delivered")
            $query.=" and d_status is null";
        
        if($from_dt!="" && $to_dt!="")
            $query.=" and d_date between cast(N'$from_dt' as date) and cast(N'$to_dt' as date)";

//            }
//echo $query;

            $res= mysqli_query(Crm::con(), $query);
//      $row= mysqli_fetch_array($res,MYSQLI_ASSOC);
      $headers= mysqli_fetch_fields($res);
      $head=array();
      foreach ($headers as $header)
          $head[]=$header->name;
      $fp= fopen("php://output", "w");
      if($fp && $res) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    fputcsv($fp, array_values($head));
            
    while ($row= mysqli_fetch_array($res,MYSQLI_ASSOC))  
        fputcsv($fp, array_values($row));

    }

    
    }
    break;
    case "tax" : {
$today= date_format(date_create(), "d-m-Y");
$filename="Tax Report-$today";

    if($from_dt!="" && $to_dt!="")
    $filename.="-Period ".$_REQUEST["from_dt"]." to ".$_REQUEST["to_dt"];


        $query="select ordertbl.ord_id,sum(cgst) as 'CGST',sum(sgst) as 'SGST',sum(cess) as 'CESS', (sum(cgst) + sum(sgst) + sum(cess) ) as 'Total Tax Payable'
from order_detail,ordertbl,delivery
where order_detail.ord_id=ordertbl.ord_id
and delivery.ord_id=ordertbl.ord_id";
        if($from_dt!="" && $to_dt!="")
    $query.=" and date_add(delivery_date, interval ordertbl.r_within day) between cast(N'$from_dt' as date) and cast(N'$to_dt' as date)";
        
$query.=" GROUP by ordertbl.ord_id";
            $res= mysqli_query(Crm::con(), $query);
//      $row= mysqli_fetch_array($res,MYSQLI_ASSOC);
      $headers= mysqli_fetch_fields($res);
      $head=array();
      foreach ($headers as $header)
          $head[]=$header->name;
      $fp= fopen("php://output", "w");
      if($fp && $res) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    fputcsv($fp, array_values($head));
            $sumcgst=0;
            $sumsgst=0;
            $sumcess=0;
            
    while ($row= mysqli_fetch_array($res,MYSQLI_ASSOC)) {
        fputcsv($fp, array_values($row));
    $sumcgst+=$row["CGST"];
    $sumsgst+=$row["SGST"];
    $sumcess+=$row["CESS"];
    }
    
    }
    $array=["Total",$sumcgst,$sumsgst,$sumcess,($sumcgst+$sumsgst+$sumcess)];
        fputcsv($fp, array_values($array));
    }
    break;

}
//mysqli_free_result($cat111);
//stmtcat111.close();
?>
