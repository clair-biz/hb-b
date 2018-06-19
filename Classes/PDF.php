<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once  'FPDF/fpdf.php';
require_once 'Base.php'; 
require_once 'Order.php'; 

//$obj=new Index;
$root="http://".$_SERVER["SERVER_NAME"]."/";
$city=$_COOKIE["city"];

$user="";   
if(isset($_SESSION["user"])!="")
    $user= json_decode ($_SESSION["user"]);
//function hex2dec
//returns an associative array (keys: R,G,B) from a hex html code (e.g. #3FE5AA)
function hex2dec($couleur = "#000000"){
    $R = substr($couleur, 1, 2);
    $rouge = hexdec($R);
    $V = substr($couleur, 3, 2);
    $vert = hexdec($V);
    $B = substr($couleur, 5, 2);
    $bleu = hexdec($B);
    $tbl_couleur = array();
    $tbl_couleur['R']=$rouge;
    $tbl_couleur['G']=$vert;
    $tbl_couleur['B']=$bleu;
    return $tbl_couleur;
}

//conversion pixel -> millimeter in 72 dpi
function px2mm($px){
    return $px*25.4/300;
}

function txtentities($html){
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}
////////////////////////////////////


Class PDF extends FPDF {
//variables of html parser
public $invc_id;
protected $B;
protected $I;
protected $U;
protected $HREF;
protected $fontList;
protected $issetfont;
protected $issetcolor;

function __construct($orientation='P', $unit='mm', $format='A4')
{
    //Call parent constructor
    parent::__construct($orientation,$unit,$format);

    //Initialization
    $this->B=0;
    $this->I=0;
    $this->U=0;
    $this->HREF='';

    $this->tableborder=0;
    $this->tdbegin=false;
    $this->tdwidth=0;
    $this->tdheight=0;
    $this->tdalign="L";
    $this->tdbgcolor=false;

    $this->oldx=0;
    $this->oldy=0;

    $this->fontlist=array("arial","times","courier","helvetica","symbol");
    $this->issetfont=false;
    $this->issetcolor=false;
}

//////////////////////////////////////
//html parser

function WriteHTML($html)
{
    $html=strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote><hr><td><tr><table><sup>"); //remove all unsupported tags
    $html=str_replace("\n",'',$html); //replace carriage returns with spaces
    $html=str_replace("\t",'',$html); //replace carriage returns with spaces
    $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE); //explode the string
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            //Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            elseif($this->tdbegin) {
                if(trim($e)!='' && $e!="&nbsp;") {
                    $this->Cell($this->tdwidth,$this->tdheight,$e,$this->tableborder,'',$this->tdalign,$this->tdbgcolor);
                }
                elseif($e=="&nbsp;") {
                    $this->Cell($this->tdwidth,$this->tdheight,'',$this->tableborder,'',$this->tdalign,$this->tdbgcolor);
                }
            }
            else
                $this->Write(5,stripslashes(txtentities($e)));
        }
        else
        {
            //Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                //Extract attributes
                $a2=explode(' ',$e);
                $tag=strtoupper(array_shift($a2));
                $attr=array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])]=$a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag, $attr)
{
    //Opening tag
    switch($tag){

        case 'SUP':
            if( !empty($attr['SUP']) ) {    
                //Set current font to 6pt     
                $this->SetFont('','',6);
                //Start 125cm plus width of cell to the right of left margin         
                //Superscript "1" 
                $this->Cell(2,2,$attr['SUP'],0,0,'L');
            }
            break;

        case 'TABLE': // TABLE-BEGIN
            if( !empty($attr['BORDER']) ) $this->tableborder=$attr['BORDER'];
            else $this->tableborder=0;
            break;
        case 'TR': //TR-BEGIN
            break;
        case 'TD': // TD-BEGIN
            if( !empty($attr['WIDTH']) ) $this->tdwidth=($attr['WIDTH']/4);
            else $this->tdwidth=40; // Set to your own width if you need bigger fixed cells
            if( !empty($attr['HEIGHT']) ) $this->tdheight=($attr['HEIGHT']/6);
            else $this->tdheight=6; // Set to your own height if you need bigger fixed cells
            if( !empty($attr['ALIGN']) ) {
                $align=$attr['ALIGN'];        
                if($align=='LEFT') $this->tdalign='L';
                if($align=='CENTER') $this->tdalign='C';
                if($align=='RIGHT') $this->tdalign='R';
            }
            else $this->tdalign='L'; // Set to your own
            if( !empty($attr['BGCOLOR']) ) {
                $coul=hex2dec($attr['BGCOLOR']);
                    $this->SetFillColor($coul['R'],$coul['G'],$coul['B']);
                    $this->tdbgcolor=true;
                }
            $this->tdbegin=true;
            break;

        case 'HR':
            if( !empty($attr['WIDTH']) )
                $Width = $attr['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.2);
            $this->Line($x,$y,$x+$Width,$y);
            $this->SetLineWidth(0.2);
            $this->Ln(1);
            break;
        case 'STRONG':
            $this->SetStyle('B',true);
            break;
        case 'EM':
            $this->SetStyle('I',true);
            break;
        case 'B':
        case 'I':
        case 'U':
            $this->SetStyle($tag,true);
            break;
        case 'A':
            $this->HREF=$attr['HREF'];
            break;
        case 'IMG':
            if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
                if(!isset($attr['WIDTH']))
                    $attr['WIDTH'] = 0;
                if(!isset($attr['HEIGHT']))
                    $attr['HEIGHT'] = 0;
                $this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
            }
            break;
        case 'BLOCKQUOTE':
        case 'BR':
            $this->Ln(5);
            break;
        case 'P':
            $this->Ln(10);
            break;
        case 'FONT':
            if (isset($attr['COLOR']) && $attr['COLOR']!='') {
                $coul=hex2dec($attr['COLOR']);
                $this->SetTextColor($coul['R'],$coul['G'],$coul['B']);
                $this->issetcolor=true;
            }
            if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
                $this->SetFont(strtolower($attr['FACE']));
                $this->issetfont=true;
            }
            if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist) && isset($attr['SIZE']) && $attr['SIZE']!='') {
                $this->SetFont(strtolower($attr['FACE']),'',$attr['SIZE']);
                $this->issetfont=true;
            }
            break;
    }
}

