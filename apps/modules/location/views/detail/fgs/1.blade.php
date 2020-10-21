<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('location.location_information') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('location.location') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="users_location[location]" id="users_location-location" value="{{ $record['users_location.location'] }}" placeholder="{{ lang('location.p_location') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('location.location_code') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="users_location[location_code]" id="users_location-location_code" value="{{ $record['users_location.location_code'] }}" placeholder="{{ lang('location.p_location_code') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('location.minimum_wage') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="users_location[min_wage_amt]" id="users_location-min_wage_amt" value="{{ $record['users_location.min_wage_amt'] }}" placeholder="{{ lang('location.p_minimum_wage') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('location.ecola_per_day') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="users_location[ecola_amt]" id="users_location-ecola_amt" value="{{ $record['users_location.ecola_amt'] }}" placeholder="{{ lang('location.p_ecola_per_day') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('location.ecola_per_month') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="users_location[ecola_amt_month]" id="users_location-ecola_amt_month" value="{{ $record['users_location.ecola_amt_month'] }}" placeholder="{{ lang('location.p_ecola_per_month') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('location.active') }}</label>
			<div class="col-md-7">							
				<div class="make-switch" data-on-label="&nbsp;{{ lang('location.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('location.option_no') }}&nbsp;">
			    	<input type="checkbox" disabled="disabled" value="1" @if( $record['users_location.status_id'] ) checked="checked" @endif name="users_location[status_id][temp]" id="users_location-status_id-temp" class="dontserializeme toggle"/>
			    	<input type="hidden" name="users_location[status_id]" id="users_location-status_id" value="<?php echo $record['users_location.status_id'] ? 1 : 0 ?>"/>
				</div> 				
			</div>	
		</div>	
	</div>
</div>