<?php 
$results = $result->result_array();
?>
<table>
    <tr>
        <td width="100%" style="text-align:left; font-size:10; "><strong>Perfect Attendance</strong></td>
    </tr>
    <tr>
        <td style="text-align:left;"><strong>Company: <?php echo $results[0]['Company'];?> </strong></td>
    </tr>
    <tr>
        <td style="text-align:left;"><strong>Department: <?php echo $results[0]['Department'];?>  </strong></td>
    </tr>
    <tr>
        <td style="text-align:left;"><strong>Period: <?php echo $first_period.' - '.$second_period; ?></strong></td>
    </tr>
    <tr>
        <td width:"100%"></td>
    </tr>
</table>
<table border="1" width="70%">
    <tr>
        <td style="text-align:center;"><strong>ID Number</strong></td>
        <td style="text-align:center;"><strong>Employee Name</strong></td>
        <td style="text-align:center;"><strong>Position</strong></td>
    </tr>
    <?php 
    foreach ($results as $result):
    ?>
    <tr>
        <td><?php echo $result['Id Number']; ?></td>
        <td><?php echo $result['Alias']; ?></td>
        <td><?php echo $result['Position']; ?></td>
     </tr>
    <?php   
    endforeach;
?>
</table>
