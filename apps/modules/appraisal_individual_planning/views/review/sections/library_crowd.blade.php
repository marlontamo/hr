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
<div class="panel-body">
	<label class="control-label ">List of Crowdsource:</label><br>
	<?php
		$db->limit(1);
		$cs_draft = $db->get_where('performance_planning_crowdsource', array('planning_id' => $appraisee->planning_id, 'user_id' => $appraisee->user_id, 'section_id' => $section_id) );
		if($cs_draft->num_rows() > 0){
			$cs_draft = $cs_draft->row();
			$cs_draft = explode(',', $cs_draft->crowdsource_user_id);
			foreach( $cs_draft as $uid )
			{
				$db->limit(1);
				$u = $db->get_where('users', array('user_id' => $uid))->row();
				echo  '<span class="label label-info label-sm">'.$u->full_name.'</span>&nbsp;';
			}
		}
	?>
</div>