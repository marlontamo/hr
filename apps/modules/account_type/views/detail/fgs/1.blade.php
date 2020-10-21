<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Account Type</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_account_type[account_type]" id="payroll_account_type-account_type" value="{{ $record['payroll_account_type.account_type'] }}" placeholder="Enter Account Type"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="payroll_account_type[description]" id="payroll_account_type-description" placeholder="Enter Description" rows="4">{{ $record['payroll_account_type.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>