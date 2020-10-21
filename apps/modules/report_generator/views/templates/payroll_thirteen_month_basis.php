<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, TRUE);
    }

    $months = array(
        'Jan' => 'January',
        'Feb' => 'February',
        'Mar' => 'March',
        'Apr' => 'April',
        'May' => 'May',
        'Jun' => 'June',
        'Jul' => 'July',
        'Aug' => 'August',
        'Sep' => 'September',
        'Oct' => 'October',
        'Nov' => 'November',
        'Dec' => 'December'
    );
?>
<table cellspacing="0" cellpadding="1" border="1"> 
    <tr>
        <td></td>
        <td></td>
        <?php
        foreach($months as $month) :
        ?>   
            <td colspan=3><?php echo $month; ?></td>
        <?php 
        endforeach; 
        ?>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>13th month Pay</td>
    </tr>      
    <tr>
        <td>Employee Name</td> 
        <td>Employee No.</td> 
        <td>REG</td> 
        <td>SALDJ</td> 
        <td>De Minimis</td> 
        <td>REG</td> 
        <td>SALDJ</td> 
        <td>De Minimis</td>
        <td>REG</td> 
        <td>SALDJ</td> 
        <td>De Minimis</td>
        <td>REG</td> 
        <td>SALDJ</td> 
        <td>De Minimis</td>
        <td>REG</td> 
        <td>SALDJ</td> 
        <td>De Minimis</td>
        <td>REG</td> 
        <td>SALDJ</td> 
        <td>De Minimis</td>
        <td>REG</td> 
        <td>SALDJ</td> 
        <td>De Minimis</td>
        <td>REG</td> 
        <td>SALDJ</td> 
        <td>De Minimis</td>
        <td>REG</td> 
        <td>SALDJ</td> 
        <td>De Minimis</td>
        <td>REG</td> 
        <td>SALDJ</td> 
        <td>De Minimis</td>
        <td>REG</td> 
        <td>SALDJ</td> 
        <td>De Minimis</td>
        <td>REG</td> 
        <td>SALDJ</td> 
        <td>De Minimis</td>
        <td>Total</td>
        <td>Month</td>
        <td>13th Month</td>
        <td>Ceiling</td>
        <td>Taxable</td>
    </tr>

    <?php
    $jan_reg = 0;
    $jan_saladj = 0;
    $jan_deminimis = 0;
    $feb_reg = 0;
    $feb_saladj = 0;
    $feb_deminimis = 0;
    $mar_reg = 0;
    $mar_saladj = 0;
    $mar_deminimis = 0;
    $apr_reg = 0;
    $apr_saladj = 0;
    $apr_deminimis = 0;
    $may_reg = 0;
    $may_saladj = 0;
    $may_deminimis = 0;
    $jun_reg = 0;
    $jun_saladj = 0;
    $jun_deminimis = 0;
    $jul_reg = 0;
    $jul_saladj = 0;
    $jul_deminimis = 0;
    $aug_reg = 0;
    $aug_saladj = 0;
    $aug_deminimis = 0;
    $sep_reg = 0;
    $sep_saladj = 0;
    $sep_deminimis = 0;
    $oct_reg = 0;
    $oct_saladj = 0;
    $oct_deminimis = 0;
    $nov_reg = 0;
    $nov_saladj = 0;
    $nov_deminimis = 0;
    $dec_reg = 0;
    $dec_saladj = 0;
    $dec_deminimis = 0;
    $total = 0;
    $thirteen_month = 0;
    $ceiling = 0;
    $taxable = 0;

    $result = $result->result_array();
    foreach( $result as $row ) : 
    ?>
    <tr>
        <td><?php echo $row['Lastname'].', '.$row['Firstname']; ?></td>
        <td><?php echo $row['Id Number']; ?></td>
        <td><?php echo $row['Jan Reg']; ?></td>
        <td><?php echo $row['Jan Saladj']; ?></td>
        <td><?php echo $row['Jan Deminimis']; ?></td>
        <td><?php echo $row['Feb Reg']; ?></td>
        <td><?php echo $row['Feb Saladj']; ?></td>
        <td><?php echo $row['Feb Deminimis']; ?></td>
        <td><?php echo $row['Mar Reg']; ?></td>
        <td><?php echo $row['Mar Saladj']; ?></td>
        <td><?php echo $row['Mar Deminimis']; ?></td>
        <td><?php echo $row['Apr Reg']; ?></td>
        <td><?php echo $row['Apr Saladj']; ?></td>
        <td><?php echo $row['Apr Deminimis']; ?></td>
        <td><?php echo $row['May Reg']; ?></td>
        <td><?php echo $row['May Saladj']; ?></td>
        <td><?php echo $row['May Deminimis']; ?></td>
        <td><?php echo $row['Jun Reg']; ?></td>
        <td><?php echo $row['Jun Saladj']; ?></td>
        <td><?php echo $row['Jun Deminimis']; ?></td>
        <td><?php echo $row['Jul Reg']; ?></td>
        <td><?php echo $row['Jul Saladj']; ?></td>
        <td><?php echo $row['Jul Deminimis']; ?></td>
        <td><?php echo $row['Aug Reg']; ?></td>
        <td><?php echo $row['Aug Saladj']; ?></td>
        <td><?php echo $row['Aug Deminimis']; ?></td>
        <td><?php echo $row['Sep Reg']; ?></td>
        <td><?php echo $row['Sep Saladj']; ?></td>
        <td><?php echo $row['Sep Deminimis']; ?></td>
        <td><?php echo $row['Oct Reg']; ?></td>
        <td><?php echo $row['Oct Saladj']; ?></td>
        <td><?php echo $row['Oct Deminimis']; ?></td>
        <td><?php echo $row['Nov Reg']; ?></td>
        <td><?php echo $row['Nov Saladj']; ?></td>
        <td><?php echo $row['Nov Deminimis']; ?></td>
        <td><?php echo $row['Dec Reg']; ?></td>
        <td><?php echo $row['Dec Saladj']; ?></td>
        <td><?php echo $row['Dec Deminimis']; ?></td>
        <td><?php echo $row['Total']; ?></td>
        <td><?php echo $row['Month Count']; ?></td>
        <td><?php echo $row['Bonus']; ?></td>
        <td><?php echo $row['Ceiling Amount']; ?></td>
        <td><?php echo $row['Taxable']; ?></td>
    </tr>
    <?php

    $jan_reg += $row['Jan Reg'];
    $jan_saladj += $row['Jan Saladj'];
    $jan_deminimis += $row['Jan Deminimis'];
    $feb_reg += $row['Feb Reg'];
    $feb_saladj += $row['Feb Saladj'];
    $feb_deminimis += $row['Feb Deminimis'];
    $mar_reg += $row['Mar Reg'];
    $mar_saladj += $row['Mar Saladj'];
    $mar_deminimis += $row['Mar Deminimis'];
    $apr_reg += $row['Apr Reg'];
    $apr_saladj += $row['Apr Saladj'];
    $apr_deminimis += $row['Apr Deminimis'];
    $may_reg += $row['May Reg'];
    $may_saladj += $row['May Saladj'];
    $may_deminimis += $row['May Deminimis'];
    $jun_reg += $row['Jun Reg'];
    $jun_saladj += $row['Jun Saladj'];
    $jun_deminimis += $row['Jun Deminimis'];
    $jul_reg += $row['Jul Reg'];
    $jul_saladj += $row['Jul Saladj'];
    $jul_deminimis += $row['Jul Deminimis'];
    $aug_reg += $row['Aug Reg'];
    $aug_saladj += $row['Aug Saladj'];
    $aug_deminimis += $row['Aug Deminimis'];
    $sep_reg += $row['Sep Reg'];
    $sep_saladj += $row['Sep Saladj'];
    $sep_deminimis += $row['Sep Deminimis'];
    $oct_reg += $row['Oct Reg'];
    $oct_saladj += $row['Oct Saladj'];
    $oct_deminimis += $row['Oct Deminimis'];
    $nov_reg += $row['Nov Reg'];
    $nov_saladj += $row['Nov Saladj'];
    $nov_deminimis += $row['Nov Deminimis'];
    $dec_reg += $row['Dec Reg'];
    $dec_saladj += $row['Dec Saladj'];
    $dec_deminimis += $row['Dec Deminimis'];
    $total += $row['Total'];
    $thirteen_month += $row['Bonus'];
    $ceiling += $row['Ceiling Amount'];
    $taxable += $row['Taxable'];

    endforeach;
    ?>
    <tr>
        <td>TOTAL</td>
        <td></td>
        <td><?php echo $jan_reg; ?></td>
        <td><?php echo $jan_saladj; ?></td>
        <td><?php echo $jan_deminimis; ?></td>
        <td><?php echo $feb_reg; ?></td>
        <td><?php echo $feb_saladj; ?></td>
        <td><?php echo $feb_deminimis; ?></td>
        <td><?php echo $mar_reg; ?></td>
        <td><?php echo $mar_saladj; ?></td>
        <td><?php echo $mar_deminimis; ?></td>
        <td><?php echo $apr_reg; ?></td>
        <td><?php echo $apr_saladj; ?></td>
        <td><?php echo $apr_deminimis; ?></td>
        <td><?php echo $may_reg; ?></td>
        <td><?php echo $may_saladj; ?></td>
        <td><?php echo $may_deminimis; ?></td>
        <td><?php echo $jun_reg; ?></td>
        <td><?php echo $jun_saladj; ?></td>
        <td><?php echo $jun_deminimis; ?></td>
        <td><?php echo $jul_reg; ?></td>
        <td><?php echo $jul_saladj; ?></td>
        <td><?php echo $jul_deminimis; ?></td>
        <td><?php echo $aug_reg; ?></td>
        <td><?php echo $aug_saladj; ?></td>
        <td><?php echo $aug_deminimis; ?></td>
        <td><?php echo $sep_reg; ?></td>
        <td><?php echo $sep_saladj; ?></td>
        <td><?php echo $sep_deminimis; ?></td>
        <td><?php echo $oct_reg; ?></td>
        <td><?php echo $oct_saladj; ?></td>
        <td><?php echo $oct_deminimis; ?></td>
        <td><?php echo $nov_reg; ?></td>
        <td><?php echo $nov_saladj; ?></td>
        <td><?php echo $nov_deminimis; ?></td>
        <td><?php echo $dec_reg; ?></td>
        <td><?php echo $dec_saladj; ?></td>
        <td><?php echo $dec_deminimis; ?></td>
        <td><?php echo $total; ?></td>
        <td></td>
        <td><?php echo $thirteen_month; ?></td>
        <td><?php echo $ceiling; ?></td>
        <td><?php echo $taxable; ?></td>
    </tr>

</table>
<?php
    if( !empty( $footer->template ) )
    {
        echo $this->parser->parse_string($footer->template, $vars, TRUE);
    }
?>