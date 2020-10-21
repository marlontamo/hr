<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, TRUE);
    }
?>

<?php
    //prep data
    $result = $result->result_array();
    $headers = array();
    $template = '';
    foreach( $result as $row )
    {
        $rowx = array(
            'lastname' => $row['Lastname'],
            'firstname' => $row['Firstname'],
            'middlename' => $row['Middlename'],
            'employee_code' => $row['Employee Code'],
            'date' => $row['Date'],
            'time_in' => $row['Time In'],
            'time_out' => $row['Time Out'],
            'hrs_work' => $row['Total Hours'],
            'nd' => $row['ND'],
            'total_ot' => $row['Total OT'],
            'status' => $row['Status'],
            'ht' =>$row['HT'],
            'schedule' => $row['Schedule']
        );

        unset( $row['Lastname'] );
        unset( $row['Firstname'] );
        unset( $row['Middlename'] );
        unset( $row['Employee Code'] );
        unset( $row['Date'] );
        unset( $row['Time In'] );
        unset( $row['Time Out'] );
        unset( $row['Total Hours'] );
        unset( $row['ND'] );
        unset( $row['Total OT'] );
        unset( $row['Status'] );
        unset( $row['HT'] );
        unset( $row['Schedule'] );

        if($r_company == 'all'){
            //$company = ucfirst($r_company);
            $company = $row['Company'];
        } else {
            $company = $row['Company'];
        }
        
        if($r_department == 'all') {
            //$department = ucfirst($r_department);
            $department = $row['Department'];
        } else {
            $department = $row['Department'];
        }
        
        
        //$com[$rowx['lastname'].', '.$rowx['firstname'].' - '.$rowx['employee_code']][$rowx['lastname']][] = $rowx;   
        //$com[$rowx['lastname'].', '.$rowx['firstname'].' - '.$rowx['employee_code']][$rowx['lastname']][] = $rowx;   
        //$com[[$rowx['lastname']],[[$rowx['firstname'],$rowx['employee_code']][] = $rowx;   

       // $com['Employee Code: '.$rowx['employee_code'].'  Lastname: '.$rowx['lastname'].' Firstname: '.$rowx['firstname'].'  Middlename: '.$rowx['middlename'].' Company: '.$company.' Department: '.$department][$rowx['lastname']][] = $rowx;  
        $com[$rowx['employee_code'].' <br/>Employee Name: '.$rowx['lastname'].' , '.$rowx['firstname'].' '.$rowx['middlename']][$rowx['lastname']][] = $rowx;

    }
?>
 <?php
    foreach( $com as $comp => $emp ): ?>
<table  style="page-break-after:always;">
    <tr>
        <td width="100%" style="text-align:center; font-size:10; "><strong>EMPLOYEE TIME RECORD</strong></td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left;">Time Record for : <?php echo  $first_period.' - '.$second_period; ?></td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left;">Employee Code : <?php echo $comp; ?> </td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left;">Company : <?php echo $company; ?> </td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left;">Department : <?php echo $department; ?> </td>
    </tr>
    
    <tr>
        <td width:"100%"></td>
    </tr>

   
   
        <!-- <tr>
           <td width="98%"colspan="10" style="font-weight:bold; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;: 1px solid black;"><?php echo $comp?><br/></td>
        </tr> -->
        <tr>
            <th width="13%" colspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Time In</th>
            <th width="13%" colspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Time Out</th>
            <th width="6%" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Total Hours</th>
            <th width="9%" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Night<br/>Differential<br/>Hours</th>
            <th width="6%" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Total OT Hours</th>
            <th width="27%" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Status</th>
            <th width="8%" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Hours<br/>of<br/>Tardiness</th>
            <th width="18%" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Schedule</th> 
        </tr>

        <tr>
            <td width="7%" style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Date</td>
            <td width="6%" style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Time</td>
            <td width="7%" style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Date</td>
            <td width="6%" style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Time</td>
            
        </tr> 
        <?php
        foreach( $emp as $idno => $rows ):

            $hours_work = 0;
            $ht = 0;
            $nd = 0;
            $tot = 0;

            foreach( $rows as $row ): ?>

                <tr>
                    <td  style=" border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;"><?php echo date("m/d/y", strtotime($row['date']))?></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $row['time_in']?></td>
                    <td style=" border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;"><?php echo date("m/d/y", strtotime($row['date']))?></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $row['time_out']?></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $row['hrs_work']?></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $row['nd']?></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $row['total_ot']?></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $row['status']?></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $row['ht']?></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $row['schedule']?></td>
                    
                    
                    <?php
                    $hours_work += $row['hrs_work'];
                    $ht += $row['ht'];
                    $nd += $row['nd'];
                    $tot += $row['total_ot'];
                    ?>
                </tr> <?php
            endforeach; ?>
            <tr>
                <td style=" border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;"></td>
                <td style=" border-top: 1px solid black; border-bottom: 1px solid black;"></td>
                <td style=" border-top: 1px solid black; border-bottom: 1px solid black;"></td>
                <td style="text-align:right; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><strong>TOTAL</strong></td>
                <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><strong><?php echo number_format($hours_work,2,'.',','); ?></strong></td>
                <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><strong><?php echo number_format($nd,2,'.',','); ?></strong></td>
                <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><strong><?php echo number_format($tot,2,'.',','); ?></strong></td>
                <td style="border-bottom: 1px solid black;"></td>
                <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><strong><?php echo number_format($ht,2,'.',','); ?></strong></td>
                <td style="border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
            </tr> 
            <?php
        endforeach;
    ?>
</table>
<?php endforeach;?>
<?php
    if( !empty( $footer->template ) )
    {
        echo $this->parser->parse_string($footer->template, $vars, TRUE);
    }
?>