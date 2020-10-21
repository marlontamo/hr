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
            'date' => $row['Date'],
            'shift' => $row['Shift'],
            'time_in' => $row['Time In'],
            'time_out' => $row['Time Out'],
            'hours_work' => $row['Hours Work'],
            'late' =>$row['Late'],
            'ut' => $row['Ut'],
            'ot' => $row['Ot'],
            'id_number' => $row['Id Number']
        );

        unset( $row['Lastname'] );
        unset( $row['Firstname'] );
        unset( $row['Date'] );
        unset( $row['Shift'] );
        unset( $row['Time In'] );
        unset( $row['Time Out'] );
        unset( $row['Hours Work'] );
        unset( $row['Late'] );
        unset( $row['Ut'] );
        unset( $row['Ot'] );
        unset( $row['Id Number'] );

        if($r_company == 'all'){
            $company = ucfirst($r_company);
        } else {
            $company = $row['Company'];
        }
        
        if($r_department == 'all') {
            $department = ucfirst($r_department);
        } else {
            $department = $row['Department'];
        }
        

        $com[$rowx['lastname'].', '.$rowx['firstname'].' - '.$rowx['id_number']][$rowx['lastname']][] = $rowx;        
    }
?>
<table>
    <tr>
        <td width="100%" style="text-align:left; font-size:10; "><strong>Daily Time Record Report</strong></td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left;">Company : <?php echo $company; ?> </td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left;">Department : <?php echo $department; ?> </td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left;">Period : <?php echo $first_period.' - '.$second_period; ?></td>
    </tr>
    <tr>
        <td width:"100%"></td>
    </tr>
</table>
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <td style="font-weight:bold; text-align:center">Date</td>
        <td style="font-weight:bold; text-align:center">Shift</td>
        <td style="font-weight:bold; text-align:center">Time In</td>
        <td style="font-weight:bold; text-align:center">Time Out</td>
        <td style="font-weight:bold; text-align:center">Hours Work</td>
        <td style="font-weight:bold; text-align:center">Late</td>
        <td style="font-weight:bold; text-align:center">UT</td>
        <td style="font-weight:bold; text-align:center">OT</td>
    </tr> 
    <?php
    foreach( $com as $comp => $emp ): ?>
        <tr>
            <td colspan="8" style="font-weight:bold"><?php echo $comp?></td>
        </tr>
        <?php
        foreach( $emp as $idno => $rows ):

            $hours_work = 0;
            $late = 0;
            $ut = 0;
            $ot = 0;
            foreach( $rows as $row ): ?>
                <tr>
                    <td><?php echo $row['date']?></td>
                    <td><?php echo $row['shift']?></td>
                    <td style="text-align:center"><?php echo $row['time_in']?></td>
                    <td style="text-align:center"><?php echo $row['time_out']?></td>
                    <td style="text-align:center"><?php echo $row['hours_work']?></td>
                    <td style="text-align:center"><?php echo $row['late']?></td>
                    <td style="text-align:center"><?php echo $row['ut']?></td>
                    <td style="text-align:center"><?php echo $row['ot']?></td>
                    <?php
                    $hours_work += $row['hours_work'];
                    $late += $row['late'];
                    $ut += $row['ut'];
                    $ot += $row['ot'];
                    ?>
                </tr> <?php
            endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align:right"><strong>TOTAL</strong></td>
                <td style="text-align:center"><strong><?php echo number_format($hours_work,2,'.',','); ?></strong></td>
                <td style="text-align:center"><strong><?php echo number_format($late,2,'.',','); ?></strong></td>
                <td style="text-align:center"><strong><?php echo number_format($ut,2,'.',','); ?></strong></td>
                <td style="text-align:center"><strong><?php echo number_format($ot,2,'.',','); ?></strong></td>
            </tr> 
            <?php
        endforeach;
    endforeach; ?>
</table>
<?php
    if (CLIENT_DIR == 'bayleaf'){
        echo '<p>&nbsp;</p><table>
            <tr>
                <td style=" width: 45%; text-align:left  ; font-size: 7; ">Noted By: </td>
                <td style=" width:  5%; text-align:center; font-size: 7; "></td>
                <td style=" width: 45%; text-align:left  ; font-size: 7; ">Verified By:</td>
                <td style=" width:  5%; text-align:center; font-size: 7; "></td>
            </tr>
            <tr><td></td></tr><tr><td></td></tr>
            <tr>
                <td style=" width: 45%; text-align:left; border-top: 1px solid black ; font-size: 7; "></td>
                <td style=" width:  5%; text-align:right; font-size: 7; "></td>
                <td style=" width: 50%; text-align:left; border-top: 1px solid black ; font-size: 7; "></td>
                <td style="text-align:right; font-size: 7; "></td>                                    
            </tr>
        </table>';       
    }

    if( !empty( $footer->template ) )
    {
        echo $this->parser->parse_string($footer->template, $vars, TRUE);
    }
?>