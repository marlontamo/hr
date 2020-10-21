<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, false);
    }
    //prep data
    $res = $result->row();
    $company = $res->{'Company'};
    $period = $res->{'Date From'}.' to '.$res->{'Date To'};

    $results = $result->result_array();
    $total_debit = 0;
    $total_credit = 0;
    $cnt = 0;
    foreach($results as $dtl_res): ?>
            <?php
            if($cnt == 0){?>  
            <div>&nbsp;</div>
            <table>
                <!-- tr>
                    <td colspan="6" width="100%" style="text-align:left; font-size:10; "><strong>< ?php echo $company; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="6" width="100%" style="text-align:left; font-size:10; "><strong>Journal Voucher</strong></td>
                </tr>
                <tr>
                    <td colspan="6" width="100%" style="text-align:left; font-size:8; ">For the Payroll Period <?php echo $period; ?></td>
                </tr>
                <tr>
                    <td width:"100%" style="font-size:10;"></td>
                </tr -->
                <tr>
                    <td>Branch</td>
                    <td>Account</td>
                    <td>Description</td>
                    <td>Subaccount</td>
                    <td>Project</td>
                    <td>Project Task</td>
                    <td>Ref. Number</td>
                    <td>Quantity</td>
                    <td>UOM</td>

                    <td>Debit Amount</td>
                    <td>Credit Amount</td>

                    <td>Transaction Description</td>
                    <td>Non Billable</td>
                </tr>
                <!-- tr> 
                    <td width="100%" style="font-size:6;">&nbsp;</td>
                </tr -->
                <?php
            }
            ?>
                <tr>
                    <td><?php echo $dtl_res['Branch']; ?></td>
                    <td><?php echo $dtl_res['Account']; ?></td>
                    <td><?php echo $dtl_res['Description']; ?></td>
                    <td><?php echo $dtl_res['Sub Account']; ?></td>
                    <td><?php echo $dtl_res['Project']; ?></td>
                    <td><?php echo $dtl_res['Project Task']; ?></td>
                    <td><?php echo $dtl_res['Ref Number']; ?></td>
                    <td><?php echo $dtl_res['Quantity']; ?></td>
                    <td><?php echo $dtl_res['UOM']; ?></td>

                    <td><?php echo $dtl_res{'Debit Amount'} != 0 ?  $dtl_res{'Debit Amount'} : ''; ?></td>
                    <td><?php echo $dtl_res{'Credit Amount'} != 0 ?  $dtl_res{'Credit Amount'} : ''; ?></td>

                    <td><?php echo $dtl_res['Transaction Description']; ?></td>
                    <td><?php echo $dtl_res['Non Billable']; ?></td>
                </tr>
                
        <?php
        $total_debit += $dtl_res{'Debit Amount'};
        $total_credit += $dtl_res{'Credit Amount'};
        $cnt++;
    endforeach; ?>
</table>
<!-- table>
    <tr>
        <td colspan="9" width="70%" style="text-align:left;">&nbsp;</td>
        <td width="15%" style="text-align:right;font-size:9;">< ?php echo $total_debit; ?></td>
        <td width="15%" style="text-align:right;font-size:9;">< ?php echo $total_credit; ?></td>
    </tr>
    <tr>
        <td width="72%" style="text-align:left; font-size:2;"></td>
        <td width="13%" style="text-align:right; border-top-width: 1px solid black; font-size:2; "></td>
        <td width="2%" style="text-align:left; font-size:2;"></td>
        <td width="13%" style="text-align:right; border-top-width: 1px solid black; font-size:2; "></td>
    </tr>
    <tr>
        <td width="72%" style="text-align:left; font-size:2;"></td>
        <td width="13%" style="text-align:right; border-top-width: 1px solid black; font-size:2; "></td>
        <td width="2%" style="text-align:left; font-size:2;"></td>
        <td width="13%" style="text-align:right; border-top-width: 1px solid black; font-size:2; "></td>
    </tr>
</table -->