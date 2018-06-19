<?php

require_once __DIR__ . '/Classes/MPDF/src/Mpdf.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML('<h1>Hello world!</h1>');
$mpdf->Output();
?>