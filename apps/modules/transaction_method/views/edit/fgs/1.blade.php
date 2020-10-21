<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('transaction_method.basic_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('transaction_method.method_name') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_transaction_method[payroll_transaction_method]" id="payroll_transaction_method-payroll_transaction_method" value="{{ $record['payroll_transaction_method.payroll_transaction_method'] }}" placeholder="{{ lang('transaction_method.p_method_name') }}"/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('transaction_method.description') }}</label>
			<div class="col-md-7">							
				<textarea class="form-control" name="payroll_transaction_method[description]" id="payroll_transaction_method-description" placeholder="{{ lang('transaction_method.p_description') }}" rows="4">{{ $record['payroll_transaction_method.description'] }}</textarea> 				
			</div>	
		</div>	
	</div>
</div>