<?php
    //prep data
    $res = $result->row();
    $company = $res->{'Company'};
    $address = $res->{'Address'};
    $payroll_date = $res->{'Payroll Date'};
    $date_from = $res->{'Date From'};
    $date_to = $res->{'Date To'};

    $schedule = '';
    if (isset($filter)){
        $schedule = end($filter);
    }  

    $result = $result->result_array();
?>

<table width="100%">
    <tr>
        <td width="100%" style="text-align:center; font-size:10; "><strong><?php echo $company; ?></strong></td>
    </tr>
    <tr>
        <td width="100%" style="text-align:center;"><strong><?php echo $address; ?></strong></td>
    </tr>
    <tr>
        <td width="100%" style="text-align:center; font-size:10; "><strong>NON ATM Register Report</strong></td>
    </tr>
    <tr>
        <td width="100%" style="font-size:10px;"></td>
    </tr>
    <tr>
        <td width="9%" style="text-align:center;"></td>
        <td width="5%" style="text-align:left;">No.</td>
        <td width="20%" style="text-align:center;">Account #</td>
        <td width="20%" style="text-align:right;">Amount</td>
        <td width="1%" style="text-align:left;">&nbsp;</td>
        <td width="35%" style="text-align:left;">Employee Name</td>
        <td width="10%" style="text-align:center;"></td>
    </tr>
    <tr> 
        <td width="  9%" style="font-size:1; "></td>
        <td width=" 81%" style="font-size:1; border-bottom:1px solid black;"></td>
        <td width=" 10%" style="font-size:1; "></td>
    </tr>
    <tr> 
        <td width="100%" style="font-size:4;"></td>
    </tr>
