<table>
    <tr>
        <td><strong>BATCHNBR</strong></td>
        <td><strong>JOURNALID</strong></td>
        <td><strong>TRANSNBR</strong></td>
        <td><strong>ACCTID</strong></td>
        <td><strong>TRANSAMT</strong></td>
        <td><strong>TRANSDESC</strong></td>
        <td><strong>TRANSREF</strong></td>
        <td><strong>TRANSDATE</strong></td>
        <td><strong>SRCELDGR</strong></td>
        <td><strong>SRCETYPE</strong></td>
        <td><strong>COMMENT</strong></td>
    </tr>
<?php 
    $result = $result->result_array();
    $transnbr = 20;
    foreach( $result as $row):
        $transamt = 0.00;
        $transamt = $row{'Dr'} != 0 ? number_format( $row{'Dr'},2,'.','') : number_format( (-1) * $row{'Cr'},2,'.',''); 
    ?> 
    <tr>
        <td>100</td>
        <td>1</td>
        <td><?php echo $transnbr; ?></td>
        <td><?php echo $row['Account Number']; ?></td>
        <td><?php echo $transamt; ?></td>
        <td><?php echo $row['Account Title']; ?></td>
        <td>PY<?php echo date('Ymd', strtotime($row['Payroll Date'])); ?></td>
        <td><?php echo date('m/d/Y', strtotime($row['Payroll Date'])); ?></td>
        <td>GL</td>
        <td>JE</td>
        <td></td>
    </tr>
    <?php
        $transnbr = $transnbr + 20;
    endforeach; ?>
</table>

