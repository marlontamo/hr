<?php   
    if($data['other_remarks'] == 1):
?>
    <td width="40%">
    	<?php echo $value['other_remarks'] ?>
    	<!-- <textarea class="form-control" rows="3" name="recruitment_interview_details[<?php echo $key['key_code']?>][other_remarks]"><?php echo $value['other_remarks'] ?></textarea> -->
    </td>
<?php
    endif;
?>