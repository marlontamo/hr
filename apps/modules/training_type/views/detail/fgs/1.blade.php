<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Training Type</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Code</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_type[type_code]" id="training_type-type_code" value="{{ $record['training_type.type_code'] }}" placeholder="Enter Code" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Type</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_type[type]" id="training_type-type" value="{{ $record['training_type.type'] }}" placeholder="Enter Type" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="training_type[description]" id="training_type-description" placeholder="Enter Description" rows="4">{{ $record['training_type.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>