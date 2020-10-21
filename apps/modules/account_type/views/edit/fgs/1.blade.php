<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('account_type.basic_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('account_type.account_type') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_account_type[account_type]" id="payroll_account_type-account_type" value="{{ $record['payroll_account_type.account_type'] }}" placeholder="{{ lang('account_type.p_account_type') }}"/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('account_type.description') }}</label>
			<div class="col-md-7">							
				<textarea class="form-control" name="payroll_account_type[description]" id="payroll_account_type-description" placeholder="{{ lang('account_type.p_description') }}" rows="4">{{ $record['payroll_account_type.description'] }}</textarea> 				
			</div>	
		</div>	
	</div>
</div>