function CloseTag($tag)
{
    //Closing tag
    if($tag=='SUP') {
    }

    if($tag=='TD') { // TD-END
        $this->tdbegin=false;
        $this->tdwidth=0;
        $this->tdheight=0;
        $this->tdalign="L";
        $this->tdbgcolor=false;
    }
    if($tag=='TR') { // TR-END
        $this->Ln();
    }
    if($tag=='TABLE') { // TABLE-END
        $this->tableborder=0;
    }

    if($tag=='STRONG')
        $tag='B';
    if($tag=='EM')
        $tag='I';
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF='';
    if($tag=='FONT'){
        if ($this->issetcolor==true) {
            $this->SetTextColor(0);
        }
        if ($this->issetfont) {
            $this->SetFont('arial');
            $this->issetfont=false;
        }
    }
}

function SetStyle($tag, $enable)
{
    //Modify style and select corresponding font
    $this->$tag+=($enable ? 1 : -1);
    $style='';
    foreach(array('B','I','U') as $s) {
        if($this->$s>0)
            $style.=$s;
    }
    $this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
    //Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}


    function Header() {
        $this->image($root."assets/images/logo.png",10,6,40);
	// Arial bold 15
	$this->SetFont('Arial','B',12);
	// Move to the right
	$this->Cell(50,6,'',0);
	// Title
	$this->Cell(130,2,'Tax Invoice/Cash Memo',0,0,'R');
	// Line break
	$this->Ln(8);
	$this->SetFont('Arial','B',7);
	$this->Cell(180,2,'A Clairvoyant BizInfo Pvt. Ltd Venture',0,0,'L');
	$this->Ln(10);

    }

    function SetCol($col)
    {
            // Set position at a given column
            $this->col = $col;
            $x = 10+$col*65;
            $this->SetLeftMargin($x);
            $this->SetX($x);
    }

    function BodyTitle() {
    $obj=new Base;
        
        $query="select DISTINCT bname,cust_fname,vend_addr,cust_addr,vendor.loc_zip,customer.loc_zip,sa_name,sa_addr,ship_addr.loc_zip,ordertbl.ord_id,ordertbl.ins_dt,invoice.ins_dt
from users,product,customer,vendor,ship_addr,invoice,ordertbl,vend_subscription,order_detail
where ordertbl.ord_id=invoice.ord_id
and customer.cust_id=ship_addr.cust_id
and vendor.vend_id=users.vend_id
and ordertbl.sa_id=ship_addr.sa_id 
and vend_subscription.vs_id=product.vs_id
and users.u_id=vend_subscription.u_id
and product.prod_id=order_detail.prod_id 
and order_detail.ord_id=ordertbl.ord_id 
and invc_id=$this->invc_id";
            $res= Base::generateResult( $query);
            if($row= mysqli_fetch_array($res)) {
        
	$this->SetFont('Arial','',10);
	$this->Cell(90,2,'Sold By:',0,0,'L');
	$this->Cell(90,2,'Billing Address:',0,0,'R');
	// Line break
	$this->Ln(5);
        //names
	$this->Cell(90,2,$row[0],0,0,'L');
	$this->Cell(90,2,$row[1],0,0,'R');
	$this->Ln(5);
        //addr
	$this->Cell(90,2,$row[2],0,0,'L');
	$this->Cell(90,2,$row[3],0,0,'R');
	$this->Ln(5);
        

        //pincode
        $this->Cell(90,2,$row[4],0,0,'L');
	$this->Cell(90,2,$row[5],0,0,'R');
	$this->Ln(5);
        
        //state
        $this->Cell(90,2, Base::getlocstatebyzip($row[4]),0,0,'L');
        $this->Cell(90,2, Base::getlocstatebyzip($row[5]),0,0,'R');
	$this->Ln(5);
        
        //state
        $this->Cell(90,2, "INDIA",0,0,'L');
        $this->Cell(90,2, "INDIA",0,0,'R');
	$this->Ln(5);
        
        
	$this->Cell(180,2,'Shipping Address:',0,0,'R');
	// Line break
	$this->Ln(5);
	$this->Cell(180,2,$row[6],0,0,'R');
	$this->Ln(5);
	$this->Cell(180,2,$row[7],0,0,'R');
	$this->Ln(5);
	$this->Cell(180,2,$row[8],0,0,'R');
	$this->Ln(5);
	$this->Cell(180,2,Base::getlocstatebyzip($row[8]),0,0,'R');
	$this->Ln(5);
	$this->Cell(180,2,"India",0,0,'R');
	$this->Ln(5);


	$this->Cell(90,2,'Order Number: '.$row[9],0,0,'L');
	$this->Cell(90,2,'Invoice Number: '. $this->invc_id,0,0,'R');
	// Line break
	$this->Ln(5);
	$this->Cell(90,2,'Order Date: '.$row[10],0,0,'L');
	$this->Cell(90,2,'Invoice Date: '.$row[11],0,0,'R');
	$this->Ln(5);
            }
    }


// Better table
function ImprovedTable()
{
    $obj=new Base;
$header = ['Sr No', 'Description', 'Unit Price', 'Quantity','Net Amt','Tax','Tax Amt','Total Amt'];
$header1 = ['', '', '(Rs.)', '','(Rs.)','(%)','(Rs.)','(Rs.)'];
$invc_prod_amt=Order::getInvcProdAmt($this->invc_id);
//echo $invc_prod_amt;
    $query="select prod_name,ord_rate,ord_qty,ord_rate*ord_qty,tax_table.cgst as t_cgst,tax_table.sgst as t_sgst,tax_table.cess as t_cess,order_detail.cgst,order_detail.sgst,order_detail.cess,invc_amt,sc_cust,( (((ord_qty*ord_rate)/$invc_prod_amt)*100 )*sc_cust)/100 from ordertbl,order_detail,product,tax_table,invoice where tax_table.hsn_code=product.hsn_code and order_detail.prod_id=product.prod_id and ordertbl.ord_id=invoice.ord_id and order_detail.ord_id=ordertbl.ord_id and invc_id=$this->invc_id";
    echo $query;
            $res= Base::generateResult( $query);
	// Column widths
	$w = array(10,50,20,20,20,20, 20, 20);
	// Header
	for($i=0;$i<count($header);$i++) 
		$this->Cell($w[$i],7,$header[$i],1,0,'C');
	$this->Ln();
	for($i=0;$i<count($header1);$i++) 
		$this->Cell($w[$i],7,$header1[$i],1,0,'C');
	$this->Ln();
	// Data
        $i=1;
        $tax_p="";
        $tax_c="";
        $tax="";
$ship_charge=0;
$invc_amt=0;
$ship_charge_u=0;
$cgst_p=0;
$sgst_p=0;
$cess_p=0;
        

$set=0;
// Better table
            while($row= mysqli_fetch_array($res)) {
                $invc_amt=$row[10];
                $cgst_p=$row[4];
                $sgst_p=$row[5];
                $cess_p=$row[6];
    $ship_charge=/*$row[11]*(*/number_format($row[12]);///100);
    $price=$row[1];
    $ship_charge_r=(($ship_charge*($cgst_p/100)) + ($ship_charge*($sgst_p/100)) + ( ( ($ship_charge*($cgst_p/100)) + ($ship_charge*($sgst_p/100)))*($cess_p/100)));
    $ship_charge_u=$ship_charge-$ship_charge_r;//(($ship_charge*($cgst_p/100)) + ($ship_charge*($sgst_p/100)) + ($ship_charge*($cess_p/100)));
    $unit_price=$price-$row[7]-$row[8]-$row[9];
                
	$this->SetFont('Arial','',10);
		$this->Cell($w[0],6,$i,0,0,'R');
		$this->Cell($w[1],6,$row[0]);
		$this->Cell($w[2],6,$unit_price."/-",0,0,'R');
		$this->Cell($w[3],6,number_format($row[2]),0,0,'R');
		$this->Cell($w[4],6,$unit_price."/-",0,0,'R');
	$this->SetFont('Arial','',8);
		$this->Cell($w[5],6,"CGST: $cgst_p%",0,0,'J');
		$this->Cell($w[6],6,$row[7]."/-",0,0,'R');
	$this->SetFont('Arial','',10);
		$this->Cell($w[7],6,$price."/-",0,0,'R');
		$this->Ln();
	$this->SetFont('Arial','',8);
		$this->Cell(120,6,"",0,0,'R');
		$this->Cell($w[5],6,"SGST: $sgst_p%",0,0,'J');
		$this->Cell($w[6],6,$row[8]."/-",0,0,'R');
		$this->Ln();
                if(!empty($row[6]) && !is_null($row[6]) && !empty($row[9]) && !is_null($row[9])) {
                    $set=1;
	$this->SetFont('Arial','',8);
		$this->Cell(120,6,"",0,0,'R');
		$this->Cell($w[5],6,"CESS: $cess_p%",0,0,'J');
		$this->Cell($w[6],6,$row[9]."/-",0,0,'R');
                }
		$this->Ln();
        
		$this->Cell($w[0],6,'');
		$this->Cell($w[1],6,"Delivery Charges",0,0);
		$this->Cell($w[2],6,$ship_charge_u-$ship_charge_r."/-",0,0,'R');
		$this->Cell($w[3],6,"",0,0,'J');
		$this->Cell($w[4],6,$ship_charge_u."/-",0,0,'R');
	$this->SetFont('Arial','',8);
		$this->Cell($w[5],6,"CGST: $cgst_p%",0,0,'J');
		$this->Cell($w[6],6,$ship_charge*($cgst_p/100)."/-",0,0,'R');
	$this->SetFont('Arial','',10);
		$this->Cell($w[7],6,"$ship_charge/-",0,0,'R');
		$this->Ln();
	$this->SetFont('Arial','',8);
		$this->Cell(120,6,"",0,0,'R');
		$this->Cell($w[5],6,"SGST: $sgst_p%",0,0,'J');
		$this->Cell($w[6],6,$ship_charge*($sgst_p/100)."/-",0,0,'R');
		$this->Ln();
                if($set==1) {
	$this->SetFont('Arial','',8);
		$this->Cell(120,6,"",0,0,'R');
		$this->Cell($w[5],6,"CESS: $cess_p%",0,0,'J');
		$this->Cell($w[6],6,( ( ($ship_charge*($cgst_p/100)) + ($ship_charge*($sgst_p/100)))*($cess_p/100))."/-",0,0,'R');
                }
		$this->Ln();
	// Closing line
	$this->Cell(array_sum($w),0,'','T');
		$this->Ln();
                $i++;
	}
        
	// Closing line
	$this->Cell(array_sum($w),0,'','T');
		$this->Ln();
	$this->SetFont('Arial','',12);
		$this->Cell(array_sum($w),6,"Net Payable: Rs. $invc_amt/-",0,0,'R');
		$this->Ln();
	$this->Cell(array_sum($w),0,'','T');
		$this->Ln(20);
        
                 
}
                
                
   /*             
$html.="    <tr>
        <td>".$i."</th>
        <td>".$row[0]."</th>
        <td>Rs. ".$row[1]."/-</th>
        <td>".$row[2]."</th>
        <td>Rs. ".$row[3]."/-</th>
        <td>$tax_p</th>
        <td>$tax</th>
        <th>Rs. ".$row[10]."/-</th>
    </tr>";
                $i++;
	}
$html.="    <tr>
        <td></th>
        <td>Delivery Charges</th>
        <td>Rs. ".$ship_charge_u."/-</th>
        <td></th>
        <td>Rs. ".$ship_charge_u."/-</th>
        <td>$tax_p</th>
        <td>$tax_c</th>
        <th>Rs. ".$ship_charge."/-</th>
    </tr>";
$html.="    <tr>
        <th colspan=7 style='text-align: right'>Total</th>
        <td>Rs. ".$invc_amt."/-</th>
    </tr>
    </table>";
	// Closing line
//	$this->Cell(array_sum($w),0,'','T');
//echo $html;
		$this->WriteHTML($html);*/
//}
    
// Page footer
function CompanyFooter()
{
	// Position at 1.5 cm from bottom
//	$this->SetY(-80);
	$this->SetFont('Arial','B',12);
	$this->Cell(180,6,'www.homebiz365.in',0,0,'R');
		$this->Ln();
	$this->SetFont('Arial','B',12);
	$this->Cell(140,6,'',0,0,'R');
	$this->Cell(40,6,'Thank You!',0,0,'R');
	$this->SetFont('Arial','B',8);
		$this->Ln();
	$this->Cell(140,6,'',0,0,'R');
	$this->Cell(40,6,'for shopping with us',0,0,'R');

        $this->Ln();
        
	$this->SetFont('Arial','',8);
	$this->Cell(180,6,'Returns Policy: At HomeBiz365 we try to deliver perfectly each and every time. But in the off-chance that you need to',0,0,'J');
		$this->Ln();
	$this->Cell(180,6,'return the item, please do so with the original Brand box/price tag, original packing and invoice without which it',0,0,'J');
		$this->Ln();
	$this->Cell(180,6,'will be really difficult for us to act on your request. Please help us in helping you. Terms and conditions apply.',0,0,'J');
		$this->Ln();
	$this->Cell(180,6,'The goods sold as are intended for end user consumption and not for re-sale..',0,0,'J');
		$this->Ln();
                
	$this->SetFont('Arial','B',10);
	$this->Cell(180,6,'Clairvoyant BizInfo Pvt. Ltd.',0,0,'L');
		$this->Ln();
	$this->SetFont('Arial','',8);
	$this->Cell(180,6,'Registered Address: Sadguru Sadan, S.No. 32/1, Plot No.10, Erandawane, Pune -411004.',0,0,'J');
		$this->Ln();
	$this->Cell(180,6,'CIN BARB18012700410134',0,0,'L');
		$this->Ln();
	$this->Cell(180,6,'GSTIN 27AAFCC4471P1Z5',0,0,'L');
		$this->Ln();
	$this->Cell(180,6,'PAN AAFCC4471P',0,0,'L');
	// Arial italic 8
	// Page number
		$this->Ln();
	$this->Cell(180,0,'','T');
		$this->Ln();
		$this->Cell(150,6,"This is computer generated Invoice, Signature not required.",0,0,'C');
	$this->Cell(30,6,'| Page '.$this->PageNo().'/{nb}',0,0,'R');
}

// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	$this->SetFont('Arial','',8);
	$this->Cell(180,0,'','T');
		$this->Ln();
	$this->Cell(180,6,'| Page '.$this->PageNo().'/{nb}',0,0,'R');
}

