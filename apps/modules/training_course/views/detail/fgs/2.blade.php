<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Bond Setup</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">With Bond</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['training_course.with_bond'] ) checked="checked" @endif name="training_course[with_bond][temp]" id="training_course-with_bond-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="training_course[with_bond]" id="training_course-with_bond" value="<?php echo $record['training_course.with_bond'] ? 1 : 0 ?>"/>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Cost</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_course[cost]" id="training_course-cost" value="{{ $record['training_course.cost'] }}" placeholder="Enter Cost" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Length of Service</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_course[length_of_service]" id="training_course-length_of_service" value="{{ $record['training_course.length_of_service'] }}" placeholder="Enter Length of Service" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Remarks</label>
				<div class="col-md-7">							<textarea class="form-control" name="training_course[remarks]" id="training_course-remarks" placeholder="Enter Remarks" rows="4">{{ $record['training_course.remarks'] }}</textarea> 				</div>	
			</div>	</div>
</div>