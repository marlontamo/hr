<tr>
	<td>
		<input type="hidden" class="form-control" maxlength="64" value="" name="recruitment_benefit[benefit_id][]" id="recruitment_benefit-benefit_id">
		<input type="text" class="form-control" maxlength="64" value="<?php echo $form_value ?>" name="recruitment_benefit[benefit][]" id="recruitment_benefit-benefit">
	</td>
	<td>
		<input type="text" class="form-control text-right" maxlength="64" value="" name="recruitment_benefit[amount][]" id="recruitment_benefit-amount">
	</td>
	<td>
		<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
			<input type="checkbox" value="1" checked="checked" name="recruitment_benefit[status_id][temp][]" id="recruitment_benefit-status_id-temp" class="dontserializeme toggle benefit_stat"/>
			<input type="hidden" name="recruitment_benefit[status_id][]" id="recruitment_benefit-status_id" value="1" class="benefit_status"/>
		</div>
		<!-- <select  class="form-control select2me input-sm" data-placeholder="Select..." name="recruitment_benefit[status_id][]" id="recruitment_benefit-status_id">
			<option value="1" @if($value['status_id'] == 1) {{"selected"}} @endif>Yes</option>
			<option value="0" @if($value['status_id'] == 0) {{"selected"}} @endif>No</option>
		</select> -->
	</td>
	<td>
		<a class="btn btn-xs text-muted delete_row" data-record-id="{{$value['benefit_id']}}" ><i class="fa fa-trash-o"></i> Delete</a>
	</td>
</tr>
<script>
$(document).ready(function(){
	$('select.select2me').select2();
	$('.make-switch').not(".has-switch")['bootstrapSwitch']();

	$('.benefit_stat').change(function(){
	    if( $(this).is(':checked') ){
	    	$(this).parent().next().val(1);
	    }
	    else{
	    	$(this).parent().next().val(0);
	    }
	});
});
</script>