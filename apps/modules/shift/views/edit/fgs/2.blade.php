<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Shift Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Shift</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_shift[shift]" id="time_shift-shift" value="{{ $record['time_shift.shift'] }}" placeholder="Enter Shift"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">From</label>
				<div class="col-md-7">							<div class="input-group bootstrap-timepicker">                                       
								<input type="text" class="form-control timepicker-default" name="time_shift[time_start]" id="time_shift-time_start" value="{{ $record['time_shift.time_start'] }}" />
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">To</label>
				<div class="col-md-7">							<div class="input-group bootstrap-timepicker">                                       
								<input type="text" class="form-control timepicker-default" name="time_shift[time_end]" id="time_shift-time_end" value="{{ $record['time_shift.time_end'] }}" />
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Color</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_shift[color]" id="time_shift-color" value="{{ $record['time_shift.color'] }}" placeholder="Enter Color"/> 				</div>	
			</div>	</div>
</div>