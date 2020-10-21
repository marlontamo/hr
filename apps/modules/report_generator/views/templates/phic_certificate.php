<?php
	$reg_company = get_registered_company();
	if(is_array($reg_company)) {
		//$company = $reg_company['registered_company'];
		$company = (isset($reg_company['registered_company']) && !empty($reg_company['registered_company'])) ? $reg_company['registered_company'] : $row['Company'];
	}else{
		$company = $row['Company'];
	}
	$middlename = !empty($row['Middlename']) ? substr( $row['Middlename'], 0, 1).". " : " ";
	$emp_name = $row['Firstname'].' '.$middlename.$row['Lastname']; 
?>
<html>
	<body>
		<div>
			<table>
				<tr>
					<td width="100%" align="right" style="font-size:7 ;">&nbsp;</td>
				</tr>
				<tr>
					<td width="100%" style="font-size:40;">&nbsp;</td>
				</tr>
				<tr>
					<td width="100%" style="font-size:40;">&nbsp;</td>
				</tr>
				<tr>
					<td width="100%" align="center" font-size="20"><h2>C  E  R  T  I  F  I  C  A  T  I  O  N</h2></td>
				</tr>
				<tr>
					<td width="100%" style="font-size:20;">&nbsp;</td>
				</tr>
				
				<tr>
					<td width="100%">
						<p style="font-size:10;">This is to certify that the following <b>PHILHEALTH Contribution</b> payments have been remitted to PHILHEALTH by <b><?php echo $company; ?></b> for and on behalf of <b><?php echo $emp_name; ?> :</b></p>
					</td>
				</tr>
			</table>
			<table cellpadding="1">
				<tr><td width="100%" style="font-size:20;">&nbsp;</td></tr>
                <tr>
                    <td width="10%">&nbsp;</td>
                    <td width="20%" style="text-align:center; font-size:10;"><b>Period Covered</b></td>
                    <td width="15%" style="text-align:center; font-size:10;"><b>Employee<br>Contribution</b></td>
	                <td width="15%" style="text-align:center; font-size:10;"><b>Employer<br>Contribution</b></td>
                    <td width="15%" style="text-align:center; font-size:10;"><b>OR No.</b></td>
                    <td width="15%" style="text-align:center; font-size:10;"><b>Date payments</b></td>
                    <td width="10%"></td>
                </tr>
            </table>
            <table cellpadding="1">
            	<?php
            	$cnt = 0; 
            	if( isset($detail) ){
            		foreach($detail as $value ) 
	                {	
	                    $period = date('M-y',strtotime($value['Payroll Date']));
	                    $emp = $value['Phic Emp'] ;
	                    $er = $value['Phic Com'] ;
	                    $sbr_no = $value['Sbr No Phic'];
	                    $dt_paid = !empty($value['Sbr Date Phic']) ? date('Y-m-d',strtotime($value['Sbr Date Phic'])) : "";
	                    ?>
	                    <tr>
	                        <td width="10%">&nbsp;</td>
		                    <td width="20%" style="text-align:center; font-size:10; "><?php echo $period;?></td>
		                    <td width="15%" style="text-align:right ; font-size:10; "><?php echo $emp != "" ? number_format( $emp, 2, '.', ',' ) : "0.00" ;?></td>
			                <td width="15%" style="text-align:right ; font-size:10; "><?php echo $er  != "" ? number_format( $er , 2, '.', ',' ) : "0.00";?></td>
		                    <td width="15%" style="text-align:center; font-size:10; "><?php echo $sbr_no;?></td>
		                    <td width="15%" style="text-align:center; font-size:10; "><?php echo $dt_paid;?></td>
		                    <td width="10%">&nbsp;</td>
	                    </tr><?php    
	                    $cnt++;
	                }
                }
            	?>
            </table>
            <table>
            	<tr>
					<td width="100%" style="font-size:10;">&nbsp;</td>
				</tr>
				
				<tr>
					<td width="100%" style="font-size:10;">
						<p>Issued this <?php echo date("jS \d\a\y  \of F Y");?> in compliance with the request of <?php echo $row['Title'].' '.$row['Lastname']; ?> for whatever legal purpose it may serve her best.</p>
					</td>
				</tr>
            	<tr>
					<td width="100%" style="font-size:30;">&nbsp;</td>
				</tr>
                <tr>
                    <td width="100%" style="text-align:left; font-size:10;"><?php echo $row['Signatory']; ?></td>
                </tr>
                <tr>
                    <td width="100%" style="text-align:left; font-size:10;"><?php echo $row['Position']?></td>
                </tr>
            </table>
        </div>
	</body>
</html>