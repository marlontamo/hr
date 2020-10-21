<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Change Work Schedule Form</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Status</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_forms[form_status_id]" id="time_forms-form_status_id" value="{{ $record['time_forms.form_status_id'] }}" placeholder="Enter Status"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="time_forms[date_to]" id="time_forms-date_to" value="{{ $record['time_forms.date_to'] }}" placeholder="Enter Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Reason</label>
				<div class="col-md-7">							<textarea class="form-control" name="time_forms[reason]" id="time_forms-reason" placeholder="Enter Reason" rows="4">{{ $record['time_forms.reason'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>New Schedule</label>
				<div class="col-md-7"><?php	                            <div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: searchable</p>
<p>Filename: templates/fgs.php</p>
<p>Line Number: 39</p>

</div>?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('time_forms_date[shift_to]',$time_forms_date_shift_to_options, $record['time_forms_date.shift_to'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>	</div>
</div>