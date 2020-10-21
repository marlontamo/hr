<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Class Code</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_transaction_class[transaction_class_code]" id="payroll_transaction_class-transaction_class_code" value="{{ $record['payroll_transaction_class.transaction_class_code'] }}" placeholder="Enter Class Code"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Class Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_transaction_class[transaction_class]" id="payroll_transaction_class-transaction_class" value="{{ $record['payroll_transaction_class.transaction_class'] }}" placeholder="Enter Class Name"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="payroll_transaction_class[description]" id="payroll_transaction_class-description" placeholder="Enter Description" rows="4">{{ $record['payroll_transaction_class.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>