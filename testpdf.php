<?php
include 'Classes/FPDF/fpdf.php';
 
Class PDF extends FPDF {
    
    function Header() {
//        $this->image('logo.png',10,6,40);
	// Arial bold 15
	$this->SetFont('Arial','B',12);
	// Move to the right
	$this->Cell(50,6,'',1);
	// Title
	$this->Cell(130,2,'Tax Invoice/Cash Memo',1,0,'R');
	// Line break
	$this->Ln(5);
	$this->SetFont('Arial','',10);
	$this->Cell(180,2,'Customer Copy',1,0,'R');
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
	$this->SetFont('Arial','',10);
	$this->Cell(180,2,'This E-commerce Vendor Agreement (“Agreement”) is made and entered into on 2018 between,',0,0,'J');
	// Line break
	$this->Ln(5);
	$this->Cell(180,2,' ___________,  a company incorporated under the Companies Act, 1956 having its',0,0,'L');
	$this->Ln(5);
	$this->Cell(90,2,'Vendor Addr',1,0,'L');
	$this->Cell(90,2,'Billing Addr',1,0,'R');
	$this->Ln(5);
	$this->Cell(180,2,'Shipping Address:',1,0,'R');
	// Line break
	$this->Ln(5);
	$this->Cell(180,2,'Shipping Name',1,0,'R');
	$this->Ln(5);
	$this->Cell(180,2,'Shipping Addr',1,0,'R');
	$this->Ln(5);


	$this->Cell(90,2,'Order Number:',1,0,'L');
	$this->Cell(90,2,'Invoice Number:',1,0,'R');
	// Line break
	$this->Ln(5);
	$this->Cell(90,2,'Order Date: ',1,0,'L');
	$this->Cell(90,2,'Invoice Date: ',1,0,'R');
	$this->Ln(5);

    }


// Better table
function ImprovedTable($header, $data)
{
	// Column widths
	$w = array(10,50,20,20,20,20, 20, 20);
	// Header
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C');
	$this->Ln();
	// Data
/*	foreach($data as $row)
	{
		$this->Cell($w[0],6,$row[0],'LR');
		$this->Cell($w[1],6,$row[1],'LR');
		$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
		$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
		$this->Ln();
	}*/
	// Closing line
	$this->Cell(array_sum($w),0,'','T');
}
    
// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	// Page number
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
$data="1;abc;10;1;10;5;0.5;10.5";
$header = ['Sr No', 'Description', 'Unit Price', 'Quantity','Net Amt','Tax','Tax Amt','Total Amt'];
// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->BodyTitle();
$pdf->ImprovedTable($header,$data);
$pdf->AddPage();
$pdf->SetFont('Times','',12);
for($i=1;$i<=40;$i++)
	$pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output();
?>
