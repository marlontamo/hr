<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, TRUE);
    }
    $branch = '';
    if (isset($filter)){
        $new_arr = array();
        foreach ($filter as $key => $value) {
            $new_arr[] = $value;
        }
        $branch_id = $new_arr[2];
        $branch_result = $this->db->get_where('users_branch',array('branch_id' => $branch_id));
        if ($branch_result && $branch_result->num_rows() > 0){
            $row_branch = $branch_result->row();
            $branch = $row_branch->branch;
        }
    }          
?>
<?php
    //prep data
    $res = $result->row();
    $company = $res->{'Company'};
    $date_from = $res->{'Date From'};
    $date_to = $res->{'Date To'};

    $result = $result->result_array();
    $headers = array();
    $template = '';
    foreach( $result as $row )
    {
        $rowx = array(
            'Id Number' => $row['Id Number'],
            'Full Name' => $row['Full Name'],
            'Basic' => $row['Basic'],
            'Cola' => $row['Cola'],
            'Nd' => $row['Nd'],
            'Overtime' => $row['Overtime'],
            'Oth Inc Taxable' => $row['Oth Inc Taxable'],
            'Oth Inc Nontax' => $row['Oth Inc Nontax'],
            'Absences' => $row['Absences'],
            'Gross Pay' => $row['Gross Pay'],
            'Whtax' => $row['Whtax'],
            'Sss' => $row['Sss'],
            'Phic' => $row['Phic'],
            'Hdmf' => $row['Hdmf'],
            'Oth Ded' => $row['Oth Ded'],
            'Netpay' => $row['Netpay'],
            'Company' => $row['Company'],
            'Payroll Date' => $row['Payroll Date'],
            'Date From' => $row['Date From'],
            'Date To' => $row['Date To'],
            'Department Id' => $row['Department Id'],
            'Department' => $row['Department'],
            'Nd' => $row['Nd'],
            'Ssser' => $row['Ssser'],
            'Phicer' => $row['Phicer'],
            'Hdmfer' => $row['Hdmfer'],
            'Hdmf Add' => $row['Hdmf Add'],
            'Sss Loan' => $row['Sss Loan'],
            'Hdmf Loan' => $row['Hdmf Loan']
            
        );
            unset( $row['Id Number'] );
            unset( $row['Full Name'] );
            unset( $row['Basic'] );
            unset( $row['Cola'] );
            unset( $row['Nd'] );
            unset( $row['Overtime'] );
            unset( $row['Oth Inc Taxable'] );
            unset( $row['Oth Inc Nontax'] );
            unset( $row['Absences'] );
            unset( $row['Gross Pay'] );
            unset( $row['Whtax'] );
            unset( $row['Sss'] );
            unset( $row['Phic'] );
            unset( $row['Hdmf'] );
            unset( $row['Hdmf Add'] );
            unset( $row['Oth Ded'] );
            unset( $row['Netpay'] );
            unset( $row['Company'] );
            unset( $row['Payroll Date'] );
            unset( $row['Date From'] );
            unset( $row['Date To'] );
            unset( $row['Department Id'] );
            unset( $row['Department'] );
            unset( $row['Nd'] );
            unset( $row['Ssser'] );
            unset( $row['Phicer'] );
            unset( $row['Hdmfer'] );
            unset( $row['Sss Loan'] );
            unset( $row['Hdmf Loan'] );

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
        $com[$rowx['Department']][$rowx['Id Number']][] = $rowx;         
    }
