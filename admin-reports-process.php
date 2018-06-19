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
$queryvs="select distinct vend_subscription.vs_id
 from vend_subscription,delivery,ordertbl,order_detail,product
 where product.prod_id=order_detail.prod_id
 and product.vs_id=vend_subscription.vs_id
 and order_detail.ord_id=ordertbl.ord_id
 and delivery.ord_id=ordertbl.ord_id
 
";
if($vs_id==0) 
$queryvs.="and vend_subscription.vs_id<>0 ";
else
$queryvs.=" and vend_subscription.vs_id=$vs_id ";

if($from_dt!="" && $to_dt!="")
    $queryvs.=" and date_add(delivery_date, interval ordertbl.r_within day) between cast(N'$from_dt' as date) and cast(N'$to_dt' as date)";
    
//    $queryvs.=" and vend_subscription.vs_id=$rowvs[0] ;";

//    echo $queryvs."<br /><br />";
$resvs= mysqli_query(Crm::con(), $queryvs);
if(mysqli_num_rows($resvs)) {
while($rowvs= mysqli_fetch_array($resvs)) {
$filename="Transaction Report-$today";
    $filename.="-".Vendor::getbnamebyvsid($rowvs[0]);
if($from_dt!="" && $to_dt!="")
    $filename.="-Period ".$_REQUEST["from_dt"]." to ".$_REQUEST["to_dt"];

    $query="SELECT DISTINCT ordertbl.ord_id as 'Order No', date_format(ordertbl.ins_dt,'%d-%m-%Y') as 'Order Date',cust_fname as 'Customer',date_format(delivery_date,'%d-%m-%Y') as 'Delivery Date',invc_amt as 'Invoice Amount',
sc_cust as 'Shipping Charges Paid By Customer',sc_vend as 'Shipping Charges Payable By Vendor',sc_hb as 'Shipping Charges Payable By HomeBiz365',ordertbl.sc_off as 'Shipping Charges Beared By Tago',round( (sc_vend+sc_cust+sc_hb+ordertbl.sc_off) ) as 'Total Shipping Charges',round( (sc_vend+sc_cust+sc_hb)*(tax_table.cgst/100)) as 'Shipping Charges CGST',round( (sc_vend+sc_cust+sc_hb)*(tax_table.sgst/100) ) as 'Shipping Charges SGST',round( (sc_vend+sc_cust+sc_hb)*(tax_table.cess/100) ) as 'Shipping Charges CESS', round( ( (sc_vend+sc_cust+sc_hb)*(tax_table.cgst/100) )+( (sc_vend+sc_cust+sc_hb)*(tax_table.sgst/100) )+( (sc_vend+sc_cust+sc_hb)*(tax_table.cess/100) ) ) as 'Total GST Payable on Shipping', round(cust_perc+vend_perc+hb_perc) as 'Shipping Charges Payable to Tago',ord_amount as 'Order Amount'
from ordertbl,customer,ord_trans,vend_subscription,product,order_detail,invoice,tax_table,ship_charge
where customer.cust_id=ordertbl.cust_id
and invoice.ord_id=ordertbl.ord_id
and product.hsn_code=tax_table.hsn_code
and order_detail.ord_id=ordertbl.ord_id
and product.prod_id=order_detail.prod_id
and product.vs_id=vend_subscription.vs_id
and ordertbl.ot_id=ord_trans.ot_id
and is_settled='N'
and cust_perc+vend_perc+hb_perc=(select cust_perc+hb_perc+vend_perc as  'Shipping Charges Payable to Tago' from ship_charge where ord_amount BETWEEN min_ord and max_ord)
and now() > date_add(delivery_date, interval ordertbl.r_within day)
and ord_status='Completed'";

if($from_dt!="" && $to_dt!="")
    $query.=" and date_add(delivery_date, interval ordertbl.r_within day) between cast(N'$from_dt' as date) and cast(N'$to_dt' as date)";
    
    $query.=" and vend_subscription.vs_id=$rowvs[0] ;";
//    echo $query."<br /><br />";
    $res=mysqli_query(Crm::con(),$query);
    
//      $row= mysqli_fetch_array($res,MYSQLI_ASSOC);
      $headers= mysqli_fetch_fields($res);
      $head=array();
      foreach ($headers as $header)
          $head[]=$header->name;
    
      $array=array();
      $array[0]="CGST on Products";
      $array[1]="SGST on Products";
      $array[2]="CESS on Products";
      $array[3]="Total GST Payable on Products";
      $array[4]="Transaction Charges";
      $array[5]="Payable to Vendor";
      $array[6]="Payable Taxes(GST)";
      
      $head= array_merge($head,$array);
      $fp= fopen("php://output", "w");
      if($fp && $res) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    
      $tabindex=$index;
    
//      $head= array_merge($head,$array);
    fputcsv($fp, array_values($head));
      
      $sumcgst=0;
      $sumsgst=0;
      $sumcess=0;
      $suminvc=0;
      $sumordamt=0;
      $sumsccust=0;
      $sumscvend=0;
      $sumpayable=0;
      $sumgstShipping=0;
      $sumgstProduct=0;
      $sumgstTotal=0;
      $sumtoTago=0;
      $sumsccgst=0;
      $sumscsgst=0;
      $sumsccess=0;
      $transaction_charge=0;
      $sumtc=0;
      while ($row= mysqli_fetch_array($res,MYSQLI_ASSOC)) {
    
        $cgst=Product::getTaxAmtFromOrder($row["Order No"],"cgst");
        $sgst=Product::getTaxAmtFromOrder($row["Order No"],"sgst");
        $cess=Product::getTaxAmtFromOrder($row["Order No"],"cess");
        $gstProduct=$cgst+$sgst+$cess;
        $toVendor= (($row["Order Amount"])-$gstProduct)  ;
        $transaction_charge=($toVendor*0.1);
        $toVendor=$toVendor-($row["Shipping Charges Payable By Vendor"])  ;
        $gstTotal=$gstProduct+$row["Total GST Payable on Shipping"];
        $sumsccgst+=$row["Shipping Charges CGST"];
        $sumscsgst+=$row["Shipping Charges SGST"];
        $sumsccess+=$row["Shipping Charges CESS"];
        $sumtoTago+=$row["Shipping Charges Payable to Tago"];
        $sumgstShipping+=$row["Total GST Payable on Shipping"];
        $sumtc+=$transaction_charge;  
        $array=array();
        $array[0]=$cgst;
        $array[1]=$sgst;
        $array[2]=$cess;
        $array[3]=$gstProduct;
        $array[4]=$transaction_charge;
        $array[5]=$toVendor-($toVendor*.10);
        $array[6]=$gstTotal;
        $row= array_merge($row,$array);
//        print_r($row);
        fputcsv($fp, array_values($row));
    $sumcgst+=$cgst;
    $sumsgst+=$sgst;
    $sumcess+=$cess;

    $suminvc+=$row["Invoice Amount"];
    $sumordamt+=$row["Order Amount"];
    $sumsccust+=$row["Shipping Charges Paid By Customer"];
    $sumscvend+=$row["Shipping Charges Payable By Vendor"];
    $sumschb+=$row["Shipping Charges Payable By HomeBiz365"];
    $sumsctago+=$row["Shipping Charges Beared By Tago"];
    $sumsc=$sumsccust+$sumscvend+$sumschb+$sumsctago;
    $sumpayable+=$toVendor-($toVendor*0.1);
    $sumgstProduct+=$gstProduct;
    $sumgstTotal+=$gstTotal;
      }
     $array=["","","","Total",$suminvc,$sumsccust,$sumscvend,$sumschb,$sumsctago,$sumsc,$sumsccgst,$sumscsgst,$sumsccess,$sumgstShipping,$sumtoTago,$sumordamt,$sumcgst,$sumsgst,$sumcess,$sumgstProduct,$sumtc,$sumpayable,$sumgstTotal];   
        fputcsv($fp, array_values($array));
    
}

    
}
      
    }
    else
echo "<script>window.location.href='".Crm::root()."Reports';</script>";
      
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
if(mysqli_num_rows($res)) {
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
    else
echo "<script>window.location.href='".Crm::root()."Reports';</script>";
    
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
if(mysqli_num_rows($res)) {
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
    $array=["Total",$sumcgst,$sumsgst,$sumcess,($sumcgst+$sumsgst+$sumcess)];
        fputcsv($fp, array_values($array));
    
    }
    }
    else
echo "<script>window.location.href='".Crm::root()."Reports';</script>";

    }
    break;

    case "vendor": {
        $query="";
    }
    break;
}
//mysqli_free_result($cat111);
//stmtcat111.close();
?>
