<?php
$qry = "select a.*, b.uitype
FROM {$db->dbprefix}performance_template_section_column a
LEFT JOIN {$db->dbprefix}performance_template_section_column_uitype b on b.uitype_id = a.uitype_id
WHERE a.deleted = 0 AND a.template_section_id = {$section_id}
ORDER BY a.sequence";
$columns = $db->query( $qry );
foreach( $columns->result() as $row ) :
	switch( $row->uitype_id )
	{
		case 5:
			$where = array(
				'rating_group_id' => $row->rating_group_id,
				'status_id' => 1,
				'deleted' => 0
			);
			$ratings = $db->get_where('performance_setup_rating_score', $where); ?>
			<div class="panel-body">
				<p class="small"><b>{{ lang('appraisal_individual_planning.standard') }}:</b><br>
					Below Standard: 1-4 &nbsp;&nbsp;&nbsp;
					Meet Standard - Low: 5-6 &nbsp;&nbsp;&nbsp;
					Meet Standard - High: 7-8 &nbsp;&nbsp;&nbsp;
					Exceed Standard: 9-10					
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
			</tr>
		</tbody>
	</table>
</div>
{{ $footer }}