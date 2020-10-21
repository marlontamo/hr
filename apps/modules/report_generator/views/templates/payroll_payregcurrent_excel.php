<?php
    //prep data
    $res = $result->row();
    $date_from = $res->{'Date From'};
    $date_to = $res->{'Date To'};
    $company = $res->{'Company'};
    $result = $result->result_array();
    $headers = array();
    $template = '';
    $allowed_per_page = 37; // includes row for spaces and department
    $result_cnt = count($result); 
    foreach( $result as $row )
    {
        $rowx = array(
            'Department ID' => $row['Department Id'],
            'Department' => $row['Department'],
            'Employee Code' => $row['Employee Code'],
            'Employee Name' => $row['Employee Name'],
            'Basic' => $row['Basic'],
            'Aut' => $row['Aut'],
            'Ot' => $row['Ot'],
            'Nd' => $row['Nd'],
            'Holiday' => $row['Holiday'],
            'Other Earnings' => $row['Other Earnings'],
            'Gross' => $row['Gross'],
            'Sss' => $row['Sss'],
            'Phic' => $row['Phic'],
            'Hdmf' => $row['Hdmf'],
            'Tax' => $row['Tax'],
            'Loan' => $row['Loan'],
            'Employee Ledger' => $row['Employee Ledger'],
            'Other Deduction' => $row['Other Deduction'],
            'Deduction' => $row['Deduction'],
            'Net Amount' => $row['Net Amount']
        );
            unset( $row['Department Id'] );
            unset( $row['Department'] );
            unset( $row['Employee Code'] );
            unset( $row['Employee Name'] );
            unset( $row['Basic'] );
            unset( $row['Aut'] );
            unset( $row['Ot'] );
            unset( $row['Nd'] );
            unset( $row['Holiday'] );
            unset( $row['Other Earnings'] );
            unset( $row['Gross'] );
            unset( $row['Sss'] );
            unset( $row['Phic'] );
            unset( $row['Hdmf'] );
            unset( $row['Tax'] );
            unset( $row['Loan'] );
            unset( $row['Employee Ledger'] );
            unset( $row['Other Deduction'] );
            unset( $row['Deduction'] );
            unset( $row['Net Amount'] );
        foreach( $row as $index => $value )
        {
            $a_index = str_replace(' ', '_', $index);
            $rowx[$a_index] = $value;
            if( floatval($value) != 0 && !isset($headers[$a_index]) )
            {
                $headers[$a_index] = $index;
                $template .= '<td style="text-align:right">{$'.$a_index.'}</td>';
            }

            if( floatval($value) == 0 )
            {
                $rowx[$a_index] = '-';
            }
        }

        $com[$rowx['Department']][$rowx['Employee Code']][] = $rowx;  
    } ?>
    <table>
<?php
    $tBasic             = 0;
    $tAut               = 0;
    $tOt                = 0;
    $tNd                = 0;
    $tHoliday           = 0;
    $tOtherEarnings     = 0;
    $tGross             = 0;
    $tSSS               = 0;
    $tPHIC              = 0;
    $tHDMF              = 0;
    $tTax               = 0;
    $tLoan              = 0;
    $tEmployeeLedger    = 0;
    $tOtherDeduction    = 0;
    $tDeduction         = 0;
    $tNetAmount         = 0;
    $gtBasic            = 0;
    $gtAut              = 0;
    $gtOt               = 0;
    $gtNd               = 0;
    $gtHoliday          = 0;
    $gtOtherEarnings    = 0;
    $gtGross            = 0;
    $gtSSS              = 0;
    $gtPHIC             = 0;
    $gtHDMF             = 0;
    $gtTax              = 0;
    $gtLoan             = 0;
    $gtEmployeeLedger   = 0;
    $gtOtherDeduction   = 0;
    $gtDeduction        = 0;
    $gtNetAmount        = 0;

    $count              = 0;
    $total_count        = 0;
    $department         = '';
    $cnt = 0; ?>

    <tr>
        <td colspan="18" align="center" style=" width:100% ; text-align:center ; "><strong><?php echo $company; ?></strong></td>
    </tr>
    <tr>
        <td colspan="18" align="center" style=" width:100% ; text-align:center ; "><strong>PAYROLL REGISTER (Preliminary)</strong></td>
    </tr>
    <tr>
        <td colspan="18" align="center" style=" width:100% ; text-align:center ; "><strong>PAYROLL PERIOD : <?php echo date("m/d/Y",strtotime($date_from)).'  - '.date("m/d/Y",strtotime($date_to)); ?></strong></td>
    </tr>
    <tr>
        <td style=" width:100% ; text-align:left ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>

    <tr style="background-color:grey;"> 
        <td style=" width: 5% ; text-align:left;"><strong>Employee Code</strong></td>
        <td style=" width: 14% ; text-align:left;"><strong>Employee Name</strong></td>
        <td style=" width: 5% ; text-align:right;"><strong>BASIC</strong></td>
        <td style=" width: 5% ; text-align:right;"><strong>AUT</strong></td>
        <td style=" width: 5% ; text-align:right;"><strong>OT</strong></td>
        <td style=" width: 4% ; text-align:right;"><strong>ND</strong></td>
        <td style=" width: 5% ; text-align:right;"><strong>Holiday</strong></td>
        <td style=" width: 5% ; text-align:right;"><strong>Other Earning</strong></td>
        <td style=" width: 5% ; text-align:right;"><strong>Gross</strong></td>
        <td style=" width: 4.5% ; text-align:right;"><strong>SSS</strong></td>
        <td style=" width: 4.5% ; text-align:right;"><strong>PHIC</strong></td>
        <td style=" width: 4% ; text-align:right;"><strong>HDMF</strong></td>
        <td style=" width: 5% ; text-align:right;"><strong>Tax</strong></td>
        <td style=" width: 5% ; text-align:right;"><strong>Loan</strong></td>
        <td style=" width: 6% ; text-align:right;"><strong>Employee Ledger</strong></td>
        <td style=" width: 6% ; text-align:right;"><strong>Other Deduction</strong></td>
        <td style=" width: 6% ; text-align:right;"><strong>Deduction</strong></td>
        <td style=" width: 6% ; text-align:right;"><strong>Net Amt</strong></td>
    </tr>
