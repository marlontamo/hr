<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('transaction_mode.basic_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('transaction_mode.mode_name') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_transaction_mode[payroll_transaction_mode]" id="payroll_transaction_mode-payroll_transaction_mode" value="{{ $record['payroll_transaction_mode.payroll_transaction_mode'] }}" placeholder="{{ lang('transaction_mode.p_mode_name') }}"/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('transaction_mode.description') }}</label>
			<div class="col-md-7">							
				<textarea class="form-control" name="payroll_transaction_mode[description]" id="payroll_transaction_mode-description" placeholder="{{ lang('transaction_mode.p_description') }}" rows="4">{{ $record['payroll_transaction_mode.description'] }}</textarea> 				
			</div>	
		</div>	
	</div>
</div>