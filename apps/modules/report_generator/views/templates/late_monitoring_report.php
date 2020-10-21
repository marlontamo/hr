<?php
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}
?>
<?php 
	//prep_data
	$project_code = 'Project Code';
	$project = 'Project';
	$full_name = 'Full Name';
	$date = 'Date';
	$late = 'Late';
	$project_title = 'Project Title';

	$result = $result->result();
	$data['days'] = array();
	$data['project_titles'] = array();
	$name = '';
	foreach( $result as $row )
	{
		if(!in_array($row->$date, $data['days'])){
			$data['days'][] = $row->$date; 
		}

		if(!in_array($row->$project_title, $data['project_titles'])){
			$data['project_titles'][] = $row->$project_title;
		}

		if($name != $row->$full_name){
			$data['employee_lates'][$row->$full_name][$row->$project_title][$row->$date][] = $row->$late;

		}
	}
	// debug($data);
?>
<table cellspacing="0" cellpadding="1" border="1">
	<tr>
		<th colspan="30" style="font-weight:bold;">Late Monitoring Report</th>
	</tr>
	<tr>
		<th rowspan="2" colspan="30"></th>
	<tr>
	<?php foreach($data['project_titles'] as $proj){ ?>
		<tr>
			<td><?php echo $proj; ?></td>
		</tr>

		<tr>
			<td>NAME</td>
		<?php foreach($data['days'] as $day){ ?>
			<td><?php echo $day; ?></td>
		<?php } ?>
			<td>TOTAL</td>
		</tr>

		<?php 
		$xtotal_late = '';
		$y_late = '';
		$ytotal_ofx = '';
		$ctr = 0;
			foreach($data['project_titles'] as $projects => $project){
				foreach($data['employee_lates'] as $employee => $record){
					echo '<tr>';
					echo '<td>'.$employee.'</td>';
					foreach($record as $day => $min_late){
						foreach($min_late as $row){
							foreach($row as $min){
								echo '<td>'.$min.'</td>';
								$xtotal_late += $min;
								$y_late[$ctr][] = $min;
							}
							
						}
					}
					echo '<td>'.$xtotal_late.'</td>';
					$ytotal_ofx[$ctr][] = $xtotal_late;
					echo '</tr>';
					$ctr++;
				}
 			}
 			// debug($y_late);
		?>

		<!-- COMPUTE FOR COLUMN TOTAL -->
		<?php 
			// for individual dates 
			$ytotal_late = array();
			foreach($y_late as $key => $value){
				foreach($value as $i => $v){
					array_key_exists($i,$ytotal_late) ? $ytotal_late[$i] += $v : $ytotal_late[$i] = $v;
				}
			}

			// for y-axis total of x-axis
			$total_of_x = array();
			foreach($ytotal_ofx as $index => $point){
				foreach($point as $id => $rate){
					array_key_exists($id,$total_of_x) ? $total_of_x[$id] += $rate : $total_of_x[$id] = $rate;
				}
			}

		?>

		<tr>
			<td>TOTAL</td>
			<?php 
				foreach($ytotal_late as $total){
					echo '<td>'.$total.'</td>';
				}
				foreach($total_of_x as $sum_total){
					echo '<td>'.$sum_total.'</td>';
				}
			?>
		</tr>
	<?php } ?>
</table>
<?php
	if( !empty( $footer->template ) )
	{
		echo $this->parser->parse_string($footer->template, $vars, TRUE);
	}
?>