<?php foreach( $com as $comp => $emp):
        foreach( $emp as $idno => $rows): 
            foreach( $rows as $value) :
                    if($department == '') { $cnt++; // add count for department name row
    ?> 
                    <tr><td colspan="18" style=" width:100% ;"><b><?php echo $value{'Department'}; ?></b></td></tr>
    <?php             
            }  else {
                if($department != $value{'Department'} ) {  $cnt++;// add count for sub total row?>
                   <tr style="background-color:lightgray;">
                        <td style=" width: 5% ; text-align:left  ; "></td>
                        <td style=" width: 14% ; text-align:left  ; "><strong>Sub Total : </strong></td>
                        <td style=" width: 5% ; text-align:right"><?php echo  $tBasic; ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo $tAut; ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo $tOt; ?></td>
                        <td style=" width: 4% ; text-align:right;"><?php echo $tNd; ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo $tHoliday; ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo $tOtherEarnings; ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo $tGross; ?></td>
                        <td style=" width: 4.5% ; text-align:right;"><?php echo $tSSS; ?></td>
                        <td style=" width: 4.5% ; text-align:right;"><?php echo $tPHIC; ?></td>
                        <td style=" width: 4% ; text-align:right;"><?php echo $tHDMF; ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo $tTax; ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo $tLoan; ?></td>
                        <td style=" width: 6% ; text-align:right;"><?php echo $tEmployeeLedger; ?></td>
                        <td style=" width: 6% ; text-align:right;"><?php echo $tOtherDeduction; ?></td>
                        <td style=" width: 6% ; text-align:right;"><?php echo $tDeduction; ?></td>
                        <td style=" width: 6% ; text-align:right;"><?php echo $tNetAmount; ?></td>
                    </tr>
                <?php 
                    $tBasic             = 0;
                    $tAut               = 0;
                    $tOt                = 0;
                    $tNd                = 0;
                    $tHoliday           = 0;
                    $tOtherEarnings     = 0;
                    $tGross             = 0;
                    $tSSS               = 0;
                    $tPHIC              = 0;
                    $tHDMF              = 0;
                    $tTax               = 0;
                    $tLoan              = 0;
                    $tEmployeeLedger    = 0;
                    $tOtherDeduction    = 0;
                    $tDeduction         = 0;
                    $tNetAmount         = 0;
                    $cnt++; // for space
                ?>
                <tr>
                    <td style=" width:100% ;"></td>
                </tr>
                <tr><td colspan="18" style=" width:100% ;"><b><?php echo $value{'Department'}; ?></b></td></tr>
    <?php        $cnt++; // add count for department name row
                }
            } ?>   
            <tr>
                <td style=" width: 5% ; text-align:left "><?php echo $value{'Employee Code'}; ?></td>
                <td style=" width: 14% ; text-align:left"><?php echo $value{'Employee Name'}; ?></td>
                <td style=" width: 5% ; text-align:right"><?php echo value{'Basic'; ?></td>
                <td style=" width: 5% ; text-align:right;"><?php echo value{'Aut'; ?></td>
                <td style=" width: 5% ; text-align:right;"><?php echo value{'Ot'; ?></td>
                <td style=" width: 4% ; text-align:right;"><?php echo value{'Nd'; ?></td>
                <td style=" width: 5% ; text-align:right;"><?php echo value{'Holiday'; ?></td>
                <td style=" width: 5% ; text-align:right;"><?php echo value{'Other Earnings'; ?></td>
                <td style=" width: 5% ; text-align:right;"><?php echo value{'Gross'; ?></td>
                <td style=" width: 4.5% ; text-align:right;"><?php echo value{'Sss'; ?></td>
                <td style=" width: 4.5% ; text-align:right;"><?php echo value{'Phic'; ?></td>
                <td style=" width: 4% ; text-align:right;"><?php echo value{'Hdmf'; ?></td>
                <td style=" width: 5% ; text-align:right;"><?php echo value{'Tax'; ?></td>
                <td style=" width: 5% ; text-align:right;"><?php echo value{'Loan'; ?></td>
                <td style=" width: 6% ; text-align:right;"><?php echo value{'Employee Ledger'; ?></td>
                <td style=" width: 6% ; text-align:right;"><?php echo value{'Other Deduction'; ?></td>
                <td style=" width: 6% ; text-align:right;"><?php echo value{'Deduction'; ?></td>
                <td style=" width: 6% ; text-align:right;"><?php echo value{'Net Amount'; ?></td>
            </tr>
        <?php   
            $tBasic             += $value{'Basic'};
            $tAut               += $value{'Aut'};
            $tOt                += $value{'Ot'};
            $tNd                += $value{'Nd'};
            $tHoliday           += $value{'Holiday'};
            $tOtherEarnings     += $value{'Other Earnings'};
            $tGross             += $value{'Gross'};
            $tSSS               += $value{'Sss'};
            $tPHIC              += $value{'Phic'};
            $tHDMF              += $value{'Hdmf'};
            $tTax               += $value{'Tax'};
            $tLoan              += $value{'Loan'};
            $tEmployeeLedger    += $value{'Employee Ledger'};
            $tOtherDeduction    += $value{'Other Deduction'};
            $tDeduction         += $value{'Deduction'};
            $tNetAmount         += $value{'Net Amount'};                

            $gtBasic         += $value{'Basic'};
            $gtAut           += $value{'Aut'};
            $gtOt            += $value{'Ot'};
            $gtNd            += $value{'Nd'};
            $gtHoliday       += $value{'Holiday'};
            $gtOtherEarnings += $value{'Other Earnings'};
            $gtGross         += $value{'Gross'};
            $gtSSS           += $value{'Sss'};
            $gtPHIC          += $value{'Phic'};
            $gtHDMF          += $value{'Hdmf'};
            $gtTax           += $value{'Tax'};
            $gtLoan          += $value{'Loan'};
            $gtEmployeeLedger+= $value{'Employee Ledger'};
            $gtOtherDeduction+= $value{'Other Deduction'};
            $gtDeduction     += $value{'Deduction'};
            $gtNetAmount     += $value{'Net Amount'};

            $count++;
            $total_count++;
            $department = $value{'Department'};
                
            endforeach; 
        endforeach;     
    endforeach; ?>
    <?php $cnt++; // add count for sub total row?>
    <tr style="background-color: lightgrey;">
        <td style=" width: 5% ; text-align:left  ; "></td>
        <td style=" width: 14% ; text-align:left  ; "><strong>Sub Total : </strong></td>
        <td style=" width: 5% ; text-align:right"><?php echo  $tBasic; ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo $tAut; ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo $tOt; ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo $tNd; ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo $tHoliday; ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo $tOtherEarnings; ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo $tGross; ?></td>
        <td style=" width: 4.5% ; text-align:right;"><?php echo $tSSS; ?></td>
        <td style=" width: 4.5% ; text-align:right;"><?php echo $tPHIC; ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo $tHDMF; ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo $tTax; ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo $tLoan; ?></td>
        <td style=" width: 6% ; text-align:right;"><?php echo $tEmployeeLedger; ?></td>
        <td style=" width: 6% ; text-align:right;"><?php echo $tOtherDeduction; ?></td>
        <td style=" width: 6% ; text-align:right;"><?php echo $tDeduction; ?></td>
        <td style=" width: 6% ; text-align:right;"><?php echo $tNetAmount; ?></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <tr style="background-color: gray;">
        <td colspan="2" style=" width: 19% ; text-align:left  ; ">Grand Total : (<?php echo $total_count; ?>)</td>
        <td style=" width: 5% ; text-align:right"><?php echo $gtBasic; ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo $gtAut; ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo $gtOt; ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo $gtNd; ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo $gtHoliday; ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo $gtOtherEarnings; ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo $gtGross; ?></td>
        <td style=" width: 4.5% ; text-align:right;"><?php echo $gtSSS; ?></td>
        <td style=" width: 4.5% ; text-align:right;"><?php echo $gtPHIC; ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo $gtHDMF; ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo $gtTax; ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo $gtLoan; ?></td>
        <td style=" width: 6% ; text-align:right;"><?php echo $gtEmployeeLedger; ?></td>
        <td style=" width: 6% ; text-align:right;"><?php echo $gtOtherDeduction; ?></td>
        <td style=" width: 6% ; text-align:right;"><?php echo $gtDeduction; ?></td>
        <td style=" width: 6% ; text-align:right;"><?php echo $gtNetAmount; ?></td>
    </tr>
</table>

