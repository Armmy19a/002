<?php

require_once('tcpdf/tcpdf.php');
session_start();
require("function/function.php");
$currentRemap = getCurrentRemap($_GET["remaps_id"]);

$dateReMap = formatDateFull($currentRemap["remap_date"]);
$timeReMap = substr($currentRemap["remap_time"], 0,5);
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('ระบบฐานข้อมูลลูกค้า Remap');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------
// set font

//$fontname = $pdf->addTTFfont('fonts/Browa.ttf', 'TrueTypeUnicode', '', 32);
$pdf->SetFont('cordiaupc', '', 10, '', true);


$line_html="";


$pdf->AddPage('P', 'A7');
$pdf->Cell(0, 0, 'ใบเสร็จ', 1, 1, 'C');

$pdf->setPageOrientation ('P', $autopagebreak='', $bottommargin='');
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(true, 0);

// Set some content to print
$cDateOrder = formatDateFull($currentOrder['order_date']);
/*$sumTotal = 0;
foreach($allOrderDetail as $data){
    $sum_price = 0;
    $a++;
    $cQuantity = number_format($data['quantity']);
    $cPrice = number_format($data['price']);
    $total += $data['quantity'] * $data['price'];
    $cSum = number_format($total);
    $sumTotal += $total;


}
*/
$total = 0;
if($currentRemap["re_normal"] == 1 && $currentRemap["re_match"] == 1){
    $total = 1200;
$line_html  .= <<<EOD
                <tr>
                    <td >ทั่วไป</td>
                    <td style="text-align:center;">1</td>
                    <td style="text-align:right;">500</td> 
                </tr>
                <tr>
                    <td >แข่งขัน</td>
                    <td style="text-align:center;">1</td>
                    <td style="text-align:right;">700</td> 
                </tr>
EOD;
}else if($currentRemap["re_normal"] == 1 && $currentRemap["re_match"] == 0){
    $total = 500;
         $line_html  .= <<<EOD
                <tr>
                    <td >ทั่วไป</td>
                    <td style="text-align:center;">1</td>
                    <td style="text-align:right;">500</td> 
                </tr>
EOD;                   
}else if($currentRemap["re_normal"] == 0 && $currentRemap["re_match"] == 1){
    $total = 700;
    $line_html  .= <<<EOD
                <tr>
                    <td >แข่งขัน</td>
                    <td style="text-align:center;">1</td>
                    <td style="text-align:right;">700</td> 
                </tr>
EOD;
}else{
    $total = 0;
    $line_html  .= <<<EOD
EOD;

}


$cSumTotal = number_format($total);
$cSumTotalText = convertMoneyToText($cSumTotal);

$body_html  .= <<<EOD
<br/><br/>

<table style="width:100%;">
    <tr>
        <td><b>ยี่ห้อ</b></td>
        <td>{$currentRemap['brands']}</td>
    </tr>
    <tr>
        <td><b>รุ่น</b></td>
        <td>{$currentRemap['generations']}</td>
    </tr>
    <tr>
        <td><b>สี</b></td>
        <td>{$currentRemap['colors']}</td>
    </tr>
    <tr>
        <td><b>วันที่</b></td>
        <td>{$dateReMap}</td>
    </tr>
    <tr>
        <td><b>เวลา</b></td>
        <td>{$timeReMap}</td>
    </tr>
</table>
<hr/>
<table style="width:100%;">
    <tr>
        <td style="width:50%;text-align:left;"><b>รายการ</b></td>
        <td style="width:25%;text-align:center;"><b>จำนวน</b></td>
        <td style="width:25%;text-align:right;"><b>รวม</b></td>
    </tr>
    {$line_html}
    <tr>
        <td colspan="2" style="text-align:right;">รวม</td>
        <td style="text-align:right;">{$cSumTotal}</td>
    </tr>
</table>
EOD;


$html = <<<EOD
{$body_html}
<br/>
<div align="right">
    ระบบฐานข้อมูลลูกค้า Remap
</div>
EOD;


// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
ob_end_clean();
$pdf->Output('รายงาน.pdf', 'I');
?>

<?php die(); ?>
