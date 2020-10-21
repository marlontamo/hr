<?php
$qry = "select a.*, b.uitype
FROM {$db->dbprefix}performance_template_section_column a
LEFT JOIN {$db->dbprefix}performance_template_section_column_uitype b on b.uitype_id = a.uitype_id
WHERE a.deleted = 0 AND a.template_section_id = {$section_id}
ORDER BY a.sequence";
$columns = $db->query( $qry );
$show_add = false;
foreach( $columns->result() as $row ) :
	switch( $row->uitype_id )
	{
		case 4:
			if( empty($row->parent_id ) && !empty($row->max_items) )
			{
				$items = $db->get_where('performance_planning_applicable_items', array('planning_id' => $appraisee->planning_id, 'user_id' => $appraisee->user_id, 'section_column_id' => $row->section_column_id))->num_rows();
				if( $items < $row->max_items )
				{
					$show_add = true;
				}
			}
			break;
		case 5:
			$where = array(
				'rating_group_id' => $row->rating_group_id,
				'status_id' => 1,
				'deleted' => 0
			);
			$ratings = $db->get_where('performance_setup_rating_score', $where); ?>
			<div class="panel-body">
				<p class="small"><b>{{ lang('appraisal_individual_planning.standard') }}:</b><br><?php
					foreach( $ratings->result() as $rating )
						echo $rating->rating_score .' - '.$rating->description.'&nbsp;'?>
				</p>   
			</div>
			<?php
			break;
		default;
			break;
	}
endforeach;?>
{{ $header }}
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr><?php
				foreach( $columns->result() as $row ) : ?>
					<th width="<?php echo $row->width?>%" ><?php echo $row->title?></th><?php
				endforeach;?>	
			</tr>
		</thead>
		<tbody class="get-section section-{{ $section_id }}" section="{{ $section_id }}">
			<tr class="first-row">
				<td colspan="2">
					<span class="pull-right bold">{{ lang('appraisal_individual_planning.total_weight') }}:</span>

				</td>
				<td><input type="text" class="form-control" id="total-weight"></td>
				<td colspan="3"></td>
			</tr> <?php
			echo '<tr class="first-row">';
			echo '<td colspan="'.$columns->num_rows().'">';
			$first = true;
			foreach( $columns->result() as $row ) :
				switch( $row->uitype_id )
				{
					case 4:
						if( $first )
						{
							echo '<button class="btn btn-success btn-xs add-kra add-kra-'.$row->section_column_id.'" onclick="add_item('.$row->section_column_id.', \'\', \'\','.$section_id.')" type="button">'.lang('appraisal_individual_planning.add_row').'</button>';
						}
						$first = false;
						break;
					default;
						break;
				}
			endforeach; 
			echo '</td>';
			echo '</tr>'; ?>
		</tbody>
	</table>
</div>
{{ $footer }}