?>
<table>
    <?php 
    $gtBasic         = 0;
    $gtCola          = 0;
    $gtND            = 0;
    $gtOvertime      = 0;
    $gtOthIncTaxable = 0;
    $gtOthIncNontax  = 0;
    $gtAbsences      = 0;
    $gtGrossPay      = 0;
    $gtWhtax         = 0;
    $gtSSS           = 0;
    $gtSSSER         = 0;
    $gtPHIC          = 0;
    $gtPHICER        = 0;
    $gtHDMF          = 0;
    $gtHDMFADD       = 0;
    $gtHDMFER        = 0;
    $gtSSSLN         = 0;
    $gtHDMFLN        = 0;
    $gtOthDed        = 0;
    $gtNetpay        = 0;

    $tBasic         = 0;
    $tCola          = 0;
    $tND            = 0;
    $tOvertime      = 0;
    $tOthIncTaxable = 0;
    $tOthIncNontax  = 0;
    $tAbsences      = 0;
    $tGrossPay      = 0;
    $tWhtax         = 0;
    $tSSS           = 0;
    $tSSSER         = 0;
    $tPHIC          = 0;
    $tPHICER        = 0;
    $tHDMF          = 0;
    $tHDMFADD       = 0;
    $tHDMFER        = 0;
    $tSSSLN         = 0;
    $tHDMFLN        = 0;
    $tOthDed        = 0;
    $tNetpay        = 0;
    $count          = 0;
    $total_count    = 0;
    $row_count      = 0;
    $array_department = array();
    foreach( $com as $comp => $emp):
        $gtdBasic         = 0;
        $gtdCola          = 0;
        $gtdND            = 0;
        $gtdOvertime      = 0;
        $gtdOthIncTaxable = 0;
        $gtdOthIncNontax  = 0;
        $gtdAbsences      = 0;
        $gtdGrossPay      = 0;
        $gtdWhtax         = 0;
        $gtdSSS           = 0;
        $gtdSSSER         = 0;
        $gtdPHIC          = 0;
        $gtdPHICER        = 0;
        $gtdHDMF          = 0;
        $gtdHDMFADD       = 0;
        $gtdHDMFER        = 0;
        $gtdSSSLN         = 0;
        $gtdHDMFLN        = 0;
        $gtdOthDed        = 0;
        $gtdNetpay        = 0;      
        $count_perd       = 0;
        foreach( $emp as $idno => $rows):            
            foreach( $rows as $value) :
                if($row_count > 19){?>
                    </table>
                    <div style="page-break-before: always;">&nbsp;</div>
                    <table>
                    <?php
                    $tBasic         = 0;
                    $tCola          = 0;
                    $tND            = 0;
                    $tOvertime      = 0;
                    $tOthIncTaxable = 0;
                    $tOthIncNontax  = 0;
                    $tAbsences      = 0;
                    $tGrossPay      = 0;
                    $tWhtax         = 0;
                    $tSSS           = 0;
                    $tSSSER         = 0;
                    $tPHIC          = 0;
                    $tPHICER        = 0;
                    $tHDMF          = 0;
                    $tHDMFADD       = 0;
                    $tHDMFER        = 0;
                    $tSSSLN         = 0;
                    $tHDMFLN        = 0;
                    $tOthDed        = 0;
                    $tNetpay        = 0;
                    $count          = 0;
                    $row_count      = 0;
                }
                if($row_count == 0 ){?>
                    <tr>
                        <td style=" width:100% ; text-align:center ; "><strong><?php echo $company; ?></strong></td>
                    </tr>
                    <?php
                        if ($branch != ''){
                    ?>
                    <tr>
                        <td style=" width:100% ; text-align:center ; "><strong>Branch : <?php echo $branch; ?></strong></td>
                    </tr>    
                    <?php
                        }
                    ?>                       
                    <tr>
                        <td style=" width:100% ; text-align:center ; "><strong>PAYROLL SHEET</strong></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; text-align:center ; "><strong>ATTENDANCE PERIOD : <?php echo date("m/d/Y",strtotime($date_from)).'  - '.date("m/d/Y",strtotime($date_to)); ?></strong></td>
                    </tr>                                        
                    <tr>
                        <td style=" width:100% ; text-align:center ; "><strong>PAYROLL PERIOD : <?php echo date("m/d/Y",strtotime("+1month",strtotime($date_from))).'  - '.date("m/".date('t',strtotime("+1month",strtotime($date_from)))."/Y",strtotime("+1month",strtotime($date_from))); ?></strong></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; text-align:left ; "></td>
                    </tr>
                    <tr> 
                        <td style=" width: 3% ; text-align:left;"><strong>&nbsp;</strong></td>
                        <td style=" width: 5% ; text-align:left;"><strong>&nbsp;</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                        <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                        <td style=" width: 1% ; text-align:right;"><strong>&nbsp;</strong></td>
                        <td style=" width: 9% ; text-align:center;"><strong>OTHER INCOME</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>GROSS</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                        <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                        <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                        <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                        <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                        <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                        <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                        <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                    </tr>
                    <tr> 
                        <td style=" width: 3% ; text-align:left;"><strong>EMP. NO.</strong></td>
                        <td style=" width: 5% ; text-align:left;"><strong>EMPLOYEE NAME</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>BASIC</strong></td>
                        <td style=" width: 4% ; text-align:right;"><strong>COLA</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>NDIFF</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>OVERTIME</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>(TAXABLE)</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>(NON-TAX)</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>ABSENCES</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>PAY</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>WTAX</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>SSS</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>SSS ER</strong></td>
                        <td style=" width: 4% ; text-align:right;"><strong>PHIC</strong></td>
                        <td style=" width: 4% ; text-align:right;"><strong>PHIC ER</strong></td>
                        <td style=" width: 4% ; text-align:right;"><strong>HDMF</strong></td>
                        <td style=" width: 4% ; text-align:right;"><strong>HDMF ER</strong></td>
                        <td style=" width: 4% ; text-align:right;"><strong>HDMF ADD</strong></td>
                        <td style=" width: 4% ; text-align:right;"><strong>SSS LOAN</strong></td>
                        <td style=" width: 4% ; text-align:right;"><strong>HDMF LOAN</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>COMPANY</strong></td>
                        <td style=" width: 5% ; text-align:right;"><strong>NETPAY</strong></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; font-size:2 ; "></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
                    </tr><?php
                }
                $row_count++;
                if($value{'Oth Inc Taxable'} == -0.00){
                    $value{'Oth Inc Taxable'} = 0.00;
                }

                if (!in_array($value{'Department'}, $array_department)){
                    array_push($array_department, $value{'Department'});
                ?>
                    <tr>
                        <td style=" width: 100% ; text-align:left ;" colspan="22"><strong><?php echo $value{'Department'}; ?></strong></td>
                    </tr>                
                <?php
                }

                ?>
                <tr>
                    <td style=" width: 3% ; text-align:left;"><?php echo $value{'Id Number'}; ?></td>
                    <td style=" width: 5% ; text-align:left ; font-size: 6.5;"><?php echo $value{'Full Name'}; ?></td>
                    <td style=" width: 5% ; text-align:right"><?php echo number_format($value{'Basic'},2,'.',','); ?></td>
                    <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Cola'},2,'.',','); ?></td>
                    <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Nd'},2,'.',','); ?></td>
                    <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Overtime'},2,'.',','); ?></td>
                    <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Oth Inc Taxable'},2,'.',','); ?></td>
                    <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Oth Inc Nontax'},2,'.',','); ?></td>
                    <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Absences'},2,'.',','); ?></td>
                    <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Gross Pay'},2,'.',','); ?></td>
                    <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Whtax'},2,'.',','); ?></td>
                    <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Sss'},2,'.',','); ?></td>
                    <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Ssser'},2,'.',','); ?></td>
                    <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Phic'},2,'.',','); ?></td>
                    <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Phicer'},2,'.',','); ?></td>
                    <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Hdmf'},2,'.',','); ?></td>
                    <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Hdmfer'},2,'.',','); ?></td>
                    <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Hdmf Add'},2,'.',','); ?></td>
                    <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Sss Loan'},2,'.',','); ?></td>
                    <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Hdmf Loan'},2,'.',','); ?></td>
                    <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Oth Ded'},2,'.',','); ?></td>
                    <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Netpay'},2,'.',','); ?></td>
                </tr>
                <?php
                $tBasic         += $value{'Basic'};
                $tCola          += $value{'Cola'};
                $tND            += $value{'Nd'};
                $tOvertime      += $value{'Overtime'};
                $tOthIncTaxable += $value{'Oth Inc Taxable'};
                $tOthIncNontax  += $value{'Oth Inc Nontax'};
                $tAbsences      += $value{'Absences'};
                $tGrossPay      += $value{'Gross Pay'};
                $tWhtax         += $value{'Whtax'};
                $tSSS           += $value{'Sss'};
                $tSSSER         += $value{'Ssser'};
                $tPHIC          += $value{'Phic'};
                $tPHICER        += $value{'Phicer'};
                $tHDMF          += $value{'Hdmf'};
                $tHDMFER        += $value{'Hdmfer'};
                $tHDMFADD       += $value{'Hdmf Add'};
                $tSSSLN         += $value{'Sss Loan'};
                $tHDMFLN        += $value{'Hdmf Loan'};
                $tOthDed        += $value{'Oth Ded'};
                $tNetpay        += $value{'Netpay'};

                $gtBasic         += $value{'Basic'};
                $gtCola          += $value{'Cola'};
                $gtND            += $value{'Nd'};
                $gtOvertime      += $value{'Overtime'};
                $gtOthIncTaxable += $value{'Oth Inc Taxable'};
                $gtOthIncNontax  += $value{'Oth Inc Nontax'};
                $gtAbsences      += $value{'Absences'};
                $gtGrossPay      += $value{'Gross Pay'};
                $gtWhtax         += $value{'Whtax'};
                $gtSSS           += $value{'Sss'};
                $gtSSSER         += $value{'Ssser'};
                $gtPHIC          += $value{'Phic'};
                $gtPHICER        += $value{'Phicer'};
                $gtHDMF          += $value{'Hdmf'};
                $gtHDMFER        += $value{'Hdmfer'};
                $gtHDMFADD       += $value{'Hdmf Add'};
                $gtSSSLN         += $value{'Sss Loan'};
                $gtHDMFLN        += $value{'Hdmf Loan'};
                $gtOthDed        += $value{'Oth Ded'};
                $gtNetpay        += $value{'Netpay'};

                $gtdBasic         += $value{'Basic'};
                $gtdCola          += $value{'Cola'};
                $gtdND            += $value{'Nd'};
                $gtdOvertime      += $value{'Overtime'};
                $gtdOthIncTaxable += $value{'Oth Inc Taxable'};
                $gtdOthIncNontax  += $value{'Oth Inc Nontax'};
                $gtdAbsences      += $value{'Absences'};
                $gtdGrossPay      += $value{'Gross Pay'};
                $gtdWhtax         += $value{'Whtax'};
                $gtdSSS           += $value{'Sss'};
                $gtdSSSER         += $value{'Ssser'};
                $gtdPHIC          += $value{'Phic'};
                $gtdPHICER        += $value{'Phicer'};
                $gtdHDMF          += $value{'Hdmf'};
                $gtdHDMFER        += $value{'Hdmfer'};
                $gtdHDMFADD       += $value{'Hdmf Add'};
                $gtdSSSLN         += $value{'Sss Loan'};
                $gtdHDMFLN        += $value{'Hdmf Loan'};
                $gtdOthDed        += $value{'Oth Ded'};
                $gtdNetpay        += $value{'Netpay'};

                $count_perd++;
                $count++;
                $total_count++;
            endforeach; 
        endforeach; 
        ?>
        <tr>
            <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>        
        </tr>
        <tr>
            <td colspan="2" style=" width: 8% ; text-align:left;">Sub Total: <?php echo $count_perd; ?></td>
            <td style=" width: 5% ; text-align:right"><?php echo number_format(  $gtdBasic ,2,'.',','); ?></td>
            <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtdCola ,2,'.',','); ?></td>
            <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtdND ,2,'.',','); ?></td>
            <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtdOvertime ,2,'.',','); ?></td>
            <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtdOthIncTaxable ,2,'.',','); ?></td>
            <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtdOthIncNontax ,2,'.',','); ?></td>
            <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtdAbsences ,2,'.',','); ?></td>
            <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtdGrossPay ,2,'.',','); ?></td>
            <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtdWhtax ,2,'.',','); ?></td>
            <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtdSSS ,2,'.',','); ?></td>
            <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtdSSSER ,2,'.',','); ?></td>
            <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtdPHIC ,2,'.',','); ?></td>
            <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtdPHICER ,2,'.',','); ?></td>
            <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtdHDMF ,2,'.',','); ?></td>
            <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtdHDMFER ,2,'.',','); ?></td>
            <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtdHDMFADD ,2,'.',','); ?></td>
            <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtdSSSLN ,2,'.',','); ?></td>
            <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtdHDMFLN ,2,'.',','); ?></td>
            <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtdOthDed ,2,'.',','); ?></td>
            <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtdNetpay ,2,'.',','); ?></td>
        </tr>     
        <tr>
            <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>        
        </tr>           
    <?php   
    endforeach; ?>
    <?php
        if ($row_count > 19){
    ?>
            <div style="page-break-before: always;">&nbsp;</div>
    <?php
        }
    ?>        
    <tr><td></td></tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>   
    <tr>
        <td colspan="2" style=" width: 8% ; text-align:left; ">Grand Total : <?php echo $total_count; ?></td>
        <td style=" width: 5% ; text-align:right"><?php echo number_format( $gtBasic ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtCola ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtND ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtOvertime ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtOthIncTaxable ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtOthIncNontax ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtAbsences ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtGrossPay ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtWhtax ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtSSS ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtSSSER ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtPHIC ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtPHICER ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtHDMF ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtHDMFER ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtHDMFADD ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtSSSLN ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtHDMFLN ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtOthDed ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtNetpay ,2,'.',','); ?></td>
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

<?php
    if( !empty( $footer->template ) )
    {
        echo $this->parser->parse_string($footer->template, $vars, TRUE);
    }
?>
