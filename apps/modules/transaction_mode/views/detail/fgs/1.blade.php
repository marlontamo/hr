<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Mode Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_transaction_mode[payroll_transaction_mode]" id="payroll_transaction_mode-payroll_transaction_mode" value="{{ $record['payroll_transaction_mode.payroll_transaction_mode'] }}" placeholder="Enter Mode Name"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="payroll_transaction_mode[description]" id="payroll_transaction_mode-description" placeholder="Enter Description" rows="4">{{ $record['payroll_transaction_mode.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>