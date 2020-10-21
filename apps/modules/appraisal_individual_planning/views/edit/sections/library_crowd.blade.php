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
endforeach;

//check for current contributors 
$where = array(
    'planning_id' => $appraisee->planning_id,
    'user_id' => $appraisee->user_id,
    'section_id' => $section_id,
);
$contributors = array();
$crowdsource_draft = array();
$crowdsource_draft = $db->get_where('performance_planning_crowdsource', $where);
if($crowdsource_draft->num_rows() > 0){
	$crowdsource_draft = $crowdsource_draft->row_array();	
	// $contributors = explode( ',', $crowdsource_draft['crowdsource_user_id'] );
	$contributors = $db->query("SELECT full_name FROM users WHERE user_id IN ({$crowdsource_draft['crowdsource_user_id']})")->result_array();
// print_r($crowdsource_draft);
}
?>
{{ $header }}
<div class="panel-body">
	<a href="javascript:crowdsource_draft({{$section_id}})" class="btn btn-info btn-sm"> Draft List</a>
	<br>
	<div class="form-group col-md-12">
        <div class="crowdsource_list{{$section_id}}">
        <?php 
        	if(count($contributors) > 0){     
        ?>
        <label class="control-label ">List of Crowdsource:</label><br>
        <?php
        		foreach($contributors as $contributor){  	
        ?>
		<a class="btn default btn-sm"><?php echo $contributor['full_name'] ?></a>&nbsp;
        <?php 
    			}
    		}
        ?>
        </div>
    </div>
</div>
