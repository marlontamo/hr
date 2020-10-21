<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Holiday Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Holiday</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_holiday[holiday]" id="time_holiday-holiday" value="{{ $record['time_holiday.holiday'] }}" placeholder="Enter Holiday"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="time_holiday[holiday_date]" id="time_holiday-holiday_date" value="{{ $record['time_holiday.holiday_date'] }}" placeholder="Enter Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Type</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Regular&nbsp;" data-off-label="&nbsp;Special&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['time_holiday.legal'] ) checked="checked" @endif name="time_holiday[legal][temp]" id="time_holiday-legal-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="time_holiday[legal]" id="time_holiday-legal" value="@if( $record['time_holiday.legal'] ) 1 else 0 @endif"/>
							</div> 				</div>	
			</div>	</div>
</div>