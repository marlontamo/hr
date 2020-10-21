<?php 
$results = $result->result_array();
?>
<table>
    <tr>
        <td width="100%" style="text-align:center; font-size:10; "><strong>Leave Balance Report</strong></td>
    </tr>
    <tr>
        <td width:"100%"></td>
    </tr>
    <tr>
        <td width:"100%"></td>
    </tr>
    <tr>
        <td width:"100%"></td>
    </tr>
    <table border="1">
        <tr>
            <td style="text-align:center;"><strong>Employee No.</strong></td>
            <td style="text-align:center;"><strong>Firstname</strong></td>
            <td style="text-align:center;"><strong>Lastname</strong></td>
            <td style="text-align:center;"><strong>Type of Leave</strong></td>
            <td style="text-align:center;"><strong>Period</strong></td>
            <td style="text-align:center;"><strong>Previous Year Balance</strong></td>
            <td style="text-align:center;"><strong>Starting Balance</strong></td>
            <td style="text-align:center;"><strong>Remaining Balance</strong></td>
            <td style="text-align:center;"><strong>Converted Leave</strong></td>
        </tr>
        <?php 
        foreach ($results as $result):
        ?>
        <tr>
            <td style="text-align:center;"><?php echo $result['Employee No']; ?></td>
            <td><?php echo $result['Firstname']; ?></td>
            <td><?php echo $result['Lastname']; ?></td>
            <td style="text-align:center;"><?php echo $result['Type Of Leave']; ?></td>
            <td style="text-align:center;"><?php echo date('M Y', strtotime($result['Period From'])).'-'.date('M Y', strtotime($result['Period To'])); ?></td>
            <td style="text-align:center;"><?php echo $result['Previous Year Balance']; ?></td>
            <td style="text-align:center;"><?php echo $result['Starting Balance']; ?></td>
            <td style="text-align:center;"><?php echo $result['Remaining Balance']; ?></td>
            <td style="text-align:center;"><?php echo $result['Paid Unit']; ?></td>
         </tr>
        <?php   
        endforeach;
    ?>
    </table>
</table>