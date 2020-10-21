<?php
	//prep data
	$res = $result->row();
    $company = $res->{'Company'};
   // $address = $res->{'Address'};
    $payroll_date = $res->{'Payroll Date'};
   $date_from = $res->{'Date From'};
    $date_to = $res->{'Date To'};
    $results = $result->result_array();
?>
<table>
	<tr>
	    <td colspan="4" width="100%" style="text-align:center; font-size:10; "><strong>DEDUCTION DETAIL PER EMPLOYEE</strong></td>
	</tr>
	<tr>
        <td colspan="4" width="100%" style="font-size:10;">For the payroll period <?php echo date("M d", strtotime($date_from)); ?> - <?php echo date("M d, Y", strtotime($date_to)); ?></td>
    </tr>
    <tr>
	    <td width="100%" style="font-size:10;"></td>
	</tr>
    <tr>
        <td width="100%" style="font-size:10;"></td>
    </tr>
    <tr>
        <td colspan="2" width="100%" style="font-size:10;">COMPANY LOAN</td>
    </tr>
	<tr>
	    <td width="30%" style="text-align:left;">PRN</td>
	    <td width="12%" style="text-align:center;">EMPLOYEE NO</td>
	    <td width="12%" style="text-align:center;">LAST NAME</td>
	    <td width="17%" style="text-align:center;">FIRST NAME</td>
	    <td width="12%" style="text-align:center;">DEDUCTION START</td>
        <td width="17%" style="text-align:right;">PAYROLL DATE</td>
	    <td width="17%" style="text-align:right;">COMPANY LOAN</td>
	</tr>
	<?php
    $tot_amount = 0;
    foreach ($results as $dtl_res) {
     ?>
        	
                <tr>
                    <td><?php echo $dtl_res['Project Code']; ?></td>
                    <td><?php echo $dtl_res['Id Number']; ?></td>
                    <td><?php echo $dtl_res['Lastname']; ?></td>
                    <td><?php echo $dtl_res['Firstname']; ?></td>
                    <td><?php echo date("m/d/Y", strtotime($dtl_res['Start Date'])); ?></td>
                    <td><?php echo date("m/d/Y", strtotime($dtl_res['Payroll Date'])); ?></td>
                    <td><?php echo $dtl_res['Amount']; ?></td>
                </tr>
                <?php 
                $tot_amount += $dtl_res['Amount'];
            }
        ?>
        
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>TOTAL</td>
                    <td><?php echo $tot_amount; ?></td>
                </tr>
</table>