<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Time Record</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Undertime</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_record_summary[undertime]" id="time_record_summary-undertime" value="{{ $record['time_record_summary.undertime'] }}" placeholder="Enter Undertime"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Late</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_record_summary[late]" id="time_record_summary-late" value="{{ $record['time_record_summary.late'] }}" placeholder="Enter Late"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Hours Actual</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_record_summary[hrs_actual]" id="time_record_summary-hrs_actual" value="{{ $record['time_record_summary.hrs_actual'] }}" placeholder="Enter Hours Actual"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Awol</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_record_summary[awol]" id="time_record_summary-awol" value="{{ $record['time_record_summary.awol'] }}" placeholder="Enter Awol"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Time Out</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_record[time_out]" id="time_record-time_out" value="{{ $record['time_record.time_out'] }}" placeholder="Enter Time Out"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Time In</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_record[time_in]" id="time_record-time_in" value="{{ $record['time_record.time_in'] }}" placeholder="Enter Time In"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Shift</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_record[shift]" id="time_record-shift" value="{{ $record['time_record.shift'] }}" placeholder="Enter Shift"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">user Id</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_record[user_id]" id="time_record-user_id" value="{{ $record['time_record.user_id'] }}" placeholder="Enter user Id"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="time_record[date]" id="time_record-date" value="{{ $record['time_record.date'] }}" placeholder="Enter Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>	</div>
</div>