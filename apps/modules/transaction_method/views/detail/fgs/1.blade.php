<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Method Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_transaction_method[payroll_transaction_method]" id="payroll_transaction_method-payroll_transaction_method" value="{{ $record['payroll_transaction_method.payroll_transaction_method'] }}" placeholder="Enter Method Name"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="payroll_transaction_method[description]" id="payroll_transaction_method-description" placeholder="Enter Description" rows="4">{{ $record['payroll_transaction_method.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>