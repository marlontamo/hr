<?php   
    if($data['other_remarks'] == 1):
?>
    <td width="40%"><textarea class="form-control" <?php if($is_disabled == 1) echo "disabled='true'" ?> rows="3" name="recruitment_interview_details[<?php echo $key['key_code']?>][other_remarks]"><?php echo $value['other_remarks'] ?></textarea>
    </td>
<?php
    endif;
?>