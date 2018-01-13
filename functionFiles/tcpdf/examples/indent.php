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
$pdf->SetTitle('Indent');
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
$pdf->SetMargins(15,10,15,true);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// add a page
$pdf->AddPage('p','A3');
require_once 'dbConnection.php';
$json = array();
$json1 = array();
$indent_id = $_GET['indent_id'];
		$query = "select indent.indent_id,indent.indent_code,indent.indent_date,indent.required_date,indent.indent_type,indent.hod_name,indent.total_quantity,indent.test_certificate,indent.budget,indent.budget_remark,indent.requirement,indent.approved_status,indent.created_by,dept.dept_name,indentfor.indentfor_id,tuse.typeofuse_id,approval.hod_approved_status,approval.hod_approved_by,CAST(approval.hod_approved_on as DATE) as hod_approved_on,approval.dgm_approved_status,approval.dgm_approved_by,CAST(approval.dgm_approved_on as DATE) as dgm_approved_on,approval.gm_approved_status,approval.gm_approved_by,CAST(approval.gm_approved_on as DATE) as gm_approved_on from tbl_indent indent left join tbl_department_master dept on indent.dept_id=dept.dept_id left join tbl_indentfor_master indentfor on indent.indentfor_id=indentfor.indentfor_id left join tbl_typeofuse_master tuse on indent.typeofuse_id=tuse.typeofuse_id left join tbl_indent_approval approval on indent.indent_id=approval.indent_id where indent.indent_id=".$indent_id."";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=$main_array;

		$indentmaterial = "select tbl_indent_material.*,material_name,unit_of_measurement,material_make from tbl_indent_material left join tbl_material_master on tbl_indent_material.material_id=tbl_material_master.material_id where indent_id=".$indent_id."";
		$result = mysqli_query($dbCon,$indentmaterial);
		$main_array =[];
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {   
			foreach($row as $key => $value) { 
				$arr[$key] = $value;
			}
			$main_array[] = $arr;
		}
		$json1=$main_array; 
		/*header('Content-Type: application/json');
		echo $json;*/

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
<h2 align="center"><mark> Voucher </mark></h2>
<table class="table_data" cellpadding="2">
<tr>
<td align="left" width = "80%"><h3>Indent Code :'.$json['indent_code'].'</h3></td>
<td align="left" width = "20%"><h3>Indent Date :'.$json['indent_date'].'</h3></td>
</tr>

<tr>
<td align="left" width = "80%"><h3>Require Date :'.date('d-m-Y',strtotime($json['required_date'])).'</h3></td>
<td align="left" width = "20%"><h3>Test Certificate : '.$json['test_certificate'].'</h3></td>
</tr>

<tr>
<td align="left" width = "80%"><h3>HOD Name : '.$json['hod_name'].'</h3></td>
<td align="left" width = "20%"><h3>Requiremnet : '.$json['requirement'].'</h3></td>
</tr>

<tr>
<td align="left" width = "80%"><h3>Type Of Use : '.$json['typeofuse']. '</h3></td>
<td align="left" width = "20%"><h3>Department : '.$json['dept_name']. '</h3></td>
</tr>

';

$pdf->writeHTML($htmlhead, true, false, true, false, '');
$htmlbody ='

<table class="table_data" border="1" cellpadding="2">
<tr bgcolor="rgb(233,244,250)">
<th align="center" style="width: 20px;">Sr.No</th>
<th align="center" style="width: 50px;">Code</th>
<th align="center" style="width: 120px;">Material Description</th>
<th align="center" style="width: 120px;">Equipment/Purpose</th>
<th align="center" style="width: 40px;">UOM</th>
<th align="center" style="width: 40px;">Quantity</th>
<th align="center" style="width: 40px;">Unit Price</th>
<th align="center" style="width: 60px;">Present Stock</th>
<th align="center" style="width: 40px;">Make</th>
<th align="center" style="width: 60px;">Model</th>
<th align="center" style="width: 80px;">Consumption Pattern</th>
<th align="center" style="width: 60px;">Proprietary</th>
</tr>';
$count=0;
$totalAmt = 0;
for($i=0;$i<sizeof($json1);$i++){
$htmlbody .='  
<tr>
<th align="center" style="width: 20px;">'.$count++.'</th>
<th align="center" style="width: 50px;">'.$json1[$i]['material_code'].'</th>
<th align="center" style="width: 120px;">'.$json1[$i]['material_description'].'</th>
<th align="center" style="width: 120px;">'.$json1[$i]['purpose'].'</th>
<th align="center" style="width: 40px;">'.$json1[$i]['unit_of_measurement'].'</th>
<th align="center" style="width: 40px;">'.$json1[$i]['quantity'].'</th>
<th align="center" style="width: 40px;">'.$json1[$i]['unit_price'].'</th>
<th align="center" style="width: 60px;">'.$json1[$i]['present_stock'].'</th>
<th align="center" style="width: 40px;">'.$json1[$i]['material_make'].'</th>
<th align="center" style="width: 60px;">'.$json1[$i]['model'].'</th>
<th align="center" style="width: 80px;">'.$json1[$i]['consumption_pattern'].'</th>
<th align="center" style="width: 60px;">'.$json1[$i]['proprietary'].'</th>

</tr>';
}
$htmlbody .='
</table>

<footer align="center">
Facor Power Limited <br>
CIN NO. - U4010DL2005PLC139923</footer>';

$pdf->writeHTML($htmlbody, true, false, true, false, '');
 ob_end_clean();

//Close and output PDF document
$pdf->Output('indent.pdf', 'I');
?>