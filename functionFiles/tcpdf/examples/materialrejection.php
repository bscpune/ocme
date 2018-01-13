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
    $this->Cell(0, 10, 'EMCO Power Limited'
    .$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
  }
}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator('PDF_CREATOR');
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('MATERIAL REJECTION');
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
$mrr_id = $_GET['mrr_id'];

 $query = "SELECT mrh.material_rejection_code,mrh.rejection_date,mrh.mrr_code,mrh.mrr_date,mrh.gate_entry_code,pr.project_name,st.store_name,mrh.inventory_type_id,mrh.supplier_name,mrh.supplier_invoice_no,mrh.location_of_despatch,mrh.transporter_name,mrh.vehicle_no,mrh.lr_no from tbl_mrr_head mrh,tbl_project_master pr,tbl_store_master st where mrh.project_id=pr.project_id and mrh.store_id=st.store_id and mrh.mrr_id='".$mrr_id."'";
    $result = mysqli_query($dbCon,$query);
    $main_array =[];
    $main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $json=$main_array;

    $query1 = "SELECT ge.material_number,ge.material_description,ge.unit_of_measurement,ge.quantity,
mm.rejected_quantity,mm.reason_for_rejection from tbl_mrr_material mm,tbl_inward_gate_entry_material ge 
where ge.inward_ge_material_id=mm.inward_ge_material_id and mm.rejected_quantity>0 
and mm.mrr_id='".$mrr_id."'";
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
<th align="left" style="width: 200px;">MATERIAL REJECTION CODE NOTE NO:    '.$json['material_rejection_code'].'</th>
<th align="left" style="width: 170px;">MATERIAL REJECTION  DATE:    '.$json['rejection_date'].'</th>
</tr>

<tr>
<td align="left" style="width: 200px;">MRR NUMBER: '.$json['mrr_code'].' <br/><br/>
MRR DATE:   '.$json['mrr_date'].' <br/><br/>
VEHICLE NO:   '.$json['vehicle_no'].'</td>

<td align="left" style="width: 170px;">GATE ENTRY NO:   '.$json['gate_entry_code'].' <br/><br/>
SUPPLIER INVOICE NO:   '.$json['supplier_invoice_no'].' <br/><br/>
LR NO:   '.$json['lr_no'].'</td>
</tr>

<tr>
<td align="left" style="width: 200px;">SUPPLIER NAME: '.$json['supplier_name'].'</td>
<td align="left" style="width: 170px;">TRANSPORTOR NAME:  '.$json['transporter_name'].'</td>
</tr>

<tr>
<td align="left" style="width: 200px;">PROJECT NAME:  '.$json['project_name'].' </td>
<td align="left" style="width: 170px;">INVENTORY TYPE:  '.$json['inventory_type_id'].'</td>
</tr>

<tr>
<td align="left" style="width: 200px;">STORE NAME:  '.$json['store_name'].' </td>
<td align="left" style="width: 170px;">LOCATION OF DISPTACH:  '.$json['location_of_despatch'].'</td>
</tr>

';

$htmlbody .='
<tr>
<th align="left" style="width: 20px;">Sr.No</th>
<th align="center" style="width: 70px;">MATERIAL NUMBER</th>
<th align="center" style="width: 70Px;">MATERIAL DESCRIPTION</th>
<th align="center" style="width: 40px;">UOM</th>
<th align="center" style="width: 40px;">QUANTITY</th>
<th align="center" style="width: 60px;">REJECTED QUANTITY</th>
<th align="center" style="width: 70px;">REASON FOR REJECTION</th>
</tr>
';

$count=1;
for($i=0;$i<sizeof($json1);$i++){
  $materialnumber = $materialnumber + $json1[$i]['material_number'];
  $materialdescription = $materialdescription + $json1[$i]['material_description'];
  $uom = $uom + $json1[$i]['unit_of_measurement'];
  $quantity = $quantity + $json1[$i]['quantity'];
  $rejectedquantity = $rejectedquantity + $json1[$i]['rejected_quantity'];
  $reasonforrejection = $reasonforrejection + $json1[$i]['reason_for_rejection'];

  $htmlbody .='
  <tr>
  <th align="center" style="width: 20px;">'.$count++.'</th>
  <th align="center" style="width: 70px;">'.$json1[$i]['material_number'].'</th>
  <th align="center" style="width: 70px;">'.$json1[$i]['material_description'].'</th>
  <th align="center" style="width: 40px;">'.$json1[$i]['unit_of_measurement'].'</th>
  <th align="center" style="width: 40px;">'.$json1[$i]['quantity'].'</th>
  <th align="center" style="width: 60px;">'.$json1[$i]['rejected_quantity'].'</th>
  <th align="center" style="width: 70px;">'.$json1[$i]['reason_for_rejection'].'</th>
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