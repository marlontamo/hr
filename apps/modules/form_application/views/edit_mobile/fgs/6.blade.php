<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Paternity Leave Form</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Status</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_forms[form_status_id]" id="time_forms-form_status_id" value="{{ $record['time_forms.form_status_id'] }}" placeholder="Enter Status"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Reason</label>
				<div class="col-md-7">							<textarea class="form-control" name="time_forms[reason]" id="time_forms-reason" placeholder="Enter Reason" rows="4">{{ $record['time_forms.reason'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Actual Delivery</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="time_forms_maternity[actual_date]" id="time_forms_maternity-actual_date" value="{{ $record['time_forms_maternity.actual_date'] }}" placeholder="Enter Actual Delivery" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>	</div>
</div>