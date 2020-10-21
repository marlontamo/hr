<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, TRUE);
    }
?>
<div>&nbsp;</div>
    <?php 
    $result = $result->result_array();
    $transnbr = 20;
    $count = 0;
    foreach ($result as $row):
        if($count == 0 || $count ==27){
            if($count == 27){?>
                <div style="page-break-before: always;">&nbsp;</div>
            <?php }?>
            <table cellpadding="2">
                <tr>
                    <td style=" width:100% ; text-align:center ; "><h3>JOURNAL DETAILS</h3></td>
                </tr>
                <tr>
                    <td style=" width:100% ; text-align:left ; "></td>
                </tr>
                <tr>
                    <td style="width: 6%; text-align:center;"><strong>BATCHNBR</strong></td>
                    <td style="width: 6%; text-align:center;"><strong>JOURNALID</strong></td>
                    <td style="width: 6%; text-align:center;"><strong>TRANSNBR</strong></td>
                    <td style="width:12%; text-align:center;"><strong>ACCTID</strong></td>
                    <td style="width:10%; text-align:right ;"><strong>TRANSAMT</strong></td>
                    <td style="width:20%; text-align:center;"><strong>TRANSDESC</strong></td>
                    <td style="width: 8%; text-align:center;"><strong>TRANSREF</strong></td>
                    <td style="width: 8%; text-align:center;"><strong>TRANSDATE</strong></td>
                    <td style="width: 8%; text-align:center;"><strong>SRCELDGR</strong></td>
                    <td style="width: 8%; text-align:center;"><strong>SRCETYPE</strong></td>
                    <td style="width: 8%; text-align:center;"><strong>COMMENT</strong></td>
                </tr>
                <tr>
                    <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
                </tr>
        <?php }
    ?>
                <tr>
                    <td style="width: 6%; text-align:center; ">100</td>
                    <td style="width: 6%; text-align:center; ">1</td>
                    <td style="width: 6%; text-align:center; "><?php echo $transnbr; ?></td>
                    <td style="width:12%; text-align:left  ; "><?php echo $row['Account Number']; ?></td>
                    <td style="width:10%; text-align:right ; "><?php echo $row{'Dr'} != 0 ? number_format( $row{'Dr'},2,'.',',') : number_format( $row{'Cr'},2,'.',','); ?></td>
                    <td style="width:20%; text-align:left  ; "><?php echo $row['Account Title']; ?></td>
                    <td style="width: 8%; text-align:center; ">PY<?php echo date('Ymd', strtotime($row['Payroll Date'])); ?></td>
                    <td style="width: 8%; text-align:center; "><?php echo date('Ymd', strtotime($row['Payroll Date'])); ?></td>
                    <td style="width: 8%; text-align:center; ">GL</td>
                    <td style="width: 8%; text-align:center; ">JE</td>
                    <td style="width: 8%; text-align:center; "></td>
                </tr>
    <?php 
        if( $count == 27){?>
                
            </table><?php
            $count = 0;
        }
        $transnbr = $transnbr + 20;
        $count++;
    endforeach; ?>
    