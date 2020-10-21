<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('pay_steps_rates.pay_steps_rates_information') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('pay_steps_rates.pay_steps_rates') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_pay_set_rates[pay_set_rates]" id="users_pay_set_rates-pay_set_rates" value="{{ $record['users_pay_set_rates.pay_set_rates'] }}" placeholder="{{ lang('pay_steps_rates.p_pay_steps_rates') }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('pay_steps_rates.pay_steps_rates_code') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_pay_set_rates[pay_set_rates_code]" id="users_pay_set_rates-pay_set_rates_code" value="{{ $record['users_pay_set_rates.pay_set_rates_code'] }}" placeholder="{{ lang('pay_steps_rates.p_pay_steps_rates_code') }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('pay_steps_rates.active') }}</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;{{ lang('pay_steps_rates.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('pay_steps_rates.option_no') }}&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['users_pay_set_rates.status_id'] ) checked="checked" @endif name="users_pay_set_rates[status_id][temp]" id="users_pay_set_rates-status_id-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="users_pay_set_rates[status_id]" id="users_pay_set_rates-status_id" value="<?php echo $record['users_pay_set_rates.status_id'] ? 1 : 0 ?>"/>
							</div> 				</div>	
			</div>	</div>
</div>