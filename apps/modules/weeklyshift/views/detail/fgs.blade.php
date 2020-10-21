<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('weeklyshift.title') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('weeklyshift.mon') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="" id="" value="{{ $monday_shift }}" placeholder="{{ lang('weeklyshift.mon') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('weeklyshift.tue') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="" id="" value="{{ $tuesday_shift }}" placeholder="{{ lang('weeklyshift.tue') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('weeklyshift.wed') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="" id="" value="{{ $wednesday_shift }}" placeholder="{{ lang('weeklyshift.wed') }}" /> 				
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('weeklyshift.thu') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="" id="" value="{{ $thursday_shift }}" placeholder="{{ lang('weeklyshift.thu') }}" /> 				
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('weeklyshift.fri') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="" id="" value="{{ $friday_shift }}" placeholder="{{ lang('weeklyshift.fri') }}" /> 				
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('weeklyshift.sat') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="" id="" value="{{ $saturday_shift }}" placeholder="{{ lang('weeklyshift.sat') }}" /> 				
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('weeklyshift.sun') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="" id="" value="{{ $sunday_shift }}" placeholder="{{ lang('weeklyshift.sun') }}" /> 				
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Deault</label>
			<div class="col-md-7">							
				<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
					<input type="checkbox" disabled="disabled" value="1" @if( $record['ww_time_shift_weekly_default'] ) checked="checked" @endif name="shift_weekly[time_shift_weekly.default]" id="shift_weekly-default-temp" class="dontserializeme toggle"/>
					<input type="hidden" disabled="disabled" name="time_shift_weekly[default]" id="shift_weekly-default" value="<?php echo $record['ww_time_shift_weekly_default'] ? 1 : 0 ?>"/>
				</div> 				
			</div>	
		</div>									
	</div>
</div>