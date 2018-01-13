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
    $this->Cell(0, 10, 'Facor Power Limited'
    .$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
  }
}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator('PDF_CREATOR');
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Payment Voucher');
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
$pdf->SetMargins(35,10,15,true);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// add a page
$pdf->AddPage('p','A4');
require_once 'dbConnection.php';
$json = array();
$json1 = array();
$reference_no = $_GET['reference_no'];

    $query = "SELECT tbl_gl_master.acc_name,credit_amount,debit_amount,gl_narrative,reference_no,date_format(trans_date,'%d-%m-%y') as trans_date FROM tbl_transactions,tbl_gl_master where  bank_trans_type= 'Payment' and tbl_transactions.gl_acc_code = tbl_gl_master.acc_code AND tbl_transactions.reference_no ='".$reference_no."'";
    $result = mysqli_query($dbCon,$query);
    echo $query;
    $main_array =[];
    $main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $json=$main_array;

    $query1 = "SELECT tbl_gl_master.acc_name,credit_amount,debit_amount,gl_narrative,reference_no,trans_date FROM tbl_transactions,tbl_gl_master where  bank_trans_type= 'Payment' and tbl_transactions.gl_acc_code = tbl_gl_master.acc_code AND tbl_transactions.reference_no ='".$reference_no."'";
    $result = mysqli_query($dbCon,$query1);
    $main_array =[];
   while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {   
      foreach($row as $key => $value) { 
        $arr[$key] = $value;
      }
      $main_array[] = $arr;
    }
   $json1=$main_array;

  $number = $json['grand_total_roundoff'];
  $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'One', '2' => 'Two',
    '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
    '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
    '10' => 'Ten', '11' => 'Eleven', '12' => 'Ewelve',
    '13' => 'Thirteen', '14' => 'Fourteen',
    '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
    '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
    '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
    '60' => 'Sixty', '70' => 'Seventy',
    '80' => 'Eighty', '90' => 'Ninety');
   $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';



/*<img src="components/images.facor_logo.png" width="100%" height="100%"> </img>
*/

$htmlhead = '
<h1 align="center" >Facor Power Limited</h1>
<h4 align="center">D P Nagar - Randia, Bhadrak, Odisha - 756135</h4> 
<h2 align="center"><mark> Payment Voucher </mark></h2>
<h3><p>Reference No :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$json['reference_no'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
<br>Payment Entry Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$json['trans_date'].'
<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$json['dept_name']. '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</p></h3>


';
$pdf->writeHTML($htmlhead, true, false, true, false, '');
$htmlbody ='
<table class="table_data" border="1"  align="center" cellpadding="2">
<tr bgcolor="rgb(233,244,250)">
<th align="center" style="width: 20px;">Sr.No</th>
<th align="center" style="width: 200px;">Particulars</th>
<th align="center" style="width: 80px;">Debit</th>
<th align="center" style="width: 80px;">Credit</th>
</tr>
';
$count=1;
$totalAmt = 0;
for($i=0;$i<sizeof($json1);$i++){
  $finaldebit = $finaldebit + $json1[$i]['debit_amount'];
  $finalcredit = $finalcredit + $json1[$i]['credit_amount']; 

$htmlbody .='  
<tr>
<th align="center" style="width: 20px;">'.$count++.'</th>
<th align="center" style="width: 200px;height: 30px;">'.$json1[$i]['acc_name'].'</th>
<th align="center" style="width: 80px;">'.$json1[$i]['debit_amount'].'</th>
<th align="center" style="width: 80px;">'.$json1[$i]['credit_amount'].'</th>
</tr>';
}

$htmlbody .='
<tr>
<td></td>
<td><b>Total</b></td>
<td>' .$finaldebit.'</td>
<td>' .$finalcredit.'</td>

</tr>
</table>
<br><br>
<b>GL Narrative : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .$json['gl_narrative'].'</b><br><br>
<b align="right">Authority Signatury</b>
<br><br><br><br><footer align="center">
Facor Power Limited <br>
CIN NO. - U4010DL2005PLC139923</footer>';

$pdf->writeHTML($htmlbody, true, false, true, false, '');
 ob_end_clean();

//Close and output PDF document
$pdf->Output('Journal_Voucher.pdf', 'I');
?>