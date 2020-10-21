<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Other Details</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>This section contains date range, total hours and supporting documents.</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>From</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="training_application[date_from]" id="training_application-date_from" value="{{ $record['training_application.date_from'] }}" placeholder="Enter From" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>To</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="training_application[date_to]" id="training_application-date_to" value="{{ $record['training_application.date_to'] }}" placeholder="Enter To" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Total Hours</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_application[total_hours]" id="training_application-total_hours" value="{{ $record['training_application.total_hours'] }}" placeholder="Enter Total Hours" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Remarks</label>
				<div class="col-md-7">							<textarea class="form-control" name="training_application[remarks]" id="training_application-remarks" placeholder="Enter Remarks" rows="4">{{ $record['training_application.remarks'] }}</textarea> 				</div>	
			</div>	</div>
</div>