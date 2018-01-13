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
    $this->Cell(0, 10, 'Emco Power Limited'
    .$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
  }
}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator('PDF_CREATOR');
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('OUTWARD GATE ENTRY');
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
$outward_gate_entry_id = $_GET['outward_gate_entry_id'];
 $query = "SELECT oge.outward_ge_code,oge.outward_date,cust.customer_name,oge.outward_type,oge.inventory_type,pr.project_name,st.store_name,oge.transporter_name,oge.vehicle_no,oge.lr_no,oge.inward_time,oge.outward_time,um.user_location from tbl_outward_gate_entry oge,tbl_project_master pr,tbl_store_master st,tbl_customer_master cust,tbl_user_master um where oge.project_id=pr.project_id and oge.store_id=st.store_id and oge.customer_id=cust.customer_id and oge.outward_gate_entry_id='".$outward_gate_entry_id."'";
    $result = mysqli_query($dbCon,$query);
    $main_array =[];
    $main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $json=$main_array;


    $query1="SELECT igem.material_number,igem.material_description,igem.unit_of_measurement,igem.quantity
from tbl_inward_gate_entry_material igem where outward_gate_entry_id='".$outward_gate_entry_id."'";
    $result = mysqli_query($dbCon,$query1);
    $main_array =[];
   while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {   
      foreach($row as $key => $value) { 
        $arr[$key] = $value;
      }
      $main_array[] = $arr;
    }
   $json1=$main_array;

  


$htmlhead = '
<table class="table_data" border="1"  align="center" cellpadding="01">
<tr>
<th align="left" style="width: 140px;"><b><br/><br/><br/>EMCO LIMITED ERECTION UNIT,BETUL</b></th>
<th align="left" style="width: 100px;"><b>OUTWARD GATE ENTRY<br/>
RETURN CHALLAN</b></th>
<th align="left" style="width: 130px;">PLACE: '.$json['user_location'].' 
<p>DATE: '.$json['outward_date'].'</p> 
<p>CHALLAN:</p> </th>
</tr>
</table>
';

$pdf->writeHTML($htmlhead, true, false, true, false, '');
$htmlbody .='
<table class="table_data" border="1"  align="center" cellpadding="01">
<tr>
<th align="left" style="width: 220px;"><b>OUTWARD NUMBER</b>:'.$json['outward_ge_code'].'</th>
<th align="left" style="width: 150px;"><b>OUTWARD DATE</b>:'.$json['outward_date'].'</th>
</tr>

<tr>
<td align="left" style="width: 220px;"><b>CUSTOMER NAME</b>:  '.$json['customer_name'].'  <br/><br/>
<b>LR NO</b>:  '.$json['lr_no'].'  </td>

<td align="left" style="width: 150px;"><b>INWARD TIME</b>:  '.$json['inward_time'].' <br/><br/>
<b>OUTWARD TIME</b>:  '.$json['outward_time'].' <br/> </td>
</tr>

<tr>
<td align="left" style="width: 200px;"><b>TRANSPORTER NAME</b>:   '.$json['transporter_name'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="width: 170px;"><b>VEHICLE NO</b>:  '.$json['vehicle_no'].'  </td>
</tr>

<tr>
<td align="left" style="width: 200px;"><b>INVENTORY TYPE</b>:   '.$json['inventory_type'].'  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="width: 170px;"><b>STORE NAME</b>:  '.$json['store_name'].'  </td>
</tr>

<tr>
<td align="left" style="width: 200px;"><b>PROJECT NAME</b>:   '.$json['project_name'].'  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="width: 170px;"><b>OUTWARD TYPE</b>:  '.$json['outward_type'].'  </td>
</tr>

';

$htmlbody .='
<tr>
<th align="left" style="width: 40px;">Sr.No</th>
<th align="center" style="width: 140px;"><b>MATERIAL NUMBER</b></th>
<th align="center" style="width: 70px;"><b>MATERIAL DESCRIPTION</b></th>
<th align="center" style="width: 60Px;"><b>UOM</b></th>
<th align="center" style="width: 60px;"><b>QUANTITY</b></th>
</tr>
';

$count=1;
for($i=0;$i<sizeof($json1);$i++){
  $materialnumber = $materialnumber + $json1[$i]['material_number'];
  $materialdescription = $materialdescription + $json1[$i]['material_description'];
  $uom = $uom + $json1[$i]['unit_of_measurement'];
  $quantity = $quantity + $json1[$i]['quantity'];


  $htmlbody .='
  <tr>
  <th align="center" style="width: 40px;">'.$count++.'</th>
  <th align="center" style="width: 140px;">'.$json1[$i]['material_number'].'</th>
  <th align="center" style="width: 70px;">'.$json1[$i]['material_description'].'</th>
  <th align="center" style="width: 60px;">'.$json1[$i]['unit_of_measurement'].'</th>
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
$pdf->Output('Outward_Gate_Entry.pdf', 'I');
?>