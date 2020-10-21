<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, TRUE);
    }
?>
<?php
    //prep data
    
    $res = $result->row();
    $company = $res->{'Company'};
    $date_from = $res->{'Date From'};
    $date_to = $res->{'Date To'};
    $sensID = $this->config->config['user']['sensitivity'];
    $result = $result->result_array();
    $headers = array();
    $template = '';
    foreach( $result as $row )
    {
        $rowx = array(
            'Sensitivity' => $row['Sensitivity'],
            'Basic' => $row['Basic'],
            'AUT' => $row['Aut'],
            'OT' => $row['Ot'],
            'ND' => $row['Nd'],
            'Holiday' => $row['Holiday'],
            'Other Earning' => $row['Other Earning'],
            'SSS' => $row['Sss'],
            'PHIC' => $row['Phic'],
            'HDMF' => $row['Hdmf'],
            'Tax' => $row['Tax'],
            'Loan' => $row['Loan'],
            'Employee Ledger' => $row['Employee Ledger'],
            'Other Deduction' => $row['Other Deduction'],
            'Net Amount' => $row['Net Amount'],
            'Company' => $row['Company'],
            'Payroll Date' => $row['Payroll Date'],
            'Date From' => $row['Date From'],
            'Date To' => $row['Date To'],
            'Department Id' => $row['Department Id'],
            'Department' => $row['Department']
        );
            unset( $row['Sensitivity'] );
            unset( $row['Basic'] );
            unset( $row['Aut'] );
            unset( $row['Ot'] );
            unset( $row['Nd'] );
            unset( $row['Holiday'] );
            unset( $row['Other Earning'] );
            unset( $row['Sss'] );
            unset( $row['Phic'] );
            unset( $row['Hdmf'] );
            unset( $row['Tax'] );
            unset( $row['Loan'] );
            unset( $row['Employee Ledger'] );
            unset( $row['Other Deduction'] );
            unset( $row['Net Amount'] );
            unset( $row['Company'] );
            unset( $row['Payroll Date'] );
            unset( $row['Date From'] );
            unset( $row['Date To'] );
            unset( $row['Department Id'] );
            unset( $row['Department'] );
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
        //$rowx['Department'] = 0; //override sorting
        $dept[$rowx['Department']][$rowx['Department Id']][] = $rowx;         
    }

