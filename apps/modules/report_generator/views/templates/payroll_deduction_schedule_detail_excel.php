<?php
	//prep data
	$res = $result->row();
    $company = $res->{'Company'};
    $address = $res->{'Address'};
    $payroll_date = $res->{'Payroll Date'};
    $date_from = $res->{'Date From'};
    $date_to = $res->{'Date To'};
    $results = $result->result_array();
?>
<table>
	<tr>
	    <td colspan="6" width="100%" style="text-align:center; font-size:10; "><strong><?php echo $company; ?></strong></td>
	</tr>
	<tr>
	    <td colspan="6" width="100%" style="text-align:center;"><?php echo $address; ?></td>
	</tr>
	<tr>
	    <td colspan="6" width="100%" style="text-align:center; font-size:10; "><strong>DEDUCTION SCHEDULE DETAIL REPORT</strong></td>
	</tr>
	<tr>
	    <td width="100%" style="font-size:10;"></td>
	</tr>
	<tr>
	    <td width="30%" style="text-align:left;">Employee Name</td>
	    <td width="12%" style="text-align:center;">Ref. #</td>
	    <td width="12%" style="text-align:center;">Date</td>
	    <td width="17%" style="text-align:center;">Advance Amount</td>
	    <td width="12%" style="text-align:center;">Advance Granted</td>
	    <td width="17%" style="text-align:right;">Deductions</td>
	</tr>
	<tr> 
	    <td width="100%" style="font-size:1; border-bottom:1px solid black;"></td>
	</tr>
	<?php
	$transaction_lbl = '';
    $count = 0;
    $tot_amount = 0;
    $total_line = 0;
    $gtot_amount = 0;
    $gtot_adv_amt = 0;
    foreach ($results as $dtl_res) {
        // if($count == 40){
        	// $count = 0; ?>
        	<!-- <table>
			    <tr><td></td></tr><tr><td></td></tr>
			    <tr>
			        <td width="30%"  style="text-align:left;">Prepared By: </td>
			        <td width="3%"  style="text-align:center;"></td>
			        <td width="30%"  style="text-align:left;">Checked By: </td>
			        <td width="3%"  style="text-align:center;"></td>
			        <td width="30%"  style="text-align:left;">Approved By:</td>
			        <td width="3%"  style="text-align:center;"></td>
			    </tr>
			    <tr><td></td></tr><tr><td></td></tr>
			    <tr>
			        <td style="text-align:left; border-top-width: 1px solid black ; "> </td>
			        <td style="text-align:right;"></td>
			        <td style="text-align:left; border-top-width: 1px solid black ; "> </td>
			        <td style="text-align:right;"></td>
			        <td style="text-align:left; border-top-width: 1px solid black ; "> </td>
			        <td style="text-align:right;"></td>                                    
			    </tr>
			    <tr><td></td></tr><tr><td></td></tr>
			    <tr>
			        <td width="12%" style="text-align:left; ">Pay Period</td>
			        <td width="5%" style="text-align:center; "> : </td>
			        <td width="20%" style="text-align:left; "><?php echo date("Y-m-d",strtotime($payroll_date)); ?></td>
			        <td width="63%" ></td>
			    </tr>
			    <tr>
			        <td width="12%" style="text-align:left; ">Pay Date</td>
			        <td width="5%" style="text-align:center; "> : </td>
			        <td width="20%" style="text-align:left; "><?php echo date("Y-m-d",strtotime($payroll_date)); ?></td>
			        <td width="63%" ></td>
			    </tr>
			    <tr>
			        <td width="12%" style="text-align:left; ">Pay Coverage</td>
			        <td width="5%" style="text-align:center; "> : </td>
			        <td width="20%" style="text-align:left; "><?php echo date("Y-m-d",strtotime($date_from)).' To '.date("Y-m-d",strtotime($date_to)); ?></td>
			        <td width="63%" ></td>
			    </tr>
			    <tr><td></td></tr><tr><td></td></tr>
			    <tr>
			        <td width="12%" style="text-align:left; "></td>
			        <td width="5%" style="text-align:center; "></td>
			        <td width="20%" style="text-align:left; "></td>
			        <td width="63%" ></td>
			    </tr>
			</table> -->
<?php   //}
        if( $transaction_lbl == '' || $transaction_lbl != $dtl_res['Transaction Label'] ) {
            if($transaction_lbl == '') { ?>
                <tr>
                    <td colspan="6" width="100%"><strong><?php echo $dtl_res['Transaction Label']; ?></strong></td>
                </tr><?php
                $total_line++;
            } else { ?>ss
                <tr>
                    <td width="50%"  style="text-align:right;font-size:2;"></td>
                    <td width=" 4%"  style="text-align:Left;font-size:2;"></td>
                    <td width="17%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ;"></td>
                    <td width="12%"  style="text-align:Left;font-size:2;"></td>
                    <td width="17%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
                </tr>
                <tr>
                    <td colspan="4" width="50%"  style="text-align:right; background-color: gray;"><strong>Total <?php echo $label; ?></strong></td>
                    <td width=" 4%"  style="text-align:Left;"></td>
                    <td width="17%"  style="text-align:right;"><strong><?php echo number_format($tot_amount,2,".",","); ?></strong></td>
                </tr>
                <tr>
                    <td width="50%"  style="text-align:right;font-size:2;"></td>
                    <td width=" 4%"  style="text-align:Left;font-size:2;"></td>
                    <td width="17%"  style="text-align:right;font-size:2;border-bottom-width: 1px solid black ;"></td>
                    <td width="12%"  style="text-align:Left;font-size:2;"></td>
                    <td width="17%"  style="text-align:right;font-size:2;border-bottom-width: 1px solid black ; "></td>
                </tr>
                <tr>
                    <td colspan="6" width="100%"><strong><?php echo $dtl_res['Transaction Label']; ?></strong></td>
                </tr><?php 
                $count++;
                $total_line++;
                $tot_amount = 0;
            }
        } ?>
        		<tr>
                    <td width="30%" style="text-align:left;"><?php echo $dtl_res['Full Name']; ?></td>
                    <td width="12%" style="text-align:center;"><?php echo $dtl_res['Reference No']; ?></td>
                    <td width="12%" style="text-align:center;"><?php echo $dtl_res['Payroll Date']; ?></td>
                    <td width="17%" style="text-align:right;"> </td>
                    <td width="12%" style="text-align:center;"> </td>
                    <td width="17%" style="text-align:right;"><?php echo number_format($dtl_res['Amount'],2,'.',','); ?></td>
                </tr><?php
        $tot_amount += $dtl_res['Amount'];
        $gtot_amount += $dtl_res['Amount'];
        $transaction_lbl = $dtl_res['Transaction Label'];
        $label = $dtl_res['Transaction Label'];
        $count++;
        $total_line++;
    } ?>

	<tr>
            <td width="50%"  style="text-align:right;font-size:2;"></td>
            <td width=" 4%"  style="text-align:Left;font-size:2;"></td>
            <td width="17%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ;"></td>
            <td width="12%"  style="text-align:Left;font-size:2;"></td>
            <td width="17%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
    </tr>
    <tr>
        <td colspan="4" width="50%"  style="text-align:right;"><strong>Total <?php echo $label; ?></strong></td>
        <td width=" 4%"  style="text-align:Left;"></td>
        <td width="17%"  style="text-align:right;"><strong><?php echo number_format($tot_amount,2,".",","); ?></strong></td>
    </tr>
	<tr> 
        <td width="100%" style="font-size:4;"></td>
    </tr>
    <tr>
        <td colspan="2" width="50%"  style="text-align:right;"><strong>Grand Total</strong></td>
        <td width=" 4%"  style="text-align:Left;"></td>
        <td width="17%"  style="text-align:right;"><strong><?php echo number_format($gtot_adv_amt,2,".",","); ?></strong></td>
        <td width="12%"  style="text-align:Left;"></td>
        <td width="17%"  style="text-align:right;"><strong><?php echo number_format($gtot_amount,2,".",","); ?></strong></td>
    </tr>
    <tr>
        <td width="50%"  style="text-align:right;font-size:2;"></td>
        <td width=" 4%"  style="text-align:Left;font-size:2;"></td>
        <td width="17%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ;"></td>
        <td width="12%"  style="text-align:Left;font-size:2;"></td>
        <td width="17%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
    </tr>
