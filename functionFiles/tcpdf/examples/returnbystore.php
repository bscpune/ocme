<?php
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
  // Page footer
  public function Footer() {

    // Logo
    $image_file = K_PATH_IMAGES.'emco1.png';
    $this->Image($image_file, 41, 21, 23, '', 'PNG', '', 'T', false, 400, '', false, false, 0, false, false, false);

    // Position at 15 mm from bottom
    $this->SetY(-15);
    // Set font
    $this->SetFont('helvetica', 'I', 8);
    // Page number
    $this->Cell(0, 10, 'EMCO Power Limited'
    .$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
  }
}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator('PDF_CREATOR');
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('RETURN BY STORE');
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


$pdf->SetFont('times', '', 10);

// set margins
$pdf->SetMargins(40,20,35,true);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// add a page
$pdf->AddPage('p','A4');
require_once 'dbConnection.php';
$json = array();
$json1 = array();
$mrr_id = $_GET['mrr_id'];

 $query = "SELECT mrr.return_no,mrr.rejected_return_no,mrr.mrr_code,mrr.supplier_name,mrr.supplier_invoice_no,mrr.location_of_despatch,mrr.vehicle_no,mrr.transporter_name,mrr.remark,mrr.inventory_type_id,project.project_name,store.store_name FROM tbl_mrr_head mrr,tbl_project_master project,tbl_store_master store where mrr.project_id=project.project_id and mrr.store_id=store.store_id and mrr.mrr_id='".$mrr_id."'";
    $result = mysqli_query($dbCon,$query);
    $main_array =[];
    $main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $json=$main_array;

    $query1 = "SELECT mm.material_code,mm.material_name,mrrm.rejected_quantity,mrrm.return_qty,mrrm.reason_for_rejection from tbl_material_master mm,tbl_mrr_material mrrm where mrr_id='".$mrr_id."'";
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
<th align="left" style="width: 140px;"><b><br/><br/><br/>EMCO LIMITED<br/>ERECTION UNIT,BETUL</b></th>
<th align="left" style="width: 100px;"><b>RETURN BY STORE/<br/>
RETURN CHALLAN</b></th>
<th align="left" style="width: 130px;">PLACE:<p> DATE:</p> <p>CHALLAN:</p> </th>
</tr>
</table>
';

$pdf->writeHTML($htmlhead, true, false, true, false, '');
$htmlbody .='
<table class="table_data" border="1"  align="center" cellpadding="01">
<tr>
<th align="left" style="width: 200px;">MATERIAL RETURN NO:'.$json['return_no'].'</th>
<th align="left" style="width: 170px;">REJECTED RETURN NO: '.$json['rejected_return_no'].'</th>
</tr>

<tr>
<td align="left" style="width: 200px;">MATERIAL TYPE: '.$json['material_type'].' <br/><br/>
MRR NO:   '.$json['mrr_code'].' <br/><br/>
VEHICLE NO:   '.$json['vehicle_no'].'</td>

<td align="left" style="width: 170px;">SUPPLIER NAME:   '.$json['supplier_name'].' <br/><br/>
SUPPLIER INVOICE NO:   '.$json['supplier_invoice_no'].' <br/><br/>
REMARKS:   '.$json['remark'].'</td>
</tr>

<tr>
<td align="left" style="width: 200px;">LOCATION OF DISPTACH:   '.$json['location_of_despatch'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="width: 170px;">TRANSPORTOR NAME:  '.$json['transporter_name'].'</td>
</tr>

<tr>
<td align="left" style="width: 200px;">PROJECT NAME:  '.$json['project_name'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="width: 170px;">INVENTORY TYPE:  '.$json['inventory_type_id'].'</td>
</tr>

<tr>
<td align="left" style="width: 200px;">STORE NAME:  '.$json['store_name'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>

';

$htmlbody .='
<tr>
<th align="left" style="width: 20px;">Sr.No</th>
<th align="center" style="width: 70px;">MATERIAL NUMBER</th>
<th align="center" style="width: 70Px;">MATERIAL NAME</th>
<th align="center" style="width: 60px;">RETURN QUANTITY</th>
<th align="center" style="width: 70px;">REJECTED QUANTITY</th>
<th align="center" style="width: 80px;">REASON FOR REJECTION</th>
</tr>
';

$count=1;
for($i=0;$i<sizeof($json1);$i++){
  $materialnumber = $materialnumber + $json1[$i]['material_code'];
  $materialname = $materialname + $json1[$i]['material_name'];
  $returnquantity = $returnquantity + $json1[$i]['return_qty'];
  $rejectedquantity = $rejectedquantity + $json1[$i]['rejected_quantity'];
  $reasonforrejection = $reasonforrejection + $json1[$i]['reason_for_rejection'];

  $htmlbody .='
  <tr>
  <th align="center" style="width: 20px;">'.$count++.'</th>
  <th align="center" style="width: 70px;">'.$json1[$i]['material_code'].'</th>
  <th align="center" style="width: 70px;">'.$json1[$i]['material_name'].'</th>
  <th align="center" style="width: 60px;">'.$json1[$i]['return_qty'].'</th>
  <th align="center" style="width: 70px;">'.$json1[$i]['rejected_quantity'].'</th>
  <th align="center" style="width: 80px;">'.$json1[$i]['reason_for_rejection'].'</th>
  </tr>
  ';
}

$htmlbody .='
</table>
<br/><br/><br/><br/><br/>
<footer align="left">
CSTNO-23262006607 <br>
TINNO-23262006607   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
<b>STORE KEEPER</b> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
RECEIVED BY
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</footer>
';

$pdf->writeHTML($htmlbody, true, false, true, false, '');
 ob_end_clean();

//Close and output PDF document
$pdf->Output('MATERIAL_REJECTION.pdf', 'I');
?>