<html xmlns:x="urn:schemas-microsoft-com:office:excel">
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
            'full_name' => $row['Full Name'],
            'date' => $row['Date'],
            'shift' => $row['Shift'],
            'time_in' => $row['Time In'],
            'time_out' => $row['Time Out'],
            'late' =>$row['Late'],
            'absent' => $row['Absent'],
            'is_leave' => $row['Is Leave'],
            'payroll_date_from' => $row['Payroll Date From'],
            'payroll_date_to' => $row['Payroll Date To']
        );

        unset( $row['Full Name'] );
        unset( $row['Date'] );
        unset( $row['Shift'] );
        unset( $row['Time In'] );
        unset( $row['Time Out'] );
        unset( $row['Late'] );
        unset( $row['Absent'] );
        unset( $row['Is Leave'] );
        unset( $row['Payroll Date From'] );
        unset( $row['Payroll Date To'] );
       // unset( $row['Payroll Rate Type'] );
        

        if($r_company == 'all'){
            $company = ucfirst($r_company);
        } else {
            $company = $row['Company'];
        }
        
        if($r_project == 'all') {
            $project = ucfirst($r_project);
        } else {
            $project = $row['Project'];
        }

        if($r_payroll_rate_type == 'all') {
            $payroll_rate_type = ucfirst($r_payroll_rate_type);
        } else {
            $payroll_rate_type = $row['Payroll Rate Type'];
        }

        $com[$rowx['full_name']][$rowx['full_name']][] = $rowx;              
    }
?>
<table>

<?php
$dates = array();
    foreach( $com as $comp => $emp ){
        foreach( $emp as $idno => $rows ){
            $dates = $rows;
            foreach( $rows as $row ){
                 $coverage =  date("F d, Y", strtotime($row['payroll_date_from'])).' - '.date("F d, Y", strtotime($row['payroll_date_to']));
            }
           
        }
    }?>
    <tr>
        <td colspan="20" width="100%" style="text-align:left; font-size:10; "><strong>Logs Monitoring Report <?php echo '('.$payroll_rate_type.')'; ?></strong></td>
    </tr>
    <tr>
        <td colspan="20" width="100%" style="text-align:left;">Date Range: <?php echo $coverage; ?></td>
    </tr>

</table>
<table cellspacing="0" cellpadding="1" border="1">
<tr>
    <td colspan="20" width="100%" style="text-align:left;">COMPANY: <?php echo $company; ?> </td>
</tr>
<tr>
    <td colspan="20" width="100%" style="text-align:left;">PROJECT: <?php echo $project; ?> </td>
</tr>
 <tr>
    <td>NAME </td>
    <?php foreach( $dates as $row ): ?>
    <td width='100%'><?php echo date("m/d/y", strtotime($row['date']));?></td>
    <?php endforeach; ?>
    <td>No. of Days Late</td>
    <td>No. of Days Absent</td>
    <td>No. of Days Leave</td>
</tr>
    
    <?php
    foreach( $com as $comp => $emp ): ?>
        
        <?php
        foreach( $emp as $idno => $rows ):

            $absent = 0;
            $late = 0;
            $leave = 0;
            ?>
            
            <tr valign="top">
            <td><?php echo $comp?></td>
            <?php foreach( $rows as $row ): ?>
                    <td width='100%'><?php echo $row['shift'].'<br style="mso-data-placement:same-cell;" />'.$row['time_in'].' - '.$row['time_out'];?></td>
                    <?php
                    $absent += $row['absent'];
                    $late += $row['late'];
                    $leave += $row['is_leave'];
                    ?>
                    <?php
            endforeach; ?>
            
            <td style="text-align:center"><strong><?php echo number_format($late,2,'.',','); ?></strong></td>
            <td style="text-align:center"><strong><?php echo number_format($absent,2,'.',','); ?></strong></td>
            <td style="text-align:center"><strong><?php echo number_format($leave,2,'.',','); ?></strong></td>
            </tr>
            
            
            <?php
        endforeach;
    endforeach; ?>
</table>
<?php
    if( !empty( $footer->template ) )
    {
        echo $this->parser->parse_string($footer->template, $vars, TRUE);
    }
?>
</html>