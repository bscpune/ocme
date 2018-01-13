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
$pdf->SetTitle('Voucher');
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

 $query = "SELECT coninv.material_issue_code,date_format(material_issue_date,'%d-%m-%y') as material_issue_date,coninv.contractor_id,coninv.indent_id,coninv.project_id,coninv.store_id,coninv.challan_no,coninv.inventory_type,coninv.loc_no,coninv.issued_to,coninv.remark,mm.material_code,mm.material_description,mm.unit_price,mm.approved_total_qty from tbl_contractor_inventory coninv,tbl_material_master mm where mm.material_id=coninv.project_id";
    $result = mysqli_query($dbCon,$query);
    echo $query;
    $main_array =[];
    $main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $json=$main_array;

    $query = "SELECT coninv.material_issue_code,coninv.material_issue_date,coninv.contractor_id,coninv.indent_id,coninv.project_id,coninv.store_id,coninv.challan_no,coninv.inventory_type,coninv.loc_no,coninv.issued_to,coninv.remark,mm.material_code,mm.material_description,mm.unit_price,mm.approved_total_qty from tbl_contractor_inventory coninv,tbl_material_master mm where mm.material_id=coninv.project_id";
    $result = mysqli_query($dbCon,$query1);
    $main_array =[];
   while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {   
      foreach($row as $key => $value) { 
        $arr[$key] = $value;
      }
      $main_array[] = $arr;
    }
   $json1=$main_array;

  // $number = $json['grand_total_roundoff'];
  // $no = round($number);
  //  $point = round($number - $no, 2) * 100;
  //  $hundred = null;
  //  $digits_1 = strlen($no);
  //  $i = 0;
  //  $str = array();
  //  $words = array('0' => '', '1' => 'One', '2' => 'Two',
  //   '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
  //   '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
  //   '10' => 'Ten', '11' => 'Eleven', '12' => 'Ewelve',
  //   '13' => 'Thirteen', '14' => 'Fourteen',
  //   '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
  //   '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
  //   '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
  //   '60' => 'Sixty', '70' => 'Seventy',
  //   '80' => 'Eighty', '90' => 'Ninety');
  //  $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
  //  while ($i < $digits_1) {
  //    $divider = ($i == 2) ? 10 : 100;
  //    $number = floor($no % $divider);
  //    $no = floor($no / $divider);
  //    $i += ($divider == 10) ? 1 : 2;
  //    if ($number) {
  //       $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
  //       $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
  //       $str [] = ($number < 21) ? $words[$number] .
  //           " " . $digits[$counter] . $plural . " " . $hundred
  //           :
  //           $words[floor($number / 10) * 10]
  //           . " " . $words[$number % 10] . " "
  //           . $digits[$counter] . $plural . " " . $hundred;
  //    } else $str[] = null;
  // }
  // $str = array_reverse($str);
  // $result = implode('', $str);
  // $points = ($point) ?
  //   "." . $words[$point / 10] . " " . 
  //         $words[$point = $point % 10] : '';



/*<img src="components/images.facor_logo.png" width="100%" height="100%"> </img>
*/

$htmlhead = '
<table class="table_data" border="1"  align="center" cellpadding="01">
<tr>
<th align="left" style="width: 100px;"><b>EMCO LIMITED<br/>ERECTION UNIT,BETUL</b></th>
<th align="left" style="width: 150px;"><b>STORE ISSUE/<br/>
RETURN CHALLAN</b></th>
<th align="left" style="width: 120px;">PLACE:<p> DATE:</p> <p>CHALLAN:</p> </th>
</tr>
</table>
';

$pdf->writeHTML($htmlhead, true, false, true, false, '');
$htmlbody .='
<table class="table_data" border="1"  align="center" cellpadding="01">
<tr>
<th align="left" style="width: 200px;">MATERIAL RETURN NUMBER:    '.$json['material_issue_code'].'</th>
<th align="left" style="width: 170px;">MATERIAL RETURN DATE:    '.$json['material_issue_date'].'</th>
</tr>

<tr>
<td align="left" style="width: 220px;">MATERIAL ISSUE CODE '.$json['issued_to'].'<br/><br/>
MATERIAL ISSUE DATE:   '.$json['challan_no'].'</td>

<td align="left" style="width: 150px;">INDENT CODE:   '.$json['indent_code'].'<br/><br/><br/>
LOC NO:   '.$json['loc_no'].'</td>
</tr>

<tr>
<td align="left" style="width: 250px;">CONTRACTOR NAME:   '.$json['contractor_name'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="width: 120px;">REMARK:  '.$json['remark'].'</td>
</tr>

<tr>
<td align="left" style="width: 250px;">PROJECT NAME:  '.$json['project_name'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="width: 120px;">INVENTORY TYPE:  '.$json['inventory_type'].'</td>
</tr>

<tr>
<td align="left" style="width: 250px;">STORE NAME:  '.$json['store_name'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
';

$htmlbody .='
<tr>
<th align="left" style="width: 40px;">Sr.No</th>
<th align="center" style="width: 140px;">MATERIAL NAME</th>
<th align="center" style="width: 70px;">MATERIAL CODE</th>
<th align="center" style="width: 60Px;">INDENT QUANTITY</th>
<th align="center" style="width: 60px;">ISSUED QUANTITY</th>
</tr>
';

$count=1;
for($i=0;$i<sizeof($json1);$i++){
  $materialname = $materialname + $json1[$i]['material_number'];
  $materialcode = $materialcode + $json1[$i]['material_issue_code'];
  $indentquantity = $indentquantity + $json1[$i]['indent_qty'];
  $issuedquantity = $issuedquantity + $json1[$i]['issued_qty'];


  $htmlbody .='
  <tr>
  <th align="center" style="width: 40px;">'.$count++.'</th>
  <th align="center" style="width: 140px;">'.$json1[$i]['material_number'].'</th>
  <th align="center" style="width: 70px;">'.$json1[$i]['material_issue_code'].'</th>
  <th align="center" style="width: 60px;">'.$json1[$i]['indent_qty'].'</th>
  <th align="center" style="width: 60px;">'.$json1[$i]['issued_qty'].'</th>
  </tr>
  ';
}

$htmlbody .='
<tr>
<td></td>
<td><b>Total</b></td>
<td>' .$finaldebit.'</td>
<td>' .$finalcredit.'</td>

</tr>
</table>
<br><br><br><br>
<b>GL Narrative : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .$json['gl_narrative'].'</b><br><br><br><br><br>
<b align="right">Authority Signatury</b>
<br><br><br><br><footer align="center">
Emco Power Limited <br>
CIN NO. - U4010DL2005PLC139923</footer>';

$pdf->writeHTML($htmlbody, true, false, true, false, '');
 ob_end_clean();

//Close and output PDF document
$pdf->Output('Gate_Entry.pdf', 'I');
?>