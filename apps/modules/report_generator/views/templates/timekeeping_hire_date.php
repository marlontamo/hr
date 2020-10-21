<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, TRUE);
    }
?>
<table style="font-size: medium;" border="1">
    <tr>
        <td style="text-align:center;"><strong>Hire Date Report</strong></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td style="width: 20%; text-align:center;"><strong>Employee Id Number</strong></td>
        <td style="width: 20%; text-align:center;"><strong>First Name</strong></td>
        <td style="width: 20%; text-align:center;"><strong>Last Name</strong></td>
        <td style="width: 20%; text-align:center;"><strong>Employment Status</strong></td>
        <td style="width: 20%; text-align:center;"><strong>Date Hired</strong></td>
    </tr>
    <?php 
    $result = $result->result_array();
    foreach( $result as $row ) : ?>
        <tr>
            <td style="width: 20%; text-align:center;"><?php echo $row['Employee Id No'];?></td> 
            <td style="width: 20%;"><?php echo $row['Firstname'];?></td> 
            <td style="width: 20%;"><?php echo $row['Lastname'];?></td> 
            <td style="width: 20%;"><?php echo $row['Employment Status'];?></td> 
            <td style="width: 20%;"><?php echo date('F d, Y', strtotime($row['Date Hired']));?></td> 
        </tr> <?php
    endforeach; 
    ?>
</table>


<?php
    if( !empty( $footer->template ) )
    {
        echo $this->parser->parse_string($footer->template, $vars, TRUE);
    }
?>