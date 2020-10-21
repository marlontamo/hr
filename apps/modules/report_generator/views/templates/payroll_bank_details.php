<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, TRUE);
    }
?>

<?php 
    $header = $result->row();
    $reg_company = get_registered_company();
    $main_company = '';
    if(is_array($reg_company)) {
         $main_company = $reg_company['registered_company'];
    }
    
    $company = '';
    if (property_exists($header,'Company')){
        $company = $header->{'Company'};
    }

     $payroll_date = '';
    if (property_exists($header,'Payroll Date')){
        $payroll_date  = date("F d, Y" ,strtotime( $header->{'Payroll Date'} ) );
    }

    $period = '';
    if (property_exists($header,'Date From')){
        $period  = date("F d, Y" ,strtotime( $header->{'Date From'} ) ) . ' - ' . date("F d, Y" ,strtotime( $header->{'Date To'} ) );
    }

    $date_from = (isset($header->{'Date From'}) ? $header->{'Date From'} : '');
    $date_to = (isset($header->{'Date To'}) ? $header->{'Date To'} : '');
    
    $schedule = '';
    $payroll_date_actuall = $payroll_date;
    $branch = '';
    if (isset($filter)){
        $payroll_date_actuall = end($filter);
        $schedule = prev($filter);
        $new_arr = array();
        foreach ($filter as $key => $value) {
            $new_arr[] = $value;
        }
        $branch_id = $new_arr[1];
        $branch_result = $this->db->get_where('users_branch',array('branch_id' => $branch_id));
        if ($branch_result && $branch_result->num_rows() > 0){
            $row_branch = $branch_result->row();
            $branch = $row_branch->branch;
        }
    }    
