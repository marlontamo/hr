
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
                echo $value['key_value'];
?>
			<!-- <textarea class="form-control" rows="3" name="recruitment_interview_details[<?php echo $key['key_code']?>][key_value]"><?php echo $value['key_value'] ?></textarea> -->
<?php
			break;
            case 3://textfield
                echo $value['key_value'];
?>
			<span>
				<!-- <input id="maxlength_defaultconfig" class="form-control <?php echo $key['key_code']?>" type="text" value="<?php echo $value['key_value'] ?>" name="recruitment_interview_details[<?php echo $key['key_code']?>][key_value]"> -->
			</span>
<?php
			break;
            case 4://Passed/Failed
                echo $value['key_value'];
	            $passed = '';
	            $failed = '';
            	if($value['key_value'] == "Passed"){
            		$passed = 'selected';
            	}else{
            		$failed = 'selected';
            	}
?>
           <!--  <select name="recruitment_interview_details[<?php echo $key['key_code']?>][key_value]" class="form-control select2me" data-placeholder="Select...">
                <option value="Passed" <?php echo $passed ?>>Passed</option>
                <option value="Failed" <?php echo $failed ?>>Failed</option>
            </select> -->
<?php
			break;
		}
?>

</div>
	<br>

<?php
	endforeach;
?>