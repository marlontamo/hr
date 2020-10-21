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
        <?php
        foreach($months as $month) :
        ?>   
            <td colspan=6><?php echo $month; ?></td>
        <?php 
        endforeach; 
        ?>
        <td colspan=6>YTD ATTRITION</td>
    </tr>    
    <tr> <?php
        foreach($columns as $column): ?>
            <td><?php echo $column->alias?></td> <?php
        endforeach; ?>
            <td>Average Total Headcount</td>
            <td>Managed</td>
            <td>Unmanaged</td>
            <td>Total Actual Attrition</td>
            <td>YTD Attrition</td>
    </tr><?php
    $result1 = $result->result();

    foreach( $result1 as $row ) : ?>
        <tr><?php
            $ath = array();
            $m = array();
            $u = array();
            $taa = array();
            $ya = array();
            foreach($columns as $column): 
                $alias = $column->alias; ?>
                <td><?php echo $row->$alias?></td> 
            <?php
                foreach ($months as $key => $value) {
                    $ath_alias = $key.' Total Headcount';
                    if($alias == $ath_alias){
                        $ath[] = $row->$alias;
                    }
                    $m_alias = $key.' Managed';
                    if($alias == $m_alias){
                        $m[] = $row->$alias;
                    }
                    $u_alias = $key.' Unmanaged';
                    if($alias == $u_alias){
                        $u[] = $row->$alias;
                    }
                    $taa_alias = $key.' Month Total Actual Attrition';
                    if($alias == $taa_alias){
                        $taa[] = $row->$alias;
                    }
                    $ya_alias = $key.' YTD Attrition';
                    if($alias == $ya_alias){
                        $ya[] = $row->$alias;
                    }
                 
                }             
                endforeach; 
            ?>
                <td><?php echo array_sum($ath); ?></td>
                <td><?php echo array_sum($m); ?></td>   
                <td><?php echo array_sum($u); ?></td>    
                <td><?php echo array_sum($taa); ?></td>
                <td><?php echo array_sum($ya); ?></td>

            <?php 
                $final_total_heacound[] = array_sum($ath);
                $final_manage[] = array_sum($m);
                $final_unmanage[] = array_sum($u);
                $final_mtaa[] = array_sum($taa);
                $final_ytd_attrition[] = array_sum($ya);
            ?>            
        </tr> 
        <?php
    endforeach; 

    $result2 = $result->result_array();
    $total_headcount = array();
    $mtaa = array();
    $yaa = array();
    foreach($result2 as $row) :
        foreach ($months as $key => $value) {
          $total_headcount[$value][] = $row[$key.' Total Headcount'];
          $mtaa[$value][] = $row[$key.' Month Total Actual Attrition'];
          $yaa[$value][] = $row[$key.' YTD Actual Attrition'];
        }
    endforeach;

    $jan_headcount =  array_sum($total_headcount['January']);
    $feb_headcount =  array_sum($total_headcount['February']);
    $mar_headcount =  array_sum($total_headcount['March']);
    $apr_headcount =  array_sum($total_headcount['April']);
    $may_headcount =  array_sum($total_headcount['May']);
    $jun_headcount =  array_sum($total_headcount['June']);
    $jul_headcount =  array_sum($total_headcount['July']);
    $aug_headcount =  array_sum($total_headcount['August']);
    $sep_headcount =  array_sum($total_headcount['September']);
    $oct_headcount =  array_sum($total_headcount['October']);
    $nov_headcount =  array_sum($total_headcount['November']);
    $dec_headcount =  array_sum($total_headcount['December']);

    $jan_mtaa =  array_sum($mtaa['January']);
    $feb_mtaa =  array_sum($mtaa['February']);
    $mar_mtaa =  array_sum($mtaa['March']);
    $apr_mtaa =  array_sum($mtaa['April']);
    $may_mtaa =  array_sum($mtaa['May']);
    $jun_mtaa =  array_sum($mtaa['June']);
    $jul_mtaa =  array_sum($mtaa['July']);
    $aug_mtaa =  array_sum($mtaa['August']);
    $sep_mtaa =  array_sum($mtaa['September']);
    $oct_mtaa =  array_sum($mtaa['October']);
    $nov_mtaa =  array_sum($mtaa['November']);
    $dec_mtaa =  array_sum($mtaa['December']);

    $jan_yaa =  array_sum($yaa['January']);
    $feb_yaa =  array_sum($yaa['February']);
    $mar_yaa =  array_sum($yaa['March']);
    $apr_yaa =  array_sum($yaa['April']);
    $may_yaa =  array_sum($yaa['May']);
    $jun_yaa =  array_sum($yaa['June']);
    $jul_yaa =  array_sum($yaa['July']);
    $aug_yaa =  array_sum($yaa['August']);
    $sep_yaa =  array_sum($yaa['September']);
    $oct_yaa =  array_sum($yaa['October']);
    $nov_yaa =  array_sum($yaa['November']);
    $dec_yaa =  array_sum($yaa['December']);

    ?>
    <tr>
        <td>TOTAL</td>
        <td><?php echo $jan_headcount; ?></td>
        <td></td>
        <td></td>
        <td><?php echo $jan_mtaa; ?></td>
        <td><?php echo $jan_yaa; ?></td>
        <?php $janya = $jan_yaa/$jan_headcount;?> 
        <td><?php echo round($janya, 2); ?></td>
        <td><?php echo $feb_headcount; ?></td>
        <td></td>
        <td></td>
        <td><?php echo $feb_mtaa; ?></td>
        <td><?php echo $feb_yaa; ?></td>
        <?php $febya = $feb_yaa/$feb_headcount;?> 
        <td><?php echo round($febya, 2); ?></td>
        <td><?php echo $mar_headcount; ?></td>
        <td></td>
        <td></td>
        <td><?php echo $mar_mtaa; ?></td>
        <td><?php echo $mar_yaa; ?></td>
        <?php $marya = $mar_yaa/$mar_headcount;?> 
        <td><?php echo round($marya, 2); ?></td>
        <td><?php echo $apr_headcount; ?></td>
        <td></td>
        <td></td>
        <td><?php echo $apr_mtaa; ?></td>
        <td><?php echo $apr_yaa; ?></td>
        <?php $aprya = $apr_yaa/$apr_headcount;?> 
        <td><?php echo round($aprya, 2); ?></td>
        <td><?php echo $may_headcount; ?></td>
        <td></td>
        <td></td>
        <td><?php echo $may_mtaa; ?></td>
        <td><?php echo $may_yaa; ?></td>
        <?php $mayya = $may_yaa/$may_headcount;?> 
        <td><?php echo round($mayya, 2); ?></td>
        <td><?php echo $jun_headcount; ?></td>
        <td></td>
        <td></td>
        <td><?php echo $jun_mtaa; ?></td>
        <td><?php echo $jun_yaa; ?></td>
        <?php $junya = $jun_yaa/$jun_headcount;?> 
        <td><?php echo round($junya, 2); ?></td>
        <td><?php echo $jul_headcount; ?></td>
        <td></td>
        <td></td>
        <td><?php echo $jul_mtaa; ?></td>
        <td><?php echo $jul_yaa; ?></td>
        <?php $julya = $jul_yaa/$jul_headcount;?> 
        <td><?php echo round($julya, 2); ?></td>
        <td><?php echo $aug_headcount; ?></td>
        <td></td>
        <td></td>
        <td><?php echo $aug_mtaa; ?></td>
        <td><?php echo $aug_yaa; ?></td>
        <?php $augya = $aug_yaa/$aug_headcount;?> 
        <td><?php echo round($augya, 2); ?></td>
        <td><?php echo $sep_headcount; ?></td>
        <td></td>
        <td></td>
        <td><?php echo $sep_mtaa; ?></td>
        <td><?php echo $sep_yaa; ?></td>
        <?php $sepya = $sep_yaa/$sep_headcount;?> 
        <td><?php echo round($sepya, 2); ?></td>
        <td><?php echo $oct_headcount; ?></td>
        <td></td>
        <td></td>
        <td><?php echo $oct_mtaa; ?></td>
        <td><?php echo $oct_yaa; ?></td>
        <?php $octya = $oct_yaa/$oct_headcount;?> 
        <td><?php echo round($octya, 2); ?></td>
        <td><?php echo $nov_headcount; ?></td>
        <td></td>
        <td></td>
        <td><?php echo $nov_mtaa; ?></td>
        <td><?php echo $nov_yaa; ?></td>
        <?php $novya = $nov_yaa/$nov_headcount;?> 
        <td><?php echo round($novya, 2); ?></td>
        <td><?php echo $dec_headcount; ?></td>
        <td></td>
        <td></td>
        <td><?php echo $dec_mtaa; ?></td>
        <td><?php echo $dec_yaa; ?></td>
        <?php $decya = $dec_yaa/$dec_headcount;?> 
        <td><?php echo round($decya, 2); ?></td>

        <td><?php echo array_sum($final_total_heacound); ?></td>
        <td><?php echo array_sum($final_manage); ?></td>
        <td><?php echo array_sum($final_unmanage); ?></td>
        <td><?php echo array_sum($final_mtaa); ?></td>
        <td><?php echo array_sum($final_ytd_attrition); ?></td>
    </tr>

</table>
<?php
    if( !empty( $footer->template ) )
    {
        echo $this->parser->parse_string($footer->template, $vars, TRUE);
    }
?>