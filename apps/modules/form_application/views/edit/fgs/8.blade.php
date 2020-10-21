<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Business Trip Form</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Status</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_forms[form_status_id]" id="time_forms-form_status_id" value="{{ $record['time_forms.form_status_id'] }}" placeholder="Enter Status"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Reason</label>
				<div class="col-md-7">							<textarea class="form-control" name="time_forms[reason]" id="time_forms-reason" placeholder="Enter Reason" rows="4">{{ $record['time_forms.reason'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Contact Number</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_forms_obt[contact_no]" id="time_forms_obt-contact_no" value="{{ $record['time_forms_obt.contact_no'] }}" placeholder="Enter Contact Number"/> 				</div>	
			</div>	</div>
</div>