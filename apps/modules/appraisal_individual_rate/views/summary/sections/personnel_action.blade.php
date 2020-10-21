{{ $header }}
<?php

	$db->limit(1);
	$pa = $db->get_where('performance_appraisal_personnel_action', array('appraisal_id' => $appraisee->appraisal_id, 'user_id' => $appraisee->user_id));
	if( $pa->num_rows() == 1 )
		$pa = $pa->row();
	else{
		$pa = new stdClass();
		$pa->recommendation_id = '';
		$pa->date = '';
		$pa->position_id = '';
		$pa->others = '';
	}
?>
<table class="table">
	<tbody>
		<tr>
			<td rowspan="3" width="20%">
				<select name="performance_appraisal_personnel_action[recommendation_id]" class="form-control select2me" data-placeholder="Select..." disabled>
              		<option value="">{{ lang('appraisal_individual_rate.select') }}...</option>
                	<?php
                		$options = $db->get_where('performance_appraisal_recommendation', array('deleted' => 0));
                		if($options->num_rows() > 0){
                			foreach( $options->result() as $option )
                			{
                				echo '<option value="'.$option->recommendation_id.'" '.($pa->recommendation_id == $option->recommendation_id ? 'selected': '').'>'. $option->recommendation .'</option>';
                			}
                		}
                	?>
                </select>
					
			</td>
			<td width="15%">
				{{ lang('appraisal_individual_rate.effective_on') }}:
			</td>
			<td width="35%">
				<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                    <input type="text" size="16" class="form-control" value="<?php if( strtotime($pa->date) && $pa->date != '1970-01-01' ) echo date('M d, Y', strtotime($pa->date))?>" name="performance_appraisal_personnel_action[date]" disabled>
                    <span class="input-group-btn">
                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                    </span>
                </div>

			</td>
			<td rowspan="2">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td>
			{{ lang('appraisal_individual_rate.new_pos') }}:
					
			</td>
			<td class="40%">
				<select  class="form-control select2me" data-placeholder="Select..." name="performance_appraisal_personnel_action[position_id]" disabled>
                	<?php
                		$options = $db->get_where('users_position', array('deleted' => 0));
                		if($options->num_rows() > 0){
                			echo '<option value=""></option>';
                			foreach( $options->result() as $position )
                			{
                				echo '<option value="'.$position->position_id.'"'.($pa->position_id == $position->position_id ? 'selected': '').'>'. $position->position .'</option>';
                			}
                		}
                	?>
                </select>
            </td>
        </tr>
        <tr>
			<td>
			Others:
					
			</td>
			<td class="40%">
				<input type="text" class="form-control" value="<?php echo $pa->others?>" name="performance_appraisal_personnel_action[others]" disabled>
            </td>
		</tr>
		 
	</tbody>
</table>
{{ $footer }}