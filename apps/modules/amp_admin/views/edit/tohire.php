<tr>
    <td>
        <?php echo form_dropdown('employment_status_id[]', $employment_statuss, $form_value, 'class="form-control select2me" data-placeholder="Select..."') ?>   
    </td>
    <td>
        <?php echo form_dropdown('job_class_id[]', $job_classes, '', 'class="form-control select2me" data-placeholder="Select..."') ?>   
    </td>
    <td>
        <?php echo form_dropdown('month[]', $months, '', 'class="form-control select2me" data-placeholder="Select..."') ?>   
    </td>
    <td>
        <input name="budget[]" type="text" class="form-control" maxlength="64" value="">
    </td>
    <td>
        <input name="needed[]" type="text" class="form-control" maxlength="64" value="">
    </td>
    <td>
        <?php echo form_dropdown('company_id[]', $companies, '', 'class="form-control select2me" data-placeholder="Select..."') ?>   
    </td>
    <td>
        <button class="btn btn-xs text-muted" type="button" onclick="delete_position_plan($(this).closest('tr'))"><i class="fa fa-trash-o"></i> Delete</button>
    </td>
</tr>
<script>

    $('select.select2me').select2();
</script>