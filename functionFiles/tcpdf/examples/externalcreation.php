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
$pdf->SetTitle('EXTERNAL INDENT');
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
$indent_code = $_GET['indent_code'];
 $query = "SELECT ih.indent_code,ih.indent_date,pr.project_name,pr.manager_name,st.site_location,act.activity_name,con.contractor_name,ih.soil_type,ih.tower_type,um.user_location from indent_head ih,tbl_project_master pr,tbl_site_master st,tbl_activity_master act,tbl_contractor_master con,tbl_user_master um where ih.project_id=pr.project_id and ih.activity_id=act.activity_id and ih.contractor_id=con.contractor_id and ih.site_id=st.site_id and indent_code='".$indent_code."'";
    $result = mysqli_query($dbCon,$query);
    $main_array =[];
    $main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $json=$main_array;


    $query1="SELECT ih.indent_code,im.material_code,mm.material_id,mm.material_name,mm.material_description,mm.unit_of_measurment,im.indent_material_qty FROM indent_head as ih,indent_material as im,tbl_material_master as mm where ih.indent_id=im.indent_id and mm.material_id=im.material_id and ih.indent_code='".$indent_code."'";
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
<th align="left" style="width: 100px;"><b>EXTERNAL INDENT/<br/>
RETURN CHALLAN</b></th>
<th align="left" style="width: 130px;">PLACE:'.$json['user_location'].' 
<p>DATE :'.$json['indent_date'].'</p> 
<p>CHALLAN:</p> </th>
</tr>
</table>
';

$pdf->writeHTML($htmlhead, true, false, true, false, '');
$htmlbody .='
<table class="table_data" border="1"  align="center" cellpadding="01">
<tr>
<th align="left" style="width: 220px;"><b>INDENT CODE:'.$json['indent_code'].'</b></th>
<th align="left" style="width: 150px;"><b>INDENT DATE:'.$json['indent_date'].'</b></th>
</tr>

<tr>
<td align="left" style="width: 220px;"><b>PROJECT NAME</b>: '.$json['project_name'].'<br/><br/>
<b>MANAGER NAME</b>:   '.$json['manager_name'].'</td>

<td align="left" style="width: 150px;"><b>SOIL TYPE</b>: '.$json['soil_type'].'<br/><br/>
<b>TOWER TYPE</b>:   '.$json['tower_type'].'</td>
</tr>

<tr>
<td align="left" style="width: 220px;"><b>SITE LOCATION</b>: '.$json['site_location'].'</td>
<td align="left" style="width: 150px;"><b>ACTIVITY NAME</b>: '.$json['activity_name'].'</td>
</tr>

<tr>
<td align="left" style="width: 220px;"><b>CONTRACTOR NAME</b>:'.$json['contractor_name'].'</td>
</tr>

';

$htmlbody .='
<tr>
<th align="left" style="width: 40px;">Sr.No</th>
<th align="center" style="width: 90px;"><b>MATERIAL CODE</b></th>
<th align="center" style="width: 70px;"><b>MATERIAL NAME</b></th>
<th align="center" style="width: 70px;"><b>MATERIAL DESCRIPTION</b></th>
<th align="center" style="width: 60px;"><b>QUANTITY</b></th>
<th align="center" style="width: 40Px;"><b>UOM</b></th>
</tr>
';

$count=1;
for($i=0;$i<sizeof($json1);$i++){
  $materialnumber = $materialnumber + $json1[$i]['material_code'];
  $materialname = $materialname + $json1[$i]['material_name'];
  $materialdescription = $materialdescription + $json1[$i]['material_description'];
  $quantity = $quantity + $json1[$i]['indent_material_qty'];
  $uom = $uom + $json1[$i]['unit_of_measurment'];


  $htmlbody .='
  <tr>
  <th align="center" style="width: 40px;">'.$count++.'</th>
  <th align="center" style="width: 90px;">'.$json1[$i]['material_code'].'</th>
  <th align="center" style="width: 70px;">'.$json1[$i]['material_name'].'</th>
  <th align="center" style="width: 70px;">'.$json1[$i]['material_description'].'</th>
  <th align="center" style="width: 60px;">'.$json1[$i]['indent_material_qty'].'</th>
  <th align="center" style="width: 40px;">'.$json1[$i]['unit_of_measurment'].'</th>
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
//$pdf->writeHTML($toolcopy, true, 0, true, 0);
 ob_end_clean();

//Close and output PDF document
$pdf->Output('Internal_indent.pdf', 'I');
?>