 <tr rel="0">
    <!-- this first column shows the year of this holiday item -->
    <td>
        <?php       
        // echo "here1";      exit();                                                              
            $db->select('purpose_id,purpose');
            $db->where('deleted', '0');
            $options = $db->get('time_forms_obt_purpose');
            $time_forms_obt_purpose_options = array('' => 'Select...');
            foreach($options->result() as $option)
            {
                $time_forms_obt_purpose_options[$option->purpose_id] = $option->purpose;
            } 
            ?>  
        <!-- <select  class="form-control select2me input-sm" data-placeholder="Select...">
        	<option>Transportation</option>
			<option>Meal</option>
			<option>Allowance</option>
        </select> -->

        <?php 
            echo form_dropdown('time_forms_obt_transpo[purpose_id][]', $time_forms_obt_purpose_options, $form_value, 'id="obt_purpose" class="form-control select2me" data-placeholder="Select..."');
        ?>
    </td>
     <td>
        <input type="text" class="form-control" maxlength="64" name="time_forms_obt_transpo[amount][]" id="time_forms_obt_transpo-amount" >
    </td>
    <td>
        <input type="text" class="form-control" maxlength="64" name="time_forms_obt_transpo[remarks][]" id="time_forms_obt_transpo-remarks" >
    </td>
    <td>
        &nbsp;
    </td>
    <td>
        <a class="btn btn-xs text-muted delete_row" ><i class="fa fa-trash-o"></i> Delete</a>
    </td>
    
</tr>
<script>
$(document).ready(function(){
	$('select.select2me').select2();


});
</script>