</table>
<table>
    <tr>
        <td width="30%"  style="text-align:left;">Prepared By: </td>
        <td width="3%"  style="text-align:center;"></td>
        <td width="30%"  style="text-align:left;">Checked By: </td>
        <td width="3%"  style="text-align:center;"></td>
        <td width="30%"  style="text-align:left;">Approved By:</td>
        <td width="3%"  style="text-align:center;"></td>
    </tr>
    <tr>
        <td style="text-align:left; border-top-width: 1px solid black ; "> </td>
        <td style="text-align:right;"></td>
        <td style="text-align:left; border-top-width: 1px solid black ; "> </td>
        <td style="text-align:right;"></td>
        <td style="text-align:left; border-top-width: 1px solid black ; "> </td>
        <td style="text-align:right;"></td>                                    
    </tr>
    <tr><td></td></tr>
    <tr>
        <td width="12%" style="text-align:left; ">Pay Period</td>
        <td width="5%" style="text-align:center; "> : </td>
        <td width="20%" style="text-align:left; "><?php echo date("Y-m-d",strtotime($payroll_date)); ?></td>
        <td width="63%" ></td>
    </tr>
    <tr>
        <td width="12%" style="text-align:left; ">Pay Date</td>
        <td width="5%" style="text-align:center; "> : </td>
        <td width="20%" style="text-align:left; "><?php echo date("Y-m-d",strtotime($payroll_date)); ?></td>
        <td width="63%" ></td>
    </tr>
    <tr>
        <td width="12%" style="text-align:left; ">Pay Coverage</td>
        <td width="5%" style="text-align:center; "> : </td>
        <td width="20%" style="text-align:left; "><?php echo date("Y-m-d",strtotime($date_from)).' To '.date("Y-m-d",strtotime($date_to)); ?></td>
        <td width="63%" ></td>
    </tr>
    <tr><td></td></tr><tr><td></td></tr>
    <tr>
        <td width="12%" style="text-align:left; "></td>
        <td width="5%" style="text-align:center; "></td>
        <td width="20%" style="text-align:left; "></td>
        <td width="63%" ></td>
    </tr>
</table>