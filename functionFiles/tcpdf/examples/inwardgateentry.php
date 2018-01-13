<?php
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
  // Page footer
  public function Footer() {
    // Logo
    $image_file = K_PATH_IMAGES.'emco2.png';
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
$pdf->SetTitle('INWARD GATE ENTRY');
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
$gate_entry_id = $_GET['gate_entry_id'];
 $query = "SELECT gate_entry_id,pr.project_name,st.store_name,gate_entry_code,inward_date,supplier_name,transporter_name,inventory_type_id,inward_time,lr_no,vehicle_no,reference_number,outward_time,challan_date,total_no_pkg as ttl_no_pkg,challan_no,um.user_location FROM tbl_inward_gate_entry, tbl_project_master pr,tbl_store_master st,tbl_user_master um where tbl_inward_gate_entry.project_id=pr.project_id and tbl_inward_gate_entry.store_id=st.store_id and gate_entry_id='".$gate_entry_id."'";
    $result = mysqli_query($dbCon,$query);
    $main_array =[];
    $main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $json=$main_array;


    $query1="SELECT material_number,material_description,unit_of_measurement,quantity as quantity,challan_qty as challan_quantity,po_balance_qty as balance_quantity FROM tbl_inward_gate_entry_material where gate_entry_id='".$gate_entry_id."'";
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
<th align="left" style="width: 140px;"><b><br/><br/><br/>EMCO LIMITED<br/>ERECTION UNIT,BETUL</b></th>
<th align="left" style="width: 100px;"><b>INWARD GATE ENTRY/<br/>
RETURN CHALLAN</b></th>
<th align="left" style="width: 130px;">PLACE:'.$json['user_location'].' 
<p> DATE:'.$json['inward_date'].'</p> 
<p>CHALLAN:</p> </th>
</tr>
</table>
';

$pdf->writeHTML($htmlhead, true, false, true, false, '');
$htmlbody .='
<table class="table_data" border="1"  align="center" cellpadding="01">
<tr>
<th align="left" style="width: 220px;">INWARD NUMBER:'.$json['gate_entry_code'].'</th>
<th align="left" style="width: 150px;">INWARD DATE:'.$json['inward_date'].'</th>
</tr>

<tr>
<td align="left" style="width: 220px;">SUPPLIER NAME:  '.$json['supplier_name'].'  <br/><br/>
INVENTORY TYPE:   '.$json['inventory_type_id'].'  <br/><br/>
PO NO:  '.$json['reference_number'].' 
 </td>

<td align="left" style="width: 150px;">INWARD TIME:  '.$json['inward_time'].' <br/><br/>
OUTWARD TIME:  '.$json['outward_time'].' <br/><br/>
LR NO:  '.$json['lr_no'].'   </td>
</tr>

<tr>
<td align="left" style="width: 250px;">TRANSPORTER NAME:   '.$json['transporter_name'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="width: 120px;">VEHICLE NO:  '.$json['vehicle_no'].'  </td>
</tr>

<tr>
<td align="left" style="width: 250px;">PROJECT NAME:   '.$json['project_name'].'  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="width: 120px;">STORE NAME:  '.$json['store_name'].'  </td>
</tr>

<tr>
<td align="left" style="width: 250px;">CHALLAN INVOICE NUMBER:   '.$json['challan_no'].'  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="width: 120px;">CHALLAN DATE:  '.$json['challan_date'].'  </td>
</tr>

<tr>
<<<<<<< .mine
<td align="left" style="width: 250px;">TOTAL NO OF PKGS:   '.$json['ttl_no_pkg'].'  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
||||||| .r233
<td align="left" style="width: 250px;"><b>TOTAL NO OF PKGS</b>:   '.$json['ttl_no_pkg'].'</td>
=======
<td align="left" style="width: 250px;"><b>TOTAL NO OF PKGS</b>: '.$json['ttl_no_pkg'].'</td>
>>>>>>> .r234
</tr>
';

if($json['inventory_type_id'] == '1')
{
  $htmlbody .='
<tr>
<<<<<<< .mine
<th align="left" style="width: 40px;">Sr.No</th>
<th align="center" style="width: 80px;">MATERIAL NUMBER</th>
<th align="center" style="width: 70px;">MATERIAL DESCRIPTION</th>
<th align="center" style="width: 30Px;">UOM</th>
<th align="center" style="width: 50px;">PO QTY</th>
<th align="center" style="width: 50px;">PO CHALLAN QTY</th>
<th align="center" style="width: 50px;">PO BALANCE QTY</th>
||||||| .r233
<th align="left" style="width: 40px;">Sr.No</th>
<th align="center" style="width: 80px;"><b>MATERIAL NUMBER</b></th>
<th align="center" style="width: 70px;"><b>MATERIAL DESCRIPTION</b></th>
<th align="center" style="width: 30Px;"><b>UOM</b></th>
<th align="center" style="width: 50px;"><b>PO QTY</b></th>
<th align="center" style="width: 50px;"><b>PO CHALLAN QTY</b></th>
<th align="center" style="width: 50px;"><b>PO BALANCE QTY</b></th>
=======
<th align="left" style="width: 30px;">Sr.No</th>
<th align="center" style="width: 60px;"><b>MATERIAL NUMBER</b></th>
<th align="center" style="width: 60px;"><b>MATERIAL DESCRIPTION</b></th>
<th align="center" style="width: 30Px;"><b>UOM</b></th>
<th align="center" style="width: 50px;"><b>DELIVERY QTY</b></th>
<th align="center" style="width: 40px;"><b>PO QTY</b></th>
<th align="center" style="width: 50px;"><b>PO CHALLAN QTY</b></th>
<th align="center" style="width: 50px;"><b>PO BALANCE QTY</b></th>
>>>>>>> .r234
</tr>
';

$count=1;
for($i=0;$i<sizeof($json1);$i++){
  $materialnumber = $materialnumber + $json1[$i]['material_number'];
  $materialdescription = $materialdescription + $json1[$i]['material_description'];
  $uom = $uom + $json1[$i]['unit_of_measurement'];
  $deliveryqty = $deliveryqty + $json1[$i]['quantity'];
  $poqty = $poqty + $json1[$i]['quantity'];
  $pochallanqty = $pochallanqty + $json1[$i]['challan_quantity'];
  $pobalanceqty = $pobalanceqty + $json1[$i]['balance_quantity'];


  $htmlbody .='
  <tr>
  <th align="center" style="width: 30px;">'.$count++.'</th>
  <th align="center" style="width: 60px;">'.$json1[$i]['material_number'].'</th>
  <th align="center" style="width: 60px;">'.$json1[$i]['material_description'].'</th>
  <th align="center" style="width: 30px;">'.$json1[$i]['unit_of_measurement'].'</th>
  <th align="center" style="width: 50px;">'.$json1[$i]['quantity'].'</th>
  <th align="center" style="width: 40px;">'.$json1[$i]['quantity'].'</th>
  <th align="center" style="width: 50px;">'.$json1[$i]['challan_quantity'].'</th>
  <th align="center" style="width: 50px;">'.$json1[$i]['balance_quantity'].'</th>
  </tr>
  ';
}
}
else if($json['inventory_type_id'] == '3') {
  $htmlbody .='
<tr>
<th align="left" style="width: 30px;">Sr.No</th>
<th align="center" style="width: 60px;"><b>MATERIAL NUMBER</b></th>
<th align="center" style="width: 60px;"><b>MATERIAL DESCRIPTION</b></th>
<th align="center" style="width: 30Px;"><b>UOM</b></th>
<th align="center" style="width: 50px;"><b>DELIVERY QTY</b></th>
<th align="center" style="width: 40px;"><b>PO QTY</b></th>
<th align="center" style="width: 50px;"><b>PO CHALLAN QTY</b></th>
<th align="center" style="width: 50px;"><b>PO BALANCE QTY</b></th>
</tr>
';

$count=1;
for($i=0;$i<sizeof($json1);$i++){
  $materialnumber = $materialnumber + $json1[$i]['material_number'];
  $materialdescription = $materialdescription + $json1[$i]['material_description'];
  $uom = $uom + $json1[$i]['unit_of_measurement'];
  $deliveryqty = $deliveryqty + $json1[$i]['quantity'];
  $poqty = $poqty + $json1[$i]['quantity'];
  $pochallanqty = $pochallanqty + $json1[$i]['challan_quantity'];
  $pobalanceqty = $pobalanceqty + $json1[$i]['balance_quantity'];


  $htmlbody .='
  <tr>
  <th align="center" style="width: 30px;">'.$count++.'</th>
  <th align="center" style="width: 60px;">'.$json1[$i]['material_number'].'</th>
  <th align="center" style="width: 60px;">'.$json1[$i]['material_description'].'</th>
  <th align="center" style="width: 30px;">'.$json1[$i]['unit_of_measurement'].'</th>
  <th align="center" style="width: 50px;">'.$json1[$i]['quantity'].'</th>
  <th align="center" style="width: 40px;">'.$json1[$i]['quantity'].'</th>
  <th align="center" style="width: 50px;">'.$json1[$i]['challan_quantity'].'</th>
  <th align="center" style="width: 50px;">'.$json1[$i]['balance_quantity'].'</th>
  </tr>
  ';
}
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
$pdf->Output('Inward_Gate_Entry.pdf', 'I');
?>