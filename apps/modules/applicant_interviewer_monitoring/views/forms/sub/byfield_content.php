
<?php
    $value['key_value'] = '';
    $value['other_remarks'] = '';
    foreach($data['keys'] as $key):
        $multiple_qry = "SELECT * FROM ww_recruitment_interview_details 
                        WHERE `key` = '{$key['key_code']}' AND interview_id = {$interview->id}";
        $multiple_sql = $db->query($multiple_qry);
        if($multiple_sql->num_rows() > 0){
            $value = $multiple_sql->row_array();
        }
?>
<div>
<?php
    	if($key['show_key_label']):
?>
			<span class="bold"><?php echo $key['key_label'] ?>:</span>
<?php
		endif;
        switch($key['uitype_id']){
            case 2://TextArea
?>
			<textarea class="form-control" <?php if($is_disabled == 1) echo "disabled='true'" ?> rows="3" name="recruitment_interview_details[<?php echo $key['key_code']?>][key_value]"><?php echo $value['key_value'] ?></textarea>
<?php
			break;
            case 3://textfield
?>
			<span>
				<input id="maxlength_defaultconfig " <?php if($is_disabled == 1) echo "disabled='true'" ?> class="form-control <?php echo $key['key_code']?>" type="text" value="<?php echo $value['key_value'] ?>" name="recruitment_interview_details[<?php echo $key['key_code']?>][key_value]">
			</span>
<?php
			break;
            case 4://Passed/Failed
	            $passed = '';
                $failed = '';
                $w_reservation = '';
            	if($value['key_value'] == "Passed"){
            		$passed = 'selected';
            	}else if($value['key_value'] == "Failed"){
            		$failed = 'selected';
            	}else{
                    $w_reservation = 'selected';
                }
?>
            <select name="recruitment_interview_details[<?php echo $key['key_code']?>][key_value]" <?php if($is_disabled == 1) echo "disabled='true'" ?> class="form-control select2me" data-placeholder="Select...">
                <option value="Passed" <?php echo $passed ?>>Passed</option>
                <option value="Failed" <?php echo $failed ?>>Failed</option>
                <option value="With Reservation" <?php echo $w_reservation ?>>With Reservation</option>
            </select>
<?php
			break;
            case 5://interview_remarks                      
                $option = $this->db->get_where('recruitment_interview_remarks', array('deleted' => 0));
                $options = array('' => 'Select...');
                foreach ($option->result() as $opt) {
                    $options[$opt->remarks] = $opt->remarks;
                }
                echo form_dropdown('recruitment_interview_details['.$key['key_code'].'][key_value]',$options, $value['key_value'], 'class="form-control select2me" data-placeholder="Select..."');
            break;
		}
?>

</div>
	<br>

<?php
	endforeach;
?>