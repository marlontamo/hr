<tr>
	<td>
		<input type="hidden" class="form-control" maxlength="64" value="" name="performance_setup_rating_score[rating_score_id][]" id="performance_setup_rating_score-rating_score_id">
		<input type="text" class="form-control" maxlength="64" value="<?php echo $form_value ?>" name="performance_setup_rating_score[rating_score][]" id="performance_setup_rating_score-rating_score">
	</td>
	<td>
		<input type="text" class="form-control" maxlength="64" value="" name="performance_setup_rating_score[score][]" id="performance_setup_rating_score-score">
	</td>
	<td>
		<input type="text" class="form-control" maxlength="64" value="" name="performance_setup_rating_score[description][]" id="performance_setup_rating_score-description">
	</td>
	<td>
		<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
			<input type="checkbox" value="1" checked="checked" name="performance_setup_rating_score[status_id][temp][]" id="performance_setup_rating_score-status_id-temp" class="dontserializeme toggle score_status"/>
			<input type="hidden" name="performance_setup_rating_score[status_id][]" id="performance_setup_rating_score-status_id" value="1"/>
		</div>
		<!-- <select  class="form-control select2me input-sm" data-placeholder="Select..." name="performance_setup_rating_score[status_id][]" id="performance_setup_rating_score-status_id">
			<option value="1" >Yes</option>
			<option value="0" >No</option>
		</select> -->
	</td>
	<td>
		<a class="btn btn-xs text-muted delete_row" ><i class="fa fa-trash-o"></i> Delete</a>
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