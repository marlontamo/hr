<?php 
//check for current contributors 
$where = array(
    'planning_id' => $appraisee->planning_id,
    'user_id' => $appraisee->planning_id,
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
	if(count($contributors) > 0){     
?>
<label class="control-label ">List of Crowdsource</label>
<?php
		foreach($contributors as $contributor){  	
?>
<a class="btn btn-default btn-sm"><?php echo $contributor['full_name'] ?></a>
<?php 
		}
	}
?>
