<table>
    <tr>
        <td><strong>BATCHID</strong></td>
        <td><strong>BATCHENTRY</strong></td>
        <td><strong>SRCELEDGER</strong></td>
        <td><strong>SRCETYPE</strong></td>
        <td><strong>FSCSYR</strong></td>
        <td><strong>FSCSPERD</strong></td>
        <td><strong>JRNLDESC</strong></td>
        <td><strong>DATEENTRY</strong></td>
    </tr>
    <?php 
    $result = $result->row();
    ?> 
    <tr>
        <td><?php echo $result->{'Batchid'};?></td>
        <td><?php echo $result->{'Btchentry'};?></td>
        <td><?php echo $result->{'Srceledger'};?></td>
        <td><?php echo $result->{'Srcetype'};?></td>
        <td><?php echo $result->{'Fscsyr'};?></td>
        <td><?php echo $result->{'Fscsperd'};?></td>
        <td><?php echo $result->{'Jrnldesc'};?></td>
        <td><?php echo $result->{'Dateentry'};?></td>
    </tr>
</table>

[Batchid] => 100
    [Btchentry] => 1
    [Srceledger] => GL
    [Srcetype] => JE
    [Fscsperd] => 2016
    [Jrnldesc] => To record payroll for May 21 - Jun 5, 2016
    [Dateentry] => 20160615