?>
<table>
    <div style="font-size: 2;">&nbsp;</div>
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
        <td style=" width:100% ; text-align:center ; "><strong>BANK DETAILS</strong></td>
    </tr>
    <tr>
        <td style=" width:100% ; text-align:center ; "><strong>ATTENDANCE PERIOD : <?php echo date("m/d/Y",strtotime($date_from)).'  - '.date("m/d/Y",strtotime($date_to)); ?></strong></td>
    </tr>                                        
    <tr>
        <td style=" width:100% ; text-align:center ; "><strong>PAYROLL PERIOD : <?php echo date("m/d/Y",strtotime("+1month",strtotime($date_from))).'  - '.date("m/".date('t',strtotime("+1month",strtotime($date_from)))."/Y",strtotime("+1month",strtotime($date_from))); ?></strong></td>
    </tr>
    <tr>
        <td style=" width:100% ; text-align:center ; font-size: 8; "><strong>Payroll Date : <?php echo $payroll_date_actuall; ?></strong></td>
    </tr>
    <tr>
        <td style=" width:100% ; text-align:left ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; text-align:left ; ">Print Date: <?php echo date('m d, Y'); ?></td>
    </tr>
        <tr>
        <td style=" width:100% ; text-align:left ; ">Print Time: <?php echo date('g:i a'); ?></td>
    </tr>
    <tr>
        <td style=" width:100% ; text-align:left ; "></td>
    </tr>
    <tr style="background-color:grey;">
        <td style="width: 10%; text-align:center;"><strong>Count</strong></td>
        <td style="width: 20%; text-align:center;"><strong>ID #</strong></td>
        <td style="width: 30%; text-align:center;"><strong>Account Name</strong></td>
        <td style="width: 20%; text-align:center;"><strong>Account Number</strong></td>
        <td style="width: 20%; text-align:center;"><strong>Amount</strong></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <?php 
    $result = $result->result_array();
    $count = 1;
    $row_count = 0;
    $amount = 0;

    foreach ($result as $row):
        if (((date('j',strtotime($payroll_date_actuall)) > 13 && date('j',strtotime($payroll_date_actuall)) < 16) || (date('j',strtotime($payroll_date_actuall)) > 26 && date('j',strtotime($payroll_date_actuall)) < 30)) && $row['Id_Number'] == '10000') {
            continue;
        }
        if ($schedule != '' && $schedule == 1){
            if ($row['Payout Scheme'] == 1 || ($row['Payout Scheme'] == 0 && $row['Payout Schedule'] == 0 )){           
                if($row_count > 49){
                    $row_count = 0;
    ?>
                    <div style="page-break-before: always; font-size: 2;">&nbsp;</div>
                    <tr>
                        <td style=" width:100% ; text-align:center ; "><strong><?php echo $company; ?></strong></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; text-align:center ; "><strong>BANK DETAILS</strong></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; text-align:center ; "><strong>ATTENDANCE PERIOD : <?php echo date("m/d/Y",strtotime($date_from)).'  - '.date("m/d/Y",strtotime($date_to)); ?></strong></td>
                    </tr>                                        
                    <tr>
                        <td style=" width:100% ; text-align:center ; "><strong>PAYROLL PERIOD : <?php echo date("m/d/Y",strtotime("+1month",strtotime($date_from))).'  - '.date("m/d/Y",strtotime("+1month",strtotime($date_to))); ?></strong></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; text-align:center ; font-size: 8; "><strong>Payroll Date : <?php echo $payroll_date; ?></strong></td>
                    </tr>

                    <tr>
                        <td style=" width:100% ; text-align:left ; "></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; text-align:left ; ">Print Date: <?php echo date('m d, Y'); ?></td>
                    </tr>
                        <tr>
                        <td style=" width:100% ; text-align:left ; ">Print Time: <?php echo date('g:i a'); ?></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; text-align:left ; "></td>
                    </tr>
                    <tr style="background-color:grey;">
                        <td style="width: 10%; text-align:center;"><strong>Count</strong></td>
                        <td style="width: 20%; text-align:center;"><strong>ID #</strong></td>
                        <td style="width: 30%; text-align:center;"><strong>Account Name</strong></td>
                        <td style="width: 20%; text-align:center;"><strong>Account Number</strong></td>
                        <td style="width: 20%; text-align:center;"><strong>Amount</strong></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; font-size:2 ; "></td>
                    </tr>
    <?php       } ?>
                <tr>
                	<td style="width: 10%; text-align:center; "><?php echo $count++; ?></td>
                	<td style="width: 20%; text-align:center; "><?php echo $row['Id_Number']; ?></td>
                	<td style="width: 30%; text-align:left  ; "><?php echo $row['Account_Name']; ?></td>
                	<td style="width: 20%; text-align:center; "><?php echo $row['Account_Number']; ?></td>
                	<td style="width: 20%; text-align:right ; "><?php echo number_format( $row['Amount'] ,2,'.',','); ?></td>
                </tr>
    <?php 
            	$amount += $row['Amount'];
                $row_count++;
            }
        }
        elseif ($schedule != '' && $schedule == 2){
            if ($row['Payout Scheme'] == 1 || ($row['Payout Scheme'] == 0 && $row['Payout Schedule'] == 1 )){           
                if($row_count > 49){
                    $row_count = 0;            
    ?>
                    <div style="page-break-before: always; font-size: 2;">&nbsp;</div>
                    <tr>
                        <td style=" width:100% ; text-align:center ; "><strong><?php echo $company; ?></strong></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; text-align:center ; "><strong>BANK DETAILS</strong></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; text-align:center ; "><strong>ATTENDANCE PERIOD : <?php echo date("m/d/Y",strtotime($date_from)).'  - '.date("m/d/Y",strtotime($date_to)); ?></strong></td>
                    </tr>                                        
                    <tr>
                        <td style=" width:100% ; text-align:center ; "><strong>PAYROLL PERIOD : <?php echo date("m/d/Y",strtotime("+1month",strtotime($date_from))).'  - '.date("m/d/Y",strtotime("+1month",strtotime($date_to))); ?></strong></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; text-align:center ; font-size: 8; "><strong>Payroll Date : <?php echo $payroll_date; ?></strong></td>
                    </tr>

                    <tr>
                        <td style=" width:100% ; text-align:left ; "></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; text-align:left ; ">Print Date: <?php echo date('m d, Y'); ?></td>
                    </tr>
                        <tr>
                        <td style=" width:100% ; text-align:left ; ">Print Time: <?php echo date('g:i a'); ?></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; text-align:left ; "></td>
                    </tr>
                    <tr style="background-color:grey;">
                        <td style="width: 10%; text-align:center;"><strong>Count</strong></td>
                        <td style="width: 20%; text-align:center;"><strong>ID #</strong></td>
                        <td style="width: 30%; text-align:center;"><strong>Account Name</strong></td>
                        <td style="width: 20%; text-align:center;"><strong>Account Number</strong></td>
                        <td style="width: 20%; text-align:center;"><strong>Amount</strong></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; font-size:2 ; "></td>
                    </tr>
    <?php       } ?>
                <tr>
                    <td style="width: 10%; text-align:center; "><?php echo $count++; ?></td>
                    <td style="width: 20%; text-align:center; "><?php echo $row['Id_Number']; ?></td>
                    <td style="width: 30%; text-align:left  ; "><?php echo $row['Account_Name']; ?></td>
                    <td style="width: 20%; text-align:center; "><?php echo $row['Account_Number']; ?></td>
                    <td style="width: 20%; text-align:right ; "><?php echo number_format( $row['Amount'] ,2,'.',','); ?></td>
                </tr>
    <?php 
                $amount += $row['Amount'];
                $row_count++;
            }
        }
        else{
            if($row_count > 49){
                $row_count = 0;              
    ?>
                <div style="page-break-before: always; font-size: 2;">&nbsp;</div>
                <tr>
                    <td style=" width:100% ; text-align:center ; "><strong><?php echo $company; ?></strong></td>
                </tr>
                <tr>
                    <td style=" width:100% ; text-align:center ; "><strong>BANK DETAILS</strong></td>
                </tr>
                <tr>
                    <td style=" width:100% ; text-align:center ; "><strong>ATTENDANCE PERIOD : <?php echo date("m/d/Y",strtotime($date_from)).'  - '.date("m/d/Y",strtotime($date_to)); ?></strong></td>
                </tr>                                        
                <tr>
                    <td style=" width:100% ; text-align:center ; "><strong>PAYROLL PERIOD : <?php echo date("m/d/Y",strtotime("+1month",strtotime($date_from))).'  - '.date("m/d/Y",strtotime("+1month",strtotime($date_to))); ?></strong></td>
                </tr>
                <tr>
                    <td style=" width:100% ; text-align:center ; font-size: 8; "><strong>Payroll Date : <?php echo $payroll_date; ?></strong></td>
                </tr>

                <tr>
                    <td style=" width:100% ; text-align:left ; "></td>
                </tr>
                <tr>
                    <td style=" width:100% ; text-align:left ; ">Print Date: <?php echo date('m d, Y'); ?></td>
                </tr>
                    <tr>
                    <td style=" width:100% ; text-align:left ; ">Print Time: <?php echo date('g:i a'); ?></td>
                </tr>
                <tr>
                    <td style=" width:100% ; text-align:left ; "></td>
                </tr>
                <tr style="background-color:grey;">
                    <td style="width: 10%; text-align:center;"><strong>Count</strong></td>
                    <td style="width: 20%; text-align:center;"><strong>ID #</strong></td>
                    <td style="width: 30%; text-align:center;"><strong>Account Name</strong></td>
                    <td style="width: 20%; text-align:center;"><strong>Account Number</strong></td>
                    <td style="width: 20%; text-align:center;"><strong>Amount</strong></td>
                </tr>
                <tr>
                    <td style=" width:100% ; font-size:2 ; "></td>
                </tr>
    <?php   } ?>
            <tr>
                <td style="width: 10%; text-align:center; "><?php echo $count++; ?></td>
                <td style="width: 20%; text-align:center; "><?php echo $row['Id_Number']; ?></td>
                <td style="width: 30%; text-align:left  ; "><?php echo $row['Account_Name']; ?></td>
                <td style="width: 20%; text-align:center; "><?php echo $row['Account_Number']; ?></td>
                <td style="width: 20%; text-align:right ; "><?php echo number_format( $row['Amount'] ,2,'.',','); ?></td>
            </tr>
    <?php 
            $amount += $row['Amount'];
            $row_count++;        
        }
    endforeach; 
    ?>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
    <tr>
    	<td style="width: 10%; text-align:center; ">TOTAL</td>
    	<td style="width: 20%; text-align:center; "></td>
    	<td style="width: 30%; text-align:center; "></td>
    	<td style="width: 20%; text-align:center; "></td>
    	<td style="width: 20%; text-align:right ; "><strong><?php echo number_format( $amount ,2,'.',','); ?></strong></td>
    </tr>
</table>