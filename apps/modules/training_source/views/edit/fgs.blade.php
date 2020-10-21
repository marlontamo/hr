<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Training Source</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Code</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_source[source_code]" id="training_source-source_code" value="{{ $record['training_source.source_code'] }}" placeholder="Enter Code" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Source</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_source[source]" id="training_source-source" value="{{ $record['training_source.source'] }}" placeholder="Enter Source" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="training_source[description]" id="training_source-description" placeholder="Enter Description" rows="4">{{ $record['training_source.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>