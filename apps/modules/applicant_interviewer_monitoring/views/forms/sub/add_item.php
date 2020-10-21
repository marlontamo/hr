<tr class="multiple-itemrow">
    <td width="50%" class="active multiple_item" style="font-size:13px !important;">                
        <span class="pull-right small text-muted delete-item" >
           <a class="pull-right small text-muted" href="#" onclick="delete_item($(this).closest('tr'))">Delete</a>
        </span>
        <input id="maxlength_defaultconfig" class="form-control" type="text" maxlength="64" name="recruitment_interview_details[<?php echo $key_code?>][key_name][]">
        <br class="add-item">
        <span class="add-item">
            <button href="#" data-toggle="modal" class="btn btn-success btn-xs" type="button" onclick="add_item('<?php echo $header_text ?>', '<?php echo $key_code?>')">Add <?php echo $header_text ?></button>
        </span>
    </td>
    <td width="50%"><textarea class="form-control" rows="3"  name="recruitment_interview_details[<?php echo $key_code?>][key_value][]"></textarea>
    </td>
</tr>