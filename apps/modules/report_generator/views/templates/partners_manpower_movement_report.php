
<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, TRUE);
    }
?>
<table cellspacing="0" cellpadding="1" border="1">
    <tr><td>Manpower Movement</td></tr>
    <tr></tr>
    <tr> 
        <td></td>
    <?php
        foreach($columns as $column): ?>
            <td><?php echo $column->alias?></td> <?php
        endforeach; ?>
    </tr>
    <?php
        $result1 = $result->result();
        $i = 1;
        foreach( $result1 as $row ) : ?>
            <tr>
                <td><?php echo $i++; ?></td>
            <?php
                foreach($columns as $column): 
                    $alias = $column->alias; ?>
                    <td><?php echo $row->$alias?></td> 
                <?php 
                endforeach; 
                ?>
            </tr> <?php
        endforeach; 
    ?>
    <?php 
    $result2 = $result->result_array();
    $promotion_count = 0;
    $lateral_count = 0;
    $manage = 0;
    $unmanaged = 0;
    $eoc = 0;
    foreach($result2 as $row) :
        ( $row['Promote From'] == '' ? 0 : $promotion_count++ );
        ( $row['Lateral Transfer From'] == '' ? 0 : $lateral_count++ );
        ( $row['Manage'] == '' ? 0 : $manage++ );
        ( $row['Unmanaged'] == '' ? 0 : $unmanaged++ );
        ( $row['EOC'] == '' ? 0 : $eoc++ );
    endforeach;
    ?>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>Total Promotion:</td>
        <td><?php echo $promotion_count; ?></td>
        <td>Total Lateral Transfer:</td>
        <td><?php echo $lateral_count; ?></td>
        <td><?php echo $manage; ?></td>
        <td><?php echo $unmanaged; ?></td>
        <td><?php echo $eoc; ?></td>
    </tr>
    <tr><td></td></tr>
    <tr>
        <td></td>
        <td>SUMMARY</td>
    </tr>
    <tr>
        <td></td>
        <td>Promotion</td><td><?php echo $promotion_count; ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Managed</td>
        <td><?php echo $manage; ?></td>
    </tr>
    <?php $separation_total = $manage + $unmanaged + $eoc; ?>
    <tr>
        <td></td>
        <td>Lateral Transfer</td><td><?php echo $lateral_count; ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Unmanaged</td>
        <td><?php echo $unmanaged; ?></td>
    </tr>
    <tr>
        <td></td>
        <td>Separation</td>
        <td><?php echo $separation_total; ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td>EOC</td>
        <td><?php echo $eoc; ?></td>
    </tr>
    <tr>
        <td></td>
        <td>TOTAL</td>
        <td><?php echo ($promotion_count + $lateral_count +  $separation_total)?></td>
        <td></td>
        <td></td>
        <td></td>
        <td>TOTAL</td>
        <td><?php echo $separation_total; ?></td>
    </tr>
</table>
<?php
    if( !empty( $footer->template ) )
    {
        echo $this->parser->parse_string($footer->template, $vars, TRUE);
    }
?>