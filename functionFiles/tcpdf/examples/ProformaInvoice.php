<?php
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'PowerdBy@Finolex Cables Limited                                    '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator('PDF_CREATOR');
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Proforma Invoice');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set header and footer fonts
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);


$pdf->SetFont('times', '', 9);

// set margins
$pdf->SetMargins(20,37,20,true);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// add a page
$pdf->AddPage('p','A4');
require_once 'dbConnection.php';
$json = array();
$json1 = array();
$INVICE_NUMBER = $_GET['EX_PR_INVICE_NUMBER'];
	$result=$sap->callFunction("ZCRM_PROFORMA_INVOICE_GET",array(
		array("IMPORT","IV_PR_INVICE_NUMBER","".$INVICE_NUMBER.""),
		array("TABLE","IT_HEADER",array()),
		array("TABLE","IT_PART",array())
		));
	if ($sap->getStatus() == SAPRFC_OK) {
		$arr = array();
		foreach($result["IT_HEADER"] as $key => $value)
			{    $arr[] = $value; }
		$json=$arr; 
		$arr1 = array();
		foreach($result["IT_PART"] as $key => $value)
			{    $arr1[] = $value; }
		 $json1=$arr1; 
	} else { 
		$sap->printStatus();
	}
	$sap->logoff();

$htmlhead = '
<h1 align="center" >Proforma Invoice</h1><br>
<h2 align="center" color="rgb0(11,178,244)">'.$arr[0]['KUNNR_NAME'].'<br>'.$arr[0]['KUNNR_ADDRESS'].' Tel.No-' .$arr[0]['KUNNR_TELPHONE'].'.</h2><br>
<h2 align="center" color="rgb0(11,178,244)">Authorised Service Center OF FINOLEX Cables Limited</h2>
<h3><p>Date : '.$arr[0]['CREATED_ON'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PI NO :'.$INVICE_NUMBER .'</p></h3>
<h2>To,<br>
'.$arr[0]['CUST_NAME'].',<br>
'.$arr[0]['CUST_ADDR'].',<br>
'.$arr[0]['CUST_MOBILE'].'
</h2><br>';
$pdf->writeHTML($htmlhead, true, false, true, false, '');
$htmlbody ='
<table class="table_data" border="1" align="center" cellpadding="2">
<tr bgcolor="rgb(233,244,250)">
<th align="center" style="width: 20px;">Sr.No</th>
<th align="center" style="width: 230px;">Perticulers</th>
<th align="center" style="width: 60px;">Quantity</th>
<th align="center" style="width: 60px;">Rate</th>
<th align="center" style="width: 60px;">Amount</th>
<th align="center" style="width: 100px;">Remark</th>
</tr>
';
$count=0;
$totalAmt = 0;
for($i=0;$i<sizeof($json1);$i++){
	$totalAmt = $totalAmt + ($json1[$i]['QUANTITY']*$json1[$i]['RATE']);
$htmlbody .='  
<tr>
<th align="center" style="width: 20px;">'.$count++.'</th>
<th align="center" style="width: 230px;">'.$json1[$i]['PERTICULARS'].'</th>
<th align="center" style="width: 60px;">'.$json1[$i]['QUANTITY'].'</th>
<th align="center" style="width: 60px;">'.$json1[$i]['RATE'].'</th>
<th align="center" style="width: 60px;">'.$json1[$i]['QUANTITY']*$json1[$i]['RATE'].'</th>
<th align="center" style="width: 100px;">'.$json1[$i]['REMARK'].'</th>
</tr>';
}
$htmlbody .='<tr>
<th colspan="3" bgcolor="rgb(173,204,74)">Total</th>
<th colspan="4">'.$totalAmt.'</th>
</tr>
</table>';
$pdf->writeHTML($htmlbody, true, false, true, false, '');
 ob_end_clean();
//Close and output PDF document
$pdf->Output('Proforma_Invoice.pdf', 'I');
?>