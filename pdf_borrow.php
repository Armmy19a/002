<?php

require_once('tcpdf/tcpdf.php');
session_start();
require("function/function.php");


$start_date = $_POST["start_date"];
$end_date = $_POST["end_date"];
$reportBorrowPdf = getReportBorrowPdf($start_date,$end_date);

$borrow_map = array( 1=>'<a style="color:blue">รออนุมัติ</a>',2=>'<a style="color:green">อนุมัติ</a>',3=>'<a style="color:red">ไม่อนุมัติ</a>',4=>'<a style="color:green">เรียบร้อย</a>');

$currentMonth = date("m");
$currentDate = '<h5 align="right">วันที่ออกรายงาน '.dateThaiFull(date("Y-m-d")).'</h5>';
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('ระบบจัดการยืม-คืนวัสดุ');
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
$pdf->SetFont('cordiaupc', '', 12, '', true);


$line_html="";
//PAGE 3 >> PAGE 1
$pdf->AddPage();

$pdf->setPageOrientation ('L', $autopagebreak='', $bottommargin='');
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(true, 0);
// Set some content to print

//$total_price = $price + 40;
$countDate = 0;
$i = 0;

$a = 0;

foreach($reportBorrowPdf as $data){
    $i++;
    $bDate = formatDateFull($data["borrow_date"]);
    $dDate = formatDateFull($data["due_date"]);
    $eTime = substr($data["end_time"],0,5);
    $sTime = substr($data["start_time"],0,5);
    $stat = $borrow_map[$data["status"]];
    
    $line_html1  .= <<<EOD
        <tr>
            <td style="text-align:center;">{$i}</td>
            <td style="text-align:center;">{$data['firstname']} {$data['lastname']}</td>
            <td style="text-align:center;">{$bDate}</td>
            <td style="text-align:center;">{$sTime}</td>
            <td style="text-align:center;">{$dDate}</td>
            <td style="text-align:center;">{$eTime}</td>
            <td style="text-align:center;">{$data['details']}</td>
            <td style="text-align:center;">{$stat}</td>
        </tr>
        

EOD;
    }

$header_html  .= <<<EOD
<div style="text-align:center;margin:0">
<b style="font-size:26px;">รายงานการยืม-คืน</b><br />
<b style="font-size:26px;">จากวันที่ {$start_date} ถึง {$end_date}</b><br />
</div>
{$currentDate}
EOD;

$body_html  .= <<<EOD
<table border="0">
    <tr>
        <td style="border-bottom: 1px solid #000;text-align:center;border-top: 1px solid #000;">ลำดับ</td>
        <td style="border-bottom: 1px solid #000;text-align:center;border-top: 1px solid #000;">ชื่อ-นามสกุล</td>
        <td style="border-bottom: 1px solid #000;text-align:center;border-top: 1px solid #000;">วันที่ยืม</td>
        <td style="border-bottom: 1px solid #000;text-align:center;border-top: 1px solid #000;">เวลาที่ยืม</td>
        <td style="border-bottom: 1px solid #000;text-align:center;border-top: 1px solid #000;">วันที่คืน</td>
        <td style="border-bottom: 1px solid #000;text-align:center;border-top: 1px solid #000;">เวลาที่คืน</td>
        <td style="border-bottom: 1px solid #000;text-align:center;border-top: 1px solid #000;">วัตถุประสงค์</td>
        <td style="border-bottom: 1px solid #000;text-align:center;border-top: 1px solid #000;">สถานะ</td>
        
    </tr>
    {$line_html1}
    
</table>
<br/>
<table>
    <tr>
        <td colspan="5" style="text-align:right;">รวมทั้งหมด</td>
        <td style="text-align:center;">{$i}</td>
        <td style="text-align:left;">รายการ</td>
    </tr>
    
    
</table>
EOD;

$html = <<<EOD
{$header_html}
{$body_html}
<div style="text-align:center;">
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
