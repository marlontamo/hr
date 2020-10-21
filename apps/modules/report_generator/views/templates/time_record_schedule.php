<?php
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}

	$branch_array = array();
	$dept_array = array();
?>
<table cellspacing="0" cellpadding="1" border="1">
	<?php
		foreach( $result->result() as $row ){
			if (!in_array($row->Branch, $branch_array)){
				array_push($branch_array, $row->Branch);
			}
		}

		if (!empty($branch_array)){
			foreach ($branch_array as $key => $value) {
	?>
				<tr>
					<td colspan="8"><strong>Branch: <?php echo $value ?></strong></td>
				</tr>	
				<tr> 
	<?php
					foreach($columns as $column): 
						if ($column->alias != 'Department' && $column->alias != 'Branch'){
	?>
							<td align="center"><strong><?php echo $column->alias?></strong></td> 
	<?php
						}
					endforeach; 
	?>
				</tr>
	<?php
				if ($result && $result->num_rows() > 0){
					foreach( $result->result() as $row ) : 
						if (!in_array($row->Department, $dept_array)){
							array_push($dept_array, $row->Department);
	?>
							<tr>
								<td colspan="8"><strong>Department: <?php echo $row->Department ?></strong></td>
							</tr>
	<?php						
						}
	?>				
						<tr>
	<?php
							foreach($columns as $column): 
								if ($column->alias != 'Department' && $column->alias != 'Branch'){							
									$alias = $column->alias; 
	?>
									<td><?php echo $row->$alias?></td> 
	<?php
								}
							endforeach; 
	?>
						</tr> 
	<?php
					endforeach; 
				}
			}
		}
	?>
</table>
<?php
	if( !empty( $footer->template ) )
	{
		echo $this->parser->parse_string($footer->template, $vars, TRUE);
	}
?>