 <tr rel="0">
    <!-- this first column shows the year of this holiday item -->
    <td>
        <select  class="form-control select2me input-sm" data-placeholder="Select...">
        	<option>Transportation</option>
			<option>Meal</option>
			<option>Allowance</option>
        </select>
    </td>
     <td>
        <input type="text" class="form-control" maxlength="64" name="" >
    </td>
    <td>
        <input type="text" class="form-control" maxlength="64"  >
    </td>
    <td>
        <a class="btn btn-xs text-muted" href="#"><i class="fa fa-trash-o"></i> Delete</a>
    </td>
    
</tr>
<script>
$(document).ready(function(){
	$('select.select2me').select2();
	$('.make-switch').not(".has-switch")['bootstrapSwitch']();

	$('.score_status').change(function(){
	    if( $(this).is(':checked') ){
	    	$(this).parent().next().val(1);
	    }
	    else{
	    	$(this).parent().next().val(0);
	    }
	});
});
</script>