</table>
<table>
    <?php 
    $cnt_line = 1;
    $tot_amount = 0;
    $gtot_amount = 0;
    $count = 0;
    $emp_count = 0;
    foreach( $result as $row ): 
        if ($schedule != '' && $schedule == 1){
            if ($row['Payout Scheme'] == 1 || ($row['Payout Scheme'] == 0 && $row['Payout Schedule'] == 0 )){           
                if($count == 50){
                    ?>
                    </table>
                    <table>
                        <tr> 
                            <td width="100%" style="font-size:4;"></td>
                        </tr>
                        <tr> 
                            <td width="  9%" style="font-size:1; "></td>
                            <td width=" 81%" style="font-size:1; border-bottom:1px solid black;"></td>
                            <td width=" 10%" style="font-size:1; "></td>
                        </tr>
                        <tr> 
                            <td width="  9%" style="font-size:1; "></td>
                            <td width=" 81%" style="font-size:1; border-bottom:1px solid black;"></td>
                            <td width=" 10%" style="font-size:1; "></td>
                        </tr>
                        <tr>
                            <td width="  9%"></td>
                            <td width=" 25%"  style="text-align:Left;"><strong>Total for this page : <?php echo $count; ?></strong></td>
                            <td width=" 20%"  style="text-align:right;"><strong><?php echo number_format($tot_amount,2,".",","); ?></strong></td>
                            <td width=" 46%"></td>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <td width="100%" style="text-align:center; font-size:130; ">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="100%" style="text-align:center; font-size:10; "><strong><?php echo $company; ?></strong></td>
                        </tr>
                        <tr>
                            <td width="100%" style="text-align:center;"><strong><?php echo $address; ?></strong></td>
                        </tr>
                        <tr>
                            <td width="100%" style="text-align:center; font-size:10; "><strong>NON ATM Register Report</strong></td>
                        </tr>
                        <tr>
                            <td width="100%" style="font-size:10px;"></td>
                        </tr>
                        <tr>
                            <td width="9%" style="text-align:center;"></td>
                            <td width="5%" style="text-align:left;">No.</td>
                            <td width="20%" style="text-align:center;">Account #</td>
                            <td width="20%" style="text-align:right;">Amount</td>
                            <td width="1%" style="text-align:left;">&nbsp;</td>
                            <td width="35%" style="text-align:left;">Employee Name</td>
                            <td width="10%" style="text-align:center;"></td>
                        </tr>
                        <tr> 
                            <td width="  9%" style="font-size:1; "></td>
                            <td width=" 81%" style="font-size:1; border-bottom:1px solid black;"></td>
                            <td width=" 10%" style="font-size:1; "></td>
                        </tr>
                        <tr> 
                            <td width="100%" style="font-size:4;"></td>
                        </tr>
                    </table>
                    <table><?php
                    $count = 0;
                    $tot_amount = 0;
                }

                ?>

                <tr>
                    <td width=" 9%"  style="text-align:left;  ">&nbsp;</td>
                    <td width=" 5%"  style="text-align:Left;  "><?php echo $cnt_line; ?>.</td>
                    <td width="20%"  style="text-align:Left;  "><?php echo $row['Bank Account']; ?></td>
                    <td width="20%"  style="text-align:right; "><?php echo number_format( $row['Amount'],2,".",","); ?></td>
                    <td width=" 1%"  style="text-align:Left;  ">&nbsp;</td>
                    <td width="35%"  style="text-align:left;  "><?php echo $row['Full Name']; ?></td>
                    <td width="10%"  style="text-align:left;  ">&nbsp;</td>
                </tr><?php
                $tot_amount += $row['Amount'];
                $gtot_amount += $row['Amount'];
                $count++;
                $emp_count++;
                $cnt_line++;
            }
        }
        elseif ($schedule != '' && $schedule == 2){
            if ($row['Payout Scheme'] == 1 || ($row['Payout Scheme'] == 0 && $row['Payout Schedule'] == 1 )){  
                if($count == 50){
                    ?>
                    </table>
                    <table>
                        <tr> 
                            <td width="100%" style="font-size:4;"></td>
                        </tr>
                        <tr> 
                            <td width="  9%" style="font-size:1; "></td>
                            <td width=" 81%" style="font-size:1; border-bottom:1px solid black;"></td>
                            <td width=" 10%" style="font-size:1; "></td>
                        </tr>
                        <tr> 
                            <td width="  9%" style="font-size:1; "></td>
                            <td width=" 81%" style="font-size:1; border-bottom:1px solid black;"></td>
                            <td width=" 10%" style="font-size:1; "></td>
                        </tr>
                        <tr>
                            <td width="  9%"></td>
                            <td width=" 25%"  style="text-align:Left;"><strong>Total for this page : <?php echo $count; ?></strong></td>
                            <td width=" 20%"  style="text-align:right;"><strong><?php echo number_format($tot_amount,2,".",","); ?></strong></td>
                            <td width=" 46%"></td>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <td width="100%" style="text-align:center; font-size:130; ">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="100%" style="text-align:center; font-size:10; "><strong><?php echo $company; ?></strong></td>
                        </tr>
                        <tr>
                            <td width="100%" style="text-align:center;"><strong><?php echo $address; ?></strong></td>
                        </tr>
                        <tr>
                            <td width="100%" style="text-align:center; font-size:10; "><strong>NON ATM Register Report</strong></td>
                        </tr>
                        <tr>
                            <td width="100%" style="font-size:10px;"></td>
                        </tr>
                        <tr>
                            <td width="9%" style="text-align:center;"></td>
                            <td width="5%" style="text-align:left;">No.</td>
                            <td width="20%" style="text-align:center;">Account #</td>
                            <td width="20%" style="text-align:right;">Amount</td>
                            <td width="1%" style="text-align:left;">&nbsp;</td>
                            <td width="35%" style="text-align:left;">Employee Name</td>
                            <td width="10%" style="text-align:center;"></td>
                        </tr>
                        <tr> 
                            <td width="  9%" style="font-size:1; "></td>
                            <td width=" 81%" style="font-size:1; border-bottom:1px solid black;"></td>
                            <td width=" 10%" style="font-size:1; "></td>
                        </tr>
                        <tr> 
                            <td width="100%" style="font-size:4;"></td>
                        </tr>
                    </table>
                    <table><?php
                    $count = 0;
                    $tot_amount = 0;
                }

                ?>

                <tr>
                    <td width=" 9%"  style="text-align:left;  ">&nbsp;</td>
                    <td width=" 5%"  style="text-align:Left;  "><?php echo $cnt_line; ?>.</td>
                    <td width="20%"  style="text-align:Left;  "><?php echo $row['Bank Account']; ?></td>
                    <td width="20%"  style="text-align:right; "><?php echo number_format( $row['Amount'],2,".",","); ?></td>
                    <td width=" 1%"  style="text-align:Left;  ">&nbsp;</td>
                    <td width="35%"  style="text-align:left;  "><?php echo $row['Full Name']; ?></td>
                    <td width="10%"  style="text-align:left;  ">&nbsp;</td>
                </tr><?php
                $tot_amount += $row['Amount'];
                $gtot_amount += $row['Amount'];
                $count++;
                $emp_count++;                
            }
        }
        else{
            if($count == 50){
                ?>
                </table>
                <table>
                    <tr> 
                        <td width="100%" style="font-size:4;"></td>
                    </tr>
                    <tr> 
                        <td width="  9%" style="font-size:1; "></td>
                        <td width=" 81%" style="font-size:1; border-bottom:1px solid black;"></td>
                        <td width=" 10%" style="font-size:1; "></td>
                    </tr>
                    <tr> 
                        <td width="  9%" style="font-size:1; "></td>
                        <td width=" 81%" style="font-size:1; border-bottom:1px solid black;"></td>
                        <td width=" 10%" style="font-size:1; "></td>
                    </tr>
                    <tr>
                        <td width="  9%"></td>
                        <td width=" 25%"  style="text-align:Left;"><strong>Total for this page : <?php echo $count; ?></strong></td>
                        <td width=" 20%"  style="text-align:right;"><strong><?php echo number_format($tot_amount,2,".",","); ?></strong></td>
                        <td width=" 46%"></td>
                    </tr>
                </table>
                <table width="100%">
                    <tr>
                        <td width="100%" style="text-align:center; font-size:130; ">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="100%" style="text-align:center; font-size:10; "><strong><?php echo $company; ?></strong></td>
                    </tr>
                    <tr>
                        <td width="100%" style="text-align:center;"><strong><?php echo $address; ?></strong></td>
                    </tr>
                    <tr>
                        <td width="100%" style="text-align:center; font-size:10; "><strong>NON ATM Register Report</strong></td>
                    </tr>
                    <tr>
                        <td width="100%" style="font-size:10px;"></td>
                    </tr>
                    <tr>
                        <td width="9%" style="text-align:center;"></td>
                        <td width="5%" style="text-align:left;">No.</td>
                        <td width="20%" style="text-align:center;">Account #</td>
                        <td width="20%" style="text-align:right;">Amount</td>
                        <td width="1%" style="text-align:left;">&nbsp;</td>
                        <td width="35%" style="text-align:left;">Employee Name</td>
                        <td width="10%" style="text-align:center;"></td>
                    </tr>
                    <tr> 
                        <td width="  9%" style="font-size:1; "></td>
                        <td width=" 81%" style="font-size:1; border-bottom:1px solid black;"></td>
                        <td width=" 10%" style="font-size:1; "></td>
                    </tr>
                    <tr> 
                        <td width="100%" style="font-size:4;"></td>
                    </tr>
                </table>
                <table><?php
                $count = 0;
                $tot_amount = 0;
            }

            ?>

            <tr>
                <td width=" 9%"  style="text-align:left;  ">&nbsp;</td>
                <td width=" 5%"  style="text-align:Left;  "><?php echo $cnt_line; ?>.</td>
                <td width="20%"  style="text-align:Left;  "><?php echo $row['Bank Account']; ?></td>
                <td width="20%"  style="text-align:right; "><?php echo number_format( $row['Amount'],2,".",","); ?></td>
                <td width=" 1%"  style="text-align:Left;  ">&nbsp;</td>
                <td width="35%"  style="text-align:left;  "><?php echo $row['Full Name']; ?></td>
                <td width="10%"  style="text-align:left;  ">&nbsp;</td>
            </tr><?php
            $tot_amount += $row['Amount'];
            $gtot_amount += $row['Amount'];
            $count++;
            $emp_count++;
        }        
    endforeach;
    if($count != 50 )
        {
            for ($space=1; $space <= (50 - $count); $space++) 
            { ?>
                <tr><td></td></tr>
            <?php }   
        }
    ?>
