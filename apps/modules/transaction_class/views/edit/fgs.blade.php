<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('transaction_class.basic_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
	<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('transaction_class.class_code') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_transaction_class[transaction_class_code]" id="payroll_transaction_class-transaction_class_code" value="{{ $record['payroll_transaction_class.transaction_class_code'] }}" placeholder="{{ lang('transaction_class.p_class_code') }}"/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('transaction_class.class_name') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_transaction_class[transaction_class]" id="payroll_transaction_class-transaction_class" value="{{ $record['payroll_transaction_class.transaction_class'] }}" placeholder="{{ lang('transaction_class.p_class_name') }}"/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('transaction_class.description') }}</label>
			<div class="col-md-7">							
				<textarea class="form-control" name="payroll_transaction_class[description]" id="payroll_transaction_class-description" placeholder="{{ lang('transaction_class.p_description') }}" rows="4">{{ $record['payroll_transaction_class.description'] }}</textarea> 				
			</div>	
		</div>	
	</div>
</div>