public static function generatePDF($invc_id) {
$pdf = new PDF();
$pdf->invc_id=$invc_id;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->BodyTitle();
$pdf->ImprovedTable();
$pdf->CompanyFooter();
//$mail->AddAttachment('../uploads/invoices/Invoice-#'.$invc_id.'.pdf', 'Invoice-#'.$invc_id.'.pdf', $encoding = 'base64', $type = 'application/pdf');
$path = "../assets/invoices/Invoice-#$invc_id.pdf";    
//$path = Crm::root()."uploads/invoices/testdoc.txt";
//echo $path."<br>";
    return /*$mail->addStringAttachment(*/$pdf->Output("S","Invoice-#$invc_id");//, 'OrderDetails.pdf', $encoding = 'base64', $type = 'application/pdf');//$pdf->Output($path,"F"); 
//return $path;
}

    public static function generateInvoiceTago($invc_id) {
    $obj=new Base;
//echo "<br><br><br><br>in Tago Mail";
//echo "<br><br><br><br>";
//echo "in tago mail $invc_id<br><br><br><br>";
//        $ordobj= unserialize($ordobj);
        $name="Sameer";
        $email="mail.oms123@gmail.com";
        $subject="HomeBiz365 - Invoice #$invc_id";
        $message="";

        $query="select DISTINCT bname,cust_fname,vend_addr,cust_addr,vendor.loc_zip,customer.loc_zip,sa_name,sa_addr,ship_addr.loc_zip,ordertbl.ord_id,ordertbl.ins_dt,invoice.ins_dt,date_format(ordertbl.req_dt,'%d-%m-%Y'),bs_from,bs_to
from users,product,customer,vendor,ship_addr,invoice,ordertbl,vend_subscription,order_detail,booking_slots
where ordertbl.ord_id=invoice.ord_id
and customer.cust_id=ship_addr.cust_id
and vendor.vend_id=users.vend_id
and ordertbl.bs_id=booking_slots.bs_id
and ordertbl.sa_id=ship_addr.sa_id 
and vend_subscription.vs_id=product.vs_id
and users.u_id=vend_subscription.u_id
and product.prod_id=order_detail.prod_id 
and order_detail.ord_id=ordertbl.ord_id 
and invc_id=$invc_id";
        
        echo $query;
            $res= Base::generateResult( $query);
            if($row= mysqli_fetch_array($res)) {
                $message.="To be delivered on ".$row[12]."<br>"
                        ."Between ".$row[13]." - ".$row[14]."<br>"
                        . "Pickup from:<br>"
                        . $row[0]."<br>"
                        . $row[2]."<br>"
                        . $row[4]."<br>"
                        . Base::getlocstatebyzip($row[4])."<br>"
                        . "India<br><br>"
                        . "Delivery to<br>"
                        . $row[6]."<br>"
                        . $row[7]."<br>"
                        . $row[8]."<br>"
                        . Base::getlocstatebyzip($row[8])."<br>"
                        . "India<br><br>";
            }
        $message.="Please check the invoice attached<br>Regards,Team HomeBiz365";
        
$attachment=PDF::generatePDF($invc_id);

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = 'relay-hosting.secureserver.net';
//Whether to use SMTP authentication
//$mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "info@homebiz365.in";
//Password to use for SMTP authentication
$mail->Password = "info_homebiz_123";



$mail->AddBCC('info@homebiz365.in', 'info@HomeBiz365');
$mail->setFrom('info@homebiz365.in', 'info@HomeBiz365');
//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$mail->addAddress($email, $name);
//Set the subject line
$mail->Subject = $subject;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->AddStringAttachment($attachment, 'attachment.pdf');
//echo $attachment;
//echo "<br>invoice id-$invc_id-<br>$attachment";
//$mail->addStringAttachment($attachment, 'OrderDetails.pdf', $encoding = 'base64', $type = 'application/pdf');
$pdf->Output($attachment,"F"); 
//$mail->addStringAttachment($attachment, "Invoice-#$invc_id.pdf" );//'base64', 'application/pdf');
$mail->IsHTML(true);   
$mail->Body= $message;
//Replace the plain text body with one created manually
                 
if (!$mail->send()) {
    return false;
    echo "Mailer Error: " . $mail->ErrorInfo;
} else
    return true;
//$pdf->Output();
//     if(Email::sendEmail($name,$email,$subject,$message,$invc_id))
//    return true;
//else
//    return false;*/
   
    }

}
//echo PDF::generateInvoiceTago(357);


/*
//Email::generateInvoiceTago(126);
$pdf = new PDF();
$pdf->invc_id=312;

//echo $pdf->invc_id."<br><br><br><br>";
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->BodyTitle();
//echo $pdf->invc_id."<br><br><br><br>";
$pdf->ImprovedTable();
//echo Crm::root().'uploads/Invoice-#'.$pdf->invc_id."<br><br><br><br>";
$pdf->Output("F","../uploads/invoices/Invoice-#".$pdf->invc_id.".pdf"); 
        
/*
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->BodyTitle(126);
$pdf->ImprovedTable(126);
$pdf->Output();
*/
?>
