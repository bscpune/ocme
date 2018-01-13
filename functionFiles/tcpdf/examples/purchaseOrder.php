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
$pdf->SetTitle('Purchase Order');
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
$po_id = $_GET['po_id'];
		$query =  "select po.po_id,po.po_code,po.po_date,po.po_type_id,i.indent_code,i.indent_date ,dept.dept_name,po.quotation_no,cs.quotation_date,vm.vendor_code,vm.vendor_name,vm.phone_no,vm.gst_no,po.shipping_address,po.billing_address,po.total_amount,po.discount_amount,po.basic_value,po.tax_amount,po.packing_amount,po.transportation_cost,po.grand_total,po.grand_total_roundoff,po.delivery_period,po.delivery_date,po.delivery_incharge_name,po.delivery_incharge_no,po.transport_no,po.insurance_no,p.payment_term_id,po.remark,po.po_status,poa.hod_approved_by,poa.hod_approved_on,poa.hod_approved_status,poa.gm_approved_by,poa.gm_approved_on,poa.gm_approved_status from tbl_purchase_order as po,tbl_purchase_type pt,tbl_indent i,tbl_department_master dept,tbl_comparative_stmt as cs,tbl_vendor_master vm,tbl_payment_term p,tbl_purchase_order_approval poa where po.indent_id = i.indent_id AND i.dept_id = dept.dept_id AND cs.indent_id = po.indent_id AND po.vendor_id = vm.vendor_id AND po.payment_term = p.payment_term_id AND pt.po_type_id = po.po_type_id AND poa.po_id = po.po_id AND po.quotation_no = cs.quotation_no AND po.po_id=".$po_id."";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=$main_array;

		$pomaterial = "select pom.po_material_id,pom.po_id,mm.material_code,mm.material_name,mm.material_description, mm.unit_of_measurement,pom.quantity,pom.unit_price as negotiable_price,pom.taxable_value,pom.packing_amt,pom.excise_duty_percentage,pom.edu_cess_percentage,pom.vat_percentage,tm.IGST as igst,tm.CGST as cgst,tm.SGST as sgst,tm.tax_code,pom.total_value as final_value from tbl_purchase_order_material as pom,tbl_material_master as mm,tbl_tax_master as tm,tbl_purchase_order as po where pom.po_id = po.po_id AND pom.material_id = mm.material_id AND pom.tax_id = tm.tax_id AND pom.po_id =".$po_id."";
		$result = mysqli_query($dbCon,$pomaterial);
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
<h2 align="center"><mark> Purchase Order </mark></h2>
<h3><p>PO NO : '.$json['po_code'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Indent Code :'.$json['indent_code'].'
<br>Date :'.$json['po_date'] .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Department : '.$json['dept_name']. '</p></h3>';

$pdf->writeHTML($htmlhead, true, false, true, false, '');
$htmlbody ='
<table class="table_data" border="1" align="center" cellpadding="2">
<tr bgcolor="rgb(233,244,250)">
<th align="center" style="width: 20px;">Sr.No</th>
<th align="center" style="width: 60px;">Code</th>
<th align="center" style="width: 60px;">Name</th>
<th align="center" style="width: 100px;">Material Description</th>
<th align="center" style="width: 30px;">UOM</th>
<th align="center" style="width: 40px;">Quantity</th>
<th align="center" style="width: 50px;">Unit Price</th>
<th align="center" style="width: 50px;">Taxable Value</th>
<th align="center" style="width: 40px;">Packing Amt</th>
<th align="center" style="width: 50px;">Excise Duty %</th>
<th align="center" style="width: 50px;">Vat/cst %</th>
<th align="center" style="width: 40px;">Tax Rate</th>
<th align="center" style="width: 40px;">IGST</th>
<th align="center" style="width: 40px;">CGST</th>
<th align="center" style="width: 40px;">SGST</th>
<th align="center" style="width: 60px;">Total Value</th>
</tr>
';
$count=0;
$totalAmt = 0;
for($i=0;$i<sizeof($json1);$i++){
$htmlbody .='  
<tr>
<th align="center" style="width: 20px;">'.$count++.'</th>

<th align="center" style="width: 60px;">'.$json1[$i]['material_code'].'</th>
<th align="center" style="width: 60px;">'.$json1[$i]['material_name'].'</th>
<th align="center" style="width: 100px;">'.$json1[$i]['material_description'].'</th>
<th align="center" style="width: 30px;">'.$json1[$i]['unit_of_measurement'].'</th>
<th align="center" style="width: 40px;">'.$json1[$i]['quantity'].'</th>
<th align="center" style="width: 50px;">'.$json1[$i]['negotiable_price'].'</th>
<th align="center" style="width: 50px;">'.$json1[$i]['taxable_value'].'</th>
<th align="center" style="width: 40px;">'.$json1[$i]['packing_amount'].'</th>
<th align="center" style="width: 50px;">'.$json1[$i]['excise_duty_percentage'].'</th>
<th align="center" style="width: 50px;">'.$json1[$i]['vat_percentage'].'</th>
<th align="center" style="width: 40px;">'.$json1[$i]['tax_code'].'</th>
<th align="center" style="width: 40px;">'.$json1[$i]['igst'].'</th>
<th align="center" style="width: 40px;">'.$json1[$i]['cgst'].'</th>
<th align="center" style="width: 40px;">'.$json1[$i]['sgst'].'</th>
<th align="center" style="width: 60px;">'.$json1[$i]['final_value'].'</th>
</tr>';
}
$htmlbody .='<tr>
<th colspan="15" align="right" >Total Amount</th>
<th>'.$json['total_amount'].'</th>
</tr><tr>
<th colspan="15" align="right" >Discount Amount</th>
<th>'.$json['discount_amount'].'</th>
</tr><tr>
<th colspan="15" align="right" >Basic Value</th>
<th>'.$json['basic_value'].'</th>
</tr><tr>
<th colspan="15" align="right" >Tax Amount</th>
<th>'.$json['tax_amount'].'</th>
</tr><tr>
<th colspan="15" align="right" >IGST</th>
<th>'.$json['igst'].'</th>
</tr><tr>
<th colspan="15" align="right" >CGST</th>
<th>'.$json['cgst'].'</th>
</tr><tr>
<th colspan="15" align="right" >SGST</th>
<th>'.$json['sgst'].'</th>
</tr><tr>
<th colspan="15" align="right" >Packing & Forwarding Amt</th>
<th>'.$json['packing_amount'].'</th>
</tr><tr>
<th colspan="15" align="right" >Transportation Cost</th>
<th>'.$json['transportation_cost'].'</th>
</tr><tr>
<th colspan="15" align="right" >Grand Total</th>
<th>'.$json['grand_total'].'</th>
</tr>
<tr>
<th colspan="15" align="right" >Grand Total Round Off</th>
<th>'.$json['grand_total_roundoff'].'</th>
</tr>
</table>
<b>Total Package Amount: Rs.' .$json['grand_total_roundoff'].'.('.$result.'Rupees)</b>

<footer align="center">
Facor Power Limited <br>
CIN NO. - U4010DL2005PLC139923</footer>';

$pdf->writeHTML($htmlbody, true, false, true, false, '');
 ob_end_clean();

//Close and output PDF document
$pdf->Output('Purchase_Order.pdf', 'I');
?>