?>
<table>
    <tr>
        <td style=" width:100% ; text-align:center ; "><strong></strong></td>
    </tr>
    <tr>
        <td style=" width:100% ; text-align:center ; "><strong>Preliminary Per Cost Center</strong></td>
    </tr>
    <tr>
        <td style=" width:100% ; text-align:center ; "><strong><?php echo date("F d, Y",strtotime($date_from)).'  To '.date("F d, Y",strtotime($date_to)); ?></strong></td>
    </tr>
    <tr>
        <td style=" width:100% ; text-align:left ; "></td>
    </tr>
    <tr> 
        <td style=" width:15% ; text-align:left;"><strong>&nbsp;</strong></td>
        <td style=" width: 6% ; text-align:right;"><strong>Basic</strong></td>
        <td style=" width: 5% ; text-align:right;"><strong>AUT</strong></td>
        <td style=" width: 5% ; text-align:right;"><strong>OT</strong></td>
        <td style=" width: 4% ; text-align:right;"><strong>ND</strong></td>
        <td style=" width: 5% ; text-align:right;"><strong>Holiday</strong></td>
        <td style=" width: 6% ; text-align:right;"><strong>Other Earning</strong></td>
        <td style=" width: 6% ; text-align:right;"><strong>Gross</strong></td>
        <td style=" width: 5% ; text-align:right;"><strong>SSS</strong></td>
        <td style=" width: 5% ; text-align:right;"><strong>PHIC</strong></td>
        <td style=" width: 5% ; text-align:right;"><strong>HDMF</strong></td>
        <td style=" width: 5% ; text-align:right;"><strong>Tax</strong></td>
        <td style=" width: 6% ; text-align:right;"><strong>Loan</strong></td>
        <td style=" width: 5% ; text-align:right;"><strong>Employee Ledger</strong></td>
        <td style=" width: 5% ; text-align:right;"><strong>Other Deduction</strong></td>
        <td style=" width: 6% ; text-align:right;"><strong>Deduction</strong></td>
        <td style=" width: 6% ; text-align:right;"><strong>Net Amt</strong></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
    <?php 
    
    foreach( $dept as $department => $depts):
        foreach( $depts as $dept_id => $rows):            
            foreach( $rows as $values) :
                // if(strpos($sensID,$value{'Sensitivity'}) !== false){
                    $gross = 0;
                    $deduction = 0;
                    $gross = $values{'Basic'} + $values{'AUT'} + $values{'OT'} + $values{'ND'} + $values{'Holiday'} + $values{'Other Earning'} ;
                    $deduction = $values{'SSS'} + $values{'PHIC'} + $values{'HDMF'} + $values{'Tax'} + $values{'Loan'} + $values{'Employee Ledger'} + $values{'Other Deduction'} ;
                    ?>
                    <tr>
                        <td style=" width:15% ; text-align:left ;"><?php echo $values{'Department'}; ?></td>
                        <td style=" width: 6% ; text-align:right;"><?php echo number_format( $values{'Basic'} ,2,'.',','); ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $values{'AUT'} ,2,'.',','); ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $values{'OT'} ,2,'.',','); ?></td>
                        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $values{'ND'} ,2,'.',','); ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $values{'Holiday'} ,2,'.',','); ?></td>
                        <td style=" width: 6% ; text-align:right;"><?php echo number_format( $values{'Other Earning'} ,2,'.',','); ?></td>
                        <td style=" width: 6% ; text-align:right;"><?php echo number_format( $gross ,2,'.',','); ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $values{'SSS'} ,2,'.',','); ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $values{'PHIC'} ,2,'.',','); ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $values{'HDMF'} ,2,'.',','); ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $values{'Tax'} ,2,'.',','); ?></td>
                        <td style=" width: 6% ; text-align:right;"><?php echo number_format( $values{'Loan'} ,2,'.',','); ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $values{'Employee Ledger'} ,2,'.',','); ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $values{'Other Deduction'} ,2,'.',','); ?></td>
                        <td style=" width: 6% ; text-align:right;"><?php echo number_format( $deduction ,2,'.',','); ?></td>
                        <td style=" width: 6% ; text-align:right;"><?php echo number_format( $values{'Net Amount'} ,2,'.',','); ?></td>
                    </tr>
                    <?php
                // }
            endforeach; 
        endforeach;     
    endforeach; ?>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
    <tr>
        <td style=" width:20% ; text-align:left  ; ">Total : <?php echo $count; ?></td>
        <td style=" width: 7% ; text-align:right"><?php echo number_format(  $tBasic ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tCola ,2,'.',','); ?></td>
        <td style=" width: 7% ; text-align:right;"><?php echo number_format( $tOvertime ,2,'.',','); ?></td>
        <td style=" width: 6% ; text-align:right;"><?php echo number_format( $tOthIncTaxable ,2,'.',','); ?></td>
        <td style=" width: 6% ; text-align:right;"><?php echo number_format( $tOthIncNontax ,2,'.',','); ?></td>
        <td style=" width: 7% ; text-align:right;"><?php echo number_format( $tAbsences ,2,'.',','); ?></td>
        <td style=" width: 7% ; text-align:right;"><?php echo number_format( $tGrossPay ,2,'.',','); ?></td>
        <td style=" width: 6% ; text-align:right;"><?php echo number_format( $tWhtax ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tSSS ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tPHIC ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tHDMF ,2,'.',','); ?></td>
        <td style=" width: 7% ; text-align:right;"><?php echo number_format( $tOthDed ,2,'.',','); ?></td>
        <td style=" width: 7% ; text-align:right;"><?php echo number_format( $tNetpay ,2,'.',','); ?></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
    <tr><td></td></tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
    <tr>
        <td style=" width:20% ; text-align:left  ; ">Grand Total : <?php echo $total_count; ?></td>
        <td style=" width: 7% ; text-align:right"><?php echo number_format( $gtBasic ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtCola ,2,'.',','); ?></td>
        <td style=" width: 7% ; text-align:right;"><?php echo number_format( $gtOvertime ,2,'.',','); ?></td>
        <td style=" width: 6% ; text-align:right;"><?php echo number_format( $gtOthIncTaxable ,2,'.',','); ?></td>
        <td style=" width: 6% ; text-align:right;"><?php echo number_format( $gtOthIncNontax ,2,'.',','); ?></td>
        <td style=" width: 7% ; text-align:right;"><?php echo number_format( $gtAbsences ,2,'.',','); ?></td>
        <td style=" width: 7% ; text-align:right;"><?php echo number_format( $gtGrossPay ,2,'.',','); ?></td>
        <td style=" width: 6% ; text-align:right;"><?php echo number_format( $gtWhtax ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtSSS ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtPHIC ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtHDMF ,2,'.',','); ?></td>
        <td style=" width: 7% ; text-align:right;"><?php echo number_format( $gtOthDed ,2,'.',','); ?></td>
        <td style=" width: 7% ; text-align:right;"><?php echo number_format( $gtNetpay ,2,'.',','); ?></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
</table>
