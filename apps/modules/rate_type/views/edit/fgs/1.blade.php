<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('rate_type.basic_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('rate_type.rate_type') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_rate_type[payroll_rate_type]" id="payroll_rate_type-payroll_rate_type" value="{{ $record['payroll_rate_type.payroll_rate_type'] }}" placeholder="{{ lang('rate_type.p_rate_type') }}"/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('rate_type.description') }}</label>
			<div class="col-md-7">							
				<textarea class="form-control" name="payroll_rate_type[description]" id="payroll_rate_type-description" placeholder="{{ lang('rate_type.p_description') }}" rows="4">{{ $record['payroll_rate_type.description'] }}</textarea> 				
			</div>	
		</div>	
	</div>
</div>