<?php 
    $results = $result->result_array();
    $grand_total = $result->num_rows();
    $company = '';
    $total = 1;
?>

<table>
    <tr>
        <td width="100%" style="text-align:center; font-size:10; "><strong>Active Employee Summary Report</strong></td>
    </tr>
</table>

<?php 
    foreach ($results as $key => $result):
?>

    <?php if($company != $result['Company']){ $total = 1; ?>
        <table>
            <tr>
                <td width="100%"></td>
            </tr>
            <tr>
                <td style="text-align:left;"><strong>Company: </strong><?php echo $result['Company'];?></td>
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
                <td style="text-align:center;"><strong>Middle Name</strong></td>
                <td style="text-align:center;"><strong>Position</strong></td>
                <td style="text-align:center;"><strong>Department</strong></td>
            </tr>
        </table>
    <?php } ?>

    <table border="1" width="100%">
        <tr>
            <td><?php echo $result['Employee ID']; ?></td>
            <td><?php echo $result['Last Name']; ?></td>
            <td><?php echo $result['First Name']; ?></td>
            <td><?php echo $result['Middle Name']; ?></td>
            <td><?php echo $result['Position']; ?></td>
            <td><?php echo $result['Department']; ?></td>
         </tr>
    </table>

    <?php if(($key+1 < $grand_total) && ($results[$key]['Company'] != $results[$key+1]['Company'])){ ?>
        <table>
            <tr>
                <td width="100%"></td>
            </tr>
            <tr>
                <td><strong>Total Active: </strong><?php echo $total;?></td>
            </tr>
            <tr>
                <td width="100%"></td>
            </tr>
        </table>
    <?php } $company = $result['Company']; $total++; ?>

<?php 
    endforeach;
?>

<table>
    <tr>
        <td width="100%"></td>
    </tr>
    <tr>
        <td><strong>Total Active: </strong><?php echo $total-1;?></td>
    </tr>
</table>
<table>
    <tr>
        <td width="100%"></td>
    </tr>
    <tr>
        <td><strong>Grand Total: </strong><?php echo $grand_total;?></td>
    </tr>
</table>