<?php
    //prep data
    $res = $result->row();
    $company = $res->{'Company'};
    $address = $res->{'Address'};
    $payroll_date = $res->{'Payroll Date'};
    $phone_no = $res->{'Phone No'};
    $fax_no = $res->{'Fax No'};
    $year = $res->{'Year'};
    $month = date("F", mktime(0, 0, 0, $res->{'Month'}, 10));
    $deduction = $res->{'Loan'};
    $date_from = $res->{'Date From'};
    $date_to = $res->{'Date To'};
    $results = $result->result_array();
?>
<table>
    <tr><td></td></tr>
    <tr>
        <td width="100%" style="text-align:left; font-size:10; "><strong><?php echo $company; ?></strong></td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left; font-size:5;"><?php echo $address; ?></td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left; font-size:5;">Phone No: <?php echo $phone_no; ?> Fax No: <?php echo $fax_no;?></td>
    </tr>
    <tr>
        <td width="100%" style="font-size:10;"></td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left; font-size:10; "><strong>MONTHLY DEDUCTION LISTING</strong></td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left; font-size:10; "><strong><?php echo $deduction; ?> for the month of <?php echo $month . " " . $year?></strong></td>
    </tr>
    <tr>
        <td width="100%" style="font-size:10;"></td>
    </tr>
    <tr>
        <td width="15%" style="text-align:center;">Employee ID</td>
        <td width="35%" style="text-align:left;">Employee Name</td>
        <td width="20%" style="text-align:center;">Date</td>
        <td width="25%" style="text-align:right;">Deductions</td>
    </tr>
    <tr> 
        <td width="95%" style="font-size:1; border-bottom:1px solid black;"></td>
    </tr>
    <tr> 
        <td width="100%" style="font-size:4;"></td>
    </tr>
    <?php
    $transaction_lbl = '';
    $count = 0;
    $tot_amount = 0;
    $total_line = 0;
    $gtot_amount = 0;
    $gtot_adv_amt = 0;
    foreach ($results as $dtl_res) {
        if($count == 48){
            $count = 0; ?>
            <table>
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
            </table>
            <div style="page-break-before: always;">
            <table>
                <tr><td></td></tr>
                <tr>
                    <td width="100%" style="text-align:left; font-size:10; "><strong><?php echo $company; ?></strong></td>
                </tr>
                <tr>
                    <td width="100%" style="text-align:left; font-size:5;"><?php echo $address; ?></td>
                </tr>
                <tr>
                    <td width="100%" style="text-align:left; font-size:5;">Phone No: <?php echo $phone_no; ?> Fax No: <?php echo $fax_no;?></td>
                </tr>
                <tr>
                    <td width="100%" style="font-size:10;"></td>
                </tr>
                <tr>
                    <td width="100%" style="text-align:left;"><strong>MONTHLY DEDUCTION LISTING</strong></td>
                </tr>
                <tr>
                    <td width="100%" style="text-align:left;"><strong><?php echo $deduction; ?> for the month of <?php echo $month . " " . $year?></strong></td>
                </tr>
                <tr>
                    <td width="100%" style="font-size:10;"></td>
                </tr>
                <tr>
                    <td width="15%" style="text-align:center;">Employee ID</td>
                    <td width="35%" style="text-align:left;">Employee Name</td>
                    <td width="20%" style="text-align:center;">Date</td>
                    <td width="25%" style="text-align:right;">Deductions</td>
                </tr>
                <tr> 
                    <td width="95%" style="font-size:1; border-bottom:1px solid black;"></td>
                </tr>
                <tr> 
                    <td width="95%" style="font-size:4;"></td>
                </tr>
            </table>
            </div><?php 

        } ?>
        <tr>
            <td width="15%" style="text-align:center;"><?php echo $dtl_res['Id Number']; ?></td>
            <td width="35%" style="text-align:left;"><?php echo $dtl_res['Full Name']; ?></td>
            <td width="20%" style="text-align:center;"><?php echo $dtl_res['Payroll Date']; ?></td>
            <td width="25%" style="text-align:right;"><?php echo number_format($dtl_res['Amount'],2,'.',','); ?></td>
        </tr>
    <?php
        $tot_amount += $dtl_res['Amount'];
        $gtot_amount += $dtl_res['Amount'];
        $transaction_lbl = $dtl_res['Transaction Label'];
        $label = $dtl_res['Transaction Label'];
        $count++;
        $total_line++;
    } ?>

    <tr>
            <td width="70%"  style="text-align:Left;font-size:2;"></td>
            <td width="25%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
    </tr>
    <tr>
        <td width="20%"  style="text-align:left;"><strong>Total Employees: </strong></td>
        <td width="10%"  style="text-align:left;"></td>
        <td width="10%"  style="text-align:left;"><strong><?php echo $count; ?></strong></td>
        <td width="10%"  style="text-align:left;"></td>
        <td width="20%"  style="text-align:left;"><strong>Total Amortization: </strong></td>
        <td width="25%"  style="text-align:right;"><strong><?php echo number_format($tot_amount,2,".",","); ?></strong></td>
    </tr>
    <tr>
        <td width="70%"  style="text-align:right;font-size:2;"></td>
        <td width="25%"  style="text-align:right;font-size:2;border-bottom-width: 1px solid black ; "></td>
    </tr>
    <tr>
        <td width="70%"  style="text-align:right;font-size:2;"></td>
        <td width="25%"  style="text-align:right;font-size:2;border-bottom-width: 1px solid black ; "></td>
    </tr>
    <?php 
    if($total_line != 48)
    {
        for ($space=1; $space <= (48 - $count); $space++) 
        { ?>
            <tr><td></td></tr>
        <?php }   
    } ?>
</table>
<table>
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
</table>