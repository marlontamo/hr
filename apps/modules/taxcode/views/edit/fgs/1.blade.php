<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Type</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="taxcode[taxcode]" id="taxcode-taxcode" value="{{ $record['taxcode.taxcode'] }}" placeholder="Enter Type" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Excemption</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="taxcode[amount]" id="taxcode-amount" value="{{ $record['taxcode.amount'] }}" placeholder="Enter Excemption" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"'/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="taxcode[description]" id="taxcode-description" placeholder="Enter Description" rows="4">{{ $record['taxcode.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>