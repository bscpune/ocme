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
$pdf->SetTitle('MATERIAL ISSUE');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set header and footer fonts
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Insert a logo in the top-left corner at 300 dpi
//$pdf->Image('images/EMCO.png',10,10,-300);

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
$contractor_inventory_id = $_GET['contractor_inventory_id'];

 $query = "SELECT con.material_issue_number,con.material_issue_date,ind.indent_code,st.site_location,act.activity_name,pr.project_name,sto.store_name,cont.contractor_name,con.inventory_type,con.loc_no,con.issued_to,con.remark,um.user_location FROM tbl_contractor_inventory con,indent_head ind,tbl_activity_master act,tbl_site_master st,tbl_contractor_master cont,tbl_project_master pr,tbl_store_master sto,tbl_user_master um 
where con.indent_id = ind.indent_id and con.activity_id=act.activity_id and con.site_id=st.site_id and con.project_id=pr.project_id and con.store_id=sto.store_id and con.contractor_id=cont.contractor_id and con.contractor_inventory_id='".$contractor_inventory_id."'";
    $result = mysqli_query($dbCon,$query);
    $main_array =[];
    $main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $json=$main_array;

    $query1 = "SELECT cm.inventory_material_id,cm.material_number as material_code,cm.issued_qty,cm.indent_qty as approved_total_qty,mm.material_name,mm.material_id,mm.unit_of_measurment,indent_qty-issued_qty as indent_remaining_qty FROM tbl_contractor_inventory_material as cm,tbl_material_master as mm where cm.material_id = mm.material_id and contractor_inventory_id = ".$contractor_inventory_id.";";

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
<th align="left" style="width: 100px;"><b>MATERIAL ISSUE/<br/>
RETURN CHALLAN</b></th>
<th align="left" style="width: 130px;">PLACE : '.$json['user_location'].'
<p> DATE : '.$json['material_issue_date'].'</p> 
<p>CHALLAN :</p> </th>
</tr>
</table>
';

$pdf->writeHTML($htmlhead, true, false, true, false, '');
$htmlbody .='
<table class="table_data" border="1"  align="center" cellpadding="01">
<tr>
<th align="left" style="width: 200px;">MATERIAL ISSUE NUMBER:    '.$json['material_issue_number'].'</th>
<th align="left" style="width: 170px;">MATERIAL ISSUE DATE:    '.$json['material_issue_date'].'</th>
</tr>

<tr>
<td align="left" style="width: 220px;">ISSUED TO: '.$json['issued_to'].'<br/><br/>
REMARK:   '.$json['remark'].'</td>

<td align="left" style="width: 150px;">INDENT NUMBER:  '.$json['indent_code'].'<br/><br/>
LOC NO:   '.$json['loc_no'].'</td>
</tr>

<tr>
<td align="left" style="width: 220px;">CONTRACTOR NAME: '.$json['contractor_name'].'</td>
<td align="left" style="width: 150px;">INVENTORY TYPE:  '.$json['inventory_type'].'</td>
</tr>

<tr>
<td align="left" style="width: 220px;">PROJECT NAME:   '.$json['project_name'].'</td>
<td align="left" style="width: 150px;">STORE NAME:  '.$json['store_name'].'</td>
</tr>

<tr>
<td align="left" style="width: 220px;">ACTIVITY NAME:   '.$json['activity_name'].'</td>
<td align="left" style="width: 150px;">SITE LOCATION:  '.$json['site_location'].'</td>
</tr>

';

$htmlbody .='
<tr>
<th align="left" style="width: 40px;">Sr.No</th>
<th align="center" style="width: 90px;">MATERIAL NAME</th>
<th align="center" style="width: 50px;">MATERIAL NUMBER</th>
<th align="center" style="width: 50px;">UOM</th>
<th align="center" style="width: 40Px;">INDENT QUANTITY</th>
<th align="center" style="width: 60px;">REMAINING QUANTITY</th>
<th align="center" style="width: 40px;">ISSUED QUANTITY</th>
</tr>
';

$count=1;
for($i=0;$i<sizeof($json1);$i++){
  $materialname = $materialname + $json1[$i]['material_name'];
  $materialcode = $materialcode + $json1[$i]['material_number'];
  $uom = $uom + $json1[$i]['unit_of_measurment'];
  $indentquantity = $indentquantity + $json1[$i]['approved_total_qty'];
  $ramainingquantity = $ramainingquantity + $json1[$i]['indent_remaining_qty'];
  $issuedquantity = $issuedquantity + $json1[$i]['issued_qty'];


  $htmlbody .='
  <tr>
  <th align="center" style="width: 40px;">'.$count++.'</th>
  <th align="center" style="width: 90px;">'.$json1[$i]['material_name'].'</th>
  <th align="center" style="width: 50px;">'.$json1[$i]['material_number'].'</th>
  <th align="center" style="width: 50px;">'.$json1[$i]['unit_of_measurment'].'</th>
  <th align="center" style="width: 40px;">'.$json1[$i]['approved_total_qty'].'</th>
  <th align="center" style="width: 60px;">'.$json1[$i]['indent_remaining_qty'].'</th>
  <th align="center" style="width: 40px;">'.$json1[$i]['issued_qty'].'</th>
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
$pdf->Output('MATERIAL_ISSUE.pdf', 'I');

?>