</table>
<table>
    <tr> 
        <td width="100%" style="font-size:4;"></td>
    </tr>
    <tr> 
        <td width="  9%" style="font-size:1; "></td>
        <td width=" 81%" style="font-size:1; border-bottom:1px solid black;"></td>
        <td width=" 10%" style="font-size:1; "></td>
    </tr>
    <tr> 
        <td width="  9%" style="font-size:1; "></td>
        <td width=" 81%" style="font-size:1; border-bottom:1px solid black;"></td>
        <td width=" 10%" style="font-size:1; "></td>
    </tr>
    <tr>
        <td width="  9%"></td>
        <td width=" 25%"  style="text-align:Left;"><strong>Total for this page : <?php echo $count; ?></strong></td>
        <td width=" 20%"  style="text-align:right;"><strong><?php echo number_format($tot_amount,2,".",","); ?></strong></td>
        <td width=" 46%"></td>
    </tr>
    <tr>
        <td width="  9%"></td>
        <td width=" 25%"  style="text-align:left;"><strong>Grand Total :  <?php echo $emp_count; ?></strong></td>
        <td width=" 20%"  style="text-align:right;"><strong><?php echo number_format($gtot_amount,2,".",","); ?></strong></td>
        <td width=" 46%"></td>
    </tr>
</table>

<table width="100%">
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
        <td style="text-align:left; border-top-width: 1px solid black ; "></td>
        <td style="text-align:right;"></td>
        <td style="text-align:left; border-top-width: 1px solid black ; "></td>
        <td style="text-align:right;"></td>
        <td style="text-align:left; border-top-width: 1px solid black ; "></td>
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

