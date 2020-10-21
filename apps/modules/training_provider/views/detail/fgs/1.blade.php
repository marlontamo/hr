<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Training Provider</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Provider</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_provider[provider]" id="training_provider-provider" value="{{ $record['training_provider.provider'] }}" placeholder="Enter Provider" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Code</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_provider[provider_code]" id="training_provider-provider_code" value="{{ $record['training_provider.provider_code'] }}" placeholder="Enter Code" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="training_provider[description]" id="training_provider-description" placeholder="Enter Description" rows="4">{{ $record['training_provider.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>