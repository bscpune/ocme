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
$pdf->SetTitle('GATE ENTRY');
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
$gate_entry_id = $_GET['gate_entry_id'];

 $query = "SELECT ge.gate_entry_code,ge.gate_entry_date,ge.transporter_name,ge.gate_entry_type,
ge.reference_number,pr.project_name,st.store_name,con.contractor_name,ge.time_in,ge.time_out,ge.vehicle_no,ge.challan_no,ge.lr_no from tbl_gate_entry ge,tbl_project_master pr,tbl_store_master st,tbl_contractor_master con  where  ge.contractor_id=con.contractor_id and ge.store_id=st.store_id and ge.project_id=pr.project_id and ge.gate_entry_id='".$gate_entry_id."'";
    $result = mysqli_query($dbCon,$query);
    $main_array =[];
    $main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $json=$main_array;


    $query1="SELECT material_number,material_description,quantity,unitprice from tbl_gate_entry_material group by material_number order by quantity";
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
<th align="left" style="width: 220px;">GATE ENTRY NO:'.$json['gate_entry_code'].'</th>
<th align="left" style="width: 150px;">ENTRY DATE:'.$json['gate_entry_date'].'</th>
</tr>

<tr>
<td align="left" style="width: 220px;">TRANSPORTER NAME:  '.$json['transporter_name'].'  <br/><br/>
GATE ENTRY TYPE:   '.$json['gate_entry_type'].'  </td>

<td align="left" style="width: 150px;">REFERENCE NO:  '.$json['reference_number'].' <br/><br/>
LR NO.:  '.$json['lr_no'].' <br/><br/>
CHALLAN NO:  '.$json['challan_no'].'   </td>
</tr>

<tr>
<td align="left" style="width: 250px;">CONTRACTOR NAME:   '.$json['contractor_name'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="width: 120px;">INWARD TIME:  '.$json['time_in'].'  </td>
</tr>

<tr>
<td align="left" style="width: 250px;">PROJECT NAME:   '.$json['project_name'].'  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="width: 120px;">OUTWARD TIME:'.$json['time_out'].'</td>
</tr>

<tr>
<td align="left" style="width: 250px;">STORE NAME:  '.$json['store_name'].'  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="width: 120px;">VEHICLE NO:'.$json['vehicle_no'].'</td>
</tr>
';

$htmlbody .='
<tr>
<th align="left" style="width: 40px;">Sr.No</th>
<th align="center" style="width: 140px;">MATERIAL NUMBER</th>
<th align="center" style="width: 70px;">MATERIAL DESCRIPTION</th>
<th align="center" style="width: 60Px;">UNIT PRICE</th>
<th align="center" style="width: 60px;">QUANTITY</th>
</tr>
';

$count=1;
for($i=0;$i<sizeof($json1);$i++){
  $materialnumber = $materialnumber + $json1[$i]['material_number'];
  $materialdescription = $materialdescription + $json1[$i]['material_description'];
  $unitprice = $unitprice + $json1[$i]['unitprice'];
  $quantity = $quantity + $json1[$i]['quantity'];


  $htmlbody .='
  <tr>
  <th align="center" style="width: 40px;">'.$count++.'</th>
  <th align="center" style="width: 140px;">'.$json1[$i]['material_number'].'</th>
  <th align="center" style="width: 70px;">'.$json1[$i]['material_description'].'</th>
  <th align="center" style="width: 60px;">'.$json1[$i]['unitprice'].'</th>
  <th align="center" style="width: 60px;">'.$json1[$i]['quantity'].'</th>
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
$pdf->Output('Gate_Entry.pdf', 'I');
?>