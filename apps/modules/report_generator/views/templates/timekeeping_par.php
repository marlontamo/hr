<?php 
$results = $result->result_array();
?>
<table>
    <tr>
        <td width="100%" style="text-align:center; font-size:10; "><strong>Perfect Attendance Report</strong></td>
    </tr>
    <tr>
        <td style="text-align:left;"><strong>Month and Year: </strong><?php echo $results[0]['Month'].' '.$results[0]['Year']; ?></td>
    </tr>
    <tr>
        <td width="100%"></td>
    </tr>
</table>
<table border="1" width="100%">
    <tr>
        <td style="text-align:center;"><strong>Employee ID</strong></td>
        <td style="text-align:center;"><strong>Last Name</strong></td>
        <td style="text-align:center;"><strong>First Name</strong></td>
        <td style="text-align:center;"><strong>Company</strong></td>
        <td style="text-align:center;"><strong>Department</strong></td>
    </tr>
    <?php 
    foreach ($results as $result):
    ?>
    <tr>
        <td> <?php echo $result['Employee ID']; ?> </td>
        <td> <?php echo $result['Last Name']; ?> </td>
        <td> <?php echo $result['First Name']; ?> </td>
        <td> <?php echo $result['Company']; ?> </td>
        <td> <?php echo $result['Department']; ?> </td>
     </tr>
    <?php   
    endforeach;
?>
</table>
