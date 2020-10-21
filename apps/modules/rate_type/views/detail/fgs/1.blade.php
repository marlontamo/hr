<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Rate Type</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_rate_type[payroll_rate_type]" id="payroll_rate_type-payroll_rate_type" value="{{ $record['payroll_rate_type.payroll_rate_type'] }}" placeholder="Enter Rate Type"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="payroll_rate_type[description]" id="payroll_rate_type-description" placeholder="Enter Description" rows="4">{{ $record['payroll_rate_type.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>