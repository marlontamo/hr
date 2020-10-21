<?php
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}
?>
<table cellspacing="0" cellpadding="1" border="1">
	<tr> <?php
		foreach($columns as $column): ?>
			<td align="center"><strong><?php echo $column->alias?></strong></td> <?php
		endforeach; ?>
	</tr><?php
	$result = $result->result();
	foreach( $result as $row ) : ?>
		<tr><?php
			foreach($columns as $column): 
				$alias = $column->alias; ?>
				<td><?php echo $row->$alias?></td> <?php
			endforeach; ?>
		</tr> <?php
	endforeach; ?>
</table>
<?php
	if( !empty( $footer->template ) )
	{
		echo $this->parser->parse_string($footer->template, $vars, TRUE);
	}
?>