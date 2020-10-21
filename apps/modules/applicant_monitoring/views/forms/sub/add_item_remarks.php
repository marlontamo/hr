<tr class="multiple-itemrow">
    <td width="50%" class="active multiple_item" style="font-size:13px !important;">                
        <span class="pull-right small text-muted delete-item" >
           <a class="pull-right small text-muted" href="#" onclick="delete_item($(this).closest('tr'))">Delete</a>
        </span>
        <input id="maxlength_defaultconfig" class="form-control" type="text" maxlength="64" name="recruitment_interview_details[<?php echo $key_code?>][key_name][]">
        <br class="add-item">
        <span class="add-item">
            <button href="#" data-toggle="modal" class="btn btn-success btn-xs" type="button" onclick="add_item_remarks('<?php echo $header_text ?>', '<?php echo $key_code?>')">Add <?php echo $header_text ?></button>
        </span>
    </td>
    <td width="50%">
    <?php 
        $option = $this->db->get_where('recruitment_interview_remarks', array('deleted' => 0));
        $options = array('' => 'Select...');
        foreach ($option->result() as $opt) {
            $options[$opt->remarks] = $opt->remarks;
        }
        echo form_dropdown('recruitment_interview_details['.$key_code.'][key_value]',$options, '', 'class="form-control select2me" data-placeholder="Select..."');
    ?>
    </td>
</tr>
<script type="text/javascript">

    $('select.select2me').select2();
    
</script>