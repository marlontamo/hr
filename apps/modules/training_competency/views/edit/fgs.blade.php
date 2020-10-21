<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Training Competency</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Competency</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_competency[competency]" id="training_competency-competency" value="{{ $record['training_competency.competency'] }}" placeholder="Enter Competency" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Code</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_competency[competency_code]" id="training_competency-competency_code" value="{{ $record['training_competency.competency_code'] }}" placeholder="Enter Code" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="training_competency[description]" id="training_competency-description" placeholder="Enter Description" rows="4">{{ $